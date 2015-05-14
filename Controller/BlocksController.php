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
		'Bbses.Bbs',
		'Bbses.BbsFrameSetting',
		'Bbses.BbsSetting',
		'Blocks.Block',
		'Frames.Frame',
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.Date',
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'blockEditable' => array('index', 'add', 'edit', 'delete')
			),
		),
		'Paginator',
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->deny('index');

		$results = $this->camelizeKeyRecursive($this->NetCommonsFrame->data);
		$this->set($results);

		//タブの設定
		$this->initTabs('block_index', 'block_settings');
	}

/**
 * index
 *
 * @return void
 * @throws Exception
 */
	public function index() {
		$this->Paginator->settings = array(
			'Bbs' => array(
				'order' => array('Bbs.id' => 'desc'),
				'conditions' => array(
					'Block.id = Bbs.block_id',
					'Block.language_id' => $this->viewVars['languageId'],
					'Block.room_id' => $this->viewVars['roomId'],
				),
				//'limit' => 1
			)
		);

		try {
			$bbses = $this->Paginator->paginate('Bbs');
		} catch (Exception $ex) {
			if (isset($this->request['paging']) && $this->params['named']) {
				$this->redirect('/bbses/blocks/index/' . $this->viewVars['frameId']);
				return;
			}
			CakeLog::error($ex);
			throw $ex;
		}

		if (! $bbses) {
			$this->view = 'Blocks/not_found';
			return;
		}

		$results = array(
			'bbses' => $bbses,
		);
		$results = $this->camelizeKeyRecursive($results);
		$this->set($results);
	}

/**
 * add
 *
 * @return void
 */
	public function add() {
		$this->view = 'Blocks/edit';

		$this->set('blockId', null);
		$bbs = $this->Bbs->create(
			array(
				'id' => null,
				'key' => null,
				'block_id' => null,
				'name' => __d('bbses', 'New bbs %s', date('YmdHis')),
			)
		);
		$bbsSetting = $this->BbsSetting->create(
			array('id' => null)
		);
		$block = $this->Block->create(
			array('id' => null, 'key' => null)
		);

		$data = Hash::merge($bbs, $bbsSetting, $block);

		if ($this->request->isPost()) {
			$data = $this->__parseRequestData();

			if (! isset($this->viewVars['bbsFrameSetting']['id'])) {
				$bbsFrameSetting = $this->BbsFrameSetting->create(
					array(
						'frame_key' => $this->viewVars['frameKey']
					)
				);
				$data['BbsFrameSetting'] = $bbsFrameSetting['BbsFrameSetting'];
			}
			$data['Block']['key'] = Security::hash('bbs_block' . mt_rand() . microtime(), 'md5');

			$this->Bbs->saveBbs($data);
			if ($this->handleValidationError($this->Bbs->validationErrors)) {
				if (! $this->request->is('ajax')) {
					$this->redirect('/bbses/blocks/index/' . $this->viewVars['frameId']);
				}
				return;
			}
			$data['Block']['id'] = null;
			$data['Block']['key'] = null;
		}

		$results = $this->camelizeKeyRecursive($data);
		$this->set($results);
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		$this->set('blockId', isset($this->params['pass'][1]) ? (int)$this->params['pass'][1] : null);

		$this->initBbs(['bbsFrameSetting']);

		if ($this->request->isPost()) {
			$data = $this->__parseRequestData();

			$this->Bbs->saveBbs($data);
			if ($this->handleValidationError($this->Bbs->validationErrors)) {
				if (! $this->request->is('ajax')) {
					$this->redirect('/bbses/blocks/index/' . $this->viewVars['frameId']);
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
 * @throws BadRequestException
 * @return void
 */
	public function delete() {
		$this->set('blockId', isset($this->params['pass'][1]) ? (int)$this->params['pass'][1] : null);
		$this->initBbs(['bbsFrameSetting']);

		if ($this->request->isDelete()) {
			if ($this->Bbs->deleteBbs($this->data)) {
				if (! $this->request->is('ajax')) {
					$this->redirect('/bbses/blocks/index/' . $this->viewVars['frameId']);
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
