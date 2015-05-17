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
class RenameBlishedCommentCount extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'rename_blished_comment_count';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
			),
			'create_field' => array(
				'bbs_article_trees' => array(
					'published_comment_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'comment' => 'Published comment counts | 公開されたコメント数 | | ', 'after' => 'article_no'),
				),
			),
			'drop_field' => array(
				'bbs_article_trees' => array('published_comment_counts'),
			),
		),
		'down' => array(
			'drop_table' => array(
			),
			'drop_field' => array(
				'bbs_article_trees' => array('published_comment_count'),
			),
			'create_field' => array(
				'bbs_article_trees' => array(
					'published_comment_counts' => array('type' => 'integer', 'null' => false, 'default' => '0', 'comment' => 'Published comment counts | 公開されたコメント数 | | '),
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
