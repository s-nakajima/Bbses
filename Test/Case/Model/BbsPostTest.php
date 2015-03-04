<?php
/**
 * BbsPost Model Test Case
 *
 * @property BbsPost $BbsPost
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BbsPost', 'Bbses.Model');
App::uses('BbsAppModelTest', 'Bbses.Test/Case/Model');

/**
 * BbsPost Model Test Case
 *
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @package NetCommons\Bbses\Test\Case\Model
 */
class BbsPostTest extends BbsAppModelTest {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.bbses.bbs_post',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->BbsPost = ClassRegistry::init('Bbses.BbsPost');
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
