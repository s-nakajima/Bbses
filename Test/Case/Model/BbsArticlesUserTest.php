<?php
/**
 * BbsArticlesUser Model Test Case
 *
 * @property BbsArticlesUser $BbsArticlesUser
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BbsArticlesUser', 'Bbses.Model');
App::uses('BbsModelTestBase', 'Bbses.Test/Case/Model');

/**
 * BbsArticlesUser Model Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Test\Case\Model
 */
class BbsArticlesUserTest extends BbsModelTestBase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->BbsArticlesUser = ClassRegistry::init('Bbses.BbsArticlesUser');
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
