<?php
/**
 * BbsSetting Model
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
 * BbsSetting Model
 *
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @package NetCommons\Bbses\Model
 */
class BbsSetting extends BbsesAppModel {

/**
 * Approval type
 *
 * @var int
 */
	const
		NOT_NEED_APPROVAL = '0',
		NEED_COMMENT_APPROVAL = '1',
		NEED_BOTH_APPROVAL = '2';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * Called after each find operation. Can be used to modify any results returned by find().
 * Return value should be the (modified) results.
 *
 * @param mixed $results The results of the find operation
 * @param bool $primary Whether this model is being queried directly (vs. being queried as an association)
 * @return mixed Result of the find operation
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#afterfind
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function afterFind($results, $primary = false) {
		foreach ($results as $i => $result) {
			if (array_key_exists('use_workflow', $result[$this->alias]) &&
					array_key_exists('is_comment_auto_approval', $result[$this->alias])) {

				if ($result[$this->alias]['use_workflow']) {
					$results[$i][$this->alias]['approval_type'] = self::NEED_BOTH_APPROVAL;
				} else if ($result[$this->alias]['is_comment_auto_approval']) {
					$results[$i][$this->alias]['approval_type'] = self::NEED_COMMENT_APPROVAL;
				} else {
					$results[$i][$this->alias]['approval_type'] = self::NOT_NEED_APPROVAL;
				}
			}
		}
		return $results;
	}

/**
 * Save bbs_setting
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function saveBbsSetting($data) {
		$this->loadModels([
			'BbsSetting' => 'Bbses.BbsSetting',
			'BlockRolePermission' => 'Blocks.BlockRolePermission',
		]);

		//トランザクションBegin
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			if (! $this->validateBbsSetting($data)) {
				return false;
			}
			foreach ($data[$this->BlockRolePermission->alias] as $value) {
				if (! $this->BlockRolePermission->validateBlockRolePermissions($value)) {
					$this->validationErrors = Hash::merge($this->validationErrors, $this->BlockRolePermission->validationErrors);
					return false;
				}
			}

			if (! $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			foreach ($data[$this->BlockRolePermission->alias] as $value) {
				if (! $this->BlockRolePermission->saveMany($value, ['validate' => false])) {
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
 * @return bool True on success, false on error
 */
	public function validateBbsSetting($data) {
		$this->set($data);
		$this->validates();
		if ($this->validationErrors) {
			return false;
		}
		return true;
	}

}
