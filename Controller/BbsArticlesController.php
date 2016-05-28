<?php
/**
 * BbsArticles Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BbsesAppController', 'Bbses.Controller');
App::uses('CakeText', 'Utility');
App::uses('WorkflowComponent', 'Workflow.Controller/Component');

/**
 * BbsArticles Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
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
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.Permission' => array(
			//アクセスの権限
			'allow' => array(
				'add,edit,delete' => 'content_creatable',
				'reply' => 'content_comment_creatable',
				'approve' => 'content_comment_publishable',
			),
		),
		'Paginator',
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'Bbses.BbsesForm',
		'Likes.Like',
		'NetCommons.DisplayNumber',
		'Workflow.Workflow',
	);

/**
 * beforeRender
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();

		if (! Current::read('Block.id')) {
			$this->setAction('emptyRender');
			return false;
		}
		if (! $bbs = $this->Bbs->getBbs()) {
			$this->setAction('throwBadRequest');
			return false;
		}
		$this->set('bbs', $bbs['Bbs']);
		$this->set('bbsSetting', $bbs['BbsSetting']);

		$bbsFrameSetting = $this->BbsFrameSetting->getBbsFrameSetting(true);
		$this->set('bbsFrameSetting', $bbsFrameSetting['BbsFrameSetting']);
	}

/**
 * index
 *
 * @return void
 * @throws Exception
 */
	public function index() {
		$query = array();
		//条件
		$query['conditions'] = $this->BbsArticle->getWorkflowConditions(array(
			'BbsArticleTree.parent_id' => null,
			'BbsArticle.bbs_id' => $this->viewVars['bbs']['id'],
		));
		//ソート
		if (isset($this->params['named']['sort']) && isset($this->params['named']['direction'])) {
			$query['order'] = array($this->params['named']['sort'] => $this->params['named']['direction']);
		} else {
			$query['order'] = array('BbsArticle.created' => 'desc');
		}
		//表示件数
		if (isset($this->params['named']['limit'])) {
			$query['limit'] = (int)$this->params['named']['limit'];
		} else {
			$query['limit'] = $this->viewVars['bbsFrameSetting']['articles_per_page'];
		}

		$this->Paginator->settings = $query;
		try {
			$bbsArticles = $this->Paginator->paginate('BbsArticle');
		} catch (Exception $ex) {
			CakeLog::error($ex);
			throw $ex;
		}
		$this->set('bbsArticles', $bbsArticles);
	}

/**
 * view
 *
 * @return void
 * @throws BadRequestException throw
 */
	public function view() {
		//参照権限チェック
		if (! $this->BbsArticle->canReadWorkflowContent()) {
			return $this->throwBadRequest();
		}

		$bbsArticleKey = null;
		if (isset($this->params['pass'][1])) {
			$bbsArticleKey = $this->params['pass'][1];
		}

		//カレント記事の取得
		$bbsArticle = $this->BbsArticle->getWorkflowContents('first', array(
			'recursive' => 0,
			'conditions' => array(
				$this->BbsArticle->alias . '.bbs_id' => $this->viewVars['bbs']['id'],
				$this->BbsArticle->alias . '.key' => $bbsArticleKey
			)
		));
		if (! $bbsArticle) {
			return $this->throwBadRequest();
		}
		$this->set('currentBbsArticle', $bbsArticle);

		$conditions = $this->BbsArticle->getWorkflowConditions();

		//事前準備
		$result = $this->__prepare($bbsArticle);
		if (! $result) {
			return $this->throwBadRequest();
		}

		//子記事の取得
		$this->BbsArticleTree->Behaviors->load('Tree', array(
			'scope' => $conditions
		));
		$children = $this->BbsArticleTree->children(
			$bbsArticle['BbsArticleTree']['id'], false, null, 'BbsArticleTree.id DESC', null, 1, 1
		);
		$children = Hash::combine($children, '{n}.BbsArticleTree.id', '{n}');

		$this->set('bbsArticleChildren', $children);

		//新着データを既読にする
		$this->BbsArticle->saveTopicUserStatus($bbsArticle);
	}

/**
 * add
 *
 * @return void
 */
	public function add() {
		$this->view = 'edit';

		if ($this->request->is('post')) {
			$data = $this->data;

			$data['BbsArticle']['status'] = $this->Workflow->parseStatus();
			$data['BbsArticleTree']['article_no'] = 1;
			unset($data['BbsArticle']['id']);

			if ($bbsArticle = $this->BbsArticle->saveBbsArticle($data)) {
				$url = NetCommonsUrl::actionUrl(array(
					'controller' => $this->params['controller'],
					'action' => 'view',
					'block_id' => $this->data['Block']['id'],
					'frame_id' => $this->data['Frame']['id'],
					'key' => $bbsArticle['BbsArticle']['key']
				));
				$this->redirect($url);
				return;
			}
			$this->NetCommons->handleValidationError($this->BbsArticle->validationErrors);

		} else {
			$this->request->data = Hash::merge($this->request->data,
				$this->BbsArticle->create(array(
					'bbs_id' => $this->viewVars['bbs']['id'],
				)),
				$this->BbsArticleTree->create(array(
					'bbs_key' => $this->viewVars['bbs']['key'],
					'post_no' => 1,
				))
			);
			$this->request->data['Bbs'] = $this->viewVars['bbs'];
			$this->request->data['Frame'] = Current::read('Frame');
			$this->request->data['Block'] = Current::read('Block');
		}
	}

/**
 * reply
 *
 * @return void
 */
	public function reply() {
		$this->view = 'edit';

		$bbsArticleKey = $this->params['pass'][1];
		$bbsArticle = $this->BbsArticle->getWorkflowContents('first', array(
			'recursive' => 0,
			'conditions' => array(
				$this->BbsArticle->alias . '.bbs_id' => $this->viewVars['bbs']['id'],
				$this->BbsArticle->alias . '.key' => $bbsArticleKey
			)
		));

		if (Hash::get($bbsArticle, 'BbsArticle.status') !== WorkflowComponent::STATUS_PUBLISHED) {
			return $this->throwBadRequest();
		}

		//事前準備
		$this->set('currentBbsArticle', $bbsArticle);
		$result = $this->__prepare($bbsArticle);
		if (! $result) {
			return $this->throwBadRequest();
		}

		if ($this->request->is('post')) {
			$data = $this->data;
			$data['BbsArticle']['status'] = $this->Workflow->parseStatus();

			$articleNo = $this->BbsArticleTree->getMaxNo($data['BbsArticleTree']['root_id']) + 1;
			$data['BbsArticleTree']['article_no'] = $articleNo;
			unset($data['BbsArticle']['id']);

			$bbsArticle = $this->BbsArticle->saveBbsArticle($data);
			if ($bbsArticle) {
				$url = NetCommonsUrl::actionUrl(array(
					'controller' => $this->params['controller'],
					'action' => 'view',
					'block_id' => $this->data['Block']['id'],
					'frame_id' => $this->data['Frame']['id'],
					'key' => $bbsArticle['BbsArticle']['key']
				));
				return $this->redirect($url);
			}
			$this->NetCommons->handleValidationError($this->BbsArticle->validationErrors);

		} else {
			if ($bbsArticle['BbsArticleTree']['root_id'] > 0) {
				$rootId = (int)$bbsArticle['BbsArticleTree']['root_id'];
			} else {
				$rootId = (int)$bbsArticle['BbsArticleTree']['id'];
			}
			if (isset($this->params->query['quote']) && $this->params->query['quote']) {
				$title = $this->BbsArticle->getReplyTitle($bbsArticle['BbsArticle']['title']);
				$content = $this->BbsArticle->getReplyContent($bbsArticle['BbsArticle']['content']);
			} else {
				$title = null;
				$content = null;
			}
			$this->request->data = Hash::merge($this->request->data,
				$this->BbsArticle->create(array(
					'bbs_id' => $this->viewVars['bbs']['id'],
					'title' => $title,
					'content' => $content,
				)),
				$this->BbsArticleTree->create(array(
					'bbs_key' => $this->viewVars['bbs']['key'],
					'root_id' => $rootId,
					'parent_id' => $bbsArticle['BbsArticleTree']['id'],
				))
			);
			$this->request->data['Bbs'] = $this->viewVars['bbs'];
			$this->request->data['Frame'] = Current::read('Frame');
			$this->request->data['Block'] = Current::read('Block');
		}
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		$this->view = 'edit';

		$bbsArticleKey = $this->params['pass'][1];
		if ($this->request->is('put')) {
			$bbsArticleKey = $this->data['BbsArticle']['key'];
		}

		$bbsArticle = $this->BbsArticle->getWorkflowContents('first', array(
			'recursive' => 0,
			'conditions' => array(
				$this->BbsArticle->alias . '.bbs_id' => $this->viewVars['bbs']['id'],
				$this->BbsArticle->alias . '.key' => $bbsArticleKey
			)
		));

		//掲示板の場合は、削除権限と同じ条件とする
		if (! $this->BbsArticle->canDeleteWorkflowContent($bbsArticle)) {
			return $this->throwBadRequest();
		}

		if ($this->request->is('put')) {
			$data = $this->data;
			$data['BbsArticle']['status'] = $this->Workflow->parseStatus();
			unset($data['BbsArticle']['id']);

			if ($bbsArticle = $this->BbsArticle->saveBbsArticle($data)) {
				$url = NetCommonsUrl::actionUrl(array(
					'controller' => $this->params['controller'],
					'action' => 'view',
					'block_id' => $this->data['Block']['id'],
					'frame_id' => $this->data['Frame']['id'],
					'key' => $bbsArticle['BbsArticle']['key']
				));
				return $this->redirect($url);
			}
			$this->NetCommons->handleValidationError($this->BbsArticle->validationErrors);

		} else {
			$this->request->data = $bbsArticle;
			$this->request->data['Bbs'] = $this->viewVars['bbs'];
			$this->request->data['Frame'] = Current::read('Frame');
			$this->request->data['Block'] = Current::read('Block');

		}

		$comments = $this->BbsArticle->getCommentsByContentKey($this->request->data['BbsArticle']['key']);
		$this->set('comments', $comments);
	}

/**
 * delete
 *
 * @return void
 */
	public function delete() {
		if (! $this->request->is('delete')) {
			return $this->throwBadRequest();
		}

		$bbsArticle = $this->BbsArticle->getWorkflowContents('first', array(
			'recursive' => 0,
			'conditions' => array(
				$this->BbsArticle->alias . '.bbs_id' => $this->viewVars['bbs']['id'],
				$this->BbsArticle->alias . '.key' => $this->data['BbsArticle']['key']
			)
		));

		//削除権限チェック
		if (! $this->BbsArticle->canDeleteWorkflowContent($bbsArticle)) {
			return $this->throwBadRequest();
		}

		//親記事の取得
		if ($bbsArticle['BbsArticleTree']['parent_id'] > 0) {
			$parentBbsArticle = $this->BbsArticle->getWorkflowContents('first', array(
				'recursive' => 0,
				'conditions' => array(
					$this->BbsArticleTree->alias . '.id' => $bbsArticle['BbsArticleTree']['parent_id'],
				)
			));
			if (! $parentBbsArticle) {
				return $this->throwBadRequest();
			}
		}

		if (! $this->BbsArticle->deleteBbsArticle($this->data)) {
			return $this->throwBadRequest();
		}

		if (isset($parentBbsArticle)) {
			$url = NetCommonsUrl::actionUrl(array(
				'controller' => $this->params['controller'],
				'action' => 'view',
				'block_id' => $this->data['Block']['id'],
				'frame_id' => $this->data['Frame']['id'],
				'key' => $parentBbsArticle['BbsArticle']['key']
			));
		} else {
			$url = NetCommonsUrl::backToPageUrl();
		}
		return $this->redirect($url);
	}

/**
 * approve
 *
 * @return void
 */
	public function approve() {
		if (! $this->request->is('put')) {
			return $this->throwBadRequest();
		}

		$data = $this->data;
		$data['BbsArticle']['status'] = $this->Workflow->parseStatus();
		if (! $data['BbsArticle']['status']) {
			return $this->throwBadRequest();
		}

		if ($this->BbsArticle->saveCommentAsPublish($data)) {
			$this->NetCommons->setFlashNotification(
				__d('net_commons', 'Successfully saved.'), array('class' => 'success')
			);

			$url = NetCommonsUrl::actionUrl(array(
				'controller' => $this->params['controller'],
				'action' => 'view',
				'block_id' => $this->data['Block']['id'],
				'frame_id' => $this->data['Frame']['id'],
				'key' => $this->data['BbsArticle']['key']
			));
			return $this->redirect($url);
		}
		$this->NetCommons->handleValidationError($this->BbsArticle->validationErrors);

		return $this->throwBadRequest();
	}

/**
 * 事前準備
 *
 * @param array $bbsArticle 記事データ
 * @return bool
 */
	private function __prepare($bbsArticle) {
		//根記事の取得
		if ($bbsArticle['BbsArticleTree']['root_id'] > 0) {
			$result = $this->__setBbsArticleByTreeId(
				'rootBbsArticle', $bbsArticle['BbsArticleTree']['root_id']
			);
			if (! $result) {
				return false;
			}
		}

		if (! $bbsArticle['BbsArticleTree']['parent_id']) {
			return true;
		}

		//親記事の取得
		if ($bbsArticle['BbsArticleTree']['parent_id'] !== $bbsArticle['BbsArticleTree']['root_id']) {
			$result = $this->__setBbsArticleByTreeId(
				'parentBbsArticle', $bbsArticle['BbsArticleTree']['parent_id']
			);
			if (! $result) {
				return false;
			}
		} else {
			$this->set('parentBbsArticle', $this->viewVars['rootBbsArticle']);
			$result = true;
		}

		//親の親記事の取得
		if ($this->viewVars['parentBbsArticle']['BbsArticleTree']['parent_id'] > 0) {
			$result = $this->__setBbsArticleByTreeId(
				'parentParentBbsArticle', $this->viewVars['parentBbsArticle']['BbsArticleTree']['parent_id']
			);
		}
		return $result;
	}

/**
 * 記事データをviewにセットする
 *
 * @param string $viewVarsKey viewVarsのキー
 * @param int $bbsArticleTreeId BbsArticleTreeId
 * @return bool
 */
	private function __setBbsArticleByTreeId($viewVarsKey, $bbsArticleTreeId) {
		$bbsArticle = $this->BbsArticle->getWorkflowContents('first', array(
			'recursive' => 0,
			'conditions' => array(
				$this->BbsArticleTree->alias . '.id' => $bbsArticleTreeId,
			)
		));
		if (! $bbsArticle) {
			return false;
		}
		$this->set($viewVarsKey, $bbsArticle);

		return true;
	}

}
