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
class BbsArticleBehaviorGetReplyContentTest extends NetCommonsModelTestCase {

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
 * getReplyContentのテスト
 *
 * @return void
 */
	public function testGetReplyContent() {
		$content = $this->TestBbsArticle->getReplyContent('aaa');
		$this->assertEquals('<p></p><blockquote class="small">aaa</blockquote><p></p>', $content);
	}

}
