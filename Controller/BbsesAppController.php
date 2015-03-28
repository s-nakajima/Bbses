<?php
/**
 * BbsesApp Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * BbsesApp Controller
 *
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @package NetCommons\Bbses\Controller
 */
class BbsesAppController extends AppController {

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'Security'
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
		if (in_array('bbs', $contains, true) || in_array('bbsSetting', $contains, true)) {
			if (! $bbs = $this->Bbs->find('first', array(
				'recursive' => 0,
				'conditions' => array(
					'Block.id' => $this->viewVars['blockId'],
					'Block.room_id' => $this->viewVars['roomId'],
				)
			))) {
				$this->_throwBadRequest();
				return false;
			}
			$bbs = $this->camelizeKeyRecursive($bbs);
			$this->set($bbs);
		}

		if (in_array('bbsSetting', $contains, true)) {
			if (! $bbsSetting = $this->BbsSetting->find('first', array(
				'recursive' => -1,
				'conditions' => array(
					'bbs_key' => $bbs['bbs']['key']
				)
			))) {
				$bbsSetting = $this->BbsSetting->create(
					array('id' => null)
				);
			}
			$bbsSetting = $this->camelizeKeyRecursive($bbsSetting);
			$this->set($bbsSetting);
		}

		if (in_array('bbsFrameSetting', $contains, true)) {
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

		if (in_array('bbsPost', $contains, true)) {
			if (! $bbsPost = $this->BbsPost->find('first', array(
				//'recursive' => 0,
				'conditions' => array(
					'BbsPost.id' => $this->viewVars['bbsPostId'],
				)
			))) {
				$this->_throwBadRequest();
				return false;
			}
			$bbsPost = $this->camelizeKeyRecursive($bbsPost);
			$this->set(['bbsPost' => $bbsPost]);
		}

		$this->set(['current' => $this->current]);
	}

/**
 * throw bad request
 *
 * @return void
 * @throws BadRequestException
 */
	protected function _throwBadRequest() {
		if ($this->request->is('ajax')) {
			$this->renderJson(
				['error' => ['validationErrors' => ['status' => __d('net_commons', 'Invalid request.')]]],
				__d('net_commons', 'Bad Request'), 400
			);
		} else {
			throw new BadRequestException(__d('net_commons', 'Bad Request'));
		}
	}
}
