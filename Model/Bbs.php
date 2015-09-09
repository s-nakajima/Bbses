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
		'BbsSettings' => array(
			'className' => 'Bbses.BbsSettings',
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
		return parent::beforeValidate($options);
	}

/**
 * Get bbs data
 *
 * @param int $blockId blocks.id
 * @param int $roomId rooms.id
 * @return array
 */
	public function getBbs($blockId, $roomId) {
		$conditions = array(
			'Block.id' => $blockId,
			'Block.room_id' => $roomId,
		);

		$faq = $this->find('first', array(
				'recursive' => 0,
				'conditions' => $conditions,
			)
		);

		return $faq;
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
//			'Block' => 'Blocks.Block',
//			'Frame' => 'Frames.Frame',
		]);

		//トランザクションBegin
		$this->begin();

		$this->set($data);
		if (! $this->validates()) {
			return false;
		}

		try {
//			//バリデーション
//			if (! $this->validateBbs($data, ['bbsSetting', 'block', 'bbsFrameSetting'])) {
//				return false;
//			}

//			//ブロックの登録
//			$block = $this->Block->saveByFrameId($data['Frame']['id']);

			//登録処理
//			$this->data['Bbs']['block_id'] = (int)$block['Block']['id'];
			if (! $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

//			$this->BbsSetting->data['BbsSetting']['bbs_key'] = $bbs['Bbs']['key'];
//			if (! $this->BbsSetting->save(null, false)) {
//				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
//			}
//			if (isset($data['BbsFrameSetting'])) {
//				if (! $this->BbsFrameSetting->save(null, false)) {
//					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
//				}
//			}

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
//			CakeLog::error($ex);
//			throw $ex;
		}

		return true;
	}

/**
 * validate bbs
 *
 * @param array $data received post data
 * @param array $contains Optional validate sets
 * @return bool True on success, false on validation errors
 */
	public function validateBbs($data, $contains = []) {
		$this->set($data);
		$this->validates();
		if ($this->validationErrors) {
			return false;
		}

		if (in_array('bbsSetting', $contains, true)) {
			if (! $this->BbsSetting->validateBbsSetting($data)) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->BbsSetting->validationErrors);
				return false;
			}
		}

		if (in_array('block', $contains, true)) {
			if (! $this->Block->validateBlock($data)) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->Block->validationErrors);
				return false;
			}
		}

		if (in_array('bbsFrameSetting', $contains, true) && isset($data['BbsFrameSetting'])) {
			if (! $this->BbsFrameSetting->validateBbsFrameSetting($data)) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->BbsFrameSetting->validationErrors);
				return false;
			}
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
			'Block' => 'Blocks.Block',
			'BlockRolePermission' => 'Blocks.BlockRolePermission',
			'Comment' => 'Comments.Comment',
		]);

		//トランザクションBegin
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		$conditions = array(
			$this->alias . '.key' => $data['Bbs']['key']
		);
		$bbses = $this->find('list', array(
				'recursive' => -1,
				'conditions' => $conditions,
			)
		);
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

			//コメントの削除
			$this->Comment->deleteByBlockKey($data['Block']['key']);

			//Blockデータ削除
			$this->Block->deleteBlock($data['Block']['key']);

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
 * Update article_modified and article_count
 *
 * @param int $bbsId bbses.id
 * @param string $bbsKey bbses.key
 * @param int $languageId languages.id
 * @return bool True on success
 * @throws InternalErrorException
 */
	public function updateBbsArticle($bbsId, $bbsKey, $languageId) {
		$this->loadModels([
			'BbsArticle' => 'Bbses.BbsArticle',
		]);
		$db = $this->getDataSource();

		$conditions = array(
			'bbs_id' => $bbsId,
			'language_id' => $languageId,
			'is_latest' => true
		);
		$count = $this->BbsArticle->find('count', array(
			'recursive' => -1,
			'conditions' => $conditions,
		));
		if ($count === false) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		$article = $this->BbsArticle->find('first', array(
			'recursive' => -1,
			'fields' => 'modified',
			'conditions' => $conditions,
			'order' => 'modified desc'
		));
		if ($article === false) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		$update = array(
			'article_count' => $count
		);
		if ($article) {
			$update['article_modified'] = $db->value($article[$this->BbsArticle->alias]['modified'], 'string');
		}

		if (! $this->updateAll($update, array('Bbs.key' => $bbsKey))) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		return true;
	}
}
