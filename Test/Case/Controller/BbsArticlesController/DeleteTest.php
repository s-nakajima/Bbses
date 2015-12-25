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

App::uses('BbsArticlesController', 'Bbses.Controller');
App::uses('WorkflowControllerDeleteTest', 'Workflow.TestSuite');

/**
 * BbsArticlesController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Test\Case\Controller\BbsArticlesController
 */
class BbsArticlesControllerDeleteTest extends WorkflowControllerDeleteTest {

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
 * @param string $bbsArticleKey 質問ID
 * @return array
 */
	private function __getData($bbsArticleKey = 'bbs_article_1') {
		$frameId = '6';
		$blockId = '2';
		$bbsId = '2';
		$bbsKey = 'bbs_1';
		$rootId = null;
		if ($bbsArticleKey === 'bbs_article_1') {
			$bbsArticleId = '1';
		} elseif ($bbsArticleKey === 'bbs_article_2') {
			$bbsArticleId = '2';
		} elseif ($bbsArticleKey === 'bbs_article_3') {
			$bbsArticleId = '3';
		} elseif ($bbsArticleKey === 'bbs_article_4') {
			$bbsArticleId = '4';
		} elseif ($bbsArticleKey === 'bbs_article_5') {
			$bbsArticleId = '5';
		} elseif ($bbsArticleKey === 'bbs_article_6') {
			$bbsArticleId = '6';
		} elseif ($bbsArticleKey === 'bbs_article_8') {
			$bbsArticleId = '8';
		} elseif ($bbsArticleKey === 'bbs_article_11') {
			$bbsArticleId = '11';
		} else {
			$bbsArticleId = '2';
		}

		$data = array(
			'delete' => null,
			'Frame' => array(
				'id' => $frameId
			),
			'Block' => array(
				'id' => $blockId,
				'key' => 'block_1',
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
				'root_id' => $rootId,
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
		$this->BbsArticle = ClassRegistry::init('Bbses.BbsArticle');
		$this->BbsArticle->Behaviors->unload('Like');
		$this->BbsArticleTree = ClassRegistry::init('Bbses.BbsArticleTree');
		$this->BbsArticleTree->Behaviors->unload('Like');
	}

/**
 * deleteアクションのGETテスト用DataProvider
 *
 * ### 戻り値
 *  - role: ロール
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderDeleteGet() {
		$data = $this->__getData();
		$results = array();

		$results[0] = array('role' => null,
			'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id'], 'key' => $data['BbsArticle']['key']),
			'assert' => null, 'exception' => 'ForbiddenException'
		);
		array_push($results, Hash::merge($results[0], array(
			'role' => Role::ROOM_ROLE_KEY_GENERAL_USER,
			'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id'], 'key' => $data['BbsArticle']['key']),
			'assert' => null, 'exception' => 'BadRequestException'
		)));
		array_push($results, Hash::merge($results[0], array(
			'role' => Role::ROOM_ROLE_KEY_EDITOR,
			'assert' => null, 'exception' => 'BadRequestException'
		)));
		array_push($results, Hash::merge($results[0], array(
			'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
			'assert' => null, 'exception' => 'BadRequestException'
		)));
		array_push($results, Hash::merge($results[0], array(
			'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
			'assert' => null, 'exception' => 'BadRequestException', 'return' => 'json'
		)));

		return $results;
	}

/**
 * deleteアクションのPOSTテスト用DataProvider
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
	public function dataProviderDeletePost() {
		$data = $this->__getData();

		return array(
			//ログインなし
			array(
				'data' => $data, 'role' => null,
				'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id'], 'key' => 'bbs_article_1'),
				'exception' => 'ForbiddenException'
			),
			//作成権限のみ
			//--他人の記事
			array(
				'data' => $data, 'role' => Role::ROOM_ROLE_KEY_GENERAL_USER,
				'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id'], 'key' => 'bbs_article_1'),
				'exception' => 'BadRequestException'
			),
			array(
				'data' => $data, 'role' => Role::ROOM_ROLE_KEY_GENERAL_USER,
				'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id'], 'key' => 'bbs_article_1'),
				'exception' => 'BadRequestException', 'return' => 'json'
			),
			//--自分の記事＆一度も公開されていない
			array(
				'data' => $this->__getData('bbs_article_4'), 'role' => Role::ROOM_ROLE_KEY_GENERAL_USER,
				'urlOptions' => array('frame_id' => $data['Frame']['id'], $data['Block']['id'], 'key' => 'bbs_article_4'),
			),
			//--自分の記事＆一度公開している
			array(
				'data' => $this->__getData('bbs_article_3'), 'role' => Role::ROOM_ROLE_KEY_GENERAL_USER,
				'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id'], 'key' => 'bbs_article_3'),
				'exception' => 'BadRequestException'
			),
			//編集権限あり
			//--公開していない
			array(
				'data' => $this->__getData('bbs_article_5'), 'role' => Role::ROOM_ROLE_KEY_EDITOR,
				'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id'], 'key' => 'bbs_article_5'),
			),
			//--公開している
			array(
				'data' => $this->__getData('bbs_article_6'), 'role' => Role::ROOM_ROLE_KEY_EDITOR,
				'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id'], 'key' => 'bbs_article_6'),
				'exception' => 'BadRequestException'
			),
			//公開権限あり
			//--親記事あり
			array(
				'data' => $this->__getData('bbs_article_8'), 'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
				'urlOptions' => array('frame_id' => null, 'block_id' => $data['Block']['id'], 'key' => 'bbs_article_8'),
			),
			//--親記事あり（取得できない）
			array(
				'data' => $this->__getData('bbs_article_11'), 'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
				'urlOptions' => array('frame_id' => null, 'block_id' => $data['Block']['id'], 'key' => 'bbs_article_11'),
				'exception' => 'BadRequestException'
			),
			array(
				'data' => $this->__getData('bbs_article_11'), 'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
				'urlOptions' => array('frame_id' => null, 'block_id' => $data['Block']['id'], 'key' => 'bbs_article_11'),
				'exception' => 'BadRequestException',
				'return' => 'json'
			),
			//フレームID指定なしテスト
			array(
				'data' => $this->__getData('bbs_article_8'), 'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
				'urlOptions' => array('frame_id' => null, 'block_id' => $data['Block']['id'], 'key' => $data['BbsArticle']['key']),
			),
		);
	}

/**
 * deleteアクションのExceptionErrorテスト用DataProvider
 *
 * ### 戻り値
 *  - mockModel: Mockのモデル
 *  - mockMethod: Mockのメソッド
 *  - data: 登録データ
 *  - urlOptions: URLオプション
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderDeleteExceptionError() {
		$data = $this->__getData();

		return array(
			array(
				'mockModel' => 'Bbses.BbsArticle', 'mockMethod' => 'deleteBbsArticle', 'data' => $data,
				'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id'], 'key' => $data['BbsArticle']['key']),
				'exception' => 'BadRequestException'
			),
			array(
				'mockModel' => 'Bbses.BbsArticle', 'mockMethod' => 'deleteBbsArticle', 'data' => $data,
				'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id'], 'key' => $data['BbsArticle']['key']),
				'exception' => 'BadRequestException', 'return' => 'json'
			),
		);
	}

}
