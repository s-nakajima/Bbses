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
	//public $belongsTo = array(
	//	'Bbs' => array(
	//		'className' => 'Bbses.Bbs',
	//		'foreignKey' => 'bbs_key',
	//		'conditions' => '',
	//		'fields' => '',
	//		'order' => ''
	//	),
	//);

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
 * get bbs data
 *
 * @param int $userId users.id
 * @param bool $contentEditable true can edit the content, false not can edit the content.
 * @param bool $contentCreatable true can create the content, false not can create the content.
 * @param array $conditions databese find condition
 * @return array
 */
	//public function getOnePosts($userId, $contentEditable, $contentCreatable, $conditions) {
	//	if (! $conditions['id']) {
	//		return;
	//	}
	//
	//	//作成権限まで
	//	if ($contentCreatable && ! $contentEditable) {
	//		//自分で書いた記事と公開中の記事を取得
	//		$conditions['or']['created_user'] = $userId;
	//		$conditions['or']['status'] = NetCommonsBlockComponent::STATUS_PUBLISHED;
	//	}
	//
	//	//作成・編集権限なし:公開中の記事のみ取得
	//	if (! $contentCreatable && ! $contentEditable) {
	//		$conditions['status'] = NetCommonsBlockComponent::STATUS_PUBLISHED;
	//	}
	//
	//	//対象記事のみ取得
	//	if (! $bbsPosts = $this->find('first', array(
	//			'recursive' => -1,
	//			'conditions' => $conditions,
	//	))) {
	//		return false;
	//
	//	}
	//
	//	return $bbsPosts;
	//}

/**
 * get bbs data
 *
 * @param int $userId users.id
 * @param bool $contentEditable true can edit the content, false not can edit the content.
 * @param bool $contentCreatable true can create the content, false not can create the content.
 * @param array $sortOrder databese find condition
 * @param int $visiblePostRow databese find condition
 * @param int $currentPage databese find condition
 * @param array $conditions databese find condition
 * @return array
 */
	//public function getPosts($userId, $contentEditable, $contentCreatable,
	//			$sortOrder = '', $visiblePostRow = '', $currentPage = '', $conditions = '') {
	//	//他人の編集中の記事・コメントが見れない人
	//	if ($contentCreatable && ! $contentEditable) {
	//		$conditions['or']['status'] = NetCommonsBlockComponent::STATUS_PUBLISHED;
	//		$conditions['or']['and']['created_user'] = $userId;
	//		$conditions['or']['and']['status <>'] = NetCommonsBlockComponent::STATUS_PUBLISHED;
	//	}
	//
	//	//公開中の記事・コメントしか見れない人
	//	if (! $contentCreatable && ! $contentEditable) {
	//		$conditions['status'] = NetCommonsBlockComponent::STATUS_PUBLISHED;
	//	}
	//
	//	//記事一覧取得
	//	$group = array('BbsPost.key');
	//	$params = array(
	//			'conditions' => $conditions,
	//			'recursive' => -1,
	//			'order' => $sortOrder,
	//			'group' => $group,
	//			'limit' => $visiblePostRow,
	//			'page' => $currentPage,
	//		);
	//
	//	if (! $bbsPosts = $this->find('all', $params)) {
	//		return false;
	//	}
	//
	//	return $bbsPosts;
	//}

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
			//var_dump($data);

			if (! $this->validateBbsPost($data)) {
				return false;
			}
			if (! $this->BbsPostI18n->validateBbsPostI18n($data)) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->BbsPostI18n->validationErrors);
				return false;
			}
			if (! $this->Comment->validateByStatus($data, array('caller' => 'BbsPostI18n'))) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->Comment->validationErrors);
				return false;
			}

			//BbsPost登録処理
			$bbsPost = $this->save(null, false);
			if (! $bbsPost) {
				// @codeCoverageIgnoreStart
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error 1'));
				// @codeCoverageIgnoreEnd
			}

			//BbsPostI18n登録処理
			$this->BbsPostI18n->data['BbsPostI18n']['bbs_post_id'] = $this->id;
			if (! $this->BbsPostI18n->save(null, false)) {
				// @codeCoverageIgnoreStart
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error 2'));
				// @codeCoverageIgnoreEnd
			}

			//コメントの登録
			if ($this->Comment->data) {
				if (! $this->Comment->save(null, false)) {
					// @codeCoverageIgnoreStart
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error 3'));
					// @codeCoverageIgnoreEnd
				}
			}
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
 * Get rss reader
 *
 * @param int $blockId blocks.id
 * @param bool $contentEditable true can edit the content, false not can edit the content.
 * @return array $rssReader
 */
	public function getMaxNo($rootPostId) {
		if (! $rootPostId) {
			return 0;
		}

		$bbsPost = $this->find('first', array(
			'recursive' => -1,
			'fields' => 'post_no',
			'conditions' => array('root_id' => $rootPostId),
			'order' => 'BbsPost.post_no DESC',
		));

		return isset($bbsPost['BbsPost']['post_no']) ? $bbsPost['BbsPost']['post_no'] : 0;
	}

/**
 * save posts
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	//public function saveComment($data) {
	//	$this->loadModels([
	//		'BbsPost' => 'Bbses.BbsPost',
	//	]);
	//
	//	//トランザクションBegin
	//	$dataSource = $this->getDataSource();
	//	$dataSource->begin();
	//	try {
	//		if (!$this->validatePost($data)) {
	//			return false;
	//		}
	//
	//		$comments = $this->save(null, false);
	//
	//		if (! $comments) {
	//			// @codeCoverageIgnoreStart
	//			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
	//			// @codeCoverageIgnoreEnd
	//		}
	//
	//		//トランザクションCommit
	//		$dataSource->commit();
	//	} catch (Exception $ex) {
	//		//トランザクションRollback
	//		$dataSource->rollback();
	//		//エラー出力
	//		CakeLog::write(LOG_ERR, $ex);
	//		throw $ex;
	//	}
	//	return $comments;
	//}

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