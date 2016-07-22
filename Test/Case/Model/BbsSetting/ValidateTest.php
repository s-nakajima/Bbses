<?php
/**
 * BbsSetting::saveBbsSetting()のテスト
 *
 * @property BbsSetting $BbsSetting
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsSaveTest', 'NetCommons.TestSuite');

/**
 * BbsSetting::saveBbsSetting()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Test\Case\Model\BbsSetting
 */
class BbsSettingValidateTest extends NetCommonsSaveTest {

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
		'plugin.likes.likes_user',
		'plugin.bbses.bbs',
		'plugin.bbses.block_setting_for_bbs',
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
	protected $_modelName = 'BbsSetting';

/**
 * Method name
 *
 * @var array
 */
	protected $_methodName = 'saveBbsSetting';

/**
 * テストDataの取得
 *
 * @param string $bbsKey BBSキー
 * @return array
 */
	private function __getData($bbsKey = 'bbs_1') {
		if ($bbsKey === 'bbs_1') {
			$id = '1';
		} else {
			$id = null;
		}

		$data = array(
			'Frame' => array(
				'id' => '6'
			),
			'BbsSetting' => array(
				'id' => $id,
				'bbs_key' => 'bbs_1',
				'use_workflow' => '1',
				'use_comment' => '1',
				'use_comment_approval' => '1',
				'use_like' => '1',
				'use_unlike' => '1',
			),
		);

		return $data;
	}

/**
 * SaveのDataProvider
 *
 * #### 戻り値
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
 * #### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return array
 */
	public function dataProviderSaveOnExceptionError() {
		return array(
			array($this->__getData(), 'Bbses.BbsSetting', 'save'),
		);
	}

/**
 * SaveのValidationErrorのDataProvider
 *
 * #### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *
 * @return array
 */
	public function dataProviderSaveOnValidationError() {
		return array(
			array($this->__getData(), 'Bbses.BbsSetting'),
		);
	}

/**
 * ValidationErrorのDataProvider
 *
 * #### 戻り値
 *  - field フィールド名
 *  - value セットする値
 *  - message エラーメッセージ
 *  - overwrite 上書きするデータ
 *
 * @return array
 */
	public function dataProviderValidationError() {
		return array(
			array($this->__getData(), 'use_workflow', 'a',
				__d('net_commons', 'Invalid request.')),
			array($this->__getData(), 'use_like', 'a',
				__d('net_commons', 'Invalid request.')),
			array($this->__getData(), 'use_unlike', 'a',
				__d('net_commons', 'Invalid request.')),
		);
	}

}
