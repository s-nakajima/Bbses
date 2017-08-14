<?php
/**
 * 全件一覧の追加によるIndex生成
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * 全件一覧の追加によるIndex生成
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Config\Migration
 */
class ListOfAllArticles extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'List_of_all_articles';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'bbs_articles' => array(
					'indexes' => array(
						'title' => array('column' => array('id', 'is_active', 'is_latest', 'created_user', 'is_origin', 'is_translation', 'key'), 'unique' => 0),
					),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'bbs_articles' => array('indexes' => array('title')),
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
