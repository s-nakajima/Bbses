<?php
/**
 * BbsFrameSettings Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BbsesAppController', 'Bbses.Controller');

/**
 * BbsFrameSettings Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
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
		'NetCommons.Permission' => array(
			//アクセスの権限
			'allow' => array(
				'edit' => 'page_editable',
			),
		),
//		'NetCommons.NetCommonsRoomRole' => array(
//			//コンテンツの権限設定
//			'allowedActions' => array(
//				'blockEditable' => array('edit'),
//			),
//		),
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();

		//タブの設定
		$this->initTabs('frame_settings', '');
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
//		if (! $this->NetCommonsFrame->validateFrameId()) {
//			$this->throwBadRequest();
//			return false;
//		}

		if ($this->request->isPut() || $this->request->isPost()) {
			if ($this->BbsFrameSetting->saveBbsFrameSetting($this->data)) {
				$this->redirect(Current::backToPageUrl());
				return;
			}
			$this->handleValidationError($this->BbsFrameSetting->validationErrors);

		} else {
			$this->request->data = $this->BbsFrameSetting->getBbsFrameSetting(true);
			$this->request->data['Frame'] = Current::read('Frame');
		}


//		$data = array();
//		if ($this->request->isPost()) {
//			$data = $this->data;
//			$this->BbsFrameSetting->saveBbsFrameSetting($data);
//
//			if ($this->handleValidationError($this->BbsFrameSetting->validationErrors)) {
//				$this->redirect(Current::backToPageUrl());
//				return;
//			}
//		}
//
//		$data = Hash::merge(
//			$bbsFrameSetting, $data
//		);
//		$results = $this->camelizeKeyRecursive($data);
//		$this->set($results);
	}

}
