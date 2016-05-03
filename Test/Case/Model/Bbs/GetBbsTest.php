<?php
/**
 * Bbs::getBbs()のテスト
 *
 * @property Bbs $Bbs
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsGetTest', 'NetCommons.TestSuite');

/**
 * Faq::getBbs()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Test\Case\Model\Bbs
 */
class BbsGetBbsTest extends NetCommonsGetTest {

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
		'plugin.bbses.bbs',
		'plugin.bbses.bbs_setting',
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
	protected $_modelName = 'Bbs';

/**
 * Method name
 *
 * @var array
 */
	protected $_methodName = 'getBbs';

/**
 * Getのテスト
 *
 * @param array $exist 取得するキー情報
 * @param array $expected 期待値（取得したキー情報）
 * @dataProvider dataProviderGet
 *
 * @return void
 */
	public function testGet($exist, $expected) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		//事前準備
		$testCurrentData = Hash::expand($exist);
		Current::$current = Hash::merge(Current::$current, $testCurrentData);

		//テスト実行
		$result = $this->$model->$method();

		//チェック
		if ($result == null) {
			$this->assertEquals($expected['id'], '0');
		} else {
			foreach ($expected as $key => $val) {
				$this->assertEquals($result[$model][$key], $val);
			}
		}
	}

/**
 * getのDataProvider
 *
 * #### 戻り値
 *  - array 取得するキー情報
 *  - array 期待値 （取得したキー情報）
 *
 * @return array
 */
	public function dataProviderGet() {
		$existData = array('Block.id' => '2', 'Room.id' => '1'); // データあり
		$notExistData = array('Block.id' => '0', 'Room.id' => '0'); // データなし

		return array(
			array($existData, array('id' => '2', 'key' => 'bbs_1')), // 存在する
			array($notExistData, array('id' => '0')), // 存在しない
		);
	}

}
