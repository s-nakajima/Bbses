<?php
/**
 * インデックスの見直し
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * インデックスの見直し
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Config\Migration
 */
class ReconsiderIndexes extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'reconsider_indexes';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'alter_field' => array(
				'bbs_article_trees' => array(
					'root_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index', 'comment' => '根記事ID'),
				),
			),
			'create_field' => array(
				'bbs_article_trees' => array(
					'indexes' => array(
						'root_id' => array('column' => array('root_id', 'bbs_key', 'lft', 'rght'), 'unique' => 0),
					),
				),
				'bbs_articles' => array(
					'indexes' => array(
						'key' => array('column' => array('key', 'language_id'), 'unique' => 0),
					),
				),
			),
			'drop_field' => array(
				'bbs_articles' => array('indexes' => array('key')),
			),
		),
		'down' => array(
			'alter_field' => array(
				'bbs_article_trees' => array(
					'root_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => '根記事ID'),
				),
			),
			'drop_field' => array(
				'bbs_article_trees' => array('indexes' => array('root_id')),
				'bbs_articles' => array('indexes' => array('key')),
			),
			'create_field' => array(
				'bbs_articles' => array(
					'indexes' => array(
						'key' => array(),
					),
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
