<?php
/**
 * BbsesApp Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * BbsesApp Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Controller
 */
class BbsesAppController extends AppController {

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsFrame',
		'Pages.PageLayout',
		'Security'
	);

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		'Bbses.Bbs',
		'Bbses.BbsSetting'
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
 * initBbs
 *
 * @param array $contains Optional result sets
 * @return void
 */
	public function initBbs($contains = []) {
		if (! $bbs = $this->Bbs->getBbs($this->viewVars['blockId'], $this->viewVars['roomId'])) {
			$this->throwBadRequest();
			return false;
		}
		$bbs = $this->camelizeKeyRecursive($bbs);
		$this->set($bbs);

		if (! $bbsSetting = $this->BbsSetting->getBbsSetting($bbs['bbs']['key'])) {
			$bbsSetting = $this->BbsSetting->create(array(
				'id' => null,
				'bbs_key' => $bbs['bbs']['key']
			));
		}
		$bbsSetting = $this->camelizeKeyRecursive($bbsSetting);
		$this->set($bbsSetting);

		if (in_array('bbsFrameSetting', $contains, true)) {
			if (! $bbsFrameSetting = $this->BbsFrameSetting->getBbsFrameSetting($this->viewVars['frameKey'])) {
				$bbsFrameSetting = $this->BbsFrameSetting->create(array(
					'frame_key' => $this->viewVars['frameKey']
				));
			}
			$bbsFrameSetting = $this->camelizeKeyRecursive($bbsFrameSetting);
			$this->set($bbsFrameSetting);
		}

		$this->set('userId', (int)$this->Auth->user('id'));
	}

/**
 * initTabs
 *
 * @param string $mainActiveTab Main active tab
 * @param string $blockActiveTab Block active tab
 * @return void
 */
	public function initTabs($mainActiveTab, $blockActiveTab) {
		if (isset($this->params['pass'][1])) {
			$blockId = (int)$this->params['pass'][1];
		} else {
			$blockId = null;
		}

		//タブの設定
		$settingTabs = array(
			'tabs' => array(
				'block_index' => array(
					'url' => array(
						'plugin' => $this->params['plugin'],
						'controller' => 'bbs_blocks',
						'action' => 'index',
						$this->viewVars['frameId'],
					)
				),
				'frame_settings' => array(
					'url' => array(
						'plugin' => $this->params['plugin'],
						'controller' => 'bbs_frame_settings',
						'action' => 'edit',
						$this->viewVars['frameId'],
					)
				),
			),
			'active' => $mainActiveTab
		);
		$this->set('settingTabs', $settingTabs);

		$blockSettingTabs = array(
			'tabs' => array(
				'block_settings' => array(
					'url' => array(
						'plugin' => $this->params['plugin'],
						'controller' => 'bbs_blocks',
						'action' => $this->params['action'],
						$this->viewVars['frameId'],
						$blockId
					)
				),
				'role_permissions' => array(
					'url' => array(
						'plugin' => $this->params['plugin'],
						'controller' => 'bbs_block_role_permissions',
						'action' => 'edit',
						$this->viewVars['frameId'],
						$blockId
					)
				),
			),
			'active' => $blockActiveTab
		);
		$this->set('blockSettingTabs', $blockSettingTabs);
	}

}
