<?php
/**
 * BbsFrameSettingFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * BbsFrameSettingFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Test\Fixture
 */
class BbsFrameSettingFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID | | | '),
		'frame_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'frame key | フレームKey | frames.key | ', 'charset' => 'utf8'),
		'articles_per_page' => array('type' => 'integer', 'null' => false, 'default' => '10', 'unsigned' => false, 'comment' => 'artcles visible row, 1, 5, 10, 20, 50, 100 | 表示記事数 1件、5件、10件、20件、50件、100件 | | '),
		'comments_per_page' => array('type' => 'integer', 'null' => false, 'default' => '10', 'unsigned' => false, 'comment' => 'comments visible row, 1 post or 5, 10, 20, 50, 100 | 表示記事数 1件、5件、10件、20件、50件、100件 | | '),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'created user | 作成者 | users.id | '),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 | | '),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'modified user | 更新者 | users.id | '),
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
		array(
			'id' => 1,
			'frame_key' => 'frame_1',
			'articles_per_page' => 10,
			'comments_per_page' => 10,
			'created_user' => 1,
			'created' => '2014-06-18 02:06:22',
			'modified_user' => 1,
			'modified' => '2014-06-18 02:06:22',
		)
	);

}
