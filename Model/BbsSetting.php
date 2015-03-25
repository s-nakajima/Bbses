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
 * Save bbs_setting
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function saveBbsSetting($data) {
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
			if (! $this->validateBbsSetting($data)) {
				return false;
			}
			if (! $this->Bbs->validateBbs($data)) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->Bbs->validationErrors);
				return false;
			}
			if (! $this->Block->validateBlock($data)) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->Block->validationErrors);
				return false;
			}

			if (isset($data['BbsFrameSetting'])) {
				if (! $this->BbsFrameSetting->validateBbsFrameSetting($data)) {
					$this->validationErrors = Hash::merge($this->validationErrors, $this->Bbs->validationErrors);
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
			$this->Bbs->data['Bbs']['block_id'] = (int)$block['Block']['id'];
			$this->Bbs->data['Bbs']['key'] = $block['Block']['key'];
			if (! $this->Bbs->save(null, false)) {
				// @codeCoverageIgnoreStart
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				// @codeCoverageIgnoreEnd
			}

			$this->data['BbsSetting']['bbs_key'] = $block['Block']['key'];
			if (! $this->save(null, false)) {
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
	public function validateBbsSetting($data) {
		$this->set($data);
		$this->validates();
		return $this->validationErrors ? false : true;
	}

}
