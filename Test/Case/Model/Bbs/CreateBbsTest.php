<?php
/**
 * Faq::createFaq createFaq()のテスト
 *
 * @property Faq $Faq
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * Bbs::createBbs()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Test\Case\Model\Bbs
 */
class BbsCreateBbsTest extends NetCommonsModelTestCase {

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
		'plugin.bbses.bbs_articles_user',
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
	protected $_methodName = 'createBbs';

/**
 * createBbsのテスト
 *
 * @param array $keydata 生成するキー情報
 * @dataProvider dataProviderCreate
 * @return void
 */
	public function testCreate($keyData) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		//事前準備
		$testCurrentData = Hash::expand($keyData);
		Current::$current = Hash::merge(Current::$current, $testCurrentData);

		//期待値
		$expected = array();
		$expected = Hash::merge(
			$this->$model->createAll(array(
					'Block' => array('plugin_key' => 'blocks'),
			)),
			$this->$model->BbsSetting->create()
		);

		//テスト実行
		$result = $this->$model->$method();

		//評価
		$this->assertContains(__d('bbses', 'New bbs %s', ''), $result['Bbs']['name']);
		unset($result['Bbs']['name']);
		unset($expected['Bbs']['name']);
		$this->assertEquals($result, $expected);
	}

/**
 * createBbsのDataProvider
 *
 * #### 戻り値
 *  - array 生成するキー情報
 *
 * @return array
 */
	public function dataProviderCreate() {
		$keyData = array('Block.id' => '1', 'Room.id' => '1', 'Language.id' => '2');

		return array(
			array($keyData),
		);
	}

}
