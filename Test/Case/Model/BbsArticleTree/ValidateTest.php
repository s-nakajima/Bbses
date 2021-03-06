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

App::uses('NetCommonsValidateTest', 'NetCommons.TestSuite');

/**
 * BbsArticleTree::beforeValidate()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Test\Case\Model\BbsArticleTree
 */
class BbsArticleTreeValidateTest extends NetCommonsValidateTest {

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
			array($this->__data, 'article_no', 'a',
				__d('net_commons', 'Invalid request.')),
			array($this->__data, 'bbs_article_key', '',
				__d('net_commons', 'Invalid request.')),
		);
	}
}
