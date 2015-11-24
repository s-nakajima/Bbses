<?php
/**
 * BbsArticleFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * BbsArticleFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Test\Fixture
 */
class BbsArticleFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID | | | '),
		'bbs_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'bbsPosts.id | 記事のID | | '),
		'language_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 6, 'comment' => 'language id | 言語ID | languages.id | '),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4, 'comment' => 'public status, 1: public, 2: public pending, 3: draft during 4: remand | 公開状況 1:公開中、2:公開申請中、3:下書き中、4:差し戻し | | '),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'Is active, 0:deactive 1:acive | アクティブなコンテンツかどうか 0:アクティブでない 1:アクティブ | | '),
		'is_latest' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'Is latest, 0:not latest 1:latest | 最新コンテンツかどうか 0:最新でない 1:最新 | | '),
		'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'key | キー |  | ', 'charset' => 'utf8'),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'title | タイトル | |', 'charset' => 'utf8'),
		'content' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'content | 本文 | |', 'charset' => 'utf8'),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'created user | 作成者 | users.id | '),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 | | '),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'modified user | 更新者 | users.id | '),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 | | '),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'bbs_id' => '2',
			'language_id' => '2',
			'status' => '3',
			'is_active' => false,
			'is_latest' => true,
			'key' => 'bbs_article_1',
			'title' => 'Lorem ipsum dolor sit amet',
			'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created_user' => 1,
			'created' => '2015-05-14 07:09:55',
			'modified_user' => 1,
			'modified' => '2015-05-14 07:09:55'
		),
		array(
			'id' => '2',
			'bbs_id' => '2',
			'language_id' => '2',
			'status' => '1',
			'is_active' => '1',
			'is_latest' => '1',
			'key' => 'bbs_article_2',
			'title' => 'Lorem ipsum dolor sit amet',
			'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created_user' => 1,
			'created' => '2015-05-14 07:09:55',
			'modified_user' => 1,
			'modified' => '2015-05-14 07:09:55'
		),
		//(一般が書いた記事＆一度公開している)
		array(
			'id' => '3',
			'bbs_id' => '2',
			'language_id' => '2',
			'status' => '1',
			'is_active' => '1',
			'is_latest' => '1',
			'key' => 'bbs_article_3',
			'title' => 'Lorem ipsum dolor sit amet',
			'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created_user' => 4,
			'created' => '2015-05-14 07:09:55',
			'modified_user' => 4,
			'modified' => '2015-05-14 07:09:55'
		),

		//(一般が書いた記事＆一度も公開していない)
		array(
			'id' => '4',
			'bbs_id' => '2',
			'language_id' => '2',
			'status' => '3',
			'is_active' => false,
			'is_latest' => '1',
			'key' => 'bbs_article_4',
			'title' => 'Lorem ipsum dolor sit amet',
			'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created_user' => 4,
			'created' => '2015-05-14 07:09:55',
			'modified_user' => 4,
			'modified' => '2015-05-14 07:09:55'
		),
		//(chef_userが書いた記事＆一度も公開していない)
		array(
			'id' => '5',
			'bbs_id' => '2',
			'language_id' => '2',
			'status' => '3',
			'is_active' => false,
			'is_latest' => '1',
			'key' => 'bbs_article_5',
			'title' => 'Lorem ipsum dolor sit amet',
			'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created_user' => 3,
			'created' => '2015-05-14 07:09:55',
			'modified_user' => 3,
			'modified' => '2015-05-14 07:09:55'
		),
		//(chef_userが書いた記事＆公開)
		array(
			'id' => '6',
			'bbs_id' => '2',
			'language_id' => '2',
			'status' => '1',
			'is_active' => '1',
			'is_latest' => '1',
			'key' => 'bbs_article_6',
			'title' => 'Lorem ipsum dolor sit amet',
			'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created_user' => 3,
			'created' => '2015-05-14 07:09:55',
			'modified_user' => 3,
			'modified' => '2015-05-14 07:09:55'
		),
		//(記事返信が2つある記事)
		array(
			'id' => '7',
			'bbs_id' => '2',
			'language_id' => '2',
			'status' => '1',
			'is_active' => '1',
			'is_latest' => '1',
			'key' => 'bbs_article_7',
			'title' => '記事1',
			'content' => '記事1です。',
			'created_user' => 1,
			'created' => '2015-05-14 07:09:55',
			'modified_user' => 1,
			'modified' => '2015-05-14 07:09:55'
		),
		array(
			'id' => '8',
			'bbs_id' => '2',
			'language_id' => '2',
			'status' => '1',
			'is_active' => '1',
			'is_latest' => '1',
			'key' => 'bbs_article_8',
			'title' => 'Re:記事1',
			'content' => '返信1です。',
			'created_user' => 1,
			'created' => '2015-05-14 07:09:55',
			'modified_user' => 1,
			'modified' => '2015-05-14 07:09:55'
		),
		array(
			'id' => '9',
			'bbs_id' => '2',
			'language_id' => '2',
			'status' => '1',
			'is_active' => '1',
			'is_latest' => '1',
			'key' => 'bbs_article_9',
			'title' => 'Re2:記事１',
			'content' => '返信2です。',
			'created_user' => 1,
			'created' => '2015-05-14 07:09:55',
			'modified_user' => 1,
			'modified' => '2015-05-14 07:09:55'
		),
		//(根記事が不正)
		array(
			'id' => '10',
			'bbs_id' => '2',
			'language_id' => '2',
			'status' => '1',
			'is_active' => '1',
			'is_latest' => '1',
			'key' => 'bbs_article_10',
			'title' => '記事10',
			'content' => '記事10です。',
			'created_user' => 1,
			'created' => '2015-05-14 07:09:55',
			'modified_user' => 1,
			'modified' => '2015-05-14 07:09:55'
		),
		//(親記事が不正)
		array(
			'id' => '11',
			'bbs_id' => '2',
			'language_id' => '2',
			'status' => '1',
			'is_active' => '1',
			'is_latest' => '1',
			'key' => 'bbs_article_11',
			'title' => '記事11',
			'content' => '記事11です。',
			'created_user' => 1,
			'created' => '2015-05-14 07:09:55',
			'modified_user' => 1,
			'modified' => '2015-05-14 07:09:55'
		),
	);

}
