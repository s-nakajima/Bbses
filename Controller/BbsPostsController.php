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
		$this->initBbs(['bbs', 'bbsSetting', 'bbsFrameSetting']);

		//言語の指定
		$this->BbsPost->bindModel(array('hasMany' => array(
				'BbsPostI18n' => array(
					'foreignKey' => 'bbs_post_id',
					'limit' => 1,
					'order' => 'BbsPostI18n.id DESC',
					'conditions' => array(
						'BbsPostI18n.language_id' => $this->viewVars['languageId']
					)
				),
				'BbsPostsUser' => array(
					'foreignKey' => 'bbs_post_id',
					'conditions' => array(
						'BbsPostsUser.user_id' => (int)$this->Auth->user('id')
					)
				),
			)),
			false
		);
		//条件
		$conditions = array(
			'BbsPost.bbs_key' => $this->viewVars['bbs']['key'],
			'BbsPost.parent_id' => null,
		);
		if (isset($this->params['named']['status'])) {
			$conditions['BbsPost.last_status'] = (int)$this->params['named']['status'];
		}
		//ソート
		if (isset($this->params['named']['sort']) && isset($this->params['named']['direction'])) {
			$order = array($this->params['named']['sort'] => $this->params['named']['direction']);
		} else {
			$order = array('BbsPost.created' => 'desc');
		}
		//表示件数
		if (isset($this->params['named']['limit'])) {
			$limit = (int)$this->params['named']['limit'];
		} else {
			$limit = (int)$this->viewVars['bbsFrameSetting']['postsPerPage'];
		}
		//Paginatorの設定
		$this->Paginator->settings = array(
			'BbsPost' => array('conditions' => $conditions, 'order' => $order, 'limit' => $limit)
		);

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

		$this->initBbs(['bbs', 'bbsSetting', 'bbsFrameSetting']);

		$this->set('bbsPostId', (int)$bbsPostId);
		$this->__initBbsPost();

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
		$this->initBbs(['bbs', 'bbsSetting', 'bbsFrameSetting']);

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

			$bbsPost = $this->BbsPost->saveBbsPost($data);
			if ($this->handleValidationError($this->BbsPost->validationErrors)) {
				if (! $this->request->is('ajax')) {
					$this->redirect('/bbses/bbs_posts/view/' . $this->viewVars['frameId'] . '/' . $bbsPost['BbsPost']['id']);
				}
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
		$this->initBbs(['bbs', 'bbsSetting', 'bbsFrameSetting']);

		$this->set('bbsPostId', (int)$parentPostId);
		$this->__initBbsPost();

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
							'<br /><blockquote class="small">' .
								$this->viewVars['currentBbsPost']['bbsPostI18n']['content'] .
							'</blockquote>';
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

			$bbsPost = $this->BbsPost->saveBbsPost($data);
			if ($this->handleValidationError($this->BbsPost->validationErrors)) {
				if (! $this->request->is('ajax')) {
					$this->redirect('/bbses/bbs_posts/view/' . $this->viewVars['frameId'] . '/' . $bbsPost['BbsPost']['parent_id']);
				}
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
		$this->initBbs(['bbs', 'bbsSetting', 'bbsFrameSetting']);

		$this->set('bbsPostId', (int)$bbsPostId);
		$this->__initBbsPost(['comments']);

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
			$bbsPost = $this->BbsPost->saveBbsPost($data);
			if ($this->handleValidationError($this->BbsPost->validationErrors)) {
				if (! $this->request->is('ajax')) {
					$this->redirect('/bbses/bbs_posts/view/' . $this->viewVars['frameId'] . '/' . $bbsPost['BbsPost']['id']);
				}
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
		$this->initBbs(['bbs', 'bbsSetting', 'bbsFrameSetting']);

		$this->set('bbsPostId', (int)$bbsPostId);
		$this->__initBbsPost();

		if (! $this->request->isDelete()) {
			$this->_throwBadRequest();
			return;
		}
		if (! $this->BbsPost->deleteBbsPost($this->data)) {
			$this->_throwBadRequest();
			return;
		}
		if (! $this->request->is('ajax')) {
			$this->redirect('/bbses/bbs_posts/' .
					($this->viewVars['currentBbsPost']['bbsPost']['parentId'] ? 'view' : 'index') . '/' .
					$this->viewVars['frameId'] . '/' . $this->viewVars['currentBbsPost']['bbsPost']['parentId']);
		}
	}

/**
 * edit
 *
 * @param int $frameId frames.id
 * @param int $bbsPostId bbsPosts.id
 * @return void
 */
	public function approve($frameId = null, $bbsPostId = null) {
		$this->initBbs(['bbs', 'bbsSetting', 'bbsFrameSetting']);

		$this->set('bbsPostId', (int)$bbsPostId);
		$this->__initBbsPost();

		if (! $this->request->isPost()) {
			$this->_throwBadRequest();
			return;
		}
		if (! $status = $this->NetCommonsWorkflow->parseStatus()) {
			$this->_throwBadRequest();
			return;
		}
		if (! $this->viewVars['currentBbsPost']['bbsPost']['rootId']) {
			$this->_throwBadRequest();
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

		$this->_throwBadRequest();
	}

/**
 * initBbs
 *
 * @param array $contains Optional result sets
 * @return void
 */
	private function __initBbsPost($contains = []) {
		if (! $bbsPost = $this->BbsPost->find('first', array(
			'recursive' => 1,
			'conditions' => array(
				'BbsPost.id' => $this->viewVars['bbsPostId'],
			)
		))) {
			$this->_throwBadRequest();
			return false;
		}
		$bbsPost = $this->camelizeKeyRecursive($bbsPost);
		$this->set(['currentBbsPost' => $bbsPost]);

		if ($bbsPost['bbsPost']['rootId'] > 0) {
			//コメント表示の場合、根記事を取得
			if (! $rootBbsPost = $this->BbsPost->find('first', array(
				'recursive' => 1,
				'conditions' => array(
					'BbsPost.id' => $bbsPost['bbsPost']['rootId'],
				)
			))) {
				$this->_throwBadRequest();
				return false;
			}
			$rootBbsPost = $this->camelizeKeyRecursive($rootBbsPost);
			$this->set(['rootBbsPost' => $rootBbsPost]);
		}

		if ($bbsPost['bbsPost']['parentId'] > 0) {
			if ($bbsPost['bbsPost']['parentId'] !== $bbsPost['bbsPost']['rootId']) {
				//コメント表示の場合、根記事を取得
				if (! $parentBbsPost = $this->BbsPost->find('first', array(
					'recursive' => 1,
					'conditions' => array(
						'BbsPost.id' => $bbsPost['bbsPost']['parentId'],
					)
				))) {
					$this->_throwBadRequest();
					return false;
				}
			} else {
				$parentBbsPost = $rootBbsPost;
			}
			$parentBbsPost = $this->camelizeKeyRecursive($parentBbsPost);
			$this->set(['parentBbsPost' => $parentBbsPost]);
		}

		//コメント
		if (in_array('comments', $contains, true)) {
			$comments = $this->Comment->getComments(
				array(
					'plugin_key' => 'bbsposts',
					'content_key' => $bbsPost['bbsPost']['key']
				)
			);
			$comments = $this->camelizeKeyRecursive($comments);
			$this->set(['comments' => $comments]);
		}
	}

/**
 * likes method
 *
 * @param int $frameId frames.id
 * @param int $postId bbsPosts.id
 * @param int $userId users.id
 * @param bool $likesFlag likes flag
 * @return void
 */
	//public function likes($frameId, $postId, $userId, $likesFlag) {
	//	if (! $this->request->isPost()) {
	//		return;
	//	}
	//
	//	CakeSession::write('backUrl', $this->request->referer());
	//
	//	if (! $postsUsers = $this->BbsPostsUser->getPostsUsers(
	//			$postId,
	//			$userId
	//	)) {
	//		//データがなければ登録
	//		$default = $this->BbsPostsUser->create();
	//		$default['BbsPostsUser'] = array(
	//					'post_id' => $postId,
	//					'user_id' => $userId,
	//					'likes_flag' => (int)$likesFlag,
	//			);
	//		$this->BbsPostsUser->savePostsUsers($default);
	//
	//	} else {
	//		$postsUsers['BbsPostsUser']['likes_flag'] = (int)$likesFlag;
	//		$this->BbsPostsUser->savePostsUsers($postsUsers);
	//
	//	}
	//	$backUrl = CakeSession::read('backUrl');
	//	CakeSession::delete('backUrl');
	//	$this->redirect($backUrl);
	//}

/**
 * unlikes method
 *
 * @param int $frameId frames.id
 * @param int $postId bbsPosts.id
 * @param int $userId users.id
 * @param bool $unlikesFlag unlikes flag
 * @return void
 */
	//public function unlikes($frameId, $postId, $userId, $unlikesFlag) {
	//	if (! $this->request->isPost()) {
	//		return;
	//	}
	//
	//	CakeSession::write('backUrl', $this->request->referer());
	//
	//	if (! $postsUsers = $this->BbsPostsUser->getPostsUsers(
	//			$postId,
	//			$userId
	//	)) {
	//		//データがなければ登録
	//		$default = $this->BbsPostsUser->create();
	//		$default['BbsPostsUser'] = array(
	//					'post_id' => $postId,
	//					'user_id' => $userId,
	//					'unlikes_flag' => (int)$unlikesFlag,
	//			);
	//		$this->BbsPostsUser->savePostsUsers($default);
	//
	//	} else {
	//		$postsUsers['BbsPostsUser']['unlikes_flag'] = (int)$unlikesFlag;
	//		$this->BbsPostsUser->savePostsUsers($postsUsers);
	//
	//	}
	//	$backUrl = CakeSession::read('backUrl');
	//	CakeSession::delete('backUrl');
	//	$this->redirect($backUrl);
	//}
}
