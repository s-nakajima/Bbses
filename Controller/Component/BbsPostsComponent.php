<?php
/**
 * BbsPosts Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Component', 'Controller');

/**
 * BbsPosts Component
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Files\Controller\Component
 */
class BbsPostsComponent extends Component {

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
 * paginatorSettings
 *
 * @return void
 */
	public function paginatorSettings() {
		//言語の指定
		$this->controller->BbsPost->bindModel(array('hasMany' => array(
				'BbsPostI18n' => array(
					'foreignKey' => 'bbs_post_id',
					'limit' => 1,
					'order' => 'BbsPostI18n.id DESC',
					'conditions' => array(
						'BbsPostI18n.language_id' => $this->controller->viewVars['languageId']
					)
				),
				'BbsPostsUser' => array(
					'foreignKey' => 'bbs_post_id',
					'conditions' => array(
						'BbsPostsUser.user_id' => (int)$this->controller->Auth->user('id')
					)
				),
			)),
			false
		);
		//条件
		$conditions = array(
			'BbsPost.bbs_key' => $this->controller->viewVars['bbs']['key'],
			'BbsPost.parent_id' => null,
		);
		if (isset($this->controller->params['named']['status'])) {
			$conditions['BbsPost.last_status'] = (int)$this->controller->params['named']['status'];
		}
		//ソート
		if (isset($this->controller->params['named']['sort']) && isset($this->controller->params['named']['direction'])) {
			$order = array($this->controller->params['named']['sort'] => $this->controller->params['named']['direction']);
		} else {
			$order = array('BbsPost.created' => 'desc');
		}
		//表示件数
		if (isset($this->controller->params['named']['limit'])) {
			$limit = (int)$this->controller->params['named']['limit'];
		} else {
			$limit = (int)$this->controller->viewVars['bbsFrameSetting']['articlesPerPage'];
		}

		//Paginatorの設定
		return array(
			'BbsPost' => array('conditions' => $conditions, 'order' => $order, 'limit' => $limit)
		);
	}

/**
 * initBbsPost
 *
 * @param array $contains Optional result sets
 * @return void
 */
	public function initBbsPost($contains = []) {
		if (! $bbsPost = $this->controller->BbsPost->find('first', array(
			'recursive' => 1,
			'conditions' => array(
				'BbsPost.id' => $this->controller->viewVars['bbsPostId'],
			)
		))) {
			$this->controller->throwBadRequest();
			return false;
		}
		$bbsPost = $this->controller->camelizeKeyRecursive($bbsPost);
		$this->controller->set(['currentBbsPost' => $bbsPost]);

		if ($bbsPost['bbsPost']['rootId'] > 0) {
			//コメント表示の場合、根記事を取得
			if (! $rootBbsPost = $this->controller->BbsPost->find('first', array(
				'recursive' => 1,
				'conditions' => array(
					'BbsPost.id' => $bbsPost['bbsPost']['rootId'],
				)
			))) {
				$this->controller->throwBadRequest();
				return false;
			}
			$rootBbsPost = $this->controller->camelizeKeyRecursive($rootBbsPost);
			$this->controller->set(['rootBbsPost' => $rootBbsPost]);
		}

		if ($bbsPost['bbsPost']['parentId'] > 0) {
			if ($bbsPost['bbsPost']['parentId'] !== $bbsPost['bbsPost']['rootId']) {
				//コメント表示の場合、根記事を取得
				if (! $parentBbsPost = $this->controller->BbsPost->find('first', array(
					'recursive' => 1,
					'conditions' => array(
						'BbsPost.id' => $bbsPost['bbsPost']['parentId'],
					)
				))) {
					$this->controller->throwBadRequest();
					return false;
				}
			} else {
				$parentBbsPost = $rootBbsPost;
			}
			$parentBbsPost = $this->controller->camelizeKeyRecursive($parentBbsPost);
			$this->controller->set(['parentBbsPost' => $parentBbsPost]);
		}

		//コメント
		if (in_array('comments', $contains, true)) {
			$comments = $this->controller->Comment->getComments(
				array(
					'plugin_key' => 'bbsposts',
					'content_key' => $bbsPost['bbsPost']['key']
				)
			);
			$comments = $this->controller->camelizeKeyRecursive($comments);
			$this->controller->set(['comments' => $comments]);
		}
	}

/**
 * saveBbsPost
 *
 * @param array $data received post data
 * @param string $containKey redirect key
 * @return bool true on success, false on error
 */
	public function saveBbsPost($data, $containKey) {
		$bbsPost = $this->controller->BbsPost->saveBbsPost($data);
		if ($this->controller->handleValidationError($this->controller->BbsPost->validationErrors)) {
			if (! $this->controller->request->is('ajax')) {
				$this->controller->redirect('/bbses/bbs_posts/view/' . $this->controller->viewVars['frameId'] . '/' . $bbsPost['BbsPost'][$containKey]);
			}
			return true;
		}
		return false;
	}

}
