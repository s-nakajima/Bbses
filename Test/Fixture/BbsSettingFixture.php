<?php
/**
 * BbsSettingFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * BbsSettingFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Test\Fixture
 */
class BbsSettingFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => 'ID | | | '),
		'bbs_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'bbs key | 掲示板キー | Hash値 | ', 'charset' => 'utf8'),
		'use_workflow' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'Use of the post approval, 0:Unused 1:Use | 記事の承認機能 0:使わない 1:使う | | '),
		'use_comment' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'Use of comments, 0:Unused 1:Use | コメント機能 0:使わない 1:使う | | '),
		'use_comment_approval' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'Use of comments approval, 0:Unused 1:Use | コメントの承認機能 0:使わない 1:使う | | '),
		'use_like' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'Use of like button, 0:Unused 1:Use | 高い評価ボタンの使用 0:使わない 1:使う | | '),
		'use_unlike' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'Use of unlike button, 0:Unused 1:Use | 低い評価ボタンの使用 0:使わない 1:使う | | '),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => 'created user | 作成者 | users.id | '),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 | | '),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => 'modified user | 更新者 | users.id | '),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 | | '),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		//掲示板1
		array(
			'id' => 1,
			'bbs_key' => 'bbs_1',
			'use_workflow' => '1',
			'use_comment' => '1',
			'use_comment_approval' => '1',
			'use_like' => '1',
			'use_unlike' => '1',
		),
		//掲示板2
		array(
			'id' => 2,
			'bbs_key' => 'bbs_2',
			'use_workflow' => '1',
			'use_comment' => '1',
			'use_comment_approval' => '1',
			'use_like' => '1',
			'use_unlike' => '1',
		),
		//掲示板3
		array(
			'id' => 3,
			'bbs_key' => 'bbs_3',
			'use_workflow' => '1',
			'use_comment' => '1',
			'use_comment_approval' => '1',
			'use_like' => '1',
			'use_unlike' => '1',
		),
		//掲示板4(ワークフローなし)
		array(
			'id' => 4,
			'bbs_key' => 'bbs_4',
			'use_workflow' => '0',
			'use_comment' => '1',
			'use_comment_approval' => '1',
			'use_like' => '1',
			'use_unlike' => '1',
		),
		//掲示板5(コメントなし)
		array(
			'id' => 5,
			'bbs_key' => 'bbs_5',
			'use_workflow' => '1',
			'use_comment' => '0',
			'use_comment_approval' => '1',
			'use_like' => '1',
			'use_unlike' => '1',
		),
		//掲示板6(コメントの承認なし)
		array(
			'id' => 6,
			'bbs_key' => 'bbs_6',
			'use_workflow' => '1',
			'use_comment' => '1',
			'use_comment_approval' => '0',
			'use_like' => '1',
			'use_unlike' => '1',
		),
		//掲示板7(いいねなし)
		array(
			'id' => 7,
			'bbs_key' => 'bbs_7',
			'use_workflow' => '1',
			'use_comment' => '1',
			'use_comment_approval' => '1',
			'use_like' => '0',
			'use_unlike' => '0',
		),
		//掲示板8(わるいねなし)
		array(
			'id' => 8,
			'bbs_key' => 'bbs_8',
			'use_workflow' => '1',
			'use_comment' => '1',
			'use_comment_approval' => '1',
			'use_like' => '1',
			'use_unlike' => '0',
		),
	);

}
