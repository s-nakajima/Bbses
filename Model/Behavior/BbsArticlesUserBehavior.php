<?php
/**
 * BbsArticlesUser Behavior
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('ModelBehavior', 'Model');

/**
 * BbsArticlesUser Behavior
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Categories\Model\Behavior
 */
class BbsArticlesUserBehavior extends ModelBehavior {

/**
 * Set bindModel BbsArticlesUser
 *
 * @param object $model instance of model
 * @param bool $reset Set to false to make the binding permanent
 * @return void
 */
	public function bindModelBbsArticlesUser(Model $model, $reset) {
		if ($model->hasField('bbs_article_key')) {
			$field = 'bbs_article_key';
		} else {
			$field = 'key';
		}
		$model->bindModel(array('belongsTo' => array(
			'BbsArticlesUser' => array(
				'className' => 'Bbses.BbsArticlesUser',
				'foreignKey' => false,
				'conditions' => array(
					'BbsArticlesUser.bbs_article_key = ' . $model->alias . '.' . $field,
					'BbsArticlesUser.user_id' => Current::read('User.id'),
				)
			),
		)), $reset);
	}

/**
 * Save BbsArticlesUser
 *
 * @param object $model instance of model
 * @param array $bbsArticleKey received bbs_article_key
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function readToArticle(Model $model, $bbsArticleKey) {
		$model->loadModels([
			'BbsArticlesUser' => 'Bbses.BbsArticlesUser',
		]);

		//既読チェック
		if (! Current::read('User.id')) {
			return true;
		}
		$count = $model->BbsArticlesUser->find('count', array(
			'recursive' => -1,
			'conditions' => array(
				'bbs_article_key' => $bbsArticleKey,
				'user_id' => Current::read('User.id')
			)
		));
		if ($count > 0) {
			return true;
		}

		//トランザクションBegin
		$model->BbsArticlesUser->begin();

		//バリデーション
		$data = $model->BbsArticlesUser->create(array(
			'bbs_article_key' => $bbsArticleKey,
			'user_id' => Current::read('User.id')
		));
		$model->BbsArticlesUser->set($data);
		if (! $model->BbsArticlesUser->validates()) {
			$model->BbsArticlesUser->rollback();
			return false;
		}

		try {
			if (! $model->BbsArticlesUser->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			//トランザクションCommit
			$model->BbsArticlesUser->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$model->BbsArticlesUser->rollback($ex);
		}
		return true;
	}

}
