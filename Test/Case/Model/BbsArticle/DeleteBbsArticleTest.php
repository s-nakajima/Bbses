<?php
/**
 * BbsArticle::deleteBbsArticle()のテスト
 *
 * @property BbsArticle $BbsArticle
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('WorkflowDeleteTest', 'Workflow.TestSuite');

/**
 * BbsArticle::deleteBbsArticle()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Test\Case\Model\BbsArticle
 */
class BbsArticleDeleteBbsArticleTest extends WorkflowDeleteTest {

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
	protected $_methodName = 'deleteBbsArticle';

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
				'key' => 'bbs_1',
			),
			'BbsArticle' => array(
				'key' => 'bbs_article_1',
				'language_id' => '2',
			),
			'BbsArticleTree' => array(
				'root_id' => '1',
			)
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
			'BbsArticleTree' => array(
				'bbs_article_key' => 'bbs_article_1',
			),
		);

		return array(
			array($this->__data, $association),
		);
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
	public function dataProviderDeleteNotExist() {
		$dataNoArticle = $this->__data;
		$dataNoArticle['BbsArticle']['key'] = 'bbs_article_0';
		$association = array(
			'BbsArticleTree' => array(
				'bbs_article_key' => 'bbs_article_0',
			),
		);
		return array(
			array($dataNoArticle, $association),
		);
	}

/**
 * Deleteのテスト
 *
 * @param array $data 削除データ
 * @param array $associationModels 削除確認の関連モデル array(model => conditions)
 * @dataProvider dataProviderDeleteNotExist
 * @return void
 */
	public function testDeleteNotExist($data, $associationModels = null) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		//テスト実行前のチェック
		$count = $this->$model->find('count', array(
			'recursive' => -1,
			'conditions' => array('key' => $data[$this->$model->alias]['key']),
		));
		$this->assertEquals(0, $count);

		if ($associationModels) {
			foreach ($associationModels as $assocModel => $conditions) {
				$count = $this->$model->$assocModel->find('count', array(
					'recursive' => -1,
					'conditions' => $conditions,
				));
				$this->assertEquals(0, $count);
			}
		}

		//テスト実行
		$result = $this->$model->$method($data);
		$this->assertFalse($result);

		//チェック
		$count = $this->$model->find('count', array(
			'recursive' => -1,
			'conditions' => array('key' => $data[$this->$model->alias]['key']),
		));
		$this->assertEquals(0, $count);

		if ($associationModels) {
			foreach ($associationModels as $assocModel => $conditions) {
				$count = $this->$model->$assocModel->find('count', array(
					'recursive' => -1,
					'conditions' => $conditions,
				));
				$this->assertEquals(0, $count);
			}
		}
	}

/**
 * ExceptionErrorのDataProvider
 *
 * #### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return void
 */
	public function dataProviderDeleteOnExceptionError() {
		return array(
			array($this->__data, 'Bbses.BbsArticle', 'deleteAll'),
			array($this->__data, 'Bbses.BbsArticleTree', 'deleteAll'),
		);
	}

}
