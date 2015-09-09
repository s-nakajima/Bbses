<?php
/**
 * Bbs Model Test Case
 *
 * @property Bbs $Bbs
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Bbs', 'Bbses.Model');
App::uses('BbsModelTestBase', 'Bbses.Test/Case/Model');

/**
 * Bbs Model Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Test\Case\Model
 */
class BbsTest extends BbsModelTestBase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Bbs = ClassRegistry::init('Bbs');
	}

/**
 * test method
 *
 * @return void
 */
	public function test() {
		$this->assertTrue(true);
	}

/**
 * test method
 *
 * @return void
 */
	public function testGetBbs() {
		/*$blockId = 1;
		$result = $this->Bbs->getBbs($blockId);

		$expected = array(
			'Bbs' => array(
				'id' => '1',
				'block_id' => $blockId,
				'name' => 'テスト掲示板1',
				'key' => 'bbs_1',
			),
		);*/

		/*$this->_assertArray(null, $expected, $result);*/
	}
}
