<?php
/**
 * BbsArticleTree::beforeValidate()のテスト
 *
 * @property BbsArticleTree $BbsArticleTree
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * BbsArticleTree::beforeValidate()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Test\Case\Model\BbsArticleTree
 */
class BbsArticleTreeBeforeValidateTest extends NetCommonsModelTestCase {

/**
 * Plugin name
 *
 * @var array
 */
	public $plugin = 'bbses';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
	}

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.likes.like',
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
	protected $_modelName = 'BbsArticleTree';

/**
 * Method name
 *
 * @var array
 */
	protected $_methodName = 'beforeValidate';

/**
 * data
 *
 * @var array
 */
	private $__data = array(
			'BbsArticleTree' => array(
				'id' => '1',
				'bbs_key' => 'bbs_1',
				'bbs_article_key' => '2',
				'user_id' => '1',
			),
	);

/**
 * ValidationErrorのDataProvider
 *
 * ### 戻り値
 *  - field フィールド名
 *  - value セットする値
 *  - message エラーメッセージ
 *  - overwrite 上書きするデータ
 *
 * @return void
 */
	public function dataProviderValidationError() {
		return array(
			array($this->__data, 'bbs_key', '',
				__d('net_commons', 'Invalid request.')),
			array($this->__data, 'lft', 'a',
				__d('net_commons', 'Invalid request.')),
			array($this->__data, 'rght', 'a',
				__d('net_commons', 'Invalid request.')),
			array($this->__data, 'article_no', 'a',
				__d('net_commons', 'Invalid request.')),
			array($this->__data, 'bbs_article_key', '',
				__d('net_commons', 'Invalid request.')),
		);
	}

/**
 * Validatesのテスト
 *
 * @param array $data 登録データ
 * @param string $field フィールド名
 * @param string $value セットする値
 * @param string $message エラーメッセージ
 * @param array $overwrite 上書きするデータ
 * @dataProvider dataProviderValidationError
 * @return void
 */
	public function testValidationError($data, $field, $value, $message, $overwrite = array()) {
		$model = $this->_modelName;

		if (is_null($value)) {
			unset($data[$model][$field]);
		} else {
			$data[$model][$field] = $value;
		}
		$data = Hash::merge($data, $overwrite);

		//validate処理実行
		$this->$model->set($data);
		$result = $this->$model->validates();
		$this->assertFalse($result);

		$this->assertEquals($this->$model->validationErrors[$field][0], $message);
	}
}
