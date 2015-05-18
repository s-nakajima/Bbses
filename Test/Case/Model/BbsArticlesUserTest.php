<?php
/**
 * BbsArticlesUser Model Test Case
 *
 * @property BbsArticlesUser $BbsArticlesUser
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BbsArticlesUser', 'Bbses.Model');
App::uses('BbsAppModelTest', 'Bbses.Test/Case/Model');

/**
 * BbsArticlesUser Model Test Case
 *
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @package NetCommons\Bbses\Test\Case\Model
 */
class BbsArticlesUserTest extends BbsAppModelTest {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.bbses.bbs_articles_user',
	);

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
