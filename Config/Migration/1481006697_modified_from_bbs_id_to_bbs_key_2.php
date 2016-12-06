<?php
/**
 * 多言語化対応のためbbs_keyに変更
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * 多言語化対応のためbbs_keyに変更
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Config\Migration
 */
class ModifiedFromBbsIdToBbsKey2 extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'modified_from_bbs_id_to_bbs_key_2';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'drop_field' => array(
				'bbs_articles' => array('bbs_id', 'indexes' => array('bbs_id')),
			),
			'alter_field' => array(
				'bbs_articles' => array(
					'bbs_key' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => '掲示板Key', 'charset' => 'utf8'),
				),
			),
			'create_field' => array(
				'bbs_articles' => array(
					'indexes' => array(
						'bbs_key' => array('column' => array('bbs_key', 'language_id'), 'unique' => 0),
					),
				),
			),
		),
		'down' => array(
			'create_field' => array(
				'bbs_articles' => array(
					'bbs_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index', 'comment' => '記事のID'),
					'indexes' => array(
						'bbs_id' => array('column' => 'bbs_id', 'unique' => 0),
					),
				),
			),
			'alter_field' => array(
				'bbs_articles' => array(
					'bbs_key' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '掲示板Key', 'charset' => 'utf8'),
				),
			),
			'drop_field' => array(
				'bbs_articles' => array('indexes' => array('bbs_key')),
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
