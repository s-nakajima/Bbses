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
App::uses('WorkflowControllerAddTest', 'Workflow.TestSuite');

/**
 * BbsArticlesController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Test\Case\Controller\BbsArticlesController
 */
class BbsArticlesControllerAddTest extends WorkflowControllerAddTest {

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
 * @return array
 */
	private function __getData() {
		$frameId = '6';
		$blockId = '2';
		$blockKey = 'block_1';
		$bbsId = '2';
		$bbsKey = 'bbs_1';
		$bbsArticleId = null;
		$bbsArticleKey = null;

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
				'id' => null,
				'key' => null,
			),
			'BbsArticle' => array(
				'id' => $bbsArticleId,
				'key' => $bbsArticleKey,
				'bbs_id' => $bbsId,
				'language_id' => '2',
				'title' => 'TITLE',
				'content' => '本文です',
			),
			'BbsArticleTree' => array(
				'id' => null,
				'bbs_key' => $bbsKey,
				'bbs_article_key' => null,
				'root_id' => null,
				'parent_id' => null,
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
		$this->BbsArticle = ClassRegistry::init('Bbses.BbsArticle');
		$this->BbsArticle->Behaviors->unload('Like');
		$this->BbsArticleTree = ClassRegistry::init('Bbses.BbsArticleTree');
		$this->BbsArticleTree->Behaviors->unload('Like');
	}

/**
 * addアクションのGETテスト(ログインなし)用DataProvider
 *
 * ### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderAddGet() {
		$data = $this->__getData();
		$results = array();

		//ログインなし
		$results[0] = array(
			'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id']),
			'assert' => null, 'exception' => 'ForbiddenException'
		);
		return $results;
	}

/**
 * addアクションのGETテスト(作成権限あり)用DataProvider
 *
 * ### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderAddGetByCreatable() {
		$data = $this->__getData();
		$results = array();

		//作成権限あり
		$base = 0;
		$results[0] = array(
			'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id']),
			'assert' => array('method' => 'assertNotEmpty'),
		);
		array_push($results, Hash::merge($results[$base], array(
			'assert' => array('method' => 'assertInput', 'type' => 'input', 'name' => 'data[Frame][id]', 'value' => $data['Frame']['id']),
		)));
		array_push($results, Hash::merge($results[$base], array(
			'assert' => array('method' => 'assertInput', 'type' => 'input', 'name' => 'data[Block][id]', 'value' => $data['Block']['id']),
		)));
		array_push($results, Hash::merge($results[$base], array(
			'assert' => array('method' => 'assertInput', 'type' => 'button', 'name' => 'save_' . WorkflowComponent::STATUS_IN_DRAFT, 'value' => null),
		)));
		array_push($results, Hash::merge($results[$base], array(
			'assert' => array('method' => 'assertInput', 'type' => 'button', 'name' => 'save_' . WorkflowComponent::STATUS_APPROVED, 'value' => null),
		)));
		array_push($results, Hash::merge($results[$base], array(
			'assert' => array('method' => 'assertInput', 'type' => 'input', 'name' => 'data[BbsArticle][id]', 'value' => $data['BbsArticle']['id']),
		)));
		array_push($results, Hash::merge($results[$base], array(
			'assert' => array('method' => 'assertInput', 'type' => 'input', 'name' => 'data[BbsArticle][key]', 'value' => $data['BbsArticle']['key']),
		)));
		array_push($results, Hash::merge($results[$base], array(
			'assert' => array('method' => 'assertInput', 'type' => 'input', 'name' => 'data[BbsArticle][title]', 'value' => null),
		)));
		array_push($results, Hash::merge($results[$base], array(
			'assert' => array('method' => 'assertInput', 'type' => 'textarea', 'name' => 'data[BbsArticle][content]', 'value' => null),
		)));

		//フレームID指定なしテスト
		array_push($results, Hash::merge($results[$base], array(
			'urlOptions' => array('frame_id' => null, 'block_id' => $data['Block']['id']),
			'assert' => array('method' => 'assertNotEmpty'),
		)));
		array_push($results, Hash::merge($results[$base], array(
			'urlOptions' => array('frame_id' => null, 'block_id' => $data['Block']['id']),
			'assert' => array('method' => 'assertInput', 'type' => 'input', 'name' => 'data[Frame][id]', 'value' => null),
		)));

		return $results;
	}

/**
 * addアクションのPOSTテスト用DataProvider
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
	public function dataProviderAddPost() {
		$data = $this->__getData();

		return array(
			//ログインなし
			array(
				'data' => $data, 'role' => null,
				'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id']),
				'exception' => 'ForbiddenException'
			),
			//作成権限あり
			array(
				'data' => $data, 'role' => Role::ROOM_ROLE_KEY_GENERAL_USER,
				'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id']),
			),
			//フレームID指定なしテスト
			array(
				'data' => $data, 'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
				'urlOptions' => array('frame_id' => null, 'block_id' => $data['Block']['id']),
			),
		);
	}

/**
 * addアクションのValidationErrorテスト用DataProvider
 *
 * ### 戻り値
 *  - data: 登録データ
 *  - urlOptions: URLオプション
 *  - validationError: バリデーションエラー
 *
 * @return array
 */
	public function dataProviderAddValidationError() {
		$data = $this->__getData();
		$result = array(
			'data' => $data,
			'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id']),
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
