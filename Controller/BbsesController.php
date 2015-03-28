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
class BbsesController extends BbsesAppController {

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		'Frames.Frame',
		'Bbses.Bbs',
		'Bbses.BbsFrameSetting',
		'Bbses.BbsPost',
		'Bbses.BbsSetting',
		'Bbses.BbsPostI18n',
		//'Bbses.BbsPostsUser',
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsBlock',
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsWorkflow',
		'NetCommons.NetCommonsRoomRole' => array(),
		'Bbses.BbsPaginator'
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
 * index
 *
 * @return void
 */
	public function index() {
		$this->setAction('view');
	}

/**
 * view
 *
 * @return void
 */
	public function view() {
		if (! $this->viewVars['blockId']) {
			$this->view = 'BbsPosts/noBbs';
			return;
		}

		$this->params['named'] = array();

		$this->view = 'BbsPosts/index';
		$this->initBbs(['bbs', 'bbsSetting', 'bbsFrameSetting']);

		$posts = $this->BbsPaginator->rootBbsPosts();
		$results = array(
			'bbsPosts' => $posts
		);
		$results = $this->camelizeKeyRecursive($results);
		$this->set($results);
	}

}
