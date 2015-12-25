<?php
/**
 * BbsArticle Behavior
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('ModelBehavior', 'Model');

/**
 * BbsArticle Behavior
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Categories\Model\Behavior
 */
class BbsArticleBehavior extends ModelBehavior {

/**
 * Update bbs_article_modified and bbs_article_count
 *
 * @param object $model instance of model
 * @param int $bbsId bbses.id
 * @param string $bbsKey bbses.key
 * @param int $languageId languages.id
 * @return bool True on success
 * @throws InternalErrorException
 */
	public function updateBbsByBbsArticle(Model $model, $bbsId, $bbsKey, $languageId) {
		$db = $model->getDataSource();

		$conditions = array(
			'bbs_id' => $bbsId,
			'language_id' => $languageId,
			'is_latest' => true
		);
		$count = $model->find('count', array(
			'recursive' => -1,
			'conditions' => $conditions,
		));
		if ($count === false) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		$article = $model->find('first', array(
			'recursive' => -1,
			'fields' => 'modified',
			'conditions' => $conditions,
			'order' => array('modified' => 'desc'),
		));
		if ($article === false) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		$update = array(
			'bbs_article_count' => $count
		);
		if ($article) {
			$update['bbs_article_modified'] = $db->value($article[$model->alias]['modified'], 'string');
		}

		if (! $model->Bbs->updateAll($update, array('Bbs.key' => $bbsKey))) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		return true;
	}

/**
 * Update bbs_article_child_count
 *
 * @param object $model instance of model
 * @param int $rootId RootId for root BbsArticle
 * @param int $languageId languages.id
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function updateBbsArticleChildCount(Model $model, $rootId, $languageId) {
		$rootId = (int)$rootId;

		$conditions = array(
			'BbsArticleTree.root_id' => $rootId,
			'BbsArticle.language_id' => $languageId,
			'BbsArticle.is_active' => true
		);
		$count = $model->find('count', array(
			'recursive' => 0,
			'conditions' => $conditions,
		));
		if ($count === false) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		$update = array('BbsArticleTree.bbs_article_child_count' => $count);
		$conditions = array('BbsArticleTree.id' => $rootId);
		if (! $model->updateAll($update, $conditions)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}
	}

/**
 * Title of reply
 *
 * @param object $model instance of model
 * @param string $title bbs_articles.title
 * @return string bbs_articles.title
 */
	public function getReplyTitle(Model $model, $title) {
		$matches = array();
		if (preg_match('/^Re(\d)?:/', $title, $matches)) {
			if (isset($matches[1])) {
				$count = (int)$matches[1];
			} else {
				$count = 1;
			}
			$result = preg_replace('/^Re(\d)?:/', 'Re' . ($count + 1) . ': ', $title);
		} else {
			$result = 'Re: ' . $title;
		}

		return $result;
	}

/**
 * Content of reply
 *
 * @param object $model instance of model
 * @param string $content bbs_articles.content
 * @return string bbs_articles.content
 */
	public function getReplyContent(Model $model, $content) {
		$result = '<p></p><blockquote class="small">' . $content . '</blockquote><p></p>';
		return $result;
	}

/**
 * Set bindModel BbsArticlesUser
 *
 * @param object $model instance of model
 * @param bool $reset Set to false to make the binding permanent
 * @return void
 */
	//public function bindModelBbsArticle(Model $model, $reset) {
	//	if ($model->hasField('bbs_article_key')) {
	//		$field = 'bbs_article_key';
	//	} else {
	//		$field = 'key';
	//	}
	//	$model->bindModel(array('belongsTo' => array(
	//		'CreatedUser' => array(
	//			'className' => 'Users.User',
	//			'fields' => 'CreatedUser.handlename',
	//			'foreignKey' => false,
	//			'conditions' => array(
	//				'BbsArticle.created_user = CreatedUser.id',
	//			)
	//		),
	//	)), $reset);
	//}

}
