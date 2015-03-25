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
class BbsSettingsController extends BbsesAppController {

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
				'blockEditable' => array('add', 'edit', 'delete')
			),
		),
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
 * add
 *
 * @return void
 */
	public function add() {
		$this->view = 'BbsSettings/edit';
		$this->initBbs(['bbsFrameSetting']);

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
			$data = $this->data;

			if (! isset($this->viewVars['bbsFrameSetting']['id'])) {
				$bbsFrameSetting = $this->BbsFrameSetting->create(
					array(
						'frame_key' => $this->viewVars['frameKey']
					)
				);
				$data['BbsFrameSetting'] = $bbsFrameSetting['BbsFrameSetting'];
			}

			$data['Block']['key'] = Security::hash('bbs_block' . mt_rand() . microtime(), 'md5');
			$this->BbsSetting->saveBbsSetting($data);
			if ($this->handleValidationError($this->BbsSetting->validationErrors)) {
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

		$this->initBbs(['bbs', 'bbsSetting', 'bbsFrameSetting']);

		if ($this->request->isPost()) {
			$data = $this->data;
			$this->BbsSetting->saveBbsSetting($data);

			if ($this->handleValidationError($this->BbsSetting->validationErrors)) {
				if (! $this->request->is('ajax')) {
					$this->redirect('/bbses/blocks/index/' . $this->viewVars['frameId']);
				}
				return;
			}

			$results = $this->camelizeKeyRecursive($data);
			$this->set($results);
		}
	}

}
