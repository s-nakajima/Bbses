<?php
/**
 * 速度改善のためのインデックス見直し
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * 速度改善のためのインデックス見直し
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Config\Migration
 */
class ForSpeedUp extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'for_speed_up';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'alter_field' => array(
				'bbs_articles' => array(
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'key' => 'index', 'comment' => '作成日時'),
				),
			),
			'create_field' => array(
				'bbs_articles' => array(
					'indexes' => array(
						'created' => array('column' => 'created', 'unique' => 0),
					),
				),
			),
		),
		'down' => array(
			'alter_field' => array(
				'bbs_articles' => array(
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '作成日時'),
				),
			),
			'drop_field' => array(
				'bbs_articles' => array('indexes' => array('created')),
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
