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
class Review extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'review';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
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
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'bbs_settings' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID | | | '),
					'bbs_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'bbs key | 掲示板キー | Hash値 | ', 'charset' => 'utf8'),
					'use_comment' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'use comment, 0:not use comment 1:use it | コメント使用有無 0:使わない 1:使う | | '),
					'use_like' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'use like button, 0:not use like button 1:use it | 高く評価ボタン使用有無 0:使わない 1:使う | | '),
					'use_unlike' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'use unlike button, 0:not use unlike button 1:use it | 低く評価ボタン使用有無 0:使わない 1:使う | | '),
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
			'create_field' => array(
				'bbs_frame_settings' => array(
					'posts_per_page' => array('type' => 'integer', 'null' => false, 'default' => '10', 'comment' => 'posts visible row, 1 post or 5, 10, 20, 50, 100 | 表示記事数 1件、5件、10件、20件、50件、100件 | | ', 'after' => 'frame_key'),
					'comments_per_page' => array('type' => 'integer', 'null' => false, 'default' => '10', 'comment' => 'comments visible row, 1 post or 5, 10, 20, 50, 100 | 表示記事数 1件、5件、10件、20件、50件、100件 | | ', 'after' => 'posts_per_page'),
				),
				'bbs_posts' => array(
					'last_status' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4, 'comment' => 'public status, 1: public, 2: public pending, 3: draft during 4: remand | 公開状況 1:公開中、2:公開申請中、3:下書き中、4:差し戻し | | ', 'after' => 'bbs_key'),
					'root_id' => array('type' => 'integer', 'null' => false, 'default' => '1', 'comment' => 'root post id | 根記事ID | | ', 'after' => 'last_status'),
					'post_no' => array('type' => 'integer', 'null' => false, 'default' => '1', 'comment' => 'comment index | コメントへの採番 | | ', 'after' => 'rght'),
				),
			),
			'drop_field' => array(
				'bbs_frame_settings' => array('visible_post_row', 'visible_comment_row'),
				'bbs_posts' => array('status', 'title', 'content', 'comment_num', 'comment_index', 'is_auto_translated', 'translation_engine'),
				'bbses' => array('use_comment', 'auto_approval', 'use_like_button', 'use_unlike_button', 'post_create_authority', 'editor_publish_authority', 'general_publish_authority', 'comment_create_authority'),
			),
			'alter_field' => array(
				'bbs_posts' => array(
					'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'parent id | 親記事のID treeビヘイビア必須カラム | | '),
					'lft' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'lft | treeビヘイビア必須カラム | | '),
					'rght' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'rght | treeビヘイビア必須カラム | | '),
				),
			),
			'drop_table' => array(
				'bbs_posts_users'
			),
		),
		'down' => array(
			'drop_table' => array(
				'bbs_post_i18ns', 'bbs_settings'
			),
			'drop_field' => array(
				'bbs_frame_settings' => array('posts_per_page', 'comments_per_page'),
				'bbs_posts' => array('post_no'),
			),
			'create_field' => array(
				'bbs_frame_settings' => array(
					'visible_post_row' => array('type' => 'integer', 'null' => false, 'default' => '10', 'comment' => 'visible row, 1 post or 5, 10, 20, 50, 100 posts | 表示記事数 1件、5件、10件、20件、50件、100件 | | '),
					'visible_comment_row' => array('type' => 'integer', 'null' => false, 'default' => '10', 'comment' => 'visible row, 1 post or 5, 10, 20, 50, 100 posts | 表示記事数 1件、5件、10件、20件、50件、100件 | | '),
				),
				'bbs_posts' => array(
					'status' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4, 'comment' => 'public status, 1: public, 2: public pending, 3: draft during 4: remand | 公開状況 1:公開中、2:公開申請中、3:下書き中、4:差し戻し | | '),
					'title' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'title | タイトル | |', 'charset' => 'utf8'),
					'content' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'content | 本文 | |', 'charset' => 'utf8'),
					'comment_num' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'comment_index' => array('type' => 'integer', 'null' => false, 'default' => '1'),
					'is_auto_translated' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'translation type. 0:original , 1:auto translation | 翻訳タイプ 0:オリジナル、1:自動翻訳 | | '),
					'translation_engine' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'translation engine | 翻訳エンジン | | ', 'charset' => 'utf8'),
				),
				'bbses' => array(
					'use_comment' => array('type' => 'boolean', 'null' => false, 'default' => true),
					'auto_approval' => array('type' => 'boolean', 'null' => false, 'default' => false),
					'use_like_button' => array('type' => 'boolean', 'null' => false, 'default' => true),
					'use_unlike_button' => array('type' => 'boolean', 'null' => false, 'default' => true),
					'post_create_authority' => array('type' => 'boolean', 'null' => false, 'default' => true),
					'editor_publish_authority' => array('type' => 'boolean', 'null' => false, 'default' => false),
					'general_publish_authority' => array('type' => 'boolean', 'null' => false, 'default' => false),
					'comment_create_authority' => array('type' => 'boolean', 'null' => false, 'default' => true),
				),
			),
			'alter_field' => array(
				'bbs_posts' => array(
					'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'lft' => array('type' => 'integer', 'null' => false, 'default' => null),
					'rght' => array('type' => 'integer', 'null' => false, 'default' => null),
				),
			),
			'create_table' => array(
				'bbs_posts_users' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID | | | '),
					'post_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => null),
					'likes_flag' => array('type' => 'boolean', 'null' => false, 'default' => false),
					'unlikes_flag' => array('type' => 'boolean', 'null' => false, 'default' => false),
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
	);

/**
 * Records keyed by model name.
 *
 * @var array $records
 */
	public $records = array(
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
				'fixed' => 0,
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
				'permission' => 'bbs_post_comment_creatable',
				'value' => 1,
				'fixed' => 1,
			),
			array(
				'role_key' => 'chief_editor',
				'type' => 'bbs_block_role',
				'permission' => 'bbs_post_comment_creatable',
				'value' => 1,
				'fixed' => 1,
			),
			array(
				'role_key' => 'editor',
				'type' => 'bbs_block_role',
				'permission' => 'bbs_post_comment_creatable',
				'value' => 1,
				'fixed' => 1,
			),
			array(
				'role_key' => 'general_user',
				'type' => 'bbs_block_role',
				'permission' => 'bbs_post_comment_creatable',
				'value' => 1,
				'fixed' => 0,
			),
			array(
				'role_key' => 'visitor',
				'type' => 'bbs_block_role',
				'permission' => 'bbs_post_comment_creatable',
				'value' => 0,
				'fixed' => 0,
			),
			//コメント公開権限
			array(
				'role_key' => 'room_administrator',
				'type' => 'bbs_block_role',
				'permission' => 'bbs_post_comment_publishable',
				'value' => 1,
				'fixed' => 1,
			),
			array(
				'role_key' => 'chief_editor',
				'type' => 'bbs_block_role',
				'permission' => 'bbs_post_comment_publishable',
				'value' => 1,
				'fixed' => 1,
			),
			array(
				'role_key' => 'editor',
				'type' => 'bbs_block_role',
				'permission' => 'bbs_post_comment_publishable',
				'value' => 0,
				'fixed' => 1,
			),
			array(
				'role_key' => 'general_user',
				'type' => 'bbs_block_role',
				'permission' => 'bbs_post_comment_publishable',
				'value' => 0,
				'fixed' => 1,
			),
			array(
				'role_key' => 'visitor',
				'type' => 'bbs_block_role',
				'permission' => 'bbs_post_comment_publishable',
				'value' => 0,
				'fixed' => 1,
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
