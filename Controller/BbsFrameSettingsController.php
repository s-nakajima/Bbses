<?php
/**
 * BbsFrameSettings Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BbsesAppController', 'Bbses.Controller');

/**
 * BbsFrameSettings Controller
 *
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @package NetCommons\Bbses\Controller
 */
class BbsFrameSettingsController extends BbsesAppController {

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		'Bbses.Bbs',
		'Bbses.BbsFrameSetting',
		'Bbses.BbsPost',
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
				'blockEditable' => array('edit'),
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
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();

		$this->layout = 'Frames.setting';
		$results = $this->camelizeKeyRecursive($this->NetCommonsFrame->data);
		$this->set($results);
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		$this->__initBbsFrameSetting();

		if ($this->request->isPost()) {
			$data = $this->data;
			$this->BbsFrameSetting->saveBbsFrameSetting($data);

			if ($this->handleValidationError($this->BbsFrameSetting->validationErrors)) {
				if (! $this->request->is('ajax')) {
					$this->redirect('/bbses/bbses/index/' . $this->viewVars['frameId']);
				}
				return;
			}

			$results = $this->camelizeKeyRecursive($data);
			$this->set($results);
		}
	}

/**
 * initBbs
 *
 * @return void
 */
	private function __initBbsFrameSetting() {
		if (! $bbsFrameSetting = $this->BbsFrameSetting->find('first', array(
			'recursive' => -1,
			'conditions' => array(
				'frame_key' => $this->viewVars['frameKey']
			)
		))) {
			$bbsFrameSetting = $this->BbsFrameSetting->create(
				array(
					'frame_key' => $this->viewVars['frameKey']
				)
			);
		}
		$bbsFrameSetting = $this->camelizeKeyRecursive($bbsFrameSetting);
		$this->set($bbsFrameSetting);
	}

}
