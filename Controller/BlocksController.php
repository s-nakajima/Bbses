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
		'Bbses.Bbs',
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
				'blockEditable' => array('index', 'current')
			),
		),
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
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->deny('index');
	}

/**
 * index
 *
 * @return void
 */
	public function index() {
		$this->Paginator->settings = array(
			'Bbs' => array(
				'order' => 'Bbs.id DESC',
				'conditions' => array(
					'Block.id = Bbs.block_id',
					'Block.language_id = ' . $this->viewVars['languageId'],
					'Block.room_id = ' . $this->viewVars['roomId'],
				)
			)
		);
		$bbses = $this->Paginator->paginate('Bbs');

		//if (! $bbses) {
		//	$this->view = 'Blocks/noBbs';
		//	return;
		//}

		$results = array(
			'bbses' => $bbses
		);
		$results = $this->camelizeKeyRecursive($results);
		$this->set($results);
	}

/**
 * edit 
 *
 * @return void
 */
	public function current() {
		if (! $this->request->isPost()) {
			$this->_throwBadRequest();
			return;
		}

		$frame = $this->Frame->find('first', array(
			'recursive' => -1,
			'conditions' => array(
				'Frame.id' => $this->viewVars['frameId'],
			),
		));

		$data = Hash::merge($frame, $this->data);

		$this->Frame->saveFrame($data);
		$this->handleValidationError($this->Frame->validationErrors);

		if (! $this->request->is('ajax')) {
			$this->redirect('/bbses/blocks/index/' . $this->viewVars['frameId']);
		}
	}
}
