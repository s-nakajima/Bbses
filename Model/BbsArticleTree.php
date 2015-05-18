<?php
/**
 * BbsArticleTree Model
 *
 * @property Root $Root
 * @property BbsArticleTree $ParentBbsArticleTree
 * @property BbsArticleTree $ChildBbsArticleTree
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BbsesAppModel', 'Bbses.Model');

/**
 * BbsArticleTree Model
 *
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @package NetCommons\Bbses\Model
 */
class BbsArticleTree extends BbsesAppModel {

/**
 * Behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'Tree',
		'Likes.Like' => array(
			'model' => 'BbsArticle'
		),
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
		'BbsArticle' => array(
			'className' => 'Bbses.BbsArticle',
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
		),
		//'ParentBbsArticleTree' => array(
		//	'className' => 'Bbses.BbsArticleTree',
		//	'foreignKey' => 'parent_id',
		//	'conditions' => '',
		//	'fields' => '',
		//	'order' => ''
		//)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		//'ChildBbsArticleTree' => array(
		//	'className' => 'Bbses.BbsArticleTree',
		//	'foreignKey' => 'parent_id',
		//	'dependent' => false,
		//	'conditions' => '',
		//	'fields' => '',
		//	'order' => '',
		//	'limit' => '',
		//	'offset' => '',
		//	'exclusive' => '',
		//	'finderQuery' => '',
		//	'counterQuery' => ''
		//)
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
			'bbs_key' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => __d('net_commons', 'Invalid request.'),
					'required' => true,
				),
			),
			'bbs_article_key' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => __d('net_commons', 'Invalid request.'),
					'on' => 'update', // Limit validation to 'create' or 'update' operations
				),
			),
			'lft' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'rght' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'article_no' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
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
					'BbsArticlesUser.bbs_article_key=BbsArticleTree.bbs_article_key',
					'BbsArticlesUser.user_id' => $userId
				)
			),
		)), false);
	}

/**
 * Set unbindModel BbsArticleTree
 *
 * @return void
 */
	public function unbindModelBbsArticleTree() {
		$this->unbindModel(
			array('belongsTo' => array_keys($this->belongsTo),
		), true);
	}

/**
 * Get max article no
 *
 * @param int $rootArticleTreeId root article id
 * @return int number
 */
	public function getMaxNo($rootArticleTreeId) {
		if (! $rootArticleTreeId) {
			return 0;
		}

		$bbsArticleTree = $this->find('first', array(
			'recursive' => -1,
			'fields' => 'article_no',
			'conditions' => array(
				'OR' => array(
					'root_id' => $rootArticleTreeId,
					'id' => $rootArticleTreeId
				)
			),
			'order' => $this->alias . '.article_no DESC',
		));

		return isset($bbsArticleTree[$this->alias]['article_no']) ? $bbsArticleTree[$this->alias]['article_no'] : 0;
	}

/**
 * Update published_comment_counts
 *
 * @param int $rootId RootId for bbs posts
 * @param int $status status
 * @param int $increment increment
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function updateCommentCounts($rootId, $status, $increment = 1) {
		if ((int)$rootId > 0 && (int)$status === (int)NetCommonsBlockComponent::STATUS_PUBLISHED) {
			if (! $this->updateAll(
					array('BbsArticleTree.published_comment_count' => 'BbsArticleTree.published_comment_count + (' . (int)$increment . ')'),
					array('BbsArticleTree.id' => (int)$rootId)
			)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}
	}

/**
 * Validate BbsArticleTree
 *
 * @param array $data received post data
 * @return bool|array True on success, validation errors array on error
 */
	public function validateBbsArticleTree($data) {
		$this->set($data);
		$this->validates();
		if ($this->validationErrors) {
			return false;
		}
		return true;
	}

}
