<?php
/**
 * 根記事一覧の追加
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * 根記事一覧の追加
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Config\Migration
 */
class AddRootIndex extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_root_index';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'bbs_frame_settings' => array(
					'display_type' => array('type' => 'string', 'null' => true, 'default' => 'flat', 'length' => 45, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'frame_key'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'bbs_frame_settings' => array('display_type'),
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
