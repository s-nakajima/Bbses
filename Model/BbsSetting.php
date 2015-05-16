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
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * Get bbs setting data
 *
 * @param string $bbsKey bbses.key
 * @return array
 */
	public function getBbsSetting($bbsKey) {
		$conditions = array(
			'bbs_key' => $bbsKey
		);

		$bbsSetting = $this->find('first', array(
				'recursive' => -1,
				'conditions' => $conditions,
			)
		);

		return $bbsSetting;
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
