<?php
/**
 * 記事数をBlock.content_countを使うように修正
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * 記事数をBlock.content_countを使うように修正
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Config\Migration
 */
class BlockContentCount extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'block_content_count';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'drop_field' => array(
				'bbses' => array('bbs_article_count'),
			),
			'create_field' => array(
				'bbs_articles' => array(
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false, 'after' => 'bbs_id'),
				),
			),
		),
		'down' => array(
			'create_field' => array(
				'bbses' => array(
					'bbs_article_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false, 'comment' => '記事数'),
				),
			),
			'drop_field' => array(
				'bbs_articles' => array('block_id'),
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
