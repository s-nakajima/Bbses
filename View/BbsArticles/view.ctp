<?php
/**
 * BbsArticles view
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->NetCommonsHtml->css(array(
	'/bbses/css/style.css',
	'/likes/css/style.css'
));
echo $this->NetCommonsHtml->script('/likes/js/likes.js');
?>

<article class="bbs-article">
	<?php
		//根記事
		echo $this->element('BbsArticles/view_bbs_article', array(
			'bbsArticle' => $rootBbsArticle,
			'parentBbsArticle' => null,
			'displayFooter' => true,
			'isRootArticle' => true
		));
	?>

	<?php if ($bbsArticleChildren) : ?>
		<?php foreach ($bbsArticleChildren as $childBbsArticle) : ?>
			<article class="row">
				<div class="col-xs-offset-1 col-xs-11">
					<?php
						if (isset($bbsArticleChildren[$childBbsArticle['BbsArticleTree']['parent_id']])) {
							echo $this->element('BbsArticles/view_bbs_article', array(
								'bbsArticle' => $childBbsArticle,
								'parentBbsArticle' => $bbsArticleChildren[$childBbsArticle['BbsArticleTree']['parent_id']],
								'displayFooter' => true,
								'isRootArticle' => false
							));
						} else {
							echo $this->element('BbsArticles/view_bbs_article', array(
								'bbsArticle' => $childBbsArticle,
								'parentBbsArticle' => $rootBbsArticle,
								'displayFooter' => true,
								'isRootArticle' => false
							));
						}
					?>
				</div>
			</article>
		<?php endforeach; ?>
	<?php endif; ?>
</article>
