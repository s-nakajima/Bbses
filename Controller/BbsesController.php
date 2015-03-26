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
		'Paginator',
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
			$this->view = 'Bbses/noSetting';
			return;
		}

		$this->view = 'BbsPosts/index';
		$this->initBbs(['bbs', 'bbsSetting', 'bbsFrameSetting']);

		$this->BbsPost->bindModel(array('hasMany' => array(
				'BbsPostI18n' => array(
					'foreignKey' => 'bbs_post_id',
					'limit' => 1,
					'order' => 'BbsPostI18n.id DESC',
					'conditions' => array(
						'BbsPostI18n.language_id' => $this->viewVars['languageId']
					)
				)
			)),
			false
		);

		$this->Paginator->settings = array(
			'BbsPost' => array(
				'conditions' => array(
					'BbsPost.bbs_key' => $this->viewVars['bbs']['key'],
					'BbsPost.parent_id' => null,
				),
				'order' => 'BbsPost.id DESC',
				'limit' => $this->viewVars['bbsFrameSetting']['postsPerPage']
			)
		);
		$posts = $this->Paginator->paginate('BbsPost');
		$results = array(
			'bbsPosts' => $posts
		);
		$results = $this->camelizeKeyRecursive($results);
		$this->set($results);
	}
}
