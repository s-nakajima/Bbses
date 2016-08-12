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
class BbsArticleBehaviorUpdateBbsByBbsArticleTest extends NetCommonsModelTestCase {

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
 * updateBbsByBbsArticleのテスト
 * @param array $expected 期待値
 * @param array $key キー情報
 * @dataProvider dataProviderUpdateBbsByBbsArticle
 * @return void
 */
	public function testUpdateBbsByBbsArticle($expected, $key) {
		//処理実行
		$this->TestBbsArticle->testUpdateBbsByBbsArticle($key['bbs_id'], $key['bbs_key'], $key['language_id']);

		//チェック
		$conditions = array(
			'id' => $key['bbs_id'],
		);
		$bbs = $this->TestBbsArticle->Bbs->find('first', array(
			'recursive' => -1,
			'conditions' => $conditions,
		));
		$this->assertEquals($expected, $bbs['Bbs']['bbs_article_count']);
	}

/**
 * UpdateBbsByBbsArticleのDataProvider
 *
 * #### 戻り値
 *  - int 期待値
 *  - array 取得するキー情報
 *
 * @return array
 */
	public function dataProviderUpdateBbsByBbsArticle() {
		return array(
			array(13, array('bbs_id' => '2', 'bbs_key' => 'bbs_1', 'language_id' => 2)),
		);
	}

/**
 * UpdateBbsByBbsArticleのExceptionErrorテスト
 *
 * @param array $key キー情報
 * @param string $model モデル名
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @param int $times エラーが発生する回（同じメソッドが複数回呼ばれる場合）
 * @dataProvider dataProviderUpdateBbsByBbsArticleExceptionError
 * @return void
 */
	public function testUpdateBbsByBbsArticleExceptionError($key, $model, $mockModel, $mockMethod, $times) {
		list($mockPlugin, $mockModel) = pluginSplit($mockModel);
		if ($mockModel === $model) {
			if ($times === '1') {
				$this->_mockForReturnFalse($model, $mockModel, $mockMethod);
			} elseif ($times === '2') {
				$this->$model = $this->getMockForModel($mockPlugin . '.' . $mockModel, array($mockMethod));
				// 1回目
				$this->$model->expects($this->at(0))
					->method('find')
					->will($this->returnValue(true));
				// 2回目
				$this->TestBbsArticle->expects($this->at(1))
					->method('find')
					->will($this->returnValue(false));
			}
		} else {
			$this->_mockForReturnFalse($model, $mockModel, $mockMethod);

		}

		$this->setExpectedException('InternalErrorException');
		//処理実行
		$this->TestBbsArticle->testUpdateBbsByBbsArticle($key['bbs_id'], $key['bbs_key'], $key['language_id']);
	}

/**
 * UpdateBbsByBbsArticleのExceptionErrorのDataProvider
 *
 * ### 戻り値
 *  - key キー情報
 *  - model モデル名
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *  - times エラー発生回
 *
 * @return array
 */
	public function dataProviderUpdateBbsByBbsArticleExceptionError() {
		$key = array(
			'bbs_id' => '0',
			'bbs_key' => 'bbs_0',
			'language_id' => 0 );

		return array(
			array($key, 'TestBbsArticle', 'TestBbsArticle.TestBbsArticle', 'find', '1'),
			array($key, 'TestBbsArticle', 'TestBbsArticle.TestBbsArticle', 'find', '2'),
			//array($key, 'TestBbsArticle', 'Bbses.Bbs', 'updateAll', '2'),
		);
	}

}
