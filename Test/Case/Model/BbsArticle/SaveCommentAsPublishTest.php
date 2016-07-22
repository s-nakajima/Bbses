<?php
/**
 * BbsArticle::saveCommentAsPublish()のテスト
 *
 * @property BbsArticle $BbsArticle
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');
App::uses('WorkflowComponent', 'Workflow.Controller/Component');

/**
 * BbsArticle::saveCommentAsPublish()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Test\Case\Model\BbsArticle
 */
class BbsArticleSaveCommentAsPublishTest extends NetCommonsModelTestCase {

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
	protected $_modelName = 'BbsArticle';

/**
 * Method name
 *
 * @var array
 */
	protected $_methodName = 'saveCommentAsPublish';

/**
 * テストDataの取得
 *
 * @param string $bbsArticleKey bbsArticleKey
 * @return array
 */
	private function __getData() {
		$data = array(
			'BbsArticle' => array(
				'id' => '4',
				'language_id' => '2',
				'bbs_id' => '2',
				'status' => WorkflowComponent::STATUS_PUBLISHED,
			),
			'BbsArticleTree' => array(
				'id' => '4',
				'root_id' => '0',
			),
			'WorkflowComment' => array(
				'comment' => 'WorkflowComment save test'
			),
		);

		return $data;
	}

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$model = $this->_modelName;
		$this->$model->Behaviors->unload('Like');
		$this->$model->Behaviors->unload('Topics');
		$this->$model->BbsArticleTree = ClassRegistry::init('Bbses.BbsArticleTree');
		$this->$model->BbsArticleTree->Behaviors->unload('Like');
	}

/**
 * SaveのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *
 * @return void
 */
	public function dataProviderSave() {
		return array(
			array($this->__getData()),
		);
	}

/**
 * SaveのExceptionErrorのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return void
 */
	public function dataProviderSaveOnExceptionError() {
		return array(
			array($this->__getData(), 'Bbses.BbsArticle', 'saveField'),
		);
	}

/**
 * SaveのExceptionError2のDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return void
 */
	public function dataProviderSaveOnExceptionError2() {
		return array(
			array($this->__getData(), 'Bbses.BbsArticle', 'saveField'),
		);
	}

/**
 * Saveのテスト
 *
 * @param array $data 登録データ
 * @dataProvider dataProviderSave
 * @return array 登録後のデータ
 */
	public function testSave($data) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		//チェック用データ取得
		$before = $this->$model->find('first', array(
			'recursive' => -1,
			'conditions' => array('id' => $data[$this->$model->alias]['id']),
		));

		//チェック用データ確認
		//is_activeのチェック
		$this->assertEquals($before[$this->$model->alias]['is_active'], false);
		//statusのチェック
		$this->assertNotEquals($before[$this->$model->alias]['status'], WorkflowComponent::STATUS_PUBLISHED);

		//テスト実行
		$result = $this->$model->$method($data);
		$this->assertNotEmpty($result);

		//登録データ取得
		$latest = $this->$model->find('first', array(
			'recursive' => -1,
			'conditions' => array('id' => $data[$this->$model->alias]['id']),
		));
		$actual = $latest;

		$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'modified');
		$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'modified_user');

		$expected[$this->$model->alias] = Hash::merge(
			$before[$this->$model->alias],
			$data[$this->$model->alias],
				array(
					'id' => $data[$this->$model->alias]['id'],
					'is_active' => true,
					'is_latest' => true,
					'status' => WorkflowComponent::STATUS_PUBLISHED
				)
		);
		$expected[$this->$model->alias] = Hash::remove($expected[$this->$model->alias], 'modified');
		$expected[$this->$model->alias] = Hash::remove($expected[$this->$model->alias], 'modified_user');

		$this->assertEquals($expected, $actual);

		return $latest;
	}

/**
 * SaveのExceptionErrorテスト
 *
 * @param array $data 登録データ
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @dataProvider dataProviderSaveOnExceptionError
 * @return void
 */
	public function testSaveOnExceptionError($data, $mockModel, $mockMethod) {
		$model = $this->_modelName;
		$method = $this->_methodName;
		$this->setExpectedException('InternalErrorException');
		$this->_mockForReturnFalse($model, $mockModel, $mockMethod);

		$this->$model->$method($data);
	}

/**
 * SaveのExceptionError2テスト(同じメソッドが異なる引数で呼ばれる（2回目でエラー）)
 *
 * @param array $data 登録データ
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @dataProvider dataProviderSaveOnExceptionError2
 * @return void
 */
	public function testSaveOnExceptionError2($data, $mockModel, $mockMethod) {
		list($mockPlugin, $mockModel) = pluginSplit($mockModel);
		$model = $this->_modelName;
		$method = $this->_methodName;
		$this->setExpectedException('InternalErrorException');

		//1回目
		$this->$model = $this->getMockForModel($mockPlugin . '.' . $mockModel, array($mockMethod));
		$this->$model->expects($this->at(0))
			->method($mockMethod)
			->will($this->returnValue(true));

		//2回目
		$this->$model->expects($this->at(1))
			->method('saveField')
			->will($this->returnValue(false));

		$this->$model->$method($data);
	}

}
