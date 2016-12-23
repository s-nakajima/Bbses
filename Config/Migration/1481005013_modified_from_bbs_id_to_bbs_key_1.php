<?php
/**
 * 多言語化対応のためbbs_keyに変更
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * 多言語化対応のためbbs_keyに変更
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Bbses\Config\Migration
 */
class ModifiedFromBbsIdToBbsKey1 extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'modified_from_bbs_id_to_bbs_key_1';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
		),
		'down' => array(
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		$BbsArticle = $this->generateModel('BbsArticle');

		$bbsTable = $BbsArticle->tablePrefix . 'bbses Bbs';
		$bbsArticleTable = $BbsArticle->tablePrefix . 'bbs_articles BbsArticle';

		if ($direction === 'up') {
			$sql = 'UPDATE ' . $bbsTable . ', ' . $bbsArticleTable .
					' SET BbsArticle.bbs_key = Bbs.key' .
					' WHERE BbsArticle.bbs_id' . ' = Bbs.id' .
					'';
		} else {
			$sql = 'UPDATE ' . $bbsTable . ', ' . $bbsArticleTable .
					' SET BbsArticle.bbs_id = Bbs.id' .
					' WHERE BbsArticle.bbs_key' . ' = Bbs.key' .
					' AND BbsArticle.language_id' . ' = Bbs.language_id' .
					'';
		}
		$BbsArticle->query($sql);
		return true;
	}
}
