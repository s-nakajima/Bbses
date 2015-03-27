<?php
/**
 * BbsPostsPaginator Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Component', 'Controller');

/**
 * BbsPostsPaginator Component
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Files\Controller\Component
 */
class BbsPaginatorComponent extends Component {

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'Paginator',
	);

/**
 * Called before the Controller::beforeFilter().
 *
 * @param Controller $controller Instantiating controller
 * @return void
 */
	public function initialize(Controller $controller) {
		$this->controller = $controller;
	}

/**
 * paginate
 *
 * @param string $model Model name.
 * @param string $field Request parameter name.
 * @return void
 */
	public function rootBbsPosts() {
//		var_dump($this->controller->params);


		$this->controller->BbsPost->bindModel(array('hasMany' => array(
				'BbsPostI18n' => array(
					'foreignKey' => 'bbs_post_id',
					'limit' => 1,
					'order' => 'BbsPostI18n.id DESC',
					'conditions' => array(
						'BbsPostI18n.language_id' => $this->controller->viewVars['languageId']
					)
				)
			)),
			false
		);

		$this->Paginator->settings = array(
			'BbsPost' => array(
				'conditions' => array(
					'BbsPost.bbs_key' => $this->controller->viewVars['bbs']['key'],
					'BbsPost.parent_id' => null,
				),
				'order' => array('BbsPost.id' => 'desc'),
				//'limit' => $this->controller->viewVars['bbsFrameSetting']['postsPerPage']
				'limit' => isset($this->controller->params['named']['limit']) ?
								(int)$this->controller->params['named']['limit'] : $this->controller->viewVars['bbsFrameSetting']['postsPerPage']
			)
		);
		return $this->Paginator->paginate('BbsPost');
	}
}
