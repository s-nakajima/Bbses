<?php
/**
 * BbsSettingFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * BbsSettingFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Test\Fixture
 */
class BbsSettingFixture extends CakeTestFixture {

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		//掲示板1
		array(
			'id' => 1,
			'bbs_key' => 'bbs_1',
			'use_workflow' => '1',
			'use_comment' => '1',
			'use_comment_approval' => '1',
			'use_like' => '0',
			'use_unlike' => '0',
		),
		//掲示板2
		array(
			'id' => 2,
			'bbs_key' => 'bbs_2',
			'use_workflow' => '1',
			'use_comment' => '1',
			'use_comment_approval' => '1',
			'use_like' => '0',
			'use_unlike' => '0',
		),
		//掲示板3
		array(
			'id' => 3,
			'bbs_key' => 'bbs_3',
			'use_workflow' => '1',
			'use_comment' => '1',
			'use_comment_approval' => '1',
			'use_like' => '1',
			'use_unlike' => '1',
		),
		//掲示板4(ワークフローなし)
		array(
			'id' => 4,
			'bbs_key' => 'bbs_4',
			'use_workflow' => '0',
			'use_comment' => '1',
			'use_comment_approval' => '1',
			'use_like' => '1',
			'use_unlike' => '1',
		),
		//掲示板5(コメントなし)
		array(
			'id' => 5,
			'bbs_key' => 'bbs_5',
			'use_workflow' => '1',
			'use_comment' => '0',
			'use_comment_approval' => '1',
			'use_like' => '1',
			'use_unlike' => '1',
		),
		//掲示板6(コメントの承認なし)
		array(
			'id' => 6,
			'bbs_key' => 'bbs_6',
			'use_workflow' => '1',
			'use_comment' => '1',
			'use_comment_approval' => '0',
			'use_like' => '1',
			'use_unlike' => '1',
		),
		//掲示板7(いいねなし)
		array(
			'id' => 7,
			'bbs_key' => 'bbs_7',
			'use_workflow' => '1',
			'use_comment' => '1',
			'use_comment_approval' => '1',
			'use_like' => '0',
			'use_unlike' => '0',
		),
		//掲示板8(わるいねなし)
		array(
			'id' => 8,
			'bbs_key' => 'bbs_8',
			'use_workflow' => '1',
			'use_comment' => '1',
			'use_comment_approval' => '1',
			'use_like' => '1',
			'use_unlike' => '0',
		),
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('Bbses') . 'Config' . DS . 'Schema' . DS . 'schema.php';
		$this->fields = (new BbsesSchema())->tables['bbs_settings'];
		parent::init();
	}

}
