<?php
/**
 * BbsSetting::saveBbsSetting()のテスト
 *
 * @property BbsSetting $BbsSetting
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsSaveTest', 'NetCommons.TestSuite');

/**
 * BbsSetting::saveBbsSetting()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Test\Case\Model\BbsSetting
 */
class BbsSettingSaveBbsSettingTest extends NetCommonsSaveTest {

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
	protected $_methodName = 'saveBbsSetting';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		Current::write('Plugin.key', $this->plugin);
		Current::write('Block.key', 'block_1');
	}

/**
 * テストDataの取得
 *
 * @return array
 */
	private function __getData() {
		$data = array(
			'BbsSetting' => array(
				'use_workflow' => '1',
				'use_comment' => '1',
				'use_comment_approval' => '1',
				'use_like' => '1',
				'use_unlike' => '1',
			),
		);

		return $data;
	}

/**
 * SaveのDataProvider
 *
 * #### 戻り値
 *  - data 登録データ
 *
 * @return array
 */
	public function dataProviderSave() {
		return array(
			array($this->__getData()),
		);
	}

/**
 * Saveのテスト
 *
 * @param array $data 登録データ
 * @dataProvider dataProviderSave
 * @return void
 */
	public function testSave($data) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		//テスト実行
		$result = $this->$model->$method($data);
		$this->assertNotEmpty($result);

		//登録データ取得
		$actual = $this->$model->getBbsSetting();
		$expected = $data;

		$this->assertEquals($expected, $actual);
	}

/**
 * SaveのExceptionErrorのDataProvider
 *
 * #### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return array
 */
	public function dataProviderSaveOnExceptionError() {
		$data = $this->__getData();
		return array(
			array($data[$this->_modelName], 'Blocks.BlockSetting', 'saveMany'),
		);
	}

/**
 * SaveのValidationErrorのDataProvider
 *
 * #### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *
 * @return array
 */
	public function dataProviderSaveOnValidationError() {
		return array(
			array($this->__getData(), 'Bbses.BbsSetting'),
		);
	}
}
