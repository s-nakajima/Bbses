<?php
/**
 * BbsArticles Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Component', 'Controller');

/**
 * BbsArticles Component
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Controller\Component
 */
class BbsArticlesComponent extends Component {

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
	public function setConditions() {
		//条件
		$activeConditions = array(
			'BbsArticle.is_active' => true,
		);
		$latestConditons = array();

		if ($this->controller->viewVars['contentEditable']) {
			$activeConditions = array();
			$latestConditons = array(
				'BbsArticle.is_latest' => true,
			);
		} elseif ($this->controller->viewVars['contentCreatable']) {
			$activeConditions = array(
				'BbsArticle.is_active' => true,
				'BbsArticle.created_user !=' => $this->controller->viewVars['userId'],
			);
			$latestConditons = array(
				'BbsArticle.is_latest' => true,
				'BbsArticle.created_user' => $this->controller->viewVars['userId'],
			);
		}

		$conditions = array(
			'BbsArticle.bbs_id' => $this->controller->viewVars['bbs']['id'],
			'BbsArticle.language_id' => $this->controller->viewVars['languageId'],
			'OR' => array($activeConditions, $latestConditons)
		);

		return $conditions;
	}

/**
 * paginatorSettings
 *
 * @return void
 */
	public function paginatorSettings() {
		//条件
		$conditions = $this->setConditions();
		$conditions['BbsArticleTree.parent_id'] = null;

		//ソート
		if (isset($this->controller->params['named']['sort']) && isset($this->controller->params['named']['direction'])) {
			$order = array($this->controller->params['named']['sort'] => $this->controller->params['named']['direction']);
		} else {
			$order = array('BbsArticle.created' => 'desc');
		}
		//表示件数
		if (isset($this->controller->params['named']['limit'])) {
			$limit = (int)$this->controller->params['named']['limit'];
		} else {
			$limit = (int)$this->controller->viewVars['bbsFrameSetting']['articlesPerPage'];
		}

		//Paginatorの設定
		return array(
			'BbsArticle' => array('conditions' => $conditions, 'order' => $order, 'limit' => $limit)
		);
	}

/**
 * View set BbsArticle
 *
 * @param string $bbsArticleKey bbs_articles.key
 * @param array $contains Optional result sets
 * @return void
 */
	public function setBbsArticle($bbsArticleKey, $contains = []) {
		//カレントの記事を取得
		$conditions = $this->setConditions();
		$this->controller->BbsArticle->bindModelBbsArticlesUser($this->controller->viewVars['userId']);
		$bbsArticle = $this->controller->BbsArticle->getBbsArticle(
			$bbsArticleKey,
			$conditions
		);
		if (! $bbsArticle) {
			$this->controller->throwBadRequest();
			return false;
		}
		$bbsArticle = $this->controller->camelizeKeyRecursive($bbsArticle);
		$this->controller->set(['currentBbsArticle' => $bbsArticle]);

		//子記事の場合、根記事を取得する
		if (in_array('rootBbsArticle', $contains, true)) {
			$this->__setRootBbsArticle($bbsArticle);
		}

		//子記事の場合、親記事を取得する
		if (in_array('parentBbsArticle', $contains, true)) {
			$this->__setParentBbsArticle($bbsArticle);
		}
	}

/**
 * View set root BbsArticle
 *
 * @param object $bbsArticle bbs_articles data
 * @return void
 */
	private function __setRootBbsArticle($bbsArticle) {
		//子記事の場合、根記事を取得する
		if ($bbsArticle['bbsArticleTree']['rootId'] > 0) {
			$conditions = $this->setConditions();

			$this->controller->BbsArticle->bindModelBbsArticlesUser($this->controller->viewVars['userId']);
			$rootBbsArticle = $this->controller->BbsArticle->getBbsArticleByTreeId(
				$bbsArticle['bbsArticleTree']['rootId'],
				$conditions
			);

			if (! $rootBbsArticle) {
				$this->controller->throwBadRequest();
				return false;
			}
			$rootBbsArticle = $this->controller->camelizeKeyRecursive($rootBbsArticle);
			$this->controller->set(['rootBbsArticle' => $rootBbsArticle]);
		}
	}

/**
 * View set root BbsArticle
 *
 * @param object $bbsArticle bbs_articles data
 * @return void
 */
	private function __setParentBbsArticle($bbsArticle) {
		//子記事の場合、親記事を取得する
		if ($bbsArticle['bbsArticleTree']['parentId'] > 0) {
			$conditions = $this->setConditions();

			$parentBbsArticle = null;
			if ($bbsArticle['bbsArticleTree']['parentId'] !== $bbsArticle['bbsArticleTree']['rootId']) {
				$this->controller->BbsArticle->bindModelBbsArticlesUser($this->controller->viewVars['userId']);
				$parentBbsArticle = $this->controller->BbsArticle->getBbsArticleByTreeId(
					$bbsArticle['bbsArticleTree']['parentId'],
					$conditions
				);
				if (! $parentBbsArticle) {
					$this->controller->throwBadRequest();
					return false;
				}
			}
			if (! isset($parentBbsArticle) && isset($this->controller->viewVars['rootBbsArticle'])) {
				$parentBbsArticle = $this->controller->viewVars['rootBbsArticle'];
			}
			$parentBbsArticle = $this->controller->camelizeKeyRecursive($parentBbsArticle);
			$this->controller->set(['parentBbsArticle' => $parentBbsArticle]);
		}
	}

/**
 * saveBbsArticle
 *
 * @param array $data received post data
 * @param string $bbsArticleKey bbs_articles.key
 * @return bool true on success, false on error
 */
	public function saveBbsArticle($data, $bbsArticleKey = null) {
		$bbsArticle = $this->controller->BbsArticle->saveBbsArticle($data);
		if ($this->controller->handleValidationError($this->controller->BbsArticle->validationErrors)) {
			if ($this->controller->request->is('ajax')) {
				return true;
			}
			if (! isset($bbsArticleKey)) {
				$bbsArticleKey = $bbsArticle['BbsArticle']['key'];
			}

			$this->controller->redirect(
				'/bbses/bbs_articles/view/' .
				$this->controller->viewVars['frameId'] . '/' . $bbsArticleKey
			);
		}
		return false;
	}

}
