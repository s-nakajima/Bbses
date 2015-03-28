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
 * @return mixed On success Model::$data if its not empty or true, false on failure
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
			if (! $this->validateBbs($data)) {
				return false;
			}
			if (! $this->BbsSetting->validateBbsSetting($data)) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->BbsSetting->validationErrors);
				return false;
			}
			if (! $this->Block->validateBlock($data)) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->Block->validationErrors);
				return false;
			}

			if (isset($data['BbsFrameSetting'])) {
				if (! $this->BbsFrameSetting->validateBbsFrameSetting($data)) {
					$this->validationErrors = Hash::merge($this->validationErrors, $this->BbsFrameSetting->validationErrors);
					return false;
				}
			}

			$frame = $this->Frame->findById($data['Frame']['id']);
			if (! $frame) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//ブロックの登録
			$block = $this->Block->save(null, false);

			//framesテーブル更新
			if (! $frame['Frame']['block_id']) {
				$frame['Frame']['block_id'] = (int)$block['Block']['id'];
				if (! $this->Frame->save($frame, false)) {
					// @codeCoverageIgnoreStart
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
					// @codeCoverageIgnoreEnd
				}
			}

			//登録処理
			$this->data['Bbs']['block_id'] = (int)$block['Block']['id'];
			$this->data['Bbs']['key'] = $block['Block']['key'];
			if (! $this->save(null, false)) {
				// @codeCoverageIgnoreStart
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				// @codeCoverageIgnoreEnd
			}

			$this->BbsSetting->data['BbsSetting']['bbs_key'] = $block['Block']['key'];
			if (! $this->BbsSetting->save(null, false)) {
				// @codeCoverageIgnoreStart
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				// @codeCoverageIgnoreEnd
			}
			if (isset($data['BbsFrameSetting'])) {
				if (! $this->BbsFrameSetting->save(null, false)) {
					// @codeCoverageIgnoreStart
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
					// @codeCoverageIgnoreEnd
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
 * @return bool True on success, false on error
 */
	public function validateBbs($data) {
		$this->set($data);
		$this->validates();
		return $this->validationErrors ? false : true;
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
			'Frame' => 'Frames.Frame',
		]);

		//トランザクションBegin
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			if (! $this->deleteAll(array($this->alias . '.key' => $data['Bbs']['key']), false)) {
				// @codeCoverageIgnoreStart
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				// @codeCoverageIgnoreEnd
			}

			if (! $this->BbsSetting->deleteAll(array($this->BbsSetting->alias . '.bbs_key' => $data['Bbs']['key']), false)) {
				// @codeCoverageIgnoreStart
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				// @codeCoverageIgnoreEnd
			}

			if (! $this->BbsPost->deleteAll(array($this->BbsPost->alias . '.bbs_key' => $data['Bbs']['key']), true)) {
				// @codeCoverageIgnoreStart
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				// @codeCoverageIgnoreEnd
			}

			if (! $this->Block->deleteAll(array($this->Block->alias . '.key' => $data['Block']['key']), true)) {
				// @codeCoverageIgnoreStart
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				// @codeCoverageIgnoreEnd
			}

			if (! $this->Frame->updateAll(
					array('Frame.block_id' => null),
					array('Frame.block_id' => (int)$data['Block']['id'])
			)) {
				// @codeCoverageIgnoreStart
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				// @codeCoverageIgnoreEnd
			}

			if (! $this->BlockRolePermission->deleteAll(array($this->BlockRolePermission->alias . '.block_key' => $data['Block']['key']), true)) {
				// @codeCoverageIgnoreStart
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				// @codeCoverageIgnoreEnd
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

}
