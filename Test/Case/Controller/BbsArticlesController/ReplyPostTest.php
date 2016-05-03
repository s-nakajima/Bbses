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
class BbsArticlesControllerReplyPostTest extends NetCommonsControllerTestCase {

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
			$bbsArticleId = '2';
			$bbsArticleKey = 'bbs_article_2';
		}

		$data = array(
			'save_' . WorkflowComponent::STATUS_IN_DRAFT => null,
			'Frame' => array(
				'id' => $frameId
			),
			'Block' => array(
				'id' => $blockId,
				'key' => $blockKey,
				'language_id' => '2',
				'room_id' => '1',
				'plugin_key' => $this->plugin,
			),
			'Bbs' => array(
				'id' => $bbsId,
				'key' => $bbsKey,
			),
			'BbsArticle' => array(
				'id' => $bbsArticleId,
				'key' => $bbsArticleKey,
				'bbs_id' => $bbsId,
				'language_id' => '2',
				'category_id' => '2',
				'status' => null,
				'title' => 'BBSTITLE',
				'content' => 'CONTENT',
			),
			'BbsArticleTree' => array(
				'id' => '1',
				'bbs_key' => $bbsKey,
				'bbs_article_key' => $bbsArticleKey,
				'root_id' => null,
			),
			'WorkflowComment' => array(
				'comment' => 'WorkflowComment save test'
			),
		);

		return $data;
	}

/**
 * ReplyアクションのPOSTテスト
 *
 * @param array $data POSTデータ
 * @param string $role ロール
 * @param array $urlOptions URLオプション
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderReplyPost
 * @return void
 */
	public function testReplyPost($data, $role, $urlOptions, $exception = null, $return = 'view') {
		//ログイン
		if (isset($role)) {
			TestAuthGeneral::login($this, $role);
		}

		//テスト実施
		$this->_testPostAction('post', $data, Hash::merge(array('action' => 'reply'), $urlOptions), $exception, $return);

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
 * ReplyアクションのPOSTテスト用DataProvider
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
	public function dataProviderReplyPost() {
		$data = $this->__getData();

		return array(
			//ログインなし
			array(
				'data' => $data, 'role' => null,
				'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id'], 'key' => $data['BbsArticle']['key']),
				'exception' => 'ForbiddenException'
			),
			//作成権限のみ
			//--他人の記事
			array(
				'data' => $data, 'role' => Role::ROOM_ROLE_KEY_GENERAL_USER,
				'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id'], 'key' => 'bbs_article_1'),
				'exception' => 'BadRequestException'
			),
			//--自分の記事(一度も公開していない)
			array(
				'data' => $this->__getData(Role::ROOM_ROLE_KEY_GENERAL_USER, 'bbs_article_4'), 'role' => Role::ROOM_ROLE_KEY_GENERAL_USER,
				'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id'], 'key' => 'bbs_article_4'),
				'exception' => 'BadRequestException'
			),
			//編集権限あり
			//--コンテンツあり
			array(
				'data' => $data, 'role' => Role::ROOM_ROLE_KEY_EDITOR,
				'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id'], 'key' => $data['BbsArticle']['key']),
			),
			//フレームID指定なしテスト
			array(
				'data' => $data, 'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
				'urlOptions' => array('frame_id' => null, 'block_id' => $data['Block']['id'], 'key' => $data['BbsArticle']['key']),
			),
		);
	}

/**
 * replyアクションのValidateionErrorテスト
 *
 * @param array $data POSTデータ
 * @param array $urlOptions URLオプション
 * @param string|null $validationError ValidationError
 * @dataProvider dataProviderReplyValidationError
 * @return void
 */
	public function testReplyValidationError($data, $urlOptions, $validationError = null) {
		//ログイン
		TestAuthGeneral::login($this);

		//テスト実施
		$this->_testActionOnValidationError('post', $data, Hash::merge(array('action' => 'reply'), $urlOptions), $validationError);

		//ログアウト
		TestAuthGeneral::logout($this);
	}

/**
 * ReplyアクションのValidationErrorテスト用DataProvider
 *
 * ### 戻り値
 *  - data: 登録データ
 *  - urlOptions: URLオプション
 *  - validationError: バリデーションエラー
 *
 * @return array
 */
	public function dataProviderReplyValidationError() {
		$data = $this->__getData();
		$result = array(
			'data' => $data,
			'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id'], 'key' => $data['BbsArticle']['key']),
		);

		return array(
			Hash::merge($result, array(
				'validationError' => array(
					'field' => 'BbsArticle.title',
					'value' => '',
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('bbses', 'Title'))
				)
			)),
			Hash::merge($result, array(
				'validationError' => array(
					'field' => 'BbsArticle.content',
					'value' => '',
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('bbses', 'Content'))
				)
			)),
		);
	}

}
