<?php
/**
 * Bbs Model Test Case
 *
 * @property Bbs $Bbs
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsRoomRoleComponent', 'NetCommons.Controller/Component');
App::uses('YACakeTestCase', 'NetCommons.TestSuite');

/**
 * Bbs Model Test Case
 *
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @package NetCommons\Bbses\Test\Case\Model
 */
class BbsAppModelTest extends YACakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		//'plugin.blocks.block',
		//'plugin.boxes.box',
		//'plugin.comments.comment',
		//'plugin.frames.frame',
		//'plugin.m17n.language',
		//'plugin.plugin_manager.plugin',
		//'plugin.rooms.room',
		//'plugin.users.user',
		//'plugin.users.user_attributes_user',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Bbs);
		unset($this->BbsFrameSetting);
		unset($this->BbsArticle);
		unset($this->BbsArticlesUser);
		unset($this->Comment);
		parent::tearDown();
	}

/**
 * _assertArray method
 *
 * @param string $key target key
 * @param mixed $value array or string, number
 * @param array $result result data
 * @return void
 */
	protected function _assertArray($key, $value, $result) {
		if ($key !== null) {
			$this->assertArrayHasKey($key, $result);
			$target = $result[$key];
		} else {
			$target = $result;
		}
		if (is_array($value)) {
			foreach ($value as $nextKey => $nextValue) {
				$this->_assertArray($nextKey, $nextValue, $target);
			}
		} elseif (isset($value)) {
			$this->assertEquals($value, $target, 'key=' . print_r($key, true) . 'value=' . print_r($value, true) . 'result=' . print_r($result, true));
		}
	}

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
	}
}
