<?php
/**
 * BbsArticles Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BbsesAppController', 'Bbses.Controller');
App::uses('String', 'Utility');

/**
 * BbsArticles Controller
 *
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @package NetCommons\Bbses\Controller
 */
class BbsArticlesController extends BbsesAppController {

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		'Bbses.BbsFrameSetting',
		'Bbses.BbsArticle',
		'Bbses.BbsArticleTree',
		'Bbses.BbsArticlesUser',
		'Comments.Comment',
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsBlock',
		'NetCommons.NetCommonsWorkflow',
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'contentCreatable' => array('add', 'edit', 'delete'),
				'contentCommentCreatable' => array('reply'),
				'contentCommentPublishable' => array('approve'),
			),
		),
		'Paginator',
		'Bbses.BbsArticles'
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.Token',
	);

/**
 * index
 *
 * @return void
 */
	public function index() {
		if (! $this->viewVars['blockId']) {
			$this->autoRender = false;
			return;
		}
		$this->initBbs(['bbsFrameSetting']);

		//Paginatorの設定
		$this->Paginator->settings = $this->BbsArticles->paginatorSettings();

		try {
			$this->BbsArticle->bindModelBbsArticlesUser($this->viewVars['userId']);
			$articles = $this->Paginator->paginate('BbsArticle');
		} catch (Exception $ex) {
			$this->params['named'] = array();
			$this->BbsArticle->bindModelBbsArticlesUser($this->viewVars['userId']);
			$articles = $this->Paginator->paginate('BbsArticle');
		}

		$results = array(
			'bbsArticles' => $articles
		);
		$results = $this->camelizeKeyRecursive($results);
		$this->set($results);
	}

/**
 * view
 *
 * @param int $frameId frames.id
 * @param string $bbsArticleKey bbs_articles.key
 * @return void
 * @throws BadRequestException throw new
 */
	public function view($frameId = null, $bbsArticleKey = null) {
		$this->initBbs(['bbsFrameSetting']);
		$this->BbsArticles->setBbsArticle($bbsArticleKey, ['rootBbsArticle', 'parentBbsArticle']);

		//既読
		if ($this->viewVars['userId'] && ! $this->viewVars['currentBbsArticle']['bbsArticlesUser']['id']) {
			$data = $this->BbsArticlesUser->create(array(
				'bbs_article_key' => $bbsArticleKey,
				'user_id' => $this->viewVars['userId']
			));
			$result = $this->BbsArticlesUser->saveArticlesUser($data);
			$result = $this->camelizeKeyRecursive($result);
			$this->viewVars['currentBbsArticle']['bbsArticlesUser'] = $result;
		}

		$conditions = $this->BbsArticles->setConditions();
		$this->BbsArticleTree->bindModelBbsArticlesUser($this->viewVars['userId']);
		$this->BbsArticleTree->Behaviors->load('Tree', array(
			'scope' => array(
				'OR' => $conditions
			)
		));

		$children = $this->BbsArticleTree->children(
			$this->viewVars['currentBbsArticle']['bbsArticleTree']['id'], false, null, 'BbsArticleTree.id DESC', null, 1, 1
		);
		$children = $this->camelizeKeyRecursive($children);
		$children = Hash::combine($children, '{n}.bbsArticleTree.id', '{n}');

		$this->set(['bbsArticleChildren' => $children]);
	}

/**
 * add
 *
 * @return void
 */
	public function add() {
		$this->view = 'edit';
		$this->initBbs(['bbsFrameSetting']);

		$bbsArticle = $this->BbsArticle->create(array(
			'id' => null,
			'bbs_id' => $this->viewVars['bbs']['id'],
			'language_id' => $this->viewVars['languageId'],
			'key' => null,
			'title' => null,
			'content' => null,
		));
		$bbsArticleTree = $this->BbsArticleTree->create(array(
			'id' => null,
			'key' => null,
			'bbs_key' => $this->viewVars['bbs']['key'],
			'root_id' => null,
			'parent_id' => null,
		));

		$data = array();
		if ($this->request->isPost()) {
			if (! $status = $this->NetCommonsWorkflow->parseStatus()) {
				return;
			}
			$data = Hash::merge(
				$this->data,
				['BbsArticle' => ['status' => $status]]
			);

			$data['BbsArticleTree']['post_no'] = 1;
			unset($data['BbsArticle']['id']);

			if ($this->BbsArticles->saveBbsArticle($data)) {
				return;
			}
			$data['contentStatus'] = null;
			$data['comments'] = null;
		}

		$data = Hash::merge(
			$bbsArticle, $bbsArticleTree, $data,
			['contentStatus' => null, 'comments' => []]
		);
		$results = $this->camelizeKeyRecursive($data);
		$this->set($results);
	}

/**
 * reply
 *
 * @param int $frameId frames.id
 * @param string $bbsArticleKey bbs_articles.key
 * @return void
 */
	public function reply($frameId = null, $bbsArticleKey = null) {
		$this->view = 'edit';
		$this->initBbs(['bbsFrameSetting']);
		$this->BbsArticles->setBbsArticle($bbsArticleKey);

		if ((int)$this->viewVars['currentBbsArticle']['bbsArticleTree']['rootId'] > 0) {
			$rootArticleTreeId = (int)$this->viewVars['currentBbsArticle']['bbsArticleTree']['rootId'];
		} else {
			$rootArticleTreeId = (int)$this->viewVars['currentBbsArticle']['bbsArticleTree']['id'];
		}

		$bbsArticleTree = $this->BbsArticleTree->create(array(
			'id' => null,
			'bbs_article_key' => null,
			'bbs_key' => $this->viewVars['bbs']['key'],
			'root_id' => $rootArticleTreeId,
			'parent_id' => (int)$this->viewVars['currentBbsArticle']['bbsArticleTree']['id'],
		));
		$bbsArticle = $this->BbsArticle->create(array(
			'id' => null,
			'key' => null,
			'bbs_id' => $this->viewVars['bbs']['id'],
			'title' => null,
			'content' => '',
		));

		$bbsArticle['BbsArticle']['title'] = $this->__replyTitle($this->viewVars['currentBbsArticle']['bbsArticle']['title']);
		if (isset($this->params->query['quote']) && $this->params->query['quote']) {
			$bbsArticle['BbsArticle']['content'] =
							'<p></p><blockquote class="small">' .
								$this->viewVars['currentBbsArticle']['bbsArticle']['content'] .
							'</blockquote><p></p>';
		}

		$data = array();
		if ($this->request->isPost()) {
			if (! $status = $this->NetCommonsWorkflow->parseStatus()) {
				return;
			}
			if ($status !== NetCommonsBlockComponent::STATUS_IN_DRAFT) {
				$status = $this->viewVars['contentCommentPublishable'] ?
								NetCommonsBlockComponent::STATUS_PUBLISHED : NetCommonsBlockComponent::STATUS_APPROVED;
			}

			$data = Hash::merge(
				$this->data,
				['BbsArticle' => ['status' => $status]]
			);

			$data['BbsArticleTree']['article_no'] = $this->BbsArticleTree->getMaxNo($rootArticleTreeId) + 1;
			unset($data['BbsArticle']['id']);

			if ($this->BbsArticles->saveBbsArticle($data)) {
				return;
			}
			$data['contentStatus'] = null;
			$data['comments'] = null;
		}

		$data = Hash::merge(
			$bbsArticle, $bbsArticleTree, $data,
			['contentStatus' => null, 'comments' => []]
		);
		$results = $this->camelizeKeyRecursive($data);
		$this->set($results);
	}

/**
 * Title of reply
 *
 * @param string $title bbs_articles.title
 * @return string bbs_articles.title
 */
	private function __replyTitle($title) {
		$title = '';
		if (isset($this->params->query['quote']) && $this->params->query['quote']) {
			$matches = array();
			if (preg_match('/^Re(\d)?:/', $title, $matches)) {
				if (isset($matches[1])) {
					$count = (int)$matches[1];
				} else {
					$count = 1;
				}
				$title = preg_replace('/^Re(\d)?:/', 'Re' . ($count + 1) . ': ', $title);
			} else {
				$title = 'Re: ' . $title;
			}
		}

		return $title;
	}

/**
 * edit
 *
 * @param int $frameId frames.id
 * @param string $bbsArticleKey bbs_articles.key
 * @return void
 */
	public function edit($frameId = null, $bbsArticleKey = null) {
		$this->view = 'edit';
		$this->initBbs(['bbsFrameSetting']);
		$this->BbsArticles->setBbsArticle($bbsArticleKey);

		$data = array();
		if ($this->request->isPost()) {
			if (! $status = $this->NetCommonsWorkflow->parseStatus()) {
				return;
			}
			if ($this->viewVars['currentBbsArticle']['bbsArticleTree']['rootId'] > 0 && $status !== NetCommonsBlockComponent::STATUS_IN_DRAFT) {
				$status = $this->viewVars['contentCommentPublishable'] ?
								NetCommonsBlockComponent::STATUS_PUBLISHED : NetCommonsBlockComponent::STATUS_APPROVED;
			}
			$data = Hash::merge(
				$this->data,
				['BbsArticle' => ['status' => $status]]
			);

			if (! $this->viewVars['currentBbsArticle']['bbsArticleTree']['rootId']) {
				unset($data['BbsArticle']['id']);
			}
			if ($this->BbsArticles->saveBbsArticle($data)) {
				return;
			}
		}

		$comments = $this->Comment->getComments(
			array(
				'plugin_key' => $this->params['plugin'],
				'content_key' => $bbsArticleKey
			)
		);
		$comments = $this->camelizeKeyRecursive($comments);
		$this->set(['comments' => $comments]);

		$data = $this->camelizeKeyRecursive(Hash::merge(
			$data,
			array('contentStatus' => $this->viewVars['currentBbsArticle']['bbsArticle']['status'])
		));
		$results = Hash::merge(
			$this->viewVars['currentBbsArticle'], $data
		);
		$this->set($results);
	}

/**
 * delete
 *
 * @param int $frameId frames.id
 * @param string $bbsArticleKey bbs_articles.key
 * @return void
 */
	public function delete($frameId = null, $bbsArticleKey = null) {
		$this->initBbs(['bbsFrameSetting']);
		$this->BbsArticles->setBbsArticle($bbsArticleKey, ['rootBbsArticle', 'parentBbsArticle']);

		if (! $this->request->isDelete()) {
			$this->throwBadRequest();
			return;
		}

		$data = Hash::merge(
			$this->data,
			['BbsArticle' => ['status' => $this->viewVars['currentBbsArticle']['bbsArticle']['status']]]
		);
		if (! $this->BbsArticle->deleteBbsArticle($data)) {
			$this->throwBadRequest();
			return;
		}
		if (! $this->request->is('ajax')) {
			if ($this->viewVars['currentBbsArticle']['bbsArticleTree']['parentId']) {
				$action = 'view';
				$articleKey = $this->viewVars['parentBbsArticle']['bbsArticle']['key'];
			} else {
				$action = 'index';
				$articleKey = '';
			}
			$this->redirect('/bbses/bbs_articles/' . $action . '/' . $this->viewVars['frameId'] . '/' . $articleKey);
		}
	}

/**
 * approve
 *
 * @param int $frameId frames.id
 * @param string $bbsArticleKey bbs_articles.key
 * @return void
 */
	public function approve($frameId = null, $bbsArticleKey = null) {
		$this->initBbs(['bbsFrameSetting']);
		$this->BbsArticles->setBbsArticle($bbsArticleKey);

		if (! $this->request->isPost()) {
			$this->throwBadRequest();
			return;
		}
		if (! $status = $this->NetCommonsWorkflow->parseStatus()) {
			$this->throwBadRequest();
			return;
		}
		if (! $this->viewVars['currentBbsArticle']['bbsArticleTree']['rootId']) {
			$this->throwBadRequest();
			return;
		}

		$data = Hash::merge(
			$this->data,
			array('BbsArticle' => array(
				'status' => $status
			)),
			array('BbsArticleTree' => array(
				'root_id' => $this->viewVars['currentBbsArticle']['bbsArticleTree']['rootId']
			))
		);

		$this->BbsArticle->saveCommentAsPublish($data);
		if ($this->handleValidationError($this->BbsArticle->validationErrors)) {
			if (! $this->request->is('ajax')) {
				$this->redirect('/bbses/bbs_articles/view/' . $this->viewVars['frameId'] . '/' . $bbsArticleKey);
			}
			return;
		}

		$this->throwBadRequest();
	}
}
