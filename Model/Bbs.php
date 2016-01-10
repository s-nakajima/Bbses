<?php
/**
 * Bbs Model
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
 * Bbs Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Model
 */
class Bbs extends BbsesAppModel {

/**
 * use tables
 *
 * @var string
 */
	public $useTable = 'bbses';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'Blocks.Block' => array(
			'name' => 'Bbs.name',
			'loadModels' => array(
				'Like' => 'Likes.Like',
				'WorkflowComment' => 'Workflow.WorkflowComment',
			)
		),
		'NetCommons.OriginalKey',
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Block' => array(
			'className' => 'Blocks.Block',
			'foreignKey' => 'block_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'BbsSetting' => array(
			'className' => 'Bbses.BbsSetting',
			'foreignKey' => 'bbs_key',
			'dependent' => false
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
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->loadModels([
			'Bbs' => 'Bbses.Bbs',
			'BbsArticle' => 'Bbses.BbsArticle',
			'BbsArticleTree' => 'Bbses.BbsArticleTree',
			'BbsFrameSetting' => 'Bbses.BbsFrameSetting',
		]);
	}

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
			//'block_id' => array(
			//	'numeric' => array(
			//		'rule' => array('numeric'),
			//		'message' => __d('net_commons', 'Invalid request.'),
			//		//'allowEmpty' => false,
			//		//'required' => true,
			//	)
			//),
			'key' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					'required' => true,
					'on' => 'update', // Limit validation to 'create' or 'update' operations
				),
			),

			'name' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('bbses', 'Bbs name')),
					'required' => true
				),
			),
		));

		if (isset($this->data['BbsSetting'])) {
			$this->BbsSetting->set($this->data['BbsSetting']);
			if (! $this->BbsSetting->validates()) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->BbsSetting->validationErrors);
				return false;
			}
		}

		if (isset($this->data['BbsFrameSetting']) && ! $this->data['BbsFrameSetting']['id']) {
			$this->BbsFrameSetting->set($this->data['BbsFrameSetting']);
			if (! $this->BbsFrameSetting->validates()) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->BbsFrameSetting->validationErrors);
				return false;
			}
		}

		return parent::beforeValidate($options);
	}

/**
 * Called after each successful save operation.
 *
 * @param bool $created True if this save created a new record
 * @param array $options Options passed from Model::save().
 * @return void
 * @throws InternalErrorException
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#aftersave
 * @see Model::save()
 */
	public function afterSave($created, $options = array()) {
		//BbsSetting登録
		if (isset($this->BbsSetting->data['BbsSetting'])) {
			if (! $this->BbsSetting->data['BbsSetting']['bbs_key']) {
				$this->BbsSetting->data['BbsSetting']['bbs_key'] = $this->data[$this->alias]['key'];
			}
			if (! $this->BbsSetting->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}

		//BbsFrameSetting登録
		if (isset($this->BbsFrameSetting->data['BbsFrameSetting']) && ! $this->BbsFrameSetting->data['BbsFrameSetting']['id']) {
			if (! $this->BbsFrameSetting->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}

		parent::afterSave($created, $options);
	}

/**
 * Create bbs data
 *
 * @return array
 */
	public function createBbs() {
		$bbs = $this->createAll(array(
			'Bbs' => array(
				'name' => __d('bbses', 'New bbs %s', date('YmdHis')),
			),
			'Block' => array(
				'room_id' => Current::read('Room.id'),
				'language_id' => Current::read('Language.id'),
			),
		));
		$bbs = Hash::merge($bbs, $this->BbsSetting->create());

		return $bbs;
	}

/**
 * Get bbs data
 *
 * @return array
 */
	public function getBbs() {
		$bbs = $this->find('all', array(
			'recursive' => -1,
			'fields' => array(
				$this->alias . '.*',
				$this->Block->alias . '.*',
				$this->BbsSetting->alias . '.*',
			),
			'joins' => array(
				array(
					'table' => $this->Block->table,
					'alias' => $this->Block->alias,
					'type' => 'INNER',
					'conditions' => array(
						$this->alias . '.block_id' . ' = ' . $this->Block->alias . ' .id',
					),
				),
				array(
					'table' => $this->BbsSetting->table,
					'alias' => $this->BbsSetting->alias,
					'type' => 'INNER',
					'conditions' => array(
						$this->alias . '.key' . ' = ' . $this->BbsSetting->alias . ' .bbs_key',
					),
				),
			),
			'conditions' => $this->getBlockConditionById(),
		));
		if (! $bbs) {
			return $bbs;
		}
		return $bbs[0];
	}

/**
 * Save bbses
 *
 * @param array $data received post data
 * @return bool True on success, false on validation errors
 * @throws InternalErrorException
 */
	public function saveBbs($data) {
		//トランザクションBegin
		$this->begin();

		//バリデーション
		$this->set($data);
		if (! $this->validates()) {
			return false;
		}

		try {
			//登録処理
			if (! $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return true;
	}

/**
 * Delete bbses
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function deleteBbs($data) {
		//トランザクションBegin
		$this->begin();

		$conditions = array(
			$this->alias . '.key' => $data['Bbs']['key']
		);
		$bbses = $this->find('list', array(
			'recursive' => -1,
			'conditions' => $conditions,
		));
		$bbsIds = array_keys($bbses);

		try {
			if (! $this->deleteAll(array($this->alias . '.key' => $data['Bbs']['key']), false, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			if (! $this->BbsSetting->deleteAll(array($this->BbsSetting->alias . '.bbs_key' => $data['Bbs']['key']), false, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			if (! $this->BbsArticle->deleteAll(array($this->BbsArticle->alias . '.bbs_id' => $bbsIds), false, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			if (! $this->BbsArticleTree->deleteAll(array($this->BbsArticleTree->alias . '.bbs_key' => $data['Bbs']['key']), false, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//Blockデータ削除
			$this->deleteBlock($data['Block']['key']);

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return true;
	}

}
