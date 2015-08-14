<?php
/**
 * BbsArticle Model
 *
 * @property Bbs $Bbs
 * @property Language $Language
 * @property User $User
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BbsesAppModel', 'Bbses.Model');

/**
 * BbsArticle Model
 *
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @package NetCommons\Bbses\Model
 */
class BbsArticle extends BbsesAppModel {

/**
 * Max length of title
 *
 * @var int
 */
	const BREADCRUMB_TITLE_LENGTH = 20;

/**
 * Max length of title
 *
 * @var int
 */
	const LIST_TITLE_LENGTH = 50;

/**
 * Max length of content
 *
 * @var int
 */
	const LIST_CONTENT_LENGTH = 100;

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'NetCommons.Publishable',
		'NetCommons.OriginalKey',
		'Likes.Like'
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Bbs' => array(
			'className' => 'Bbses.Bbs',
			'foreignKey' => 'bbs_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'BbsArticleTree' => array(
			'className' => 'Bbses.BbsArticleTree',
			'foreignKey' => false,
			'conditions' => 'BbsArticleTree.bbs_article_key=BbsArticle.key',
			'fields' => '',
			'order' => ''
		),
		'CreatedUser' => array(
			'className' => 'Users.User',
			'foreignKey' => false,
			'conditions' => 'BbsArticle.created_user = CreatedUser.id',
			'fields' => 'CreatedUser.handlename',
			'order' => ''
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
			'title' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('bbses', 'Title')),
					'required' => true
				),
			),
			'content' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('bbses', 'Content')),
					'required' => true
				),
			),

			//status to set in PublishableBehavior.

		));
		return parent::beforeValidate($options);
	}

/**
 * Set bindModel BbsArticlesUser
 *
 * @param int $userId users.id
 * @return void
 */
	public function bindModelBbsArticlesUser($userId) {
		$this->bindModel(array('belongsTo' => array(
			'BbsArticlesUser' => array(
				'className' => 'Bbses.BbsArticlesUser',
				'foreignKey' => false,
				'conditions' => array(
					'BbsArticlesUser.bbs_article_key=BbsArticle.key',
					'BbsArticlesUser.user_id' => $userId
				)
			),
		)), true);
	}

/**
 * Get BbsArticles
 *
 * @param array $conditions findAll conditions
 * @return array BbsArticles
 */
	public function getBbsArticles($conditions) {
		$bbsArticles = $this->find('all', array(
				'recursive' => 0,
				'conditions' => $conditions,
			)
		);
		return $bbsArticles;
	}

/**
 * Get BbsArticle
 *
 * @param string $bbsArticleKey bbs_article.key
 * @param array $conditions find conditions
 * @return array BbsArticle
 */
	public function getBbsArticle($bbsArticleKey, $conditions = []) {
		$conditions[$this->alias . '.key'] = $bbsArticleKey;

		$bbsArticle = $this->find('first', array(
				'recursive' => 0,
				'conditions' => $conditions,
			)
		);

		return $bbsArticle;
	}

/**
 * Get BbsArticle by bbs_article_trees.id
 *
 * @param id $bbsArticleTreeId bbs_article_trees.id
 * @param array $conditions find conditions
 * @return array BbsArticle
 */
	public function getBbsArticleByTreeId($bbsArticleTreeId, $conditions = []) {
		$conditions['BbsArticleTree.id'] = $bbsArticleTreeId;

		$bbsArticle = $this->find('first', array(
				'recursive' => 0,
				'conditions' => $conditions,
			)
		);

		return $bbsArticle;
	}

/**
 * Save article
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function saveBbsArticle($data) {
		$this->loadModels([
			'Bbs' => 'Bbses.Bbs',
			'BbsArticle' => 'Bbses.BbsArticle',
			'BbsArticleTree' => 'Bbses.BbsArticleTree',
			'Comment' => 'Comments.Comment',
		]);

		//トランザクションBegin
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			if (! $this->validateBbsArticle($data, ['bbsArticleTree', 'comment'])) {
				return false;
			}

			//BbsArticle登録処理
			if (! $bbsArticle = $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//BbsArticleTree登録処理
			$this->BbsArticleTree->data['BbsArticleTree']['bbs_article_key'] = $bbsArticle[$this->alias]['key'];
			if (! $this->BbsArticleTree->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//コメントの登録
			if (isset($data['Comment']) && $this->Comment->data) {
				$this->Comment->data[$this->Comment->name]['block_key'] = $data['Block']['key'];
				$this->Comment->data[$this->Comment->name]['content_key'] = $bbsArticle[$this->alias]['key'];
				if (! $this->Comment->save(null, false)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
			}

			//Bbsのarticle_count、article_modified
			$this->Bbs->updateBbsArticle($data['Bbs']['id'], $data['Bbs']['key'], $data['BbsArticle']['language_id']);

			//コメント数の更新
			$this->BbsArticleTree->updateCommentCounts($data['BbsArticleTree']['root_id'], $data['BbsArticle']['status']);

			//トランザクションCommit
			$dataSource->commit();
		} catch (Exception $ex) {
			//トランザクションRollback
			$dataSource->rollback();
			//エラー出力
			CakeLog::error($ex);
			throw $ex;
		}
		return $bbsArticle;
	}

/**
 * Validate BbsArticle
 *
 * @param array $data received post data
 * @param array $contains Optional validate sets
 * @return bool True on success, false on validation error
 */
	public function validateBbsArticle($data, $contains = []) {
		$this->set($data);
		$this->validates();
		if ($this->validationErrors) {
			return false;
		}

		if (in_array('bbsArticleTree', $contains, true)) {
			if (! $this->BbsArticleTree->validateBbsArticleTree($data)) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->BbsArticleTree->validationErrors);
				return false;
			}
		}

		if (in_array('comment', $contains, true) && isset($data['Comment'])) {
			if (! $this->Comment->validateByStatus($data, array('plugin' => $this->plugin, 'caller' => $this->name))) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->Comment->validationErrors);
				return false;
			}
		}

		return true;
	}

/**
 * Delete posts
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function deleteBbsArticle($data) {
		$this->loadModels([
			'Bbs' => 'Bbses.Bbs',
			'BbsArticle' => 'Bbses.BbsArticle',
			'BbsArticleTree' => 'Bbses.BbsArticleTree',
			'Comment' => 'Comments.Comment',
		]);

		//トランザクションBegin
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			//BbsArticleの削除
			if (! $this->deleteAll(array($this->alias . '.key' => $data['BbsArticle']['key']), false, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//Treeデータの削除
			$this->BbsArticleTree->unbindModelBbsArticleTree();
			if (! $this->BbsArticleTree->deleteAll(array($this->BbsArticleTree->alias . '.bbs_article_key' => $data['BbsArticle']['key']), false, true)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//コメントの削除
			$this->Comment->deleteByContentKey($data['BbsArticle']['key']);

			//Bbsのarticle_count、article_modified
			$this->Bbs->updateBbsArticle($data['Bbs']['id'], $data['Bbs']['key'], $data['BbsArticle']['language_id']);

			//コメント数の更新
			$this->BbsArticleTree->updateCommentCounts($data['BbsArticleTree']['root_id'], $data['BbsArticle']['status'], -1);

			//トランザクションCommit
			$dataSource->commit();
		} catch (Exception $ex) {
			//トランザクションRollback
			$dataSource->rollback();
			//エラー出力
			CakeLog::error($ex);
			throw $ex;
		}

		return true;
	}

/**
 * Save comment as publish
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function saveCommentAsPublish($data) {
		$this->loadModels([
			'BbsArticle' => 'Bbses.BbsArticle',
			'BbsArticleTree' => 'Bbses.BbsArticleTree',
		]);

		//トランザクションBegin
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			//BbsArticle登録処理
			$this->id = (int)$data['BbsArticle']['id'];
			if (! $this->saveField('status', $data['BbsArticle']['status'], false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			if (! $this->saveField('is_active', true, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//コメント数の更新
			$this->BbsArticleTree->updateCommentCounts($data['BbsArticleTree']['root_id'], $data['BbsArticle']['status']);

			//トランザクションCommit
			$dataSource->commit();
		} catch (Exception $ex) {
			//トランザクションRollback
			$dataSource->rollback();
			//エラー出力
			CakeLog::error($ex);
			throw $ex;
		}
		return true;
	}

}
