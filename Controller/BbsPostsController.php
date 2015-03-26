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
			$this->view = 'Bbses/notCreateBbs';
			return;
		}
		$this->initBbs(['bbs', 'bbsSetting', 'bbsFrameSetting']);
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
			$this->view = 'Bbses/notCreateBbs';
			return;
		}

		$this->initBbs(['bbs', 'bbsSetting', 'bbsFrameSetting']);

		$this->set('bbsPostId', (int)$bbsPostId);
		$this->__initBbsPost();

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
 * @param int $postId postId
 * @throws BadRequestException
 * @return void
 */
	public function delete($frameId, $postId) {
		//確認ダイアログ経由

		//if (! $this->request->isPost()) {
		//	return;
		//}
		//
		//if ($this->BbsPost->delete($postId)) {
		//	//記事一覧へリダイレクト
		//	$this->redirect(array(
		//			'controller' => 'bbses',
		//			'action' => 'view',
		//			$frameId,
		//		));
		//}
		//
		//throw new BadRequestException(__d('net_commons', 'Bad Request'));
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
					'plugin_key' => 'BbsPostI18n',
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

/**
 * __initPost method
 *
 * @return void
 */
	//private function __initPost() {
	//	//新規記事データセット
	//	$bbsPosts = $this->BbsPost->create();
	//
	//	//新規の記事名称
	//	$bbsPosts['BbsPost']['title'] = '新規記事_' . date('YmdHis');
	//
	//	$comments = $this->Comment->getComments(
	//		array(
	//			'plugin_key' => 'bbsPosts',
	//			'content_key' => isset($bbsPosts['BbsPost']['key']) ? $bbsPosts['BbsPost']['key'] : null,
	//		)
	//	);
	//	$results['comments'] = $comments;
	//	$results = $this->camelizeKeyRecursive($results);
	//	$results['bbsPosts'] = $bbsPosts['BbsPost'];
	//	$results['contentStatus'] = null;
	//	$this->set($results);
	//}

/**
 * __setPost method
 *
 * @param int $postId bbsPosts.id
 * @throws BadRequestException
 * @return void
 */
	//private function __setPost($postId) {
	//	$conditions['bbs_key'] = $this->viewVars['bbses']['key'];
	//	$conditions['id'] = $postId;
	//
	//	if (! $bbsPosts = $this->BbsPost->getOnePosts(
	//			$this->viewVars['userId'],
	//			$this->viewVars['contentEditable'],
	//			$this->viewVars['contentCreatable'],
	//			$conditions
	//	)) {
	//		throw new BadRequestException(__d('net_commons', 'Bad Request'));
	//
	//	}
	//
	//	//評価を取得
	//	$likes = $this->BbsPostsUser->getLikes(
	//				$bbsPosts['BbsPost']['id'],
	//				$this->viewVars['userId']
	//			);
	//
	//	//取得した記事の作成者IDからユーザ情報を取得
	//	$user = $this->User->find('first', array(
	//			'recursive' => -1,
	//			'conditions' => array(
	//				'id' => $bbsPosts['BbsPost']['created_user'],
	//			)
	//		)
	//	);
	//
	//	$comments = $this->Comment->getComments(
	//		array(
	//			'plugin_key' => 'bbsPosts',
	//			'content_key' => isset($bbsPosts['BbsPost']['key']) ? $bbsPosts['BbsPost']['key'] : null,
	//		)
	//	);
	//	$results['comments'] = $comments;
	//	$results = $this->camelizeKeyRecursive($results);
	//	$results['bbsPosts'] = $bbsPosts['BbsPost'];
	//	$results['contentStatus'] = $bbsPosts['BbsPost']['status'];
	//
	//	//ユーザ名、ID、評価をセット
	//	$results['bbsPosts']['username'] = $user['User']['username'];
	//	$results['bbsPosts']['userId'] = $user['User']['id'];
	//	$results['bbsPosts']['likesNum'] = $likes['likesNum'];
	//	$results['bbsPosts']['unlikesNum'] = $likes['unlikesNum'];
	//	$results['bbsPosts']['likesFlag'] = $likes['likesFlag'];
	//	$results['bbsPosts']['unlikesFlag'] = $likes['unlikesFlag'];
	//	$this->set($results);
	//}

/**
 * __saveReadStatus method
 *
 * @param int $postId bbsPosts.id
 * @return void
 */
	//private function __saveReadStatus($postId) {
	//	//既読情報がなければデータ登録
	//	if (! $this->BbsPostsUser->getPostsUsers(
	//			$postId,
	//			$this->viewVars['userId']
	//	)) {
	//		$default = $this->BbsPostsUser->create();
	//		$default['BbsPostsUser'] = array(
	//					'post_id' => $postId,
	//					'user_id' => $this->viewVars['userId'],
	//					'likes_flag' => false,
	//					'unlikes_flag' => false,
	//			);
	//		$this->BbsPostsUser->savePostsUsers($default);
	//	}
	//}
}
