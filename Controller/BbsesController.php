<?php
/**
 * Bbses Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BbsesAppController', 'Bbses.Controller');

/**
 * Bbses Controller
 *
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @package NetCommons\Bbses\Controller
 */
class BbsesController extends BbsesAppController {

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
		'Bbses.BbsSetting',
		//'Bbses.BbsPostsUser',
	);

/**
 * use components
 *
 * @var array
 */
//	public $components = array(
//		'NetCommons.NetCommonsBlock',
//		'NetCommons.NetCommonsFrame',
//		'NetCommons.NetCommonsRoomRole' => array(
//			//コンテンツの権限設定
//			'allowedActions' => array(
//				'contentPublishable' => array('edit'),
//			),
//		),
//	);
	public $components = array(
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsWorkflow',
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			//'allowedActions' => array(
			//	'contentEditable' => array('edit')
			//),
		),
		'Paginator',
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.Token'
	);

/**
 * index
 *
 * @return void
 */
//	public function index($frameId, $currentPage = '', $sortParams = '',
//								$visiblePostRow = '', $narrowDownParams = '') {
//		$this->view = 'Bbses/view';
//		$this->view($frameId, $currentPage, $sortParams, $visiblePostRow, $narrowDownParams);
//	}
	public function index() {
		$this->setAction('view');
	}

/**
 * view
 *
 * @return void
 */
	public function view() {
		if (! $this->viewVars['blockId']) {
			$this->view = 'Bbses/noSetting';
			return;
		}

		$this->view = 'BbsPosts/index';
		$this->initBbs(['bbs', 'bbsSetting', 'bbsFrameSetting']);

		$this->Paginator->settings = array(
			//'recursive' => -1,
			'BbsPost' => array(
				//'recursive' => -1,
				'conditions' => array(
					'BbsPost.bbs_key' => $this->viewVars['bbs']['key'],
					'BbsPost.parent_id' => 0,
				),
				'order' => 'BbsPost.id DESC',
			),
			'BbsPostI18n' => array(
				//'recursive' => -1,
				'conditions' => array(
					'BbsPost.id = BbsPostI18n.bbs_post_id',
					'BbsPostI18n.language_id = ' . $this->viewVars['languageId'],
					//'CreatedUser.language_id' => 2,
					//'CreatedUser.key' => 'nickname'
				),
				'order' => 'BbsPostI18n.id DESC'
			)
		);
		$posts = $this->Paginator->paginate('BbsPost');
		$results = array(
			'bbsPosts' => $posts
		);
		$results = $this->camelizeKeyRecursive($results);
		$this->set($results);

		var_dump($this->viewVars);

		//一覧ページのURLをBackURLに保持
//		if ($this->request->isGet()) {
//			CakeSession::write('backUrl', Router::url(null, true));
//		}

	//	//コメント表示数/掲示板名等をセット
	//	$this->setBbs();
	//
	//	//フレーム置いた直後
	//	if (! isset($this->viewVars['bbses']['id'])) {
	//		if ((int)$this->viewVars['rolesRoomId'] === 0) {
	//			$this->autoRender = false;
	//			return;
	//		}
	//		$this->view = 'Bbses/notCreateBbs';
	//		return;
	//	}
	//
	//	//各パラメータをセット
	//	$this->initParams($currentPage, $sortParams, $narrowDownParams);
	//
	//	//表示件数を設定
	//	$visiblePostRow = ($visiblePostRow === '')?
	//			$this->viewVars['bbsSettings']['visible_post_row'] : $visiblePostRow;
	//	$this->set('currentVisibleRow', $visiblePostRow);
	//
	//	//記事一覧情報取得
	//	$this->__setPost();
	//
	//	//ページング情報取得
	//	$this->setPagination();
	//
	//	//記事数取得
	//	$this->__setPostNum();
	}

/**
 * edit method
 *
 * @return void
 */
	//public function add() {
	//	$this->view = 'bbsPosts/edit';
	//	$this->view();
	//}

/**
 * edit method
 *
 * @return void
 */
	//public function edit() {
	//	$this->setBbs();
	//
	//	if ($this->request->isGet() &&
	//			! strstr($this->request->referer(), '/bbses')) {
	//		CakeSession::write('backUrl', $this->request->referer());
	//	}
	//
	//	if (! $this->request->isPost()) {
	//		return;
	//	}
	//
	//	$data = $this->__setEditSaveData($this->data);
	//
	//	if (!$bbs = $this->Bbs->saveBbs($data)) {
	//		if (!$this->handleValidationError($this->Bbs->validationErrors)) {
	//			return;
	//		}
	//	}
	//
	//	$this->set('blockId', $bbs['Bbs']['block_id']);
	//
	//	if (! $this->request->is('ajax')) {
	//		$this->redirectBackUrl();
	//	}
	//}

/**
 * __setPost method
 *
 * @return void
 */
	//private function __setPost() {
	//	//ソート条件をセット
	//	$sortOrder = $this->setSortOrder($this->viewVars['sortParams']);
	//
	//	//取得条件をセット
	//	$conditions['bbs_key'] = $this->viewVars['bbses']['key'];
	//	$conditions['parent_id'] = null;
	//
	//	//絞り込み条件をセット
	//	$conditions = $this->setNarrowDown($conditions, $this->viewVars['narrowDownParams']);
	//
	//	if (! $bbsPosts = $this->BbsPost->getPosts(
	//			$this->viewVars['userId'],
	//			$this->viewVars['contentEditable'],
	//			$this->viewVars['contentCreatable'],
	//			$sortOrder,								//order by指定
	//			$this->viewVars['currentVisibleRow'],	//limit指定
	//			$this->viewVars['currentPage'],			//ページ番号指定
	//			$conditions								//検索条件をセット
	//	)) {
	//		$bbsPosts = $this->BbsPost->create();
	//		$results = array(
	//				'bbsPosts' => $bbsPosts['BbsPost'],
	//				'bbsPostNum' => 0,
	//			);
	//
	//	} else {
	//		$results = $this->__setPostRelatedData($bbsPosts);
	//
	//	}
	//	$this->set($results);
	//}

/**
 * __setPostRelatedData method
 *
 * @param array $bbsPosts bbsPosts
 * @return array
 */
	//private function __setPostRelatedData($bbsPosts) {
	//	//記事を$results['bbsPosts']にセット
	//	foreach ($bbsPosts as $bbsPost) {
	//
	//		//評価を取得
	//		$likes = $this->BbsPostsUser->getLikes(
	//					$bbsPost['BbsPost']['id'],
	//					$this->viewVars['userId']
	//				);
	//
	//		$bbsPost['BbsPost']['likesNum'] = $likes['likesNum'];
	//		$bbsPost['BbsPost']['unlikesNum'] = $likes['unlikesNum'];
	//
	//		//未読or既読セット
	//		//$readStatus true:read, false:not read
	//		$readStatus = $this->BbsPostsUser->getPostsUsers(
	//							$bbsPost['BbsPost']['id'],
	//							$this->viewVars['userId']
	//						);
	//		$bbsPost['BbsPost']['readStatus'] = $readStatus;
	//
	//		//未読(narrowDownParams = '6')の場合、未読記事をセット
	//		//未読以外の場合は全ての記事をセット
	//		if (($this->viewVars['narrowDownParams'] === '6' && ! $readStatus) ||
	//				$this->viewVars['narrowDownParams'] !== '6') {
	//
	//			//編集中のコメント数をセット
	//			$bbsPost['BbsPost']['editCommentNum'] =
	//				(int)$this->__setCommentNum($bbsPost['BbsPost']['lft'], $bbsPost['BbsPost']['rght'])
	//					- (int)$bbsPost['BbsPost']['comment_num'];
	//
	//			//記事データを配列にセット
	//			$results['bbsPosts'][] = $bbsPost['BbsPost'];
	//
	//		}
	//	}
	//
	//	//該当記事がない場合は空をセット
	//	if (! isset($results)) {
	//		$bbsPosts = $this->BbsPost->create();
	//		$results = array(
	//				'bbsPosts' => $bbsPosts['BbsPost'],
	//				'bbsPostNum' => 0,
	//			);
	//
	//	} else {
	//		//記事数を$results['bbsPostNum']セット
	//		$results['bbsPostNum'] = count($results['bbsPosts']);
	//
	//	}
	//
	//	return $results;
	//}

/**
 * __setCommentNum method
 *
 * @param int $lft bbsPosts.lft
 * @param int $rght bbsPosts.rght
 * @return string order for search
 */
	//private function __setCommentNum($lft, $rght) {
	//	//検索条件をセット
	//	$conditions['bbs_key'] = $this->viewVars['bbses']['key'];
	//	$conditions['and']['lft >'] = $lft;
	//	$conditions['and']['rght <'] = $rght;
	//
	//	//公開データ以外も含めたコメント数を取得
	//	if (! $bbsCommnets = $this->BbsPost->getPosts(
	//			$this->viewVars['userId'],
	//			$this->viewVars['contentEditable'],
	//			$this->viewVars['contentCreatable'],
	//			null,
	//			null,
	//			null,
	//			$conditions
	//	)) {
	//		return 0;
	//	}
	//
	//	return count($bbsCommnets);
	//}

/**
 * __setPostNum method
 *
 * @return string order for search
 */
	//private function __setPostNum() {
	//	$conditions['bbs_key'] = $this->viewVars['bbses']['key'];
	//	$conditions['parent_id'] = '';
	//
	//	$bbsPosts = $this->BbsPost->getPosts(
	//			$this->viewVars['userId'],
	//			$this->viewVars['contentEditable'],
	//			$this->viewVars['contentCreatable'],
	//			null,
	//			null,
	//			null,
	//			$conditions
	//		);
	//
	//	$results['postNum'] = count($bbsPosts);
	//	$this->set($results);
	//}

/**
 * setEditSaveData
 *
 * @param array $postData post data
 * @return array
 */
	//private function __setEditSaveData($postData) {
	//	$blockId = isset($postData['Block']['id']) ? (int)$postData['Block']['id'] : null;
	//
	//	if (! $bbs = $this->Bbs->getBbs($blockId)) {
	//		//bbsテーブルデータ作成とkey格納
	//		$bbs = $this->initBbs();
	//		$bbs['Bbs']['block_id'] = 0;
	//	}
	//
	//	$data['Bbs'] = $this->__convertStringToBoolean($postData, $bbs);
	//
	//	$results = Hash::merge($postData, $bbs, $data);
	//
	//	//IDリセット
	//	unset($results['Bbs']['id']);
	//
	//	return $results;
	//}

/**
 * __convertStringToBoolean
 *
 * @param array $data post data
 * @param array $bbs bbses
 * @return array
 */
	//private function __convertStringToBoolean($data, $bbs) {
	//	//boolean値が文字列になっているため個別で格納し直し
	//	return $data['Bbs'] = array(
	//			'name' => $data['Bbs']['name'],
	//			'use_comment' => ($data['Bbs']['use_comment'] === '1') ? true : false,
	//			'auto_approval' => ($data['Bbs']['auto_approval'] === '1') ? true : false,
	//			'use_like_button' => ($data['Bbs']['use_like_button'] === '1') ? true : false,
	//			'use_unlike_button' => ($data['Bbs']['use_unlike_button'] === '1') ? true : false,
	//		);
	//}
}
