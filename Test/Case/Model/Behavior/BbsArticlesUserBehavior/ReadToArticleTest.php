<?php
/**
 * BbsArticleUserBehavior(ビヘイビア)のテスト
 *
 * @property TestBbsArticle $TestBbsArticle
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');
App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');
/**
 * Bbses(ビヘイビア)のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Test\Case\Model\Behavior
 */
class BbsArticlesUserBehaviorReadToArticleTest extends NetCommonsModelTestCase {

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
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		NetCommonsControllerTestCase::loadTestPlugin($this, 'Bbses', 'TestBbsArticle');
		$this->TestBbsArticle = ClassRegistry::init('TestBbsArticle.TestBbsArticle');
		$this->TestBbsArticle->Behaviors->unload('Like');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TestBbsArticle);
		parent::tearDown();
	}

/**
 * readToArticleのテスト
 *
 * @param int $userId ユーザーID
 * @param string $bbsArticleKey bbs_article_key
 * @param bool $expected 期待値
 * @dataProvider dataProviderReadToArticle
 *
 * @return void
 */
	public function testReadToArticle($userId, $bbsArticleKey, $expected) {
		//事前準備
		Current::$current['User']['id'] = $userId;

		//テスト実行
		$result = $this->TestBbsArticle->testReadToArticle($bbsArticleKey);

		//チェック
		$this->assertEquals($result, $expected);
	}

/**
 * ReadToArticleのDataProvider
 *
 * #### 戻り値
 *  - string ユーザーID
 *  - string bbsArticleKey
 *  - bool 期待値
 *
 * @return array
 */
	public function dataProviderReadToArticle() {
		return array(
			array(0, 'bbs_article_2', true), // user.idなし
			array(1, 'bbs_article_2', true), // user.idあり（countが0以上）
			array(1, 'bbs_article_xx', true), // user.idあり（countが0）
		);
	}

/**
 * ReadToArticleのExceptionErrorテスト
 *
 * @param string $model モデル名
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @param string $exception Exception
 * @dataProvider dataProviderReadToArticleExceptionError
 * @return void
 */
	public function testReadToArticleExceptionError($model, $mockModel, $mockMethod, $exception = null) {
		$bbsArticleKey = 'bbs_article_0';
		Current::$current['User']['id'] = '1';

		$this->_mockForReturnFalse($model, $mockModel, $mockMethod);

		if ($exception !== null) {
			$this->setExpectedException('InternalErrorException');
		}

		//処理実行
		$this->TestBbsArticle->testReadToArticle($bbsArticleKey);
	}

/**
 * UpdateBbsArticleChildCountのExceptionErrorのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - model Model名
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *  - exception
 *
 * @return void
 */
	public function dataProviderReadToArticleExceptionError() {
		return array(
			array('TestBbsArticle', 'Bbses.BbsArticlesUser', 'validates'),
			array('TestBbsArticle', 'Bbses.BbsArticlesUser', 'save', 'InternalErrorException'),
		);
	}

}
