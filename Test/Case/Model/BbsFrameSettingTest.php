<?php
/**
 * BbsFrameSetting Model Test Case
 *
 * @property BbsFrameSetting $BbsFrameSetting
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BbsFrameSetting', 'Bbses.Model');
App::uses('BbsModelTestBase', 'Bbses.Test/Case/Model');

/**
 * BbsFrameSetting Model Test Case
 *
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @package NetCommons\Bbses\Test\Case\Model
 */
class BbsFrameSettingTest extends BbsModelTestBase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->BbsFrameSetting = ClassRegistry::init('Bbses.BbsFrameSetting');
	}

/**
 * test method
 *
 * @return void
 */
	public function test() {
		$this->assertTrue(true);
	}
}
