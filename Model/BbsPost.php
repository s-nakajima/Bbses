<?php
/**
 * BbsPost Model
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
 * BbsPost Model
 *
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @package NetCommons\Bbses\Model
 */
class BbsPost extends BbsesAppModel {

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'Tree',
		'Likes.Like'
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'CreatedUser' => array(
			'className' => 'Users.UserAttributesUser',
			'foreignKey' => false,
			'conditions' => array(
				'BbsPost.created_user = CreatedUser.user_id',
				'CreatedUser.key' => 'nickname'
			),
			'fields' => array('CreatedUser.key', 'CreatedUser.value'),
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'BbsPostI18n' => array(
			'className' => 'Bbses.BbsPostI18n',
			'foreignKey' => 'bbs_post_id',
			'limit' => 1,
			'order' => 'BbsPostI18n.id DESC',
			'dependent' => true,
		),
		'BbsPostsUser' => array(
			'className' => 'Bbses.BbsPostsUser',
			'foreignKey' => 'bbs_post_id',
			'dependent' => true,
		),
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
			'key' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => __d('net_commons', 'Invalid request.'),
					'required' => true,
				)
			),
			'bbs_key' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => __d('net_commons', 'Invalid request.'),
					'required' => true,
				)
			),
		));
		return parent::beforeValidate($options);
	}

/**
 * Called after each find operation. Can be used to modify any results returned by find().
 * Return value should be the (modified) results.
 *
 * @param mixed $results The results of the find operation
 * @param bool $primary Whether this model is being queried directly (vs. being queried as an association)
 * @return mixed Result of the find operation
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#afterfind
 */
	public function afterFind($results, $primary = false) {
		foreach ($results as $i => $result) {
			if (isset($result['BbsPostI18n'][0])) {
				$bbsPostI18n = $result['BbsPostI18n'][0];
				unset($results[$i]['BbsPostI18n'][0]);
				$results[$i]['BbsPostI18n'] = $bbsPostI18n;
			}
		}
		return $results;
	}

/**
 * save posts
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function saveBbsPost($data) {
		$this->loadModels([
			'BbsPost' => 'Bbses.BbsPost',
			'BbsPostI18n' => 'Bbses.BbsPostI18n',
			'Comment' => 'Comments.Comment',
		]);

		//トランザクションBegin
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		try {
			if (! $this->validateBbsPost($data)) {
				return false;
			}
			if (! $this->BbsPostI18n->validateBbsPostI18n($data)) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->BbsPostI18n->validationErrors);
				return false;
			}

			if (isset($data['Comment'])) {
				$data['BbsPost']['status'] = $data['BbsPostI18n']['status'];
				if (! $this->Comment->validateByStatus($data, array('caller' => 'BbsPost'))) {
					$this->validationErrors = Hash::merge($this->validationErrors, $this->Comment->validationErrors);
					return false;
				}
			}

			//BbsPost登録処理
			$bbsPost = $this->save(null, false);
			if (! $bbsPost) {
				// @codeCoverageIgnoreStart
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				// @codeCoverageIgnoreEnd
			}

			//BbsPostI18n登録処理
			$this->BbsPostI18n->data['BbsPostI18n']['bbs_post_id'] = $this->id;
			if (! $this->BbsPostI18n->save(null, false)) {
				// @codeCoverageIgnoreStart
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				// @codeCoverageIgnoreEnd
			}

			//コメントの登録
			if (isset($data['Comment']) && $this->Comment->data) {
				if (! $this->Comment->save(null, false)) {
					// @codeCoverageIgnoreStart
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
					// @codeCoverageIgnoreEnd
				}
			}

			//コメント数の更新
			$this->__updateCommentCounts($data['BbsPost']['root_id'], $data['BbsPostI18n']['status']);

			//トランザクションCommit
			$dataSource->commit();
		} catch (Exception $ex) {
			//トランザクションRollback
			$dataSource->rollback();
			//エラー出力
			CakeLog::write(LOG_ERR, $ex);
			throw $ex;
		}
		return $bbsPost;
	}

/**
 * save posts
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function saveCommentAsPublish($data) {
		$this->loadModels([
			'BbsPost' => 'Bbses.BbsPost',
			'BbsPostI18n' => 'Bbses.BbsPostI18n',
		]);

		//トランザクションBegin
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		try {
			//BbsPost登録処理
			$this->id = (int)$data['BbsPost']['id'];
			if (! $this->saveField('last_status', $data['BbsPost']['last_status'], false)) {
				// @codeCoverageIgnoreStart
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				// @codeCoverageIgnoreEnd
			}

			//BbsPostI18n登録処理
			$this->BbsPostI18n->id = (int)$data['BbsPostI18n']['id'];
			if (! $this->BbsPostI18n->saveField('status', $data['BbsPostI18n']['status'], false)) {
				// @codeCoverageIgnoreStart
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				// @codeCoverageIgnoreEnd
			}

			//コメント数の更新
			$this->__updateCommentCounts($data['BbsPost']['root_id'], $data['BbsPostI18n']['status']);

			//トランザクションCommit
			$dataSource->commit();
		} catch (Exception $ex) {
			//トランザクションRollback
			$dataSource->rollback();
			//エラー出力
			CakeLog::write(LOG_ERR, $ex);
			throw $ex;
		}
		return true;
	}

/**
 * Update published_comment_counts
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	private function __updateCommentCounts($rootId, $status, $increment = 1) {
		if ((int)$rootId > 0 && (int)$status === (int)NetCommonsBlockComponent::STATUS_PUBLISHED) {
			if (! $this->updateAll(
					array('BbsPost.published_comment_counts' => 'BbsPost.published_comment_counts + (' . $increment . ')'),
					array('BbsPost.id' => (int)$rootId)
			)) {
				// @codeCoverageIgnoreStart
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				// @codeCoverageIgnoreEnd
			}
		}
	}

/**
 * Delete posts
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function deleteBbsPost($data) {
		$this->loadModels([
			'BbsPost' => 'Bbses.BbsPost',
			'BbsPostI18n' => 'Bbses.BbsPostI18n',
			'Comment' => 'Comments.Comment',
		]);

		//トランザクションBegin
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			if (! $this->deleteAll(array($this->alias . '.key' => $data['BbsPost']['key']), true, true)) {
				// @codeCoverageIgnoreStart
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				// @codeCoverageIgnoreEnd
			}

			//コメント数の更新
			$this->__updateCommentCounts($data['BbsPost']['root_id'], $data['BbsPost']['last_status'], -1);

			//トランザクションCommit
			$dataSource->commit();
		} catch (Exception $ex) {
			//トランザクションRollback
			$dataSource->rollback();
			//エラー出力
			CakeLog::write(LOG_ERR, $ex);
			throw $ex;
		}

		return true;
	}

/**
 * Get rss reader
 *
 * @param int $rootPostId root post id
 * @return int number
 */
	public function getMaxNo($rootPostId) {
		if (! $rootPostId) {
			return 0;
		}

		$bbsPost = $this->find('first', array(
			'recursive' => -1,
			'fields' => 'post_no',
			'conditions' => array(
				'OR' => array(
					'root_id' => $rootPostId,
					'id' => $rootPostId
				)
			),
			'order' => 'BbsPost.post_no DESC',
		));

		return isset($bbsPost['BbsPost']['post_no']) ? $bbsPost['BbsPost']['post_no'] : 0;
	}

/**
 * validate BbsPost
 *
 * @param array $data received post data
 * @return bool|array True on success, validation errors array on error
 */
	public function validateBbsPost($data) {
		$this->set($data);
		$this->validates();
		return $this->validationErrors ? false : true;
	}

}
