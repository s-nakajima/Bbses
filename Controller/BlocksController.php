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
 * use models
 *
 * @var array
 */
	public $uses = array(
		//'Users.User',
		'Bbses.Bbs',
		//'Bbses.BbsFrameSetting',
		//'Bbses.BbsPost',
		//'Bbses.BbsPostsUser',
		//'Comments.Comment',
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
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
		$this->Paginator->settings = array(
			'Bbs' => array(
				'order' => 'Bbs.id DESC',
			),
			'Block' => array(
				'conditions' => array(
					'Block.block_id = Bbs.block_id',
					//'CreatedUser.language_id' => 2,
					'CreatedUser.key' => 'nickname'
				)
			)
		);
		//$comments = $this->Paginator->paginate('Comment');
	}
}
