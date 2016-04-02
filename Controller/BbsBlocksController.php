<?php
/**
 * BbsBlocks Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BbsesAppController', 'Bbses.Controller');

/**
 * BbsBlocks Controller
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
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.Permission' => array(
			'allow' => array(
				'index,add,edit,delete' => 'block_editable',
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
		'Blocks.BlockForm',
		'Blocks.BlockTabs' => array(
			'mainTabs' => array(
				'block_index' => array('url' => array('controller' => 'bbs_blocks')),
				'frame_settings' => array('url' => array('controller' => 'bbs_frame_settings')),
			),
			'blockTabs' => array(
				'block_settings' => array('url' => array('controller' => 'bbs_blocks')),
				'mail_settings' => array('url' => array('controller' => 'bbs_mail_settings')),
				'role_permissions' => array('url' => array('controller' => 'bbs_block_role_permissions')),
			),
		),
		'Likes.Like',
	);

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
	}

/**
 * add
 *
 * @return void
 */
	public function add() {
		$this->view = 'edit';

		if ($this->request->is('post')) {
			//登録処理
			if ($this->Bbs->saveBbs($this->data)) {
				return $this->redirect(NetCommonsUrl::backToIndexUrl('default_setting_action'));
			}
			$this->NetCommons->handleValidationError($this->Bbs->validationErrors);

		} else {
			//表示処理(初期データセット)
			$this->request->data = $this->Bbs->createBbs();
			$this->request->data = Hash::merge($this->request->data, $this->BbsFrameSetting->getBbsFrameSetting(true));
			$this->request->data['Frame'] = Current::read('Frame');
		}
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		if ($this->request->is('put')) {
			//登録処理
			if ($this->Bbs->saveBbs($this->data)) {
				return $this->redirect(NetCommonsUrl::backToIndexUrl('default_setting_action'));
			}
			$this->NetCommons->handleValidationError($this->Bbs->validationErrors);

		} else {
			//表示処理(初期データセット)
			if (! $bbs = $this->Bbs->getBbs()) {
				return $this->throwBadRequest();
			}
			$this->request->data = Hash::merge($this->request->data, $bbs);
			$this->request->data = Hash::merge($this->request->data, $this->BbsFrameSetting->getBbsFrameSetting(true));
			$this->request->data['Frame'] = Current::read('Frame');
		}
	}

/**
 * delete
 *
 * @return void
 */
	public function delete() {
		if ($this->request->is('delete')) {
			if ($this->Bbs->deleteBbs($this->data)) {
				return $this->redirect(NetCommonsUrl::backToIndexUrl('default_setting_action'));
			}
		}

		return $this->throwBadRequest();
	}
}
