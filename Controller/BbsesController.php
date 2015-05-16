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
 * index
 *
 * @return void
 */
	public function index() {
		$html = $this->requestAction(
			array('controller' => 'bbs_posts', 'action' => 'index', $this->viewVars['frameId']),
			array('return')
		);

		$this->set('html', $html);
	}
}
