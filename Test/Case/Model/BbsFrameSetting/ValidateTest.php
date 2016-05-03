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

App::uses('NetCommonsValidateTest', 'NetCommons.TestSuite');

/**
 * BbsFrameSetting::saveBbsFrameSetting()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Test\Case\Model\BbsFrameSetting
 */
class BbsFrameSettingValidateTest extends NetCommonsValidateTest {

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
 * @param string $bbsArticleKey bbsArticleKey
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
				'comments_per_page' => '20',
			),
		);

		return $data;
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
			array($this->__getData(), 'frame_key', '',
				__d('net_commons', 'Invalid request.')),
			array($this->__getData(), 'articles_per_page', '',
				__d('net_commons', 'Invalid request.')),
			array($this->__getData(), 'comments_per_page', '',
				__d('net_commons', 'Invalid request.')),
		);
	}

}
