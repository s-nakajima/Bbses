<?php
/**
 * BbsArticleBehavior(ビヘイビア)のテスト
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
class BbsArticleBehaviorUpdateBbsArticleChildCountTest extends NetCommonsModelTestCase {

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
		'plugin.bbses.block_setting_for_bbs',
		'plugin.bbses.bbs_frame_setting',
		'plugin.bbses.bbs_article',
		'plugin.bbses.bbs_article_tree',
		'plugin.likes.like',
		'plugin.likes.likes_user',
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
 * updateBbsArticleChildCountのテスト
 * @param int $rootId
 * @param int $languageId
 * @param array $expected 期待値
 * @dataProvider dataProviderUpdateBbsArticleChildCount
 * @return void
 */
	public function testUpdateBbsArticleChildCount($rootId, $languageId, $expected) {
		//処理実行
		$this->TestBbsArticle->testUpdateBbsArticleChildCount($rootId, $languageId);

		//チェック
		$conditions = array(
			'id' => $rootId,
		);
		$article = $this->TestBbsArticle->BbsArticleTree->find('first', array(
			'recursive' => -1,
			'conditions' => $conditions,
		));
		$this->assertEquals($article['BbsArticleTree']['bbs_article_child_count'], $expected);
	}

/**
 * UpdateBbsArticleChildCountのDataProvider
 *
 * #### 戻り値
 *  - int rootId
 *  - int languageId
 *  - int 期待値
 *
 * @return array
 */
	public function dataProviderUpdateBbsArticleChildCount() {
		return array(
			array(1, 2, 1),
		);
	}

/**
 * UpdateBbsArticleChildCountのExceptionErrorテスト
 *
 * @param string $model モデル名
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @dataProvider dataProviderUpdateBbsArticleChildCountExceptionError
 * @return void
 */
	public function testUpdateBbsArticleChildCountExceptionError($model, $mockModel, $mockMethod) {
		$rootId = '1';
		$languageId = '2';

		$this->_mockForReturnFalse($model, $mockModel, $mockMethod);

		$this->setExpectedException('InternalErrorException');
		//処理実行
		$this->TestBbsArticle->testUpdateBbsArticleChildCount($rootId, $languageId);
	}

/**
 * UpdateBbsArticleChildCountのExceptionErrorのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - model Model名
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return array
 */
	public function dataProviderUpdateBbsArticleChildCountExceptionError() {
		return array(
			array('TestBbsArticle', 'TestBbsArticle.TestBbsArticle', 'find'),
			array('TestBbsArticle', 'TestBbsArticle.TestBbsArticle', 'updateAll'),
		);
	}

}
