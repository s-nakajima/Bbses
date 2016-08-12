<?php
/**
 * TestBbsArticleBehavior Model
 *
 * @property TestBbsArticle $testBbsArticle
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppModel', 'Model');
App::uses('BbsesAppModel', 'Bbses.Model');
App::uses('Bbs', 'Bbses.Model');
App::uses('BbsArticle', 'Bbses.Model');
App::uses('BbsArticleTree', 'Bbses.Model');

/**
 * TestBbsArticle Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Test\test_app\TestBbsArticle\Model
 */
class TestBbsArticle extends BbsArticle {

/**
 * name
 *
 * @var string
 */
	public $name = 'BbsArticle';

/**
 * alias
 *
 * @var string
 */
	public $alias = 'BbsArticle';

/**
 * Custom database table name
 *
 * @var string
 */
	public $useTable = 'bbs_articles';

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'Bbses.BbsArticle',
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'BbsArticleTree' => array(
			'type' => 'INNER',
			'className' => 'Bbses.BbsArticleTree',
			'foreignKey' => false,
			'conditions' => 'BbsArticleTree.bbs_article_key=BbsArticle.key',
			'fields' => '',
			'order' => ''
		),
	);

/**
 * Update bbs_article_modified
 *
 * @param int $bbsId bbses.id
 * @param string $bbsKey bbses.key
 * @param int $languageId languages.id
 */
	public function testUpdateBbsByBbsArticle($bbsId, $bbsKey, $languageId) {
		$this->loadModels([
			'Bbs' => 'Bbses.Bbs',
			'BbsArticle' => 'Bbses.BbsArticle',
			'BbsArticleTree' => 'Bbses.BbsArticleTree',
		]);

		$this->updateBbsByBbsArticle($bbsId, $bbsKey, $languageId);
	}

/**
 * Update bbs_article_child_count
 *
 * @param int $rootId RootId for root BbsArticle
 * @param int $languageId languages.id
 */
	public function testUpdateBbsArticleChildCount($rootId, $languageId) {
		$this->loadModels([
			'Bbs' => 'Bbses.Bbs',
			'BbsArticle' => 'Bbses.BbsArticle',
			'BbsArticleTree' => 'Bbses.BbsArticleTree',
		]);

		$this->updateBbsArticleChildCount($rootId, $languageId);
	}

}
