<?php
/**
 * BbsArticleTree Model
 *
 * @property Root $Root
 * @property BbsArticleTree $ParentBbsArticleTree
 * @property BbsArticleTree $ChildBbsArticleTree
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BbsesAppModel', 'Bbses.Model');

/**
 * BbsArticleTree Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
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
		'Bbses.BbsArticle',
		'Bbses.BbsArticlesUser',
		'Likes.Like' => array(
			'field' => 'bbs_article_key'
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
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
					'required' => true,
				),
			),
			'bbs_article_key' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
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

		if (isset($bbsArticleTree[$this->alias]['article_no'])) {
			return $bbsArticleTree[$this->alias]['article_no'];
		} else {
			return '0';
		}
	}

}
