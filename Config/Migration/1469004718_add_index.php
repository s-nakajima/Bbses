<?php
/**
 * AddIndex
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * AddIndex
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Config\Migration
 */
class AddIndex extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_index';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'alter_field' => array(
				'bbs_article_trees' => array(
					'bbs_article_key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => '記事キー', 'charset' => 'utf8'),
				),
				'bbs_articles' => array(
					'bbs_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index', 'comment' => '記事のID'),
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => 'キー', 'charset' => 'utf8'),
				),
				'bbs_frame_settings' => array(
					'frame_key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => 'フレームKey', 'charset' => 'utf8'),
				),
				'bbs_settings' => array(
					'bbs_key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => '掲示板キー', 'charset' => 'utf8'),
				),
				'bbses' => array(
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => '掲示板キー', 'charset' => 'utf8'),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
				),
			),
			'create_field' => array(
				'bbs_article_trees' => array(
					'indexes' => array(
						'bbs_article_key' => array('column' => 'bbs_article_key', 'unique' => 0),
					),
				),
				'bbs_articles' => array(
					'indexes' => array(
						'bbs_id' => array('column' => 'bbs_id', 'unique' => 0),
						'key' => array('column' => 'key', 'unique' => 0),
					),
				),
				'bbs_frame_settings' => array(
					'indexes' => array(
						'frame_key' => array('column' => 'frame_key', 'unique' => 0),
					),
				),
				'bbs_settings' => array(
					'indexes' => array(
						'bbs_key' => array('column' => 'bbs_key', 'unique' => 0),
					),
				),
				'bbses' => array(
					'indexes' => array(
						'key' => array('column' => 'key', 'unique' => 0),
						'block_id' => array('column' => 'block_id', 'unique' => 0),
					),
				),
			),
		),
		'down' => array(
			'alter_field' => array(
				'bbs_article_trees' => array(
					'bbs_article_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '記事キー', 'charset' => 'utf8'),
				),
				'bbs_articles' => array(
					'bbs_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => '記事のID'),
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'キー', 'charset' => 'utf8'),
				),
				'bbs_frame_settings' => array(
					'frame_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'フレームKey', 'charset' => 'utf8'),
				),
				'bbs_settings' => array(
					'bbs_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '掲示板キー', 'charset' => 'utf8'),
				),
				'bbses' => array(
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '掲示板キー', 'charset' => 'utf8'),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
				),
			),
			'drop_field' => array(
				'bbs_article_trees' => array('indexes' => array('bbs_article_key')),
				'bbs_articles' => array('indexes' => array('bbs_id', 'key')),
				'bbs_frame_settings' => array('indexes' => array('frame_key')),
				'bbs_settings' => array('indexes' => array('bbs_key')),
				'bbses' => array('indexes' => array('key', 'block_id')),
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
