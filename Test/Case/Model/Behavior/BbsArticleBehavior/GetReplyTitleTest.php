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
class BbsArticleBehaviorGetReplyTitleTest extends NetCommonsModelTestCase {

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
 * getReplyTitleのテスト
 *
 * @param string $title タイトル情報
 * @param string $expected 期待値
 * @dataProvider dataProviderGetReplyTitle
 *
 * @return void
 */
	public function testGetReplyTitle($title, $expected) {
		//テスト実行
		$result = $this->TestBbsArticle->getReplyTitle($title);

		//チェック
		$this->assertEquals($expected, $result);
	}

/**
 * geReplyTitletのDataProvider
 *
 * #### 戻り値
 *  - array 取得するキー情報
 *  - array 期待値 （取得したキー情報）
 *
 * @return array
 */
	public function dataProviderGetReplyTitle() {
		return array(
			array('aaa', 'Re: aaa'),
			array('Re: aaa', 'Re2:  aaa'),
			array('Re2:  aaa', 'Re3:   aaa'),
			array('Re3:   aaa', 'Re4:    aaa'),
		);
	}

}
