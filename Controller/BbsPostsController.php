<?php
/**
 * BbsPosts Controller
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
 * Bbses Controller
 *
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @package NetCommons\Bbses\Controller
 */
class BbsPostsController extends BbsesAppController {

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		'Frames.Frame',
		'Bbses.Bbs',
		'Bbses.BbsFrameSetting',
		'Bbses.BbsPost',
		'Bbses.BbsPostI18n',
		'Bbses.BbsSetting',
		'Bbses.BbsPostsUser',
		'Users.User',
		'Comments.Comment',
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsBlock',
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsWorkflow',
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'contentCreatable' => array('add', 'reply', 'edit', 'delete'),
				'bbsPostCreatable' => array('add', 'reply', 'edit', 'delete')
			),
		),
		'Paginator',
		'Bbses.BbsPosts'
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
			$this->view = 'BbsPosts/noBbs';
			return;
		}
		$this->initBbs(['bbsFrameSetting']);

		//Paginatorの設定
		$this->Paginator->settings = $this->BbsPosts->paginatorSettings();

		try {
			$posts = $this->Paginator->paginate('BbsPost');
		} catch (Exception $ex) {
			$this->params['named'] = array();
			$posts = $this->Paginator->paginate('BbsPost');
		}
		$results = array(
			'bbsPosts' => $posts
		);
		$results = $this->camelizeKeyRecursive($results);
		$this->set($results);
	}

/**
 * view
 *
 * @param int $frameId frames.id
 * @param int $bbsPostId posts.id
 * @return void
 * @throws BadRequestException throw new
 */
	public function view($frameId = null, $bbsPostId = null) {
		if (! $this->viewVars['blockId']) {
			$this->view = 'BbsPosts/noBbs';
			return;
		}

		$this->initBbs(['bbsFrameSetting']);

		$this->set('bbsPostId', (int)$bbsPostId);
		$this->BbsPosts->initBbsPost();

		//既読
		if ($this->viewVars['userId'] && ! $this->viewVars['currentBbsPost']['bbsPostsUser']) {
			$data = $this->BbsPostsUser->create(array(
				'bbs_post_id' => $bbsPostId,
				'user_id' => $this->viewVars['userId']
			));
			$this->BbsPostsUser->setDataSource('master');
			$result = $this->BbsPostsUser->savePostsUser($data);
			$result = $this->camelizeKeyRecursive($result);
			$this->viewVars['currentBbsPost']['bbsPostsUser'] = $result;
		}

		//$this->BbsPost->Behaviors->load('Tree', array(
		//	'scope' => array(
		//		'OR' => array(
		//			'BbsPost.last_status' => 0,
		//			'BbsPost.root_id' => 1,
		//		)
		//	)
		//));

		$children = $this->BbsPost->children(
			$this->viewVars['bbsPostId'], false, null, 'BbsPost.id DESC', null, 1, 1
		);
		$children = $this->camelizeKeyRecursive($children);
		$children = Hash::combine($children, '{n}.bbsPost.id', '{n}');

		$this->set(['bbsPostChildren' => $children]);
	}

/**
 * add
 *
 * @return void
 */
	public function add() {
		$this->view = 'BbsPosts/edit';
		$this->initBbs(['bbsFrameSetting']);

		$bbsPost = $this->BbsPost->create(
			array(
				'id' => null,
				'key' => null,
				'bbs_key' => $this->viewVars['bbs']['key'],
				'root_id' => null,
				'parent_id' => null,
			)
		);
		$bbsPostI18n = $this->BbsPostI18n->create(
			array(
				'id' => null,
				'key' => null,
				'bbs_post_id' => null,
				'title' => null,
				'content' => '',
			)
		);

		$data = Hash::merge($bbsPost, $bbsPostI18n, ['contentStatus' => null, 'comments' => []]);

		if ($this->request->isPost()) {
			if (! $status = $this->NetCommonsWorkflow->parseStatus()) {
				return;
			}
			$data = Hash::merge(
				$this->data,
				['BbsPostI18n' => ['status' => $status]],
				['BbsPost' => ['last_status' => $status]]
			);

			$data['BbsPost']['post_no'] = 1;
			$data['BbsPost']['key'] = Security::hash('bbs_post' . mt_rand() . microtime(), 'md5');
			unset($data['BbsPost']['id']);

			if ($this->BbsPosts->saveBbsPost($data, 'id')) {
				return;
			}
			$data['contentStatus'] = null;
			$data['comments'] = null;
		}

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
	public function reply($frameId = null, $parentPostId = null) {
		$this->view = 'BbsPosts/edit';
		$this->initBbs(['bbsFrameSetting']);

		$this->set('bbsPostId', (int)$parentPostId);
		$this->BbsPosts->initBbsPost();

		if ((int)$this->viewVars['currentBbsPost']['bbsPost']['rootId'] > 0) {
			$rootPostId = (int)$this->viewVars['currentBbsPost']['bbsPost']['rootId'];
		} else {
			$rootPostId = (int)$this->viewVars['currentBbsPost']['bbsPost']['id'];
		}

		$bbsPost = $this->BbsPost->create(
			array(
				'id' => null,
				'key' => null,
				'bbs_key' => $this->viewVars['bbs']['key'],
				'root_id' => $rootPostId,
				'parent_id' => (int)$parentPostId,
			)
		);
		$bbsPostI18n = $this->BbsPostI18n->create(
			array(
				'id' => null,
				'key' => null,
				'bbs_post_id' => null,
				'title' => null,
				'content' => '',
			)
		);

		if (isset($this->params->query['quote']) && $this->params->query['quote']) {
			$bbsPostI18n['BbsPostI18n']['title'] = 'Re: ' . $this->viewVars['currentBbsPost']['bbsPostI18n']['title'];
			$bbsPostI18n['BbsPostI18n']['content'] =
							'<p></p><blockquote class="small">' .
								$this->viewVars['currentBbsPost']['bbsPostI18n']['content'] .
							'</blockquote><p></p>';
		}

		$data = Hash::merge($bbsPost, $bbsPostI18n, ['contentStatus' => null, 'comments' => []]);

		if ($this->request->isPost()) {
			if (! $status = $this->NetCommonsWorkflow->parseStatus()) {
				return;
			}
			if ($status !== NetCommonsBlockComponent::STATUS_IN_DRAFT) {
				$status = $this->viewVars['bbsCommentPublishable'] ?
								NetCommonsBlockComponent::STATUS_PUBLISHED : NetCommonsBlockComponent::STATUS_APPROVED;
			}

			$data = Hash::merge(
				$this->data,
				['BbsPostI18n' => ['status' => $status]],
				['BbsPost' => ['last_status' => $status]]
			);

			$this->BbsPost->setDataSource('master');

			$data['BbsPost']['post_no'] = $this->BbsPost->getMaxNo($rootPostId) + 1;
			$data['BbsPost']['key'] = Security::hash('bbs_post' . mt_rand() . microtime(), 'md5');
			unset($data['BbsPost']['id']);

			if ($this->BbsPosts->saveBbsPost($data, 'parent_id')) {
				return;
			}
			$data['contentStatus'] = null;
			$data['comments'] = null;
		}

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
	public function edit($frameId = null, $bbsPostId = null) {
		$this->initBbs(['bbsFrameSetting']);

		$this->set('bbsPostId', (int)$bbsPostId);
		$this->BbsPosts->initBbsPost(['comments']);

		$data = Hash::merge(
			$this->viewVars['currentBbsPost'],
			array('contentStatus' => $this->viewVars['currentBbsPost']['bbsPostI18n']['status'])
		);

		if ($this->request->isPost()) {
			if (! $status = $this->NetCommonsWorkflow->parseStatus()) {
				return;
			}
			if ($this->viewVars['currentBbsPost']['bbsPost']['rootId'] > 0 && $status !== NetCommonsBlockComponent::STATUS_IN_DRAFT) {
				$status = $this->viewVars['bbsCommentPublishable'] ?
								NetCommonsBlockComponent::STATUS_PUBLISHED : NetCommonsBlockComponent::STATUS_APPROVED;
			}

			$data = Hash::merge(
				$this->data,
				['BbsPostI18n' => ['status' => $status]],
				['BbsPost' => ['last_status' => $status]]
			);

			if (! $this->viewVars['currentBbsPost']['bbsPost']['rootId']) {
				unset($data['BbsPostI18n']['id']);
			}

			$this->BbsPost->setDataSource('master');
			if ($this->BbsPosts->saveBbsPost($data, 'id')) {
				return;
			}
		}

		$results = $this->camelizeKeyRecursive($data);
		$this->set($results);
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
		$this->initBbs(['bbsFrameSetting']);

		$this->set('bbsPostId', (int)$bbsPostId);
		$this->BbsPosts->initBbsPost();

		if (! $this->request->isDelete()) {
			$this->throwBadRequest();
			return;
		}
		if (! $this->BbsPost->deleteBbsPost($this->data)) {
			$this->throwBadRequest();
			return;
		}
		if (! $this->request->is('ajax')) {
			$this->redirect('/bbses/bbs_posts/' .
					($this->viewVars['currentBbsPost']['bbsPost']['parentId'] ? 'view' : 'index') . '/' .
					$this->viewVars['frameId'] . '/' . $this->viewVars['currentBbsPost']['bbsPost']['parentId']);
		}
	}

/**
 * approve
 *
 * @param int $frameId frames.id
 * @param int $bbsPostId bbsPosts.id
 * @return void
 */
	public function approve($frameId = null, $bbsPostId = null) {
		$this->initBbs(['bbsFrameSetting']);

		$this->set('bbsPostId', (int)$bbsPostId);
		$this->BbsPosts->initBbsPost();

		if (! $this->request->isPost()) {
			$this->throwBadRequest();
			return;
		}
		if (! $status = $this->NetCommonsWorkflow->parseStatus()) {
			$this->throwBadRequest();
			return;
		}
		if (! $this->viewVars['currentBbsPost']['bbsPost']['rootId']) {
			$this->throwBadRequest();
			return;
		}

		$data = Hash::merge(
			$this->data,
			array('BbsPostI18n' => array('status' => $status)),
			array('BbsPost' => array(
				'last_status' => $status,
				'root_id' => $this->viewVars['currentBbsPost']['bbsPost']['rootId']
			))
		);

		$this->BbsPost->setDataSource('master');
		$this->BbsPost->saveCommentAsPublish($data);
		if ($this->handleValidationError($this->BbsPost->validationErrors)) {
			if (! $this->request->is('ajax')) {
				$this->redirect($this->request->referer());
			}
			return;
		}

		$this->throwBadRequest();
	}
}
