<?php
/**
 * Bbs Model
 *
 * @property Block $Block
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BbsesAppModel', 'Bbses.Model');

/**
 * Bbs Model
 *
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
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
			'dependent' => true
		)
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
			//'key' => array(
			//	'notEmpty' => array(
			//		'rule' => array('notEmpty'),
			//		'message' => __d('net_commons', 'Invalid request.'),
			//		//'required' => true,
			//	)
			//),

			//status to set in PublishableBehavior.

			'is_auto_translated' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __d('net_commons', 'Invalid request.'),
				)
			),
			'name' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('bbses', 'Bbs name')),
					'required' => true
				),
			),
		));
		return parent::beforeValidate($options);
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
			'Block' => 'Blocks.Block',
			'Frame' => 'Frames.Frame',
		]);

		//トランザクションBegin
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			//バリデーション
			if (! $this->validateBbs($data, ['bbsSetting', 'block', 'bbsFrameSetting'])) {
				return false;
			}

			//ブロックの登録
			$block = $this->Block->saveByFrameId($data['Frame']['id']);

			//登録処理
			$this->data['Bbs']['block_id'] = (int)$block['Block']['id'];
			$this->data['Bbs']['key'] = $block['Block']['key'];
			if (! $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			$this->BbsSetting->data['BbsSetting']['bbs_key'] = $block['Block']['key'];
			if (! $this->BbsSetting->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			if (isset($data['BbsFrameSetting'])) {
				if (! $this->BbsFrameSetting->save(null, false)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
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
		$this->setDataSource('master');

		$this->loadModels([
			'Bbs' => 'Bbses.Bbs',
			'BbsSetting' => 'Bbses.BbsSetting',
			'BbsPost' => 'Bbses.BbsPost',
			'BbsPostI18n' => 'Bbses.BbsPostI18n',
			'Block' => 'Blocks.Block',
			'BlockRolePermission' => 'Blocks.BlockRolePermission',
			'Comment' => 'Comments.Comment',
		]);

		//トランザクションBegin
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			if (! $this->deleteAll(array($this->alias . '.key' => $data['Bbs']['key']), false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			if (! $this->BbsSetting->deleteAll(array($this->BbsSetting->alias . '.bbs_key' => $data['Bbs']['key']), false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			if (! $this->BbsPost->deleteAll(array($this->BbsPost->alias . '.bbs_key' => $data['Bbs']['key']), true)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

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
}
