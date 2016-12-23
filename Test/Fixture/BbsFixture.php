<?php
/**
 * BbsFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * BbsFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Test\Fixture
 * @codeCoverageIgnore
 */
class BbsFixture extends CakeTestFixture {

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'bbses';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		//掲示板1
		array(
			'id' => 1,
			'key' => 'bbs_1A',
			'block_id' => '1',
			'language_id' => '2',
			'name' => 'Test bbs 1',
			'bbs_article_modified' => 1,
		),
		array(
			'id' => 2,
			'key' => 'bbs_1',
			'block_id' => '2',
			'language_id' => '2',
			'name' => 'Test bbs 1',
			'bbs_article_modified' => 1,
		),
		//掲示板2
		array(
			'id' => 3,
			'key' => 'bbs_2',
			'block_id' => '4',
			'language_id' => '2',
			'name' => 'Test bbs 2',
			'bbs_article_modified' => 1,
		),
		//掲示板3
		array(
			'id' => 4,
			'key' => 'bbs_3',
			'block_id' => '6',
			'language_id' => '2',
			'name' => 'Test bbs 3',
			'bbs_article_modified' => 1,
		),

		//掲示板4(ワークフローなし)
		array(
			'id' => 5,
			'key' => 'bbs_4',
			'block_id' => '11',
			'language_id' => '2',
			'name' => 'Test bbs 4',
			'bbs_article_modified' => 1,
		),
		//掲示板5(コメントなし)
		array(
			'id' => 6,
			'key' => 'bbs_5',
			'block_id' => '12',
			'language_id' => '2',
			'name' => 'Test bbs 5',
			'bbs_article_modified' => 1,
		),
		//掲示板6(コメントの承認なし)
		array(
			'id' => 7,
			'key' => 'bbs_6',
			'block_id' => '13',
			'language_id' => '2',
			'name' => 'Test bbs 6',
			'bbs_article_modified' => 1,
		),
		//掲示板7(いいねなし)
		array(
			'id' => 8,
			'key' => 'bbs_7',
			'block_id' => '14',
			'language_id' => '2',
			'name' => 'Test bbs 7',
			'bbs_article_modified' => 1,
		),
		//掲示板8(わるいねなし)
		array(
			'id' => 9,
			'key' => 'bbs_8',
			'block_id' => '15',
			'language_id' => '2',
			'name' => 'Test bbs 8',
			'bbs_article_modified' => 1,
		),
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('Bbses') . 'Config' . DS . 'Schema' . DS . 'schema.php';
		$this->fields = (new BbsesSchema())->tables['bbses'];
		parent::init();
	}

}
