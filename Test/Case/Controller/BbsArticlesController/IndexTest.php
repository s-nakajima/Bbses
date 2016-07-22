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

App::uses('WorkflowControllerIndexTest', 'Workflow.TestSuite');

/**
 * BbsArticlesController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Test\Case\Controller\BbsArticlesController
 */
class BbsArticlesControllerIndexTest extends WorkflowControllerIndexTest {

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

		$data = array(
			'Frame' => array(
				'id' => $frameId
			),
			'Block' => array(
				'id' => $blockId,
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
 * indexアクションのテスト(ログインなし)用DataProvider
 *
 * ### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderIndex() {
		$data = $this->__getData();
		$results = array();
		//ソート、表示件数指定なし
		$results[0] = array(
			'urlOptions' => array('frame_id' => $data['Frame']['id']),
			'assert' => array('method' => 'assertNotEmpty'),
		);
		//並べ替え、新しい投稿順
		$results[1] = array(
			'urlOptions' => array('frame_id' => $data['Frame']['id'], 'sort' => 'BbsArticle.created', 'direction' => 'desc'),
			'assert' => array('method' => 'assertNotEmpty'),
		);
		//並べ替え、古い投稿順
		$results[2] = array(
			'urlOptions' => array('frame_id' => $data['Frame']['id'], 'sort' => 'BbsArticle.created', 'direction' => 'asc'),
			'assert' => array('method' => 'assertNotEmpty'),
		);
		//表示件数指定
		$results[3] = array(
			'urlOptions' => array('frame_id' => $data['Frame']['id'], 'limit' => 'limit:1'),
			//'assert' => array('method' => 'assertContains', 'expected' => sprintf(__d('bbses', '%s articles'), 1))
			'assert' => array('method' => 'assertNotEmpty'),
		);

		//チェック
		//--追加ボタンチェック(なし)
		$results[4] = array(
			'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id']),
			'assert' => array('method' => 'assertActionLink', 'action' => 'add', 'linkExist' => false, 'url' => array()),
		);

		return $results;
	}

/**
 * indexアクションのテスト(編集権限あり)用DataProvider
 *
 * ### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderIndexByEditable() {
		$data = $this->__getData();
		$results = array();

		//編集権限あり
		$base = 0;
		$results[0] = array(
			'urlOptions' => array('frame_id' => $data['Frame']['id']),
			'assert' => array('method' => 'assertNotEmpty'),
		);
		//チェック
		//--追加ボタンチェック
		array_push($results, Hash::merge($results[$base], array(
			'assert' => array('method' => 'assertActionLink', 'action' => 'add', 'linkExist' => true, 'url' => array()),
		)));
		//フレームあり(コンテンツなし)テスト
		array_push($results, Hash::merge($results[$base], array(
			'urlOptions' => array('frame_id' => '14', 'block_id' => null),
			'assert' => array('method' => 'assertEquals', 'expected' => 'emptyRender'),
			'exception' => null, 'return' => 'viewFile'
		)));
		//記事なしテスト
		array_push($results, Hash::merge($results[$base], array(
			'urlOptions' => array('frame_id' => null, 'block_id' => '6'),
			'assert' => array('method' => 'assertContains', 'expected' => __d('bbses', 'No article found.'))
		)));
		//フレームID指定なしテスト
		array_push($results, Hash::merge($results[$base], array(
			'urlOptions' => array('frame_id' => null, 'block_id' => $data['Block']['id']),
		)));

		return $results;
	}

/**
 * indexアクションのテスト(作成権限のみ)用DataProvider
 *
 * ### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderIndexByCreatable() {
		$data = $this->__getData();
		$results = array();

		//作成権限あり
		$base = 0;
		$results[0] = array(
			'urlOptions' => array('frame_id' => $data['Frame']['id']),
			'assert' => array('method' => 'assertNotEmpty'),
		);
		//チェック
		//--追加ボタンチェック
		array_push($results, Hash::merge($results[$base], array(
			'assert' => array('method' => 'assertActionLink', 'action' => 'add', 'linkExist' => true, 'url' => array()),
		)));
		//フレームID指定なしテスト
		array_push($results, Hash::merge($results[$base], array(
			'urlOptions' => array('frame_id' => null, 'block_id' => $data['Block']['id']),
			'assert' => array('method' => 'assertNotEmpty'),
		)));

		return $results;
	}

/**
 * ページネーションDataProvider
 *
 * ### 戻り値
 *  - page: ページ番号
 *  - isFirst: 最初のページかどうか
 *  - isLast: 最後のページかどうか
 *
 * @return array
 */
	public function dataProviderPaginator() {
		//$page, $isFirst, $isLast
		$data = array(
			array(1, true, false),
			array(3, false, false),
			array(6, false, true),
		);
		return $data;
	}

/**
 * index()のページネーションテスト
 *
 * @param int $page ページ番号
 * @param bool $isFirst 最初のページかどうか
 * @param bool $isLast 最後のページかどうか
 * @dataProvider dataProviderPaginator
 * @return void
 */
	public function testIndexPaginator($page, $isFirst, $isLast) {
		TestAuthGeneral::login($this);

		//テスト実施
		$frameId = '6';
		$url = array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'index',
			'frame_id' => $frameId,
			'limit' => 'limit:1',
		);
		if (! $isFirst) {
			$url[] = 'page:' . $page;
		}
		$result = $this->_testNcAction($url, array('method' => 'get'));

		//チェック
		$this->assertRegExp(
			'/' . preg_quote('<ul class="pagination">', '/') . '/', $result
		);
		if ($isFirst) {
			$this->assertNotRegExp('/<li><a.*?rel="first".*?<\/a><\/li>/', $result);
		} else {
			$this->assertRegExp('/<li><a.*?rel="first".*?<\/a><\/li>/', $result);
		}
		$this->assertRegExp('/<li class="active"><a>' . $page . '<\/a><\/li>/', $result);
		if ($isLast) {
			$this->assertNotRegExp('/<li><a.*?rel="last".*?<\/a><\/li>/', $result);
		} else {
			$this->assertRegExp('/<li><a.*?rel="last".*?<\/a><\/li>/', $result);
		}

		TestAuthGeneral::logout($this);
	}

/**
 * indexアクションのExceptionErrorテスト
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderIndexExceptionError
 * @return void
 * @throws InternalErrorException
 */
	public function testIndexExceptionError($urlOptions, $assert, $exception = null, $return = 'view') {
		$this->generate(
			'Bbses.BbsArticles',
			[
				'components' => [
					'Paginator'
				]
			]
		);

		//Exception
		$this->controller->Components->Paginator
			->expects($this->once())
			->method('paginate')
			->will($this->returnCallback(function () {
				throw new InternalErrorException();
			}));

		//テスト実施
		$url = Hash::merge(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'index',
		), $urlOptions);

		$this->_testGetAction($url, $assert, $exception, $return);
	}

/**
 * indexアクションのExceptionErrorテスト用DataProvider
 *
 * #### 戻り値
 *  - urlOptions: URLオプション
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderIndexExceptionError() {
		$data = $this->__getData();

		return array(
			array(
				'urlOptions' => array('frame_id' => $data['Frame']['id']),
				'assert' => array('method' => 'assertNotEmpty'),
				'exception' => 'InternalErrorException',
			),
		);
	}

}
