<?php
/**
 * BbsFrameSetting Model
 *
 * @property Block $Block
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BbsesAppModel', 'Bbses.Model');

/**
 * BbsFrameSetting Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Model
 */
class BbsFrameSetting extends BbsesAppModel {

/**
 * listStyle
 *
 * @var array
 */
//	static public $displayNumberOptions = array();

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Frame' => array(
			'className' => 'Frames.Frame',
			'foreignKey' => 'frame_key',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

/**
 * Constructor. Binds the model's database table to the object.
 *
 * @param bool|int|string|array $id Set this ID for this model on startup,
 * can also be an array of options, see above.
 * @param string $table Name of database table to use.
 * @param string $ds DataSource connection name.
 * @see Model::__construct()
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
//	public function __construct($id = false, $table = null, $ds = null) {
//		parent::__construct($id, $table, $ds);
//
//		self::$displayNumberOptions = array(
//			1 => __d('bbses', '%s article', 1),
//			5 => __d('bbses', '%s articles', 5),
//			10 => __d('bbses', '%s articles', 10),
//			20 => __d('bbses', '%s articles', 20),
//			50 => __d('bbses', '%s articles', 50),
//			100 => __d('bbses', '%s articles', 100),
//		);
//	}

/**
 * Called during validation operations, before validation. Please note that custom
 * validation rules can be defined in $validate.
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if validate operation should continue, false to abort
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforevalidate
 * @see Model::save()
 */
	public function beforeValidate($options = array()) {
		$this->validate = Hash::merge($this->validate, array(
			'frame_key' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
					'required' => true,
				)
			),
			'articles_per_page' => array(
				'number' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
					'required' => true,
				)
			),
			'comments_per_page' => array(
				'number' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
					'required' => true,
				)
			),
		));
		return parent::beforeValidate($options);
	}

/**
 * Get bbs frame setting data
 *
 * @return array BbsFrameSetting data
 */
	public function getBbsFrameSetting($created) {
		$conditions = array(
			'frame_key' => Current::read('Frame.key')
		);

		$bbsFrameSetting = $this->find('first', array(
				'recursive' => -1,
				'conditions' => $conditions,
			)
		);

		if ($created && ! $bbsFrameSetting) {
			$bbsFrameSetting = $this->create(array(
				'frame_key' => Current::read('Frame.key')
			));
		}

		return $bbsFrameSetting;
	}

/**
 * save bbs
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function saveBbsFrameSetting($data) {
		$this->loadModels([
			'BbsFrameSetting' => 'Bbses.BbsFrameSetting',
		]);

		//トランザクションBegin
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			//バリデーション
			if (!$this->validateBbsFrameSetting($data)) {
				return false;
			}

			//登録処理
			if (! $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//トランザクションCommit
			$dataSource->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}

		return true;
	}

/**
 * validate bbs_frame_setting
 *
 * @param array $data received post data
 * @return bool True on success, false on error
 */
	public function validateBbsFrameSetting($data) {
		$this->set($data);
		$this->validates();
		if ($this->validationErrors) {
			return false;
		}
		return true;
	}
}
