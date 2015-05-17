<?php
/**
 * BbsArticle Model
 *
 * @property Bbs $Bbs
 * @property Language $Language
 * @property User $User
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('BbsesAppModel', 'Bbses.Model');

/**
 * Summary for BbsArticle Model
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
			'className' => 'Users.UserAttributesUser',
			'foreignKey' => false,
			'conditions' => array(
				'BbsArticle.created_user = CreatedUser.user_id',
				'CreatedUser.key' => 'nickname'
			),
			'fields' => array('CreatedUser.key', 'CreatedUser.value'),
			'order' => ''
		)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
//	public $hasAndBelongsToMany = array(
//		'User' => array(
//			'className' => 'Users.User',
//			'joinTable' => 'bbs_articles_users',
//			'foreignKey' => 'BbsArticlesUser.bbs_article_key=BbsArticle.key',
//			'associationForeignKey' => 'user_id',
//			'unique' => 'keepExisting',
//			'conditions' => '',
//			'fields' => '',
//			'order' => '',
//			'limit' => '',
//			'offset' => '',
//			'finderQuery' => '',
//		)
//	);

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
					'required'
					=> true
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
			)),
			false
		);
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
 * Save article
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function saveBbsArticle($data) {
		$this->loadModels([
			'BbsArticle' => 'Bbses.BbsArticle',
			'BbsArticle' => 'Bbses.BbsArticleTree',
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
				if (! $this->Comment->save(null, false)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
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

}
