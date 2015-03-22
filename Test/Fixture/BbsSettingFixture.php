<?php
/**
 * BbsSettingFixture
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for BbsSettingFixture
 */
class BbsSettingFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID | | | '),
		'bbs_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'bbs key | 掲示板キー | Hash値 | ', 'charset' => 'utf8'),
		'use_comment' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'use comment, 0:not use comment 1:use it | コメント使用有無 0:使わない 1:使う | | '),
		'use_like' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'use like button, 0:not use like button 1:use it | 高く評価ボタン使用有無 0:使わない 1:使う | | '),
		'use_unlike' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'use unlike button, 0:not use unlike button 1:use it | 低く評価ボタン使用有無 0:使わない 1:使う | | '),
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
			'bbs_key' => 'Lorem ipsum dolor sit amet',
			'use_comment' => 1,
			'use_like' => 1,
			'use_unlike' => 1,
			'created_user' => 1,
			'created' => '2015-03-20 23:20:51',
			'modified_user' => 1,
			'modified' => '2015-03-20 23:20:51'
		),
	);

}
