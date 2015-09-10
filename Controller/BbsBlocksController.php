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
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'Blocks.BlockForm',
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
		'Paginator',
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeRender() {
		//タブの設定
		$this->initTabs('block_index', 'block_settings');
		parent::beforeRender();
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
	}

/**
 * add
 *
 * @return void
 */
	public function add() {
		$this->view = 'edit';

		if ($this->request->isPost()) {
			//登録処理
			if ($this->Bbs->saveBbs($this->data)) {
				$this->redirect(Current::backToIndexUrl('default_setting_action'));
			}
			$this->handleValidationError($this->Bbs->validationErrors);

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
		if ($this->request->isPut()) {
			//登録処理
			if ($this->Bbs->saveBbs($this->data)) {
				$this->redirect(Current::backToIndexUrl('default_setting_action'));
			}
			$this->handleValidationError($this->Bbs->validationErrors);

		} else {
			//表示処理(初期データセット)
			CurrentFrame::setBlock($this->request->params['pass'][1]);
			if (! $bbs = $this->Bbs->getBbs()) {
				$this->throwBadRequest();
				return false;
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
		if ($this->request->isDelete()) {
			if ($this->Bbs->deleteBbs($this->data)) {
				$this->redirect(Current::backToIndexUrl('default_setting_action'));
			}
		}

		$this->throwBadRequest();
	}
}
