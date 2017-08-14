<?php
/**
 * 根記事詳細
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BbsArticlesController', 'Bbses.Controller');

echo $this->NetCommonsHtml->css(array(
	'/bbses/css/style.css',
	'/likes/css/style.css'
));
echo $this->NetCommonsHtml->script([
	'/bbses/js/bbses.js',
	'/likes/js/likes.js',
]);
?>

<article class="bbs-<?php echo Hash::get($bbsFrameSetting, ['display_type'], 'flat'); ?> bbs-article"
			ng-controller="BbsArticlesView" ng-init="initialize()">
	<?php
		//根記事
		echo $this->element('BbsArticles/view_bbs_root_article', array(
			'bbsArticle' => $rootBbsArticle,
		));

		//子記事
		if ($bbsArticleChildren) {
			foreach ($bbsArticleChildren as $childBbsArticle) {
				$linkId = sprintf(BbsArticlesController::LINK_ID_FORMAT, $childBbsArticle['BbsArticleTree']['id']);
				if (isset($bbsArticleChildren[$childBbsArticle['BbsArticleTree']['parent_id']])) {
					echo $this->element(
						'BbsArticles/' . Hash::get($bbsFrameSetting, ['display_type'], 'flat') . '/view_bbs_child_article',
						array(
							'bbsArticle' => $childBbsArticle,
							'parentBbsArticle' => $bbsArticleChildren[$childBbsArticle['BbsArticleTree']['parent_id']],
							'linkId' => $linkId,
						)
					);
				} else {
					echo $this->element(
						'BbsArticles/' . Hash::get($bbsFrameSetting, ['display_type'], 'flat') . '/view_bbs_child_article',
						array(
							'bbsArticle' => $childBbsArticle,
							'parentBbsArticle' => $rootBbsArticle,
							'linkId' => $linkId,
						)
					);
				}
			}
		}
	?>
</article>
