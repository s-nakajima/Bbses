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
		try {
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

			$conditions = array(
				'BbsPost.bbs_key' => $this->controller->viewVars['bbs']['key'],
				'BbsPost.parent_id' => null,
			);

			if (isset($this->controller->params['named']['status'])) {
				$conditions['BbsPost.last_status'] = (int)$this->controller->params['named']['status'];
			}

			$this->Paginator->settings = array(
				'BbsPost' => array(
					'conditions' => $conditions,
					'order' => isset($this->controller->params['named']['sort']) && isset($this->controller->params['named']['direction']) ?
									array($this->controller->params['named']['sort'] => $this->controller->params['named']['direction']) : array('BbsPost.created' => 'desc'),
					//'limit' => 1,
					'limit' => isset($this->controller->params['named']['limit']) ?
									(int)$this->controller->params['named']['limit'] : $this->controller->viewVars['bbsFrameSetting']['postsPerPage']
				)
			);
			return $this->Paginator->paginate('BbsPost');

		} catch (Exception $ex) {
			$this->controller->params['named'] = array();
			$this->controller->redirect('/bbses/bbs_posts/index/' . $this->controller->viewVars['frameId']);
		}
	}
}
