<?php
/**
 * BbsArticlesController Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');
App::uses('WorkflowComponent', 'Workflow.Controller/Component');

/**
 * BbsArticlesController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Test\Case\Controller\BbsArticlesController
 */
class BbsArticlesControllerApproveTest extends NetCommonsControllerTestCase {

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
 * Plugin name
 *
 * @var array
 */
	public $plugin = 'bbses';

/**
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'bbs_articles';

/**
 * テストDataの取得
 *
 * @param string $role ロール
 * @param string $bbsArticleKey キー
 * @return array
 */
	private function __getData($role = null, $bbsArticleKey = null) {
		$frameId = '6';
		$blockId = '2';
		$blockKey = 'block_1';
		$bbsId = '2';
		$bbsKey = 'bbs_1';
		if ($role === Role::ROOM_ROLE_KEY_GENERAL_USER) {
			if ($bbsArticleKey === 'bbs_article_4') {
				$bbsArticleId = '4';
				$bbsArticleKey = 'bbs_article_4';
			} else {
				$bbsArticleId = '3';
				$bbsArticleKey = 'bbs_article_3';
			}
		} else {
			$bbsArticleId = '1';
			$bbsArticleKey = 'bbs_article_1';
		}

		$data = array(
			'save_' . WorkflowComponent::STATUS_IN_DRAFT => null,
			'Frame' => array(
				'id' => $frameId
			),
			'Block' => array(
				'id' => $blockId,
				'key' => $blockKey,
			),
			'Bbs' => array(
				'id' => $bbsId,
				'key' => $bbsKey,
			),
			'BbsArticle' => array(
				'id' => $bbsArticleId,
				'key' => $bbsArticleKey,
				'language_id' => '2',
			),
			'BbsArticleTree' => array(
				'id' => '1',
				'root_id' => null,
			),
		);

		return $data;
	}

/**
 * ApproveアクションのGETテスト
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderApproveGet
 * @return void
 */
	public function testApproveGet($urlOptions, $assert, $exception = null, $return = 'view') {
		//テスト実施
		$url = Hash::merge(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'approve',
		), $urlOptions);

		$this->_testGetAction($url, $assert, $exception, $return);
	}

/**
 * ApproveアクションのGETテスト(ログインなし)用DataProvider
 *
 * ### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderApproveGet() {
		$data = $this->__getData();
		$results = array();

		//ログインなし
		$results[0] = array(
			'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id'], 'key' => $data['BbsArticle']['key']),
			'assert' => null, 'exception' => 'ForbiddenException'
		);
		return $results;
	}

/**
 * approveアクションのGETテスト(編集権限、公開権限なし)
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderApproveGetByEditable
 * @return void
 */
	public function testApproveGetByEditable($urlOptions, $assert, $exception = null, $return = 'view') {
		//ログイン
		TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_EDITOR);

		$this->testApproveGet($urlOptions, $assert, $exception, $return);

		//ログアウト
		TestAuthGeneral::logout($this);
	}

/**
 * ApproveアクションのGETテスト(編集権限、公開権限なし)用DataProvider
 *
 * ### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderApproveGetByEditable() {
		$data = $this->__getData();
		$results = array();

		//編集権限あり
		//--コンテンツあり
		$results[0] = array(
			'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id'], 'key' => $data['BbsArticle']['key']),
			'assert' => null,
			'exception' => 'ForbiddenException',
		);

		return $results;
	}

/**
 * ApproveアクションのGETテスト(公開権限あり)
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderApproveGetByPublishable
 * @return void
 */
	public function testApproveGetByPublishable($urlOptions, $assert, $exception = null, $return = 'view') {
		//ログイン
		TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR);

		$this->testApproveGet($urlOptions, $assert, $exception, $return);

		//ログアウト
		TestAuthGeneral::logout($this);
	}

/**
 * ApproveアクションのGETテスト(公開権限あり)用DataProvider
 *
 * ### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderApproveGetByPublishable() {
		$data = $this->__getData();
		$results = array();
		//Put以外（Get）エラー
		$results[0] = array(
			'urlOptions' => array('frame_id' => null, 'block_id' => $data['Block']['id'], 'key' => $data['BbsArticle']['key']),
			'assert' => null,
			'exception' => 'BadRequestException',
		);
		$results[1] = array(
			'urlOptions' => array('frame_id' => null, 'block_id' => $data['Block']['id'], 'key' => $data['BbsArticle']['key']),
			'assert' => null,
			'exception' => 'BadRequestException', 'json',
		);

		return $results;
	}

/**
 * ApproveアクションのPUTテスト
 *
 * @param array $data PUTデータ
 * @param string $role ロール
 * @param array $urlOptions URLオプション
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderApprovePut
 * @return void
 */
	public function testApprovePut($data, $role, $urlOptions, $exception = null, $return = 'view') {
		//ログイン
		if (isset($role)) {
			TestAuthGeneral::login($this, $role);
		}

		if ($exception === 'BadRequestException' && array_key_exists('save_3', $data)) {
			$this->_mockForReturnFalse('Bbses.BbsArticle', 'saveCommentAsPublish');
		}

		//テスト実施
		$this->_testPostAction('put', $data, Hash::merge(array('action' => 'approve'), $urlOptions), $exception, $return);

		//正常の場合、リダイレクト
		if (! $exception) {
			$header = $this->controller->response->header();
			$this->assertNotEmpty($header['Location']);
		}

		//ログアウト
		if (isset($role)) {
			TestAuthGeneral::logout($this);
		}
	}

/**
 * ApproveアクションのPOSTテスト用DataProvider
 *
 * ### 戻り値
 *  - data: 登録データ
 *  - role: ロール
 *  - urlOptions: URLオプション
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderApprovePut() {
		$data = $this->__getData();

		//statusエラーデータ
		$dataError = $data;
		unset($dataError['save_3']);

		return array(
			//ログインなし
			array(
				'data' => $data, 'role' => null,
				'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id'], 'key' => $data['BbsArticle']['key']),
				'exception' => 'ForbiddenException'
			),
			//作成権限のみ
			array(
				'data' => $data, 'role' => Role::ROOM_ROLE_KEY_GENERAL_USER,
				'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id'], 'key' => $data['BbsArticle']['key']),
				'exception' => 'ForbiddenException'
			),
			//編集権限あり
			array(
				'data' => $data, 'role' => Role::ROOM_ROLE_KEY_EDITOR,
				'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id'], 'key' => $data['BbsArticle']['key']),
				'exception' => 'ForbiddenException'
			),
			//編集権限あり(公開権限あり)
			array(
				'data' => $data, 'role' => Role::ROOM_ROLE_KEY_CHIEF_EDITOR,
				'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id'], 'key' => $data['BbsArticle']['key']),
			),
			//(saveCommentAsPublishエラー)
			array(
				'data' => $data, 'role' => Role::ROOM_ROLE_KEY_CHIEF_EDITOR,
				'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id'], 'key' => $data['BbsArticle']['key']),
				'exception' => 'BadRequestException'
			),
			array(
				'data' => $data, 'role' => Role::ROOM_ROLE_KEY_CHIEF_EDITOR,
				'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id'], 'key' => $data['BbsArticle']['key']),
				'exception' => 'BadRequestException', 'return' => 'json'
			),
			//フレームID指定なしテスト
			array(
				'data' => $data, 'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
				'urlOptions' => array('frame_id' => null, 'block_id' => $data['Block']['id'], 'key' => $data['BbsArticle']['key']),
			),
			//statusエラー
			array(
				'data' => $dataError, 'role' => Role::ROOM_ROLE_KEY_CHIEF_EDITOR,
				'urlOptions' => array('frame_id' => $dataError['Frame']['id'], 'block_id' => $dataError['Block']['id'], 'key' => $dataError['BbsArticle']['key']),
				'exception' => 'BadRequestException'
			),
			array(
				'data' => $dataError, 'role' => Role::ROOM_ROLE_KEY_CHIEF_EDITOR,
				'urlOptions' => array('frame_id' => $dataError['Frame']['id'], 'block_id' => $dataError['Block']['id'], 'key' => $dataError['BbsArticle']['key']),
				'exception' => 'BadRequestException', 'return' => 'json'
			),
		);
	}

}
