<?php
/**
 * Blocks Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BbsesAppController', 'Bbses.Controller');

/**
 * Blocks Controller
 *
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @package NetCommons\Bbses\Controller
 */
class BlocksController extends BbsesAppController {

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		//'Users.User',
		'Bbses.Bbs',
		//'Bbses.BbsFrameSetting',
		//'Bbses.BbsPost',
		//'Bbses.BbsPostsUser',
		'Frames.Frame',
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsWorkflow',
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'blockEditable' => array('index', 'current')
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
		'NetCommons.Token'
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->deny('index');
	}

/**
 * index
 *
 * @return void
 */
	public function index() {
		$this->Paginator->settings = array(
			'Bbs' => array(
				'order' => 'Bbs.id DESC',
				'conditions' => array(
					'Block.id = Bbs.block_id',
					'Block.language_id = ' . $this->viewVars['languageId'],
					'Block.room_id = ' . $this->viewVars['roomId'],
					//'CreatedUser.language_id' => 2,
					//'CreatedUser.key' => 'nickname'
				)
			)
		);
		$bbses = $this->Paginator->paginate('Bbs');

		//if (! $bbses) {
		//	$this->view = 'Blocks/noBbs';
		//	return;
		//}

		$results = array(
			'bbses' => $bbses
		);
		$results = $this->camelizeKeyRecursive($results);
		$this->set($results);
	}

/**
 * edit method
 *
 * @param int $frameId frames.id
 * @param int $bbsPostId bbsPosts.id
 * @return void
 */
	public function current() {
		if (! $this->request->isPost()) {
			$this->_throwBadRequest();
			return;
		}

		$frame = $this->Frame->find('first', array(
			'recursive' => -1,
			'conditions' => array(
				'Frame.id' => $this->viewVars['frameId'],
			),
		));

		$data = Hash::merge($frame, $this->data);

		$this->Frame->saveFrame($data);
		$this->handleValidationError($this->Frame->validationErrors);
		
		if (! $this->request->is('ajax')) {
			$this->redirect('/bbses/blocks/index/' . $this->viewVars['frameId']);
		}

//		$this->initBbs(['bbs', 'bbsSetting', 'bbsFrameSetting']);
//
//		$this->set('bbsPostId', (int)$bbsPostId);
//		$this->__initBbsPost(['comments']);
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
//			$bbsPost = $this->BbsPost->saveBbsPost($data);
//			if ($this->handleValidationError($this->BbsPost->validationErrors)) {
//				if (! $this->request->is('ajax')) {
//					$this->redirect('/bbses/bbs_posts/view/' . $this->viewVars['frameId'] . '/' . $bbsPost['BbsPost']['id']);
//				}
//				return;
//			}
//		}
//
//		$results = $this->camelizeKeyRecursive($data);
//		$this->set($results);
	}

}
