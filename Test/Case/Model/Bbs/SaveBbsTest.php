<?php
/**
 * Bbs::saveBbs()のテスト
 *
 * @property Bbs $Bbs
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsSaveTest', 'NetCommons.TestSuite');

/**
 * Bbs::saveBbs()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Test\Case\Model\Bbs
 */
class BbsSaveBbsTest extends NetCommonsSaveTest {

/**
 * Plugin name
 *
 * @var array
 */
	public $plugin = 'bbses';

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.likes.like',
		'plugin.bbses.bbs',
		'plugin.bbses.bbs_setting',
		'plugin.bbses.bbs_frame_setting',
		'plugin.bbses.bbs_article',
		'plugin.bbses.bbs_article_tree',
		'plugin.workflow.workflow_comment',
	);

/**
 * Model name
 *
 * @var array
 */
	protected $_modelName = 'Bbs';

/**
 * Method name
 *
 * @var array
 */
	protected $_methodName = 'saveBbs';

/**
 * テストDataの取得
 *
 * @param string $bbsKey bbsKey
 * @return array
 */
	private function __getData($bbsKey = 'bbs_1') {
		$frameId = '6';
		$frameKey = 'frame_3';
		$blockId = '2';
		$blockKey = 'block_1';
		$bbsId = '2';
		if ($bbsKey === 'bbs_1') {
			$bbsId = '2';
			$bbsSettingId = '1';
		} else {
			$bbsId = null;
			$bbsSettingId = null;
		}

		$data = array(
			'Frame' => array(
				'id' => $frameId
			),
			'Block' => array(
				'id' => $blockId,
				'key' => $blockKey,
				'language_id' => '2',
				'room_id' => '1',
				'plugin_key' => $this->plugin,
				'public_type' => '1',
			),
			'Bbs' => array(
				'id' => $bbsId,
				'key' => $bbsKey,
				'name' => 'bbsName',
				'block_id' => $blockId,
				'bbs_article_count' => '0',
				'bbs_article_modified' => null,
			),
			'BbsSetting' => array(
				'id' => $bbsSettingId,
				'bbs_key' => $bbsKey,
				'use_comment' => '1',
				'use_like' => '1',
				'use_unlike' => '1',
			),
			'BbsFrameSetting' => array(
				'id' => $bbsId,
				'frame_key' => $frameKey,
				'articles_per_page' => 10,
				'comments_per_page' => 10,
			),
		);

		return $data;
	}

/**
 * SaveのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *
 * @return void
 */
	public function dataProviderSave() {
		return array(
			array($this->__getData()), //修正
			array($this->__getData(null)), //新規
		);
	}

/**
 * SaveのExceptionErrorのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return void
 */
	public function dataProviderSaveOnExceptionError() {
		return array(
			array($this->__getData(), 'Bbses.Bbs', 'save'),
			array($this->__getData(null), 'Bbses.BbsSetting', 'save'),
			array($this->__getData(null), 'Bbses.BbsFrameSetting', 'save'),
		);
	}

/**
 * SaveのValidationErrorのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *
 * @return void
 */
	public function dataProviderSaveOnValidationError() {
		return array(
			array($this->__getData(), 'Bbses.Bbs'),
			array($this->__getData(), 'Bbses.BbsSetting'),
			array($this->__getData(null), 'Bbses.BbsFrameSetting'),
		);
	}

}
