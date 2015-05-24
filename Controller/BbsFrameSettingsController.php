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
 * layout
 *
 * @var array
 */
	public $layout = 'Frames.setting';

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		'Bbses.BbsFrameSetting',
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
				'blockEditable' => array('edit'),
			),
		),
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();

		$results = $this->camelizeKeyRecursive($this->NetCommonsFrame->data);
		$this->set($results);

		//タブの設定
		$this->initTabs('frame_settings', '');
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		if (! $this->NetCommonsFrame->validateFrameId()) {
			$this->throwBadRequest();
			return false;
		}

		if (! $bbsFrameSetting = $this->BbsFrameSetting->getBbsFrameSetting($this->viewVars['frameKey'])) {
			$bbsFrameSetting = $this->BbsFrameSetting->create(array(
				'frame_key' => $this->viewVars['frameKey']
			));
		}

		$data = array();
		if ($this->request->isPost()) {
			$data = $this->data;
			$this->BbsFrameSetting->saveBbsFrameSetting($data);

			if ($this->handleValidationError($this->BbsFrameSetting->validationErrors)) {
				$this->redirectByFrameId();
				return;
			}
		}

		$data = Hash::merge(
			$bbsFrameSetting, $data
		);
		$results = $this->camelizeKeyRecursive($data);
		$this->set($results);
	}

}
