<?php
/**
 * BbsFrameSetting::saveBbsFrameSetting()のテスト
 *
 * @property BbsFrameSetting $BbsFrameSetting
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsSaveTest', 'NetCommons.TestSuite');

/**
 * BbsFrameSetting::saveBbsFrameSetting()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Test\Case\Model\BbsFrameSetting
 */
class BbsFrameSettingSaveBbsFrameSettingTest extends NetCommonsSaveTest {

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
	protected $_modelName = 'BbsFrameSetting';

/**
 * Method name
 *
 * @var array
 */
	protected $_methodName = 'saveBbsFrameSetting';

/**
 * テストDataの取得
 *
 * @param string $frameKey フレームKey
 * @return array
 */
	private function __getData($frameKey = 'frame_1') {
		if ($frameKey === 'frame_1') {
			$id = '1';
		} else {
			$id = null;
		}

		$data = array(
			'Frame' => array(
				'id' => '6'
			),
			'BbsFrameSetting' => array(
				'id' => $id,
				'frame_key' => 'frame_1',
				'articles_per_page' => '20',
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
			array($this->__getData(), 'Bbses.BbsFrameSetting', 'save'),
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
			array($this->__getData(), 'Bbses.BbsFrameSetting'),
		);
	}
}
