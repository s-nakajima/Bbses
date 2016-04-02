<?php
/**
 * BbsMailSettingsController::edit()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * BbsMailSettingsController::edit()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Test\Case\Controller\BbsMailSettingsController
 */
class BbsMailSettingsControllerEditTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.bbses.bbs_article',
		'plugin.bbses.bbs_article_tree',
		'plugin.bbses.bbs_articles_user',
		'plugin.bbses.bbs_frame_setting',
		'plugin.bbses.bbs_setting',
		'plugin.bbses.bbs',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'bbses';

/**
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'bbs_mail_settings';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//ログイン
		TestAuthGeneral::login($this);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		//ログアウト
		TestAuthGeneral::logout($this);

		parent::tearDown();
	}

/**
 * edit()アクションのGetリクエストテスト
 *
 * @return void
 */
	public function testEditGet() {
		//テストデータ
		$frameId = '6';
		$blockId = '2';

		//テスト実行
		$this->_testGetAction(array('action' => 'edit', 'block_id' => $blockId, 'frame_id' => $frameId),
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->assertInput('form', null, 'bbses/bbs_mail_settings/edit/' . $blockId, $this->view);
	}

}
