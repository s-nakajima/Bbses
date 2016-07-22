<?php
/**
 * DeleteBbsSettings
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * DeleteBbsSettings
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package NetCommons\Bbses\Config\Migration
 */
class DeleteBbsSettings extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'delete_bbs_settings';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'drop_table' => array(
				'bbs_settings'
			),
		),
		'down' => array(
			'create_table' => array(
				'bbs_settings' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => 'ID'),
					'bbs_key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => '掲示板キー', 'charset' => 'utf8'),
					'use_workflow' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => '記事の承認機能 0:使わない 1:使う'),
					'use_comment' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'コメント機能 0:使わない 1:使う'),
					'use_comment_approval' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'コメントの承認機能 0:使わない 1:使う'),
					'use_like' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'いいねボタンの使用 0:使わない 1:使う'),
					'use_unlike' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'わるいねボタンの使用 0:使わない 1:使う'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => '作成者'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '作成日時'),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => '更新者'),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '更新日時'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'bbs_key' => array('column' => 'bbs_key', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		return true;
	}
}
