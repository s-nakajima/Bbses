<?php
/**
 * BbsArticle Model
 *
 * @property Bbs $Bbs
 * @property Language $Language
 * @property User $User
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BbsesAppModel', 'Bbses.Model');

/**
 * BbsArticle Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
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
		'Bbses.BbsArticle',
		'Bbses.BbsArticlesUser',
		'Comments.Comment',
		'Likes.Like',
		'NetCommons.OriginalKey',
		'Workflow.Workflow',
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
//		'Bbs' => array(
//			'className' => 'Bbses.Bbs',
//			'foreignKey' => 'bbs_id',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		),
		'BbsArticleTree' => array(
			'type' => 'INNER',
			'className' => 'Bbses.BbsArticleTree',
			'foreignKey' => false,
			'conditions' => 'BbsArticleTree.bbs_article_key=BbsArticle.key',
			'fields' => '',
			'order' => ''
		),
//		'CreatedUser' => array(
//			'className' => 'Users.User',
//			'foreignKey' => false,
//			'conditions' => 'BbsArticle.created_user = CreatedUser.id',
//			'fields' => 'CreatedUser.handlename',
//			'order' => ''
//		)
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
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('bbses', 'Title')),
					'required' => true
				),
			),
			'content' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('bbses', 'Content')),
					'required' => true
				),
			),

			//status to set in PublishableBehavior.

		));

		if (! parent::beforeValidate($options)) {
			return false;
		}

		if (isset($this->data['BbsArticleTree'])) {
			$this->BbsArticleTree->set($this->data['BbsArticleTree']);
			if (! $this->BbsArticleTree->validates()) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->BbsArticleTree->validationErrors);
				return false;
			}
		}

		return true;
	}

/**
 * Called after each successful save operation.
 *
 * @param bool $created True if this save created a new record
 * @param array $options Options passed from Model::save().
 * @return void
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#aftersave
 * @see Model::save()
 */
	public function afterSave($created, $options = array()) {
		//BbsArticleTree登録
		if (isset($this->BbsArticleTree->data['BbsArticleTree'])) {
			if (! $this->BbsArticleTree->data['BbsArticleTree']['bbs_article_key']) {
				$this->BbsArticleTree->data['BbsArticleTree']['bbs_article_key'] = $this->data[$this->alias]['key'];
			}
			if (! $this->BbsArticleTree->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}

		//Bbsのbbs_article_count、bbs_article_modified
		if (isset($this->data['Bbs']['id']) && isset($this->data['Bbs']['key'])) {
			$this->updateBbsByBbsArticle($this->data['Bbs']['id'], $this->data['Bbs']['key'], $this->data[$this->alias]['language_id']);
		}

		//コメント数の更新
		if (isset($this->data['BbsArticleTree']['root_id']) && $this->data['BbsArticleTree']['root_id']) {
			$this->updateBbsArticleChildCount($this->data['BbsArticleTree']['root_id'], $this->data[$this->alias]['language_id']);
		}

		parent::afterSave($created, $options);
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
		]);

		//トランザクションBegin
		$this->begin();

		//バリデーション
		$this->set($data);
		if (! $this->validates()) {
			$this->rollback();
			return false;
		}

		try {
			//登録処理
			if (! $bbsArticle = $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return $bbsArticle;
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
		]);

		//トランザクションBegin
		$this->begin();
		$this->set($data);

		$bbsArticleTree = $this->BbsArticleTree->find('first', array(
			'recursive' => -1,
			'fields' => array('lft', 'rght'),
			'conditions' => array(
				'bbs_article_key' => $this->data['BbsArticle']['key']
			),
		));
		if (! $bbsArticleTree) {
			$this->rollback();
			return false;
		}
		$bbsArticleTrees = $this->BbsArticleTree->find('list', array(
			'recursive' => -1,
			'fields' => array('id', 'bbs_article_key'),
			'conditions' => array(
				'lft >=' => $bbsArticleTree['BbsArticleTree']['lft'],
				'rght <=' => $bbsArticleTree['BbsArticleTree']['rght'],
			),
		));

		try {
			//Treeデータの削除
			$conditions = array($this->BbsArticleTree->alias . '.bbs_article_key' => $this->data['BbsArticle']['key']);
			if (! $this->BbsArticleTree->deleteAll($conditions, false, true)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//BbsArticleの削除
			if (! $this->deleteAll(array($this->alias . '.key' => $bbsArticleTrees), false, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//コメントの削除
			$this->deleteCommentsByContentKey($this->data['BbsArticle']['key']);

			//Bbsのbbs_article_count、bbs_article_modified
			$this->updateBbsByBbsArticle($this->data['Bbs']['id'], $data['Bbs']['key'], $this->data['BbsArticle']['language_id']);

			//コメント数の更新
			$this->updateBbsArticleChildCount($this->data['BbsArticleTree']['root_id'], $this->data['BbsArticle']['language_id']);

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
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
		$this->begin();
		$this->set($data);

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
			$this->updateBbsArticleChildCount($data['BbsArticleTree']['root_id'], $data['BbsArticle']['language_id']);

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return true;
	}

}
