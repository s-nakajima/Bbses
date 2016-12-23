<?php
/**
 * Bbs::deleteBbs()のテスト
 *
 * @property Bbs $Bbs
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsDeleteTest', 'NetCommons.TestSuite');

/**
 * Bbs::deleteBbs()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Test\Case\Model\Bbs
 */
class BbsDeleteBbsTest extends NetCommonsDeleteTest {

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
	protected $_modelName = 'Bbs';

/**
 * Method name
 *
 * @var array
 */
	protected $_methodName = 'deleteBbs';

/**
 * data
 *
 * @var array
 */
	private $__data = array(
			'Block' => array(
				'id' => '2',
				'key' => 'block_1',
			),
			'Bbs' => array(
				'id' => '2',
				'block_key' => 'block_1',
				'key' => 'bbs_1',
			),
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		Current::write('Language.id', '2');
		parent::setUp();
	}

/**
 * DeleteのDataProvider
 *
 * #### 戻り値
 *  - data: 削除データ
 *  - associationModels: 削除確認の関連モデル array(model => conditions)
 *
 * @return array
 */
	public function dataProviderDelete() {
			$association = array(
				'BbsArticle' => array(
					'bbs_key' => 'bbs_1',
				),
				'BbsArticleTree' => array(
					'bbs_key' => 'bbs_1',
				),
			);

		return array(
			array($this->__data, $association )
		);
	}

/**
 * ExceptionErrorのDataProvider
 *
 * #### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return array
 */
	public function dataProviderDeleteOnExceptionError() {
		return array(
			array($this->__data, 'Bbses.Bbs', 'deleteAll'),
			array($this->__data, 'Bbses.BbsArticle', 'deleteAll'),
			array($this->__data, 'Bbses.BbsArticleTree', 'deleteAll'),
		);
	}

}
