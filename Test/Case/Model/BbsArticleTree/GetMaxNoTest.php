<?php
/**
 * BbsArticleTree::getMaxNo()のテスト
 *
 * @property BbsArticleTree $BbsArticleTree
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsGetTest', 'NetCommons.TestSuite');

/**
 * BbsArticleTree::getMaxNo()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Test\Case\Model\BbsArticleTree
 */
class BbsArticleTreeGetMaxNoTest extends NetCommonsGetTest {

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
	protected $_methodName = 'getMaxNo';

/**
 * getMaxNoのテスト
 *
 * @param int $rootArticleId
 * @param array $expected 期待値
 * @dataProvider dataProviderGetMaxNo
 *
 * @return void
 */
	public function testGetMaxNo($rootArticleId, $expected) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		//テスト実行
		$result = $this->$model->$method($rootArticleId);

		//チェック
		$this->assertEquals($expected, $result);
	}

/**
 * getMaxNoのDataProvider
 *
 * #### 戻り値
 *  - int  rootArticleTreeId
 *  - array 期待値 （取得したキー情報）
 *
 * @return array
 */
	public function dataProviderGetMaxNo() {
		return array(
			array('1', 1),
			array('2', 0), //article_noが未設定の場合
			array('0', 0), //存在しない場合
			array('999', 0), //存在しない場合
		);
	}

}
