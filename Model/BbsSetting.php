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
