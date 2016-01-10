<?php
/**
 * BbsArticle::saveBbsArticle()のテスト
 *
 * @property BbsArticle $BbsArticle
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsValidateTest', 'NetCommons.TestSuite');
App::uses('WorkflowComponent', 'Workflow.Controller/Component');

/**
 * BbsArticle::saveBbsArticle()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Test\Case\Model\BbsArticle
 */
class BbsArticleValidateTest extends NetCommonsValidateTest {

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
	protected $_modelName = 'BbsArticle';

/**
 * Method name
 *
 * @var array
 */
	protected $_methodName = '';

/**
 * テストDataの取得
 *
 * @param string $bbsArticleKey bbsArticleKey
 * @return array
 */
	private function __getData($bbsArticleKey = 'bbs_article_1') {
		$frameId = '6';
		$blockId = '2';
		$bbsKey = 'bbs_1';
		$blockKey = 'block_2';
		$bbsId = '2';
		if ($bbsArticleKey === 'bbs_article_1') {
			$bbsArticleTreeId = '1';
			$bbsArticleId = '1';
			$rootId = null;
		} else {
			$bbsArticleId = null;
			$bbsArticleTreeId = null;
			$rootId = '1';
		}

		$data = array(
			//'save_1' => null,
			'Frame' => array(
				'id' => $frameId,
				'block_id' => $blockId,
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
				'bbs_id' => $bbsId,
				'title' => 'BBS ARTICLE TITLE',
				'content' => '<p>CONTENT</p>',
				'status' => WorkflowComponent::STATUS_PUBLISHED,
			),
			'BbsArticleTree' => array(
				'id' => $bbsArticleTreeId,
				'bbs_key' => $bbsKey,
				'bbs_article_key' => $bbsArticleKey,
				'root_id' => $rootId,
				'parent_id' => null,
			),
			'WorkflowComment' => array(
				'comment' => 'WorkflowComment save test'
			),
		);

		return $data;
	}

/**
 * ValidationErrorのDataProvider
 *
 * ### 戻り値
 *  - field フィールド名
 *  - value セットする値
 *  - message エラーメッセージ
 *  - overwrite 上書きするデータ
 *
 * @return void
 */
	public function dataProviderValidationError() {
		return array(
			array($this->__getData(), 'title', '',
				sprintf(__d('net_commons', 'Please input %s.'), __d('bbses', 'Title'))),
			array($this->__getData(), 'content', '',
				sprintf(__d('net_commons', 'Please input %s.'), __d('bbses', 'Content'))),
		);
	}

}
