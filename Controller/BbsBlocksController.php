<?php
/**
 * Blocks Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BbsesAppController', 'Bbses.Controller');

/**
 * Blocks Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Controller
 */
class BbsBlocksController extends BbsesAppController {

/**
 * layout
 *
 * @var array
 */
	public $layout = 'NetCommons.setting';

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		'Bbses.BbsFrameSetting',
		'Blocks.Block',
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
//		'NetCommons.Date',
		'Likes.Like',
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
				'index,add,edit,delete' => 'block_editable',
			),
		),
//		'NetCommons.NetCommonsBlock',
//		'NetCommons.NetCommonsRoomRole' => array(
//			//コンテンツの権限設定
//			'allowedActions' => array(
//				'blockEditable' => array('index', 'add', 'edit', 'delete')
//			),
//		),
		'Paginator',
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
//		$this->Auth->deny('index');

		//タブの設定
		$this->initTabs('block_index', 'block_settings');
	}

/**
 * index
 *
 * @return void
 */
	public function index() {
		$this->Paginator->settings = array(
			'Bbs' => array(
				'order' => array('Bbs.id' => 'desc'),
				'conditions' => $this->Bbs->getBlockConditions(),
			)
		);

		$bbses = $this->Paginator->paginate('Bbs');
		if (! $bbses) {
			$this->view = 'Blocks.Blocks/not_found';
			return;
		}
		$this->set('bbses', $bbses);
		$this->request->data['Frame'] = Current::read('Frame');

//		$results = array(
//			'bbses' => $bbses,
//		);
//		$results = $this->camelizeKeyRecursive($results);
//		$this->set($results);
	}

/**
 * add
 *
 * @return void
 */
	public function add() {
		$this->view = 'edit';

		if ($this->request->isPost()) {
			if ($this->Bbs->saveBbs($this->data)) {
				$this->redirect(Current::backToIndexUrl('default_setting_action'));
			}
			$this->handleValidationError($this->Bbs->validationErrors);

		} else {
			//表示処理(初期データセット)
			$this->request->data = $this->Bbs->createAll(array(
				$this->Bbs->alias => array(
					'name' => __d('bbses', 'New bbs %s', date('YmdHis')),
				)
			));
			$this->request->data = Hash::merge($this->request->data, $this->BbsSetting->create());
			$this->request->data = Hash::merge($this->request->data, $this->BbsFrameSetting->getBbsFrameSetting(true));
			$this->request->data['Frame'] = Current::read('Frame');
		}

//		$this->set('blockId', null);
//		$bbs = $this->Bbs->create(
//			array(
//				'id' => null,
//				'key' => null,
//				'block_id' => null,
//				'name' => __d('bbses', 'New bbs %s', date('YmdHis')),
//			)
//		);
//		$bbsSetting = $this->BbsSetting->create(
//			array('id' => null)
//		);
//		$block = $this->Block->create(
//			array('id' => null, 'key' => null)
//		);
//
//		$data = array();
//		if ($this->request->isPost()) {
//			$data = $this->__parseRequestData();
//
//			if (! isset($this->viewVars['bbsFrameSetting']['id'])) {
//				$bbsFrameSetting = $this->BbsFrameSetting->create(
//					array(
//						'frame_key' => $this->viewVars['frameKey']
//					)
//				);
//				$data['BbsFrameSetting'] = $bbsFrameSetting['BbsFrameSetting'];
//			}
//
//			$this->Bbs->saveBbs($data);
//			if ($this->handleValidationError($this->Bbs->validationErrors)) {
//				if (! $this->request->is('ajax')) {
//					$this->redirect('/bbses/bbs_blocks/index/' . $this->viewVars['frameId']);
//				}
//				return;
//			}
//			$data['Block']['id'] = null;
//			$data['Block']['key'] = null;
//			unset($data['Frame']);
//		}
//
//		$data = Hash::merge($bbs, $bbsSetting, $block, $data);
//		$results = $this->camelizeKeyRecursive($data);
//		$this->set($results);
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		if (! $this->NetCommonsBlock->validateBlockId()) {
			$this->throwBadRequest();
			return false;
		}
		$this->set('blockId', (int)$this->params['pass'][1]);

		$this->initBbs(['bbsFrameSetting']);

		if ($this->request->isPost()) {
			$data = $this->__parseRequestData();

			$this->Bbs->saveBbs($data);
			if ($this->handleValidationError($this->Bbs->validationErrors)) {
				if (! $this->request->is('ajax')) {
					$this->redirect('/bbses/bbs_blocks/index/' . $this->viewVars['frameId']);
				}
				return;
			}

			$results = $this->camelizeKeyRecursive($data);
			$this->set($results);
		}
	}

/**
 * delete
 *
 * @return void
 */
	public function delete() {
		if (! $this->NetCommonsBlock->validateBlockId()) {
			$this->throwBadRequest();
			return false;
		}
		$this->set('blockId', (int)$this->params['pass'][1]);

		$this->initBbs(['bbsFrameSetting']);

		if ($this->request->isDelete()) {
			if ($this->Bbs->deleteBbs($this->data)) {
				if (! $this->request->is('ajax')) {
					$this->redirect('/bbses/bbs_blocks/index/' . $this->viewVars['frameId']);
				}
				return;
			}
		}

		$this->throwBadRequest();
	}

/**
 * Parse data from request
 *
 * @return array
 */
	private function __parseRequestData() {
		$data = $this->data;
		if ($data['Block']['public_type'] === Block::TYPE_LIMITED) {
			//$data['Block']['from'] = implode('-', $data['Block']['from']);
			//$data['Block']['to'] = implode('-', $data['Block']['to']);
		} else {
			unset($data['Block']['from'], $data['Block']['to']);
		}

		return $data;
	}

}
