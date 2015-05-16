<?php
/**
 * Bbses CakeMigration
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * Bbses CakeMigration
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Config\Migration
 */
class RenameArticlesPerPage extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'rename_articles_per_page';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
			),
			'alter_field' => array(
				'bbs_articles' => array(
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'key | キー |  | ', 'charset' => 'utf8'),
				),
			),
			'create_field' => array(
				'bbs_frame_settings' => array(
					'articles_per_page' => array('type' => 'integer', 'null' => false, 'default' => '10', 'comment' => 'artcles visible row, 1, 5, 10, 20, 50, 100 | 表示記事数 1件、5件、10件、20件、50件、100件 | | ', 'after' => 'frame_key'),
				),
			),
			'drop_field' => array(
				'bbs_frame_settings' => array('posts_per_page'),
			),
		),
		'down' => array(
			'drop_table' => array(
			),
			'alter_field' => array(
				'bbs_articles' => array(
					'key' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'comment' => 'key | キー |  | ', 'charset' => 'utf8'),
				),
			),
			'drop_field' => array(
				'bbs_frame_settings' => array('articles_per_page'),
			),
			'create_field' => array(
				'bbs_frame_settings' => array(
					'posts_per_page' => array('type' => 'integer', 'null' => false, 'default' => '10', 'comment' => 'posts visible row, 1 post or 5, 10, 20, 50, 100 | 表示記事数 1件、5件、10件、20件、50件、100件 | | '),
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
