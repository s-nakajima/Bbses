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
			'root_id' => 1,
			'parent_id' => 1,
			'lft' => 1,
			'rght' => 1,
			'article_no' => 1,
			'bbs_article_child_count' => 1,
			'created_user' => 1,
			'created' => '2015-05-14 07:09:02',
			'modified_user' => 1,
			'modified' => '2015-05-14 07:09:02'
		),
	);

}
