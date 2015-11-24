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
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID | | | '),
		'bbs_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'bbs key | 掲示板キー | Hash値 | ', 'charset' => 'utf8'),
		'bbs_article_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'bbs articles key | 記事キー | Hash値 | ', 'charset' => 'utf8'),
		'root_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'root post id | 根記事ID | | '),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'parent id | 親記事のID treeビヘイビア必須カラム | | '),
		'lft' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'lft | treeビヘイビア必須カラム | | '),
		'rght' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'rght | treeビヘイビア必須カラム | | '),
		'article_no' => array('type' => 'integer', 'null' => false, 'default' => '1', 'comment' => 'comment index | 記事毎の採番 | | '),
		'bbs_article_child_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'comment' => 'Published comment counts | 公開されたコメント数 | | '),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'created user | 作成者 | users.id | '),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 | | '),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'modified user | 更新者 | users.id | '),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 | | '),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

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
	);

}
