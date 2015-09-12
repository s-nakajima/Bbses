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
				'Comment' => 'Comments.Comment',
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

			//status to set in PublishableBehavior.

			'name' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('bbses', 'Bbs name')),
					'required' => true
				),
			),
		));

		if (! parent::beforeValidate($options)) {
			return false;
		}

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
	}

/**
 * Called after each successful save operation.
 *
 * @param bool $created True if this save created a new record
 * @param array $options Options passed from Model::save().
 * @return void
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
		$this->BbsSetting = ClassRegistry::init('Bbses.BbsSetting');

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
		$this->loadModels([
			'Bbs' => 'Bbses.Bbs',
			'BbsSetting' => 'Bbses.BbsSetting',
			'BbsFrameSetting' => 'Bbses.BbsFrameSetting',
		]);

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
		$this->loadModels([
			'Bbs' => 'Bbses.Bbs',
			'BbsSetting' => 'Bbses.BbsSetting',
			'BbsArticle' => 'Bbses.BbsArticle',
			'BbsArticleTree' => 'Bbses.BbsArticleTree',
		]);

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

/**
 * Update bbs_article_modified and bbs_article_count
 *
 * @param int $bbsId bbses.id
 * @param string $bbsKey bbses.key
 * @param int $languageId languages.id
 * @return bool True on success
 * @throws InternalErrorException
 */
//	public function updateBbsArticle($bbsId, $bbsKey, $languageId) {
//		$this->loadModels([
//			'BbsArticle' => 'Bbses.BbsArticle',
//		]);
//		$db = $this->getDataSource();
//
//		$conditions = array(
//			'bbs_id' => $bbsId,
//			'language_id' => $languageId,
//			'is_latest' => true
//		);
//		$count = $this->BbsArticle->find('count', array(
//			'recursive' => -1,
//			'conditions' => $conditions,
//		));
//		if ($count === false) {
//			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
//		}
//
//		$article = $this->BbsArticle->find('first', array(
//			'recursive' => -1,
//			'fields' => 'modified',
//			'conditions' => $conditions,
//			'order' => 'modified desc'
//		));
//		if ($article === false) {
//			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
//		}
//
//		$update = array(
//			'bbs_article_count' => $count
//		);
//		if ($article) {
//			$update['bbs_article_modified'] = $db->value($article[$this->BbsArticle->alias]['modified'], 'string');
//		}
//
//		if (! $this->updateAll($update, array('Bbs.key' => $bbsKey))) {
//			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
//		}
//
//		return true;
//	}

}
