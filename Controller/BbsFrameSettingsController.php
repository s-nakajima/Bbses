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
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.DisplayNumber',
	);

/**
 * beforeRender
 *
 * @return void
 */
	public function beforeRender() {
		//タブの設定
		$this->initTabs('frame_settings', '');
		parent::beforeRender();
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
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
	}
}
