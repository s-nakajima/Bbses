<?php
class RenameBbsArticleKey extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'rename_bbs_article_key';

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
				'bbs_articles_users' => array(
					'bbs_article_key' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Article Key | 記事Key | bbs_posts.key | ', 'charset' => 'utf8', 'after' => 'id'),
				),
			),
			'drop_field' => array(
				'bbs_articles_users' => array('bbs_article_id'),
			),
		),
		'down' => array(
			'drop_table' => array(
			),
			'drop_field' => array(
				'bbs_articles_users' => array('bbs_article_key'),
			),
			'create_field' => array(
				'bbs_articles_users' => array(
					'bbs_article_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'Article ID | 記事ID | bbs_posts.id | '),
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
