<?php
/**
 * BbsPostsUser Model Test Case
 *
 * @property BbsPostsUser $BbsPostsUser
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BbsPostsUser', 'Bbses.Model');
App::uses('BbsAppModelTest', 'Bbses.Test/Case/Model');

/**
 * BbsPostsUser Model Test Case
 *
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @package NetCommons\Bbses\Test\Case\Model
 */
class BbsPostsUserTest extends BbsAppModelTest {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.bbses.bbs_posts_user',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->BbsPostsUser = ClassRegistry::init('Bbses.BbsPostsUser');
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
