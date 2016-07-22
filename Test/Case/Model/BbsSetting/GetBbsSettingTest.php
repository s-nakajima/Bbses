<?php
/**
 * BbsSetting::getBbsSetting()のテスト
 *
 * @property AccessCounter $AccessCounter
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsGetTest', 'NetCommons.TestSuite');

/**
 * BbsFrameSetting::getBbsFrameSetting()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Test\Case\Model\Bbses
 */
class BbsSettingGetBbsSettingTest extends NetCommonsGetTest {

/**
 * Plugin name
 *
 * @var array
 */
	public $plugin = 'bbses';

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.likes.like',
		'plugin.likes.likes_user',
		'plugin.bbses.bbs',
		'plugin.bbses.block_setting_for_bbs',
		'plugin.bbses.bbs_frame_setting',
		'plugin.bbses.bbs_article',
		'plugin.bbses.bbs_article_tree',
		'plugin.workflow.workflow_comment',
	);

/**
 * Model name
 *
 * @var array
 */
	protected $_modelName = 'BbsSetting';

/**
 * Method name
 *
 * @var array
 */
	protected $_methodName = 'getBbsSetting';

/**
 * Getのテスト - データあり
 *
 * @return void
 */
	public function testGet() {
		$model = $this->_modelName;
		$method = $this->_methodName;
		Current::write('Block.key', 'block_1');
		Current::write('Language.id', '2');

		//テスト実行
		$result = $this->$model->$method();

		//debug($result);
		$this->assertCount(1, $result);
	}

/**
 * Getのテスト - データなしの場合、新規登録データ取得
 *
 * @return void
 */
	public function testGetEmpty() {
		$model = $this->_modelName;
		$method = $this->_methodName;
		Current::write('Block.key', 'block_xxx');
		Current::write('Language.id', '2');

		//テスト実行
		$result = $this->$model->$method();

		//debug($result);
		$this->assertCount(1, $result);
	}

}
