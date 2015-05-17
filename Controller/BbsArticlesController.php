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
//		'Frames.Frame',
//		'Bbses.Bbs',
		'Bbses.BbsFrameSetting',
		'Bbses.BbsArticle',
		'Bbses.BbsArticleTree',
//		'Bbses.BbsSetting',
		'Bbses.BbsArticlesUser',
//		'Users.User',
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
			$articles = $this->Paginator->paginate('BbsArticle');
		} catch (Exception $ex) {
			$this->params['named'] = array();
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

//		$this->set('bbsPostId', (int)$bbsPostId);
		$this->BbsArticles->setBbsArticle($bbsArticleKey);

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

//		$bbsPostI18n = $this->BbsPostI18n->create(
//			array(
//				'id' => null,
//				'key' => null,
//				'bbs_post_id' => null,
//				'title' => null,
//				'content' => '',
//			)
//		);

//		$data = Hash::merge($bbsPost, $bbsPostI18n, ['contentStatus' => null, 'comments' => []]);

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

			if ($this->BbsArticles->saveBbsArticle($data, 'id')) {
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
 * @param int $parentPostId Parent bbs_posts.id
 * @return void
 */
	public function reply($frameId = null, $bbsArticleKey = null) {
		$this->view = 'edit';
		$this->initBbs(['bbsFrameSetting']);

		$this->BbsArticles->setBbsArticle($bbsArticleKey);

//		$this->set('bbsPostId', (int)$parentPostId);
//		$this->BbsPosts->initBbsPost();
//
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

		if (isset($this->params->query['quote']) && $this->params->query['quote']) {
			$matches = array();
			$title = $this->viewVars['currentBbsArticle']['bbsArticle']['title'];

			if (preg_match('/^Re(\d)?:/', $title, $matches)) {
				$bbsArticle['BbsArticle']['title'] = preg_replace('/^Re(\d)?:/', 'Re' . (int)$matches[1] . ': ', $title, $matches);
			} else {
				$bbsArticle['BbsArticle']['title'] = 'Re: ' . $title;
			}
			$bbsArticle['BbsArticle']['content'] =
							'<p></p><blockquote>' .
								$this->viewVars['currentBbsArticle']['bbsArticle']['content'] .
							'</blockquote><p></p>';
		}
//
//		$data = Hash::merge($bbsPost, $bbsPostI18n, ['contentStatus' => null, 'comments' => []]);

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

			if ($this->BbsArticles->saveBbsArticle($data, 'parentId')) {
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
 * edit
 *
 * @param int $frameId frames.id
 * @param int $bbsPostId bbsPosts.id
 * @return void
 */
	public function edit($frameId = null, $bbsArticleKey = null) {
//		$this->initBbs(['bbsFrameSetting']);
//
//		$this->set('bbsPostId', (int)$bbsPostId);
//		$this->BbsPosts->initBbsPost(['comments']);
//
//		$data = Hash::merge(
//			$this->viewVars['currentBbsPost'],
//			array('contentStatus' => $this->viewVars['currentBbsPost']['bbsPostI18n']['status'])
//		);
//
//		if ($this->request->isPost()) {
//			if (! $status = $this->NetCommonsWorkflow->parseStatus()) {
//				return;
//			}
//			if ($this->viewVars['currentBbsPost']['bbsPost']['rootId'] > 0 && $status !== NetCommonsBlockComponent::STATUS_IN_DRAFT) {
//				$status = $this->viewVars['bbsCommentPublishable'] ?
//								NetCommonsBlockComponent::STATUS_PUBLISHED : NetCommonsBlockComponent::STATUS_APPROVED;
//			}
//
//			$data = Hash::merge(
//				$this->data,
//				['BbsPostI18n' => ['status' => $status]],
//				['BbsPost' => ['last_status' => $status]]
//			);
//
//			if (! $this->viewVars['currentBbsPost']['bbsPost']['rootId']) {
//				unset($data['BbsPostI18n']['id']);
//			}
//
//			$this->BbsPost->setDataSource('master');
//			if ($this->BbsPosts->saveBbsPost($data, 'id')) {
//				return;
//			}
//		}
//
//		$results = $this->camelizeKeyRecursive($data);
//		$this->set($results);
	}

/**
 * delete
 *
 * @param int $frameId frames.id
 * @param int $bbsPostId postId
 * @throws BadRequestException
 * @return void
 */
	public function delete($frameId = null, $bbsPostId = null) {
//		$this->initBbs(['bbsFrameSetting']);
//
//		$this->set('bbsPostId', (int)$bbsPostId);
//		$this->BbsPosts->initBbsPost();
//
//		if (! $this->request->isDelete()) {
//			$this->throwBadRequest();
//			return;
//		}
//		if (! $this->BbsPost->deleteBbsPost($this->data)) {
//			$this->throwBadRequest();
//			return;
//		}
//		if (! $this->request->is('ajax')) {
//			$this->redirect('/bbses/bbs_posts/' .
//					($this->viewVars['currentBbsPost']['bbsPost']['parentId'] ? 'view' : 'index') . '/' .
//					$this->viewVars['frameId'] . '/' . $this->viewVars['currentBbsPost']['bbsPost']['parentId']);
//		}
	}

/**
 * approve
 *
 * @param int $frameId frames.id
 * @param int $bbsPostId bbsPosts.id
 * @return void
 */
	public function approve($frameId = null, $bbsPostId = null) {
//		$this->initBbs(['bbsFrameSetting']);
//
//		$this->set('bbsPostId', (int)$bbsPostId);
//		$this->BbsPosts->initBbsPost();
//
//		if (! $this->request->isPost()) {
//			$this->throwBadRequest();
//			return;
//		}
//		if (! $status = $this->NetCommonsWorkflow->parseStatus()) {
//			$this->throwBadRequest();
//			return;
//		}
//		if (! $this->viewVars['currentBbsPost']['bbsPost']['rootId']) {
//			$this->throwBadRequest();
//			return;
//		}
//
//		$data = Hash::merge(
//			$this->data,
//			array('BbsPostI18n' => array('status' => $status)),
//			array('BbsPost' => array(
//				'last_status' => $status,
//				'root_id' => $this->viewVars['currentBbsPost']['bbsPost']['rootId']
//			))
//		);
//
//		$this->BbsPost->setDataSource('master');
//		$this->BbsPost->saveCommentAsPublish($data);
//		if ($this->handleValidationError($this->BbsPost->validationErrors)) {
//			if (! $this->request->is('ajax')) {
//				$this->redirect($this->request->referer());
//			}
//			return;
//		}
//
//		$this->throwBadRequest();
	}
}
