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
class Bbses extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'bbses';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'bbses' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID | | | '),
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'bbs key | 掲示板キー | Hash値 | ', 'charset' => 'utf8'),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'bbs name | 掲示板名称 | | ', 'charset' => 'utf8'),
					'is_auto_translated' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'translation type. 0:original , 1:auto translation | 翻訳タイプ 0:オリジナル、1:自動翻訳 | | '),
					'translation_engine' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'translation engine | 翻訳エンジン | | ', 'charset' => 'utf8'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'created user | 作成者 | users.id | '),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 | | '),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'modified user | 更新者 | users.id | '),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 | | '),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1)
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
				),
				'bbs_frame_settings' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID | | | '),
					'frame_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'frame key | フレームKey | frames.key | ', 'charset' => 'utf8'),
					'posts_per_page' => array('type' => 'integer', 'null' => false, 'default' => '10', 'comment' => 'posts visible row, 1 post or 5, 10, 20, 50, 100 | 表示記事数 1件、5件、10件、20件、50件、100件 | | '),
					'comments_per_page' => array('type' => 'integer', 'null' => false, 'default' => '10', 'comment' => 'comments visible row, 1 post or 5, 10, 20, 50, 100 | 表示記事数 1件、5件、10件、20件、50件、100件 | | '),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'created user | 作成者 | users.id | '),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 | | '),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'modified user | 更新者 | users.id | '),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 | | '),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1)
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
				),
				'bbs_posts' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID | | | '),
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'bbs posts key | 掲示板記事キー | Hash値 | ', 'charset' => 'utf8'),
					'bbs_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'bbs key | 掲示板キー | Hash値 | ', 'charset' => 'utf8'),
					'last_status' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4, 'comment' => 'public status, 1: public, 2: public pending, 3: draft during 4: remand | 公開状況 1:公開中、2:公開申請中、3:下書き中、4:差し戻し | | '),
					'root_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'root post id | 根記事ID | | '),
					'published_comment_counts' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'Published comment counts | 公開されたコメント数 | | '),
					'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'parent id | 親記事のID treeビヘイビア必須カラム | | '),
					'lft' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'lft | treeビヘイビア必須カラム | | '),
					'rght' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'rght | treeビヘイビア必須カラム | | '),
					'post_no' => array('type' => 'integer', 'null' => false, 'default' => '1', 'comment' => 'comment index | コメントへの採番 | | '),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'created user | 作成者 | users.id | '),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 | | '),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'modified user | 更新者 | users.id | '),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 | | '),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1)
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
				),
				'bbs_post_i18ns' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID | | | '),
					'bbs_post_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'bbsPosts.id | 記事のID | | '),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 6, 'comment' => 'language id | 言語ID | languages.id | '),
					'status' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4, 'comment' => 'public status, 1: public, 2: public pending, 3: draft during 4: remand | 公開状況 1:公開中、2:公開申請中、3:下書き中、4:差し戻し | | '),
					'title' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'title | タイトル | |', 'charset' => 'utf8'),
					'content' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'content | 本文 | |', 'charset' => 'utf8'),
					'is_auto_translated' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'translation type. 0:original , 1:auto translation | 翻訳タイプ 0:オリジナル、1:自動翻訳 | | '),
					'translation_engine' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'translation engine | 翻訳エンジン | | ', 'charset' => 'utf8'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'created user | 作成者 | users.id | '),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 | | '),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'modified user | 更新者 | users.id | '),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 | | '),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1)
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
				),
				'bbs_settings' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID | | | '),
					'bbs_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'bbs key | 掲示板キー | Hash値 | ', 'charset' => 'utf8'),
					'use_post_approval' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'Use of the post approval, 0:Unused 1:Use | 記事の承認機能 0:使わない 1:使う | | '),
					'use_comment' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'Use of comments, 0:Unused 1:Use | コメント機能 0:使わない 1:使う | | '),
					'use_comment_approval' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'Use of comments approval, 0:Unused 1:Use | コメントの承認機能 0:使わない 1:使う | | '),
					'use_like' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'Use of like button, 0:Unused 1:Use | 高い評価ボタンの使用 0:使わない 1:使う | | '),
					'use_unlike' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'Use of unlike button, 0:Unused 1:Use | 低い評価ボタンの使用 0:使わない 1:使う | | '),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'created user | 作成者 | users.id | '),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 | | '),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'modified user | 更新者 | users.id | '),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 | | '),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1)
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
				),
				'bbs_posts_users' => array(
				    'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID | | | '),
				    'bbs_post_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'Post ID | 記事ID | bbs_posts.id | '),
					'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'User ID | ユーザID | users.id | '),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'created user | 作成者 | users.id | '),
				    'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 | | '),
				    'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'modified user | 更新者 | users.id | '),
				    'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 | | '),
				    'indexes' => array(
				        'PRIMARY' => array('column' => 'id', 'unique' => 1),
				    ),
				    'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'bbses', 'bbs_frame_settings', 'bbs_posts', 'bbs_post_i18ns', 'bbs_settings', 'bbs_posts_users',
			),
		),
	);

/**
 * Records keyed by model name.
 *
 * @var array $records
 */
	public $records = array(
		'plugins' => array(
			array(
				'language_id' => 2,
				'key' => 'bbses',
				'namespace' => 'netcommons/bbses',
				'name' => '掲示板',
				'type' => 1,
			),
		),
		'plugins_roles' => array(
			array(
				'role_key' => 'room_administrator',
				'plugin_key' => 'bbses'
			),
		),
		'plugins_rooms' => array(
			array(
				'room_id' => '1',
				'plugin_key' => 'bbses'
			),
		),
		'default_role_permission' => array(
			//記事投稿権限
			array(
				'role_key' => 'room_administrator',
				'type' => 'bbs_block_role',
				'permission' => 'bbs_post_creatable',
				'value' => 1,
				'fixed' => 1,
			),
			array(
				'role_key' => 'chief_editor',
				'type' => 'bbs_block_role',
				'permission' => 'bbs_post_creatable',
				'value' => 1,
				'fixed' => 1,
			),
			array(
				'role_key' => 'editor',
				'type' => 'bbs_block_role',
				'permission' => 'bbs_post_creatable',
				'value' => 1,
				'fixed' => 1,
			),
			array(
				'role_key' => 'general_user',
				'type' => 'bbs_block_role',
				'permission' => 'bbs_post_creatable',
				'value' => 1,
				'fixed' => 0,
			),
			array(
				'role_key' => 'visitor',
				'type' => 'bbs_block_role',
				'permission' => 'bbs_post_creatable',
				'value' => 0,
				'fixed' => 1,
			),
			//記事公開権限
			array(
				'role_key' => 'room_administrator',
				'type' => 'bbs_block_role',
				'permission' => 'bbs_post_publishable',
				'value' => 1,
				'fixed' => 1,
			),
			array(
				'role_key' => 'chief_editor',
				'type' => 'bbs_block_role',
				'permission' => 'bbs_post_publishable',
				'value' => 1,
				'fixed' => 0,
			),
			array(
				'role_key' => 'editor',
				'type' => 'bbs_block_role',
				'permission' => 'bbs_post_publishable',
				'value' => 0,
				'fixed' => 0,
			),
			array(
				'role_key' => 'general_user',
				'type' => 'bbs_block_role',
				'permission' => 'bbs_post_publishable',
				'value' => 0,
				'fixed' => 1,
			),
			array(
				'role_key' => 'visitor',
				'type' => 'bbs_block_role',
				'permission' => 'bbs_post_publishable',
				'value' => 0,
				'fixed' => 1,
			),
			//コメント投稿権限
			array(
				'role_key' => 'room_administrator',
				'type' => 'bbs_block_role',
				'permission' => 'bbs_comment_creatable',
				'value' => 1,
				'fixed' => 1,
			),
			array(
				'role_key' => 'chief_editor',
				'type' => 'bbs_block_role',
				'permission' => 'bbs_comment_creatable',
				'value' => 1,
				'fixed' => 1,
			),
			array(
				'role_key' => 'editor',
				'type' => 'bbs_block_role',
				'permission' => 'bbs_comment_creatable',
				'value' => 1,
				'fixed' => 1,
			),
			array(
				'role_key' => 'general_user',
				'type' => 'bbs_block_role',
				'permission' => 'bbs_comment_creatable',
				'value' => 1,
				'fixed' => 0,
			),
			array(
				'role_key' => 'visitor',
				'type' => 'bbs_block_role',
				'permission' => 'bbs_comment_creatable',
				'value' => 0,
				'fixed' => 0,
			),
			//コメント公開権限
			array(
				'role_key' => 'room_administrator',
				'type' => 'bbs_block_role',
				'permission' => 'bbs_comment_publishable',
				'value' => 1,
				'fixed' => 1,
			),
			array(
				'role_key' => 'chief_editor',
				'type' => 'bbs_block_role',
				'permission' => 'bbs_comment_publishable',
				'value' => 1,
				'fixed' => 1,
			),
			array(
				'role_key' => 'editor',
				'type' => 'bbs_block_role',
				'permission' => 'bbs_comment_publishable',
				'value' => 0,
				'fixed' => 0,
			),
			array(
				'role_key' => 'general_user',
				'type' => 'bbs_block_role',
				'permission' => 'bbs_comment_publishable',
				'value' => 0,
				'fixed' => 0,
			),
			array(
				'role_key' => 'visitor',
				'type' => 'bbs_block_role',
				'permission' => 'bbs_comment_publishable',
				'value' => 0,
				'fixed' => 1,
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction up or down direction of migration process
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction up or down direction of migration process
 * @return bool Should process continue
 */

	public function after($direction) {
		if ($direction === 'down') {
			return true;
		}
		foreach ($this->records as $model => $records) {
			if (!$this->updateRecords($model, $records)) {
				return false;
			}
		}
		return true;
	}

/**
 * Update model records
 *
 * @param string $model model name to update
 * @param string $records records to be stored
 * @param string $scope ?
 * @return bool Should process continue
 */
	public function updateRecords($model, $records, $scope = null) {
		$Model = $this->generateModel($model);
		foreach ($records as $record) {
			$Model->create();
			if (!$Model->save($record, false)) {
				return false;
			}
		}
		return true;
	}
}
