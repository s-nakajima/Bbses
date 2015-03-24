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

		//$this->view = 'Bbses/view';
		//$this->view($frameId, $currentPage, $sortParams, $visiblePostRow, $narrowDownParams);
	}

/**
 * view method
 *
 * @param int $frameId frames.id
 * @param int $postId posts.id
 * @param int $currentPage currentPage
 * @param int $sortParams sortParameter
 * @param int $visibleCommentRow visibleCommentRow
 * @param int $narrowDownParams narrowDownParameter
 * @throws BadRequestException throw new
 * @return void
 */
	public function view($frameId = null, $bbsPostId = null) {
		if (! $this->viewVars['blockId']) {
			$this->view = 'Bbses/notCreateBbs';
			return;
		}

		$this->set('bbsPostId', (int)$bbsPostId);
		$this->initBbs(['bbs', 'bbsSetting', 'bbsFrameSetting', 'bbsPost']);

//		if ((int)$this->viewVars['bbsPost']['parent_id'] > 0) {
//			//コメント表示の場合、根記事を取得
//			if (! $rootBbsPost = $this->BbsPost->find('first', array(
//				'recursive' => 0,
//				'conditions' => array(
//					'BbsPost.id' => $this->viewVars['bbsPostId'],
//				)
//			))) {
//				$this->_throwBadRequest();
//				return false;
//			}
//		}

		$children = $this->BbsPost->children($this->viewVars['bbsPostId']);
		$children = $this->camelizeKeyRecursive($children);
		$this->set($children);


		//if (! $postId) {
		//	BadRequestException(__d('net_commons', 'Bad Request'));
		//}
		//
		//if ($this->request->isGet()) {
		//	CakeSession::write('backUrl', $this->request->referer());
		//}
		//
		////コメント表示数/掲示板名等をセット
		//$this->setBbs();
		//
		////選択した記事をセット
		//$this->__setPost($postId);
		//
		////各パラメータをセット
		//$this->initParams($currentPage, $sortParams, $narrowDownParams);
		//
		////表示件数をセット
		//$visibleCommentRow =
		//	($visibleCommentRow === '')? $this->viewVars['bbsSettings']['visible_comment_row'] : $visibleCommentRow;
		//$this->set('currentVisibleRow', $visibleCommentRow);
		//
		////Treeビヘイビアのlft,rghtカラムを利用して対象記事のコメントのみ取得
		//$conditions['and']['lft >'] = $this->viewVars['bbsPosts']['lft'];
		//$conditions['and']['rght <'] = $this->viewVars['bbsPosts']['rght'];
		////記事に関するコメントをセット
		//$this->setComment($conditions);
		//
		////Treeビヘイビアのlft,rghtカラムを利用して対象記事のコメントのみ取得
		//$conditions['and']['lft >'] = $this->viewVars['bbsPosts']['lft'];
		//$conditions['and']['rght <'] = $this->viewVars['bbsPosts']['rght'];
		////ページング情報取得
		//$this->setPagination($conditions, $postId);
		//
		////コメント数をセットする
		//$this->setCommentNum(
		//		$this->viewVars['bbsPosts']['lft'],
		//		$this->viewVars['bbsPosts']['rght']
		//	);
		//
		////コメント作成権限をセットする
		////$this->setCommentCreateAuth();
		//if (((int)$this->viewVars['rolesRoomId'] !== 0 &&
		//		(int)$this->viewVars['rolesRoomId'] < 4) ||
		//		($this->viewVars['bbses']['comment_create_authority'] &&
		//		$this->viewVars['contentCreatable'])) {
		//
		//	$this->set('commentCreatable', true);
		//
		//} else {
		//	$this->set('commentCreatable', false);
		//
		//}
		//
		////既読情報を登録
		//$this->__saveReadStatus($postId);
	}

/**
 * add
 *
 * @param int $frameId frames.id
 * @return void
 */
	public function add($frameId = null) {
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
				['BbsPostI18n' => ['status' => $status]]
			);

			$this->BbsPost->useDbConfig = 'master';
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

		$this->set('bbsPostId', (int)$parentPostId);
		$this->initBbs(['bbs', 'bbsSetting', 'bbsFrameSetting', 'bbsPost']);

		if ((int)$this->viewVars['bbsPost']['bbsPost']['rootId'] > 0) {
			$rootPostId = (int)$this->viewVars['bbsPost']['bbsPost']['rootId'];
		} else {
			$rootPostId = (int)$this->viewVars['bbsPost']['bbsPost']['id'];
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
			$bbsPostI18n['BbsPostI18n']['title'] = 'Re: ' . $this->viewVars['bbsPost']['bbsPostI18n']['title'];
			$bbsPostI18n['BbsPostI18n']['content'] =
							'<br /><blockquote>' .
								$this->viewVars['bbsPost']['bbsPostI18n']['content'] .
							'</blockquote>';
		}

		$data = Hash::merge($bbsPost, $bbsPostI18n, ['contentStatus' => null, 'comments' => []]);

		if ($this->request->isPost()) {
			if (! $status = $this->NetCommonsWorkflow->parseStatus()) {
				return;
			}
			if ($status !== NetCommonsBlockComponent::STATUS_IN_DRAFT) {
				$status = $this->viewVars['bbsPostCommentPublishable'] ? NetCommonsBlockComponent::STATUS_PUBLISHED : NetCommonsBlockComponent::STATUS_APPROVED;
			}

			$data = Hash::merge(
				$this->data,
				['BbsPostI18n' => ['status' => $status]]
			);

			$this->BbsPost->useDbConfig = 'master';
			$data['BbsPost']['post_no'] = $this->BbsPost->getMaxNo($rootPostId) + 1;
			$data['BbsPost']['key'] = Security::hash('bbs_post' . mt_rand() . microtime(), 'md5');
			unset($data['BbsPost']['id']);

			$bbsPost = $this->BbsPost->saveBbsPost($data);
			var_dump($this->BbsPost->validationErrors);
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
 * edit method
 *
 * @param int $frameId frames.id
 * @param int $bbsPostId bbsPosts.id
 * @return void
 */
	public function edit($frameId = null, $bbsPostId = null) {
		$this->set('bbsPostId', (int)$bbsPostId);
		$this->initBbs(['bbs', 'bbsSetting', 'bbsFrameSetting', 'bbsPost']);



		////掲示板名を取得
		//$this->setBbs();
		//
		////編集する記事を取得
		//$this->__setPost($postId);
		//
		//if ($this->request->isGet()) {
		//	CakeSession::write('backUrl', $this->request->referer());
		//}
		//
		//if (! $this->request->isPost()) {
		//	return;
		//}
		//
		//if (! $data = $this->setEditSaveData($this->data, $postId)) {
		//	return;
		//}
		//
		//if (! $this->BbsPost->savePost($data)) {
		//	if (! $this->handleValidationError($this->BbsPost->validationErrors)) {
		//		return;
		//	}
		//}
		//
		//if (! $this->request->is('ajax')) {
		//	$this->redirectBackUrl();
		//}
	}

/**
 * delete method
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
