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
//		'Language' => array(
//			'className' => 'Language',
//			'foreignKey' => 'language_id',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'User' => array(
			'className' => 'Users.User',
			'joinTable' => 'bbs_articles_users',
			'foreignKey' => 'bbs_article_id',
			'associationForeignKey' => 'user_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
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

}
