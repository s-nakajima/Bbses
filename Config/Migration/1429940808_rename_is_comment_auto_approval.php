<?php
/**
 * Bbses CakeMigration
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * Bbses CakeMigration
 *
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @package NetCommons\Bbses\Config\Migration
 */
class RenameIsCommentAutoApproval extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'rename_is_comment_auto_approval';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(),
			'alter_field' => array(
				'bbs_settings' => array(
					'use_comment' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'Use comments, 0:Unused 1:Use | コメント機能 0:使わない 1:使う | | '),
					'is_comment_auto_approval' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'Use comments auto approval, 0:Unused 1:Use | コメントの承認機能 0:使わない 1:使う | | '),
				),
			),
		),
		'down' => array(
			'drop_table' => array(),
			'alter_field' => array(
				'bbs_settings' => array(
					'use_comment' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'Use of comments, 0:Unused 1:Use | コメント機能 0:使わない 1:使う | | '),
					'is_comment_auto_approval' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'Use of comments approval, 0:Unused 1:Use | コメントの承認機能 0:使わない 1:使う | | '),
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
