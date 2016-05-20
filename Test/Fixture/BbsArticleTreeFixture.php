<?php
/**
 * BbsArticleTreeFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * BbsArticleTreeFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Test\Fixture
 */
class BbsArticleTreeFixture extends CakeTestFixture {

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'bbs_key' => 'bbs_1',
			'bbs_article_key' => 'bbs_article_1',
			'root_id' => null,
			'parent_id' => null,
			'lft' => 1,
			'rght' => 4,
			'article_no' => 1,
			'bbs_article_child_count' => 1,
			'created_user' => 1,
			'created' => '2015-05-14 07:09:02',
			'modified_user' => 1,
			'modified' => '2015-05-14 07:09:02'
		),
		array(
			'id' => 2,
			'bbs_key' => 'bbs_1',
			'bbs_article_key' => 'bbs_article_2',
			'root_id' => 1,
			'parent_id' => 1,
			'lft' => 2,
			'rght' => 3,
			'article_no' => 0,
			'bbs_article_child_count' => 0,
			'created_user' => 1,
			'created' => '2015-05-14 07:09:02',
			'modified_user' => 1,
			'modified' => '2015-05-14 07:09:02'
		),
		array(
			'id' => 3,
			'bbs_key' => 'bbs_1',
			'bbs_article_key' => 'bbs_article_3',
			'root_id' => null,
			'parent_id' => null,
			'lft' => 5,
			'rght' => 6,
			'article_no' => 1,
			'bbs_article_child_count' => 1,
			'created_user' => 4,
			'created' => '2015-05-14 07:09:02',
			'modified_user' => 4,
			'modified' => '2015-05-14 07:09:02'
		),
		array(
			'id' => 4,
			'bbs_key' => 'bbs_1',
			'bbs_article_key' => 'bbs_article_4',
			'root_id' => null,
			'parent_id' => null,
			'lft' => 7,
			'rght' => 8,
			'article_no' => 1,
			'bbs_article_child_count' => 1,
			'created_user' => 4,
			'created' => '2015-05-14 07:09:02',
			'modified_user' => 4,
			'modified' => '2015-05-14 07:09:02'
		),
		array(
			'id' => 5,
			'bbs_key' => 'bbs_1',
			'bbs_article_key' => 'bbs_article_5',
			'root_id' => null,
			'parent_id' => null,
			'lft' => 9,
			'rght' => 10,
			'article_no' => 1,
			'bbs_article_child_count' => 1,
			'created_user' => 3,
			'created' => '2015-05-14 07:09:02',
			'modified_user' => 3,
			'modified' => '2015-05-14 07:09:02'
		),
		array(
			'id' => 6,
			'bbs_key' => 'bbs_1',
			'bbs_article_key' => 'bbs_article_6',
			'root_id' => null,
			'parent_id' => null,
			'lft' => 11,
			'rght' => 12,
			'article_no' => 1,
			'bbs_article_child_count' => 1,
			'created_user' => 3,
			'created' => '2015-05-14 07:09:02',
			'modified_user' => 3,
			'modified' => '2015-05-14 07:09:02'
		),
		array( // 返信が2つある記事
			'id' => 7,
			'bbs_key' => 'bbs_1',
			'bbs_article_key' => 'bbs_article_7',
			'root_id' => null,
			'parent_id' => null,
			'lft' => 13,
			'rght' => 18,
			'article_no' => 1,
			'bbs_article_child_count' => 2,
			'created_user' => 1,
			'created' => '2015-05-14 07:09:02',
			'modified_user' => 1,
			'modified' => '2015-05-14 07:09:02'
		),
		array(
			'id' => 8,
			'bbs_key' => 'bbs_1',
			'bbs_article_key' => 'bbs_article_8',
			'root_id' => 7,
			'parent_id' => 7,
			'lft' => 14,
			'rght' => 17,
			'article_no' => 2,
			'bbs_article_child_count' => 0,
			'created_user' => 1,
			'created' => '2015-05-14 07:09:02',
			'modified_user' => 1,
			'modified' => '2015-05-14 07:09:02'
		),
		array(
			'id' => 9,
			'bbs_key' => 'bbs_1',
			'bbs_article_key' => 'bbs_article_9',
			'root_id' => 7,
			'parent_id' => 8,
			'lft' => 15,
			'rght' => 16,
			'article_no' => 3,
			'bbs_article_child_count' => 0,
			'created_user' => 1,
			'created' => '2015-05-14 07:09:02',
			'modified_user' => 1,
			'modified' => '2015-05-14 07:09:02'
		),
		array( //根記事不正
			'id' => 10,
			'bbs_key' => 'bbs_1',
			'bbs_article_key' => 'bbs_article_10',
			'root_id' => 99,
			'parent_id' => 7,
			'lft' => 19,
			'rght' => 20,
			'article_no' => 1,
			'bbs_article_child_count' => 0,
			'created_user' => 1,
			'created' => '2015-05-14 07:09:02',
			'modified_user' => 1,
			'modified' => '2015-05-14 07:09:02'
		),
		array( //親記事不正
			'id' => 11,
			'bbs_key' => 'bbs_1',
			'bbs_article_key' => 'bbs_article_11',
			'root_id' => 0,
			'parent_id' => 99,
			'lft' => 21,
			'rght' => 22,
			'article_no' => 1,
			'bbs_article_child_count' => 0,
			'created_user' => 1,
			'created' => '2015-05-14 07:09:02',
			'modified_user' => 1,
			'modified' => '2015-05-14 07:09:02'
		),
		array( //一般が書いた記事（子記事が承認待ち）
			'id' => 12,
			'bbs_key' => 'bbs_2',
			'bbs_article_key' => 'bbs_article_12',
			'root_id' => 0,
			'parent_id' => 0,
			'lft' => 23,
			'rght' => 26,
			'article_no' => 1,
			'bbs_article_child_count' => 1,
			'created_user' => 1,
			'created' => '2015-05-14 07:09:02',
			'modified_user' => 1,
			'modified' => '2015-05-14 07:09:02'
		),
		array( //一般が書いた記事（子記事が承認待ち）
			'id' => 13,
			'bbs_key' => 'bbs_2',
			'bbs_article_key' => 'bbs_article_13',
			'root_id' => 12,
			'parent_id' => 12,
			'lft' => 24,
			'rght' => 25,
			'article_no' => 2,
			'bbs_article_child_count' => 0,
			'created_user' => 4,
			'created' => '2015-05-14 07:09:02',
			'modified_user' => 4,
			'modified' => '2015-05-14 07:09:02'
		),
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('Bbses') . 'Config' . DS . 'Schema' . DS . 'schema.php';
		$this->fields = (new BbsesSchema())->tables['bbs_article_trees'];
		parent::init();
	}

}
