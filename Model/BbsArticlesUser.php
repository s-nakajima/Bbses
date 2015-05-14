<?php
/**
 * BbsArticlesUser Model
 *
 * @property BbsArticle $BbsArticle
 * @property User $User
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('BbsesAppModel', 'Bbses.Model');

/**
 * Summary for BbsArticlesUser Model
 */
class BbsArticlesUser extends BbsesAppModel {

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'master';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'BbsArticle' => array(
			'className' => 'BbsArticle',
			'foreignKey' => 'bbs_article_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
