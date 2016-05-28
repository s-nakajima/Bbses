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

<div class="frame">
	<div class="nc-content-list">
		<nav>
			<?php echo $this->element('BbsArticles/breadcrumb'); ?>
		</nav>

		<article>
			<?php if (isset($rootBbsArticle)) : ?>
				<?php echo $this->element('BbsArticles/view_bbs_article', array(
					'bbsArticle' => $rootBbsArticle,
					'parentBbsArticle' => null,
					'bodyHide' => true,
					'panelClass' => 'panel-info',
				)); ?>
			<?php else : ?>
				<?php echo $this->element('BbsArticles/view_bbs_article', array(
					'bbsArticle' => $currentBbsArticle,
					'parentBbsArticle' => null,
					'panelClass' => 'panel-info',
				)); ?>
			<?php endif; ?>

			<article>
				<?php if (isset($parentParentBbsArticle)) : ?>
					<?php echo $this->element('BbsArticles/view_bbs_article', array(
						'bbsArticle' => $parentBbsArticle,
						'parentBbsArticle' => $parentParentBbsArticle,
						'panelClass' => 'panel-warning',
						'bodyHide' => true,
					)); ?>
				<?php endif; ?>

				<?php if (isset($parentBbsArticle)) : ?>
					<?php echo $this->element('BbsArticles/view_bbs_article', array(
						'bbsArticle' => $currentBbsArticle,
						'parentBbsArticle' => $parentBbsArticle,
						'panelClass' => 'panel-success',
					)); ?>
				<?php endif; ?>

				<?php if ($bbsArticleChildren) : ?>
					<?php foreach ($bbsArticleChildren as $childBbsArticle) : ?>
						<article class="row">
							<div class="col-xs-offset-1 col-xs-11">
								<?php if (isset($bbsArticleChildren[$childBbsArticle['BbsArticleTree']['parent_id']])) : ?>
									<?php echo $this->element('BbsArticles/view_bbs_article', array(
											'bbsArticle' => $childBbsArticle,
											'parentBbsArticle' => $bbsArticleChildren[$childBbsArticle['BbsArticleTree']['parent_id']],
											'panelClass' => 'panel-default',
										)); ?>

								<?php else : ?>
									<?php echo $this->element('BbsArticles/view_bbs_article', array(
											'bbsArticle' => $childBbsArticle,
											'parentBbsArticle' => $currentBbsArticle,
											'panelClass' => 'panel-default',
										)); ?>

								<?php endif; ?>
							</div>
						</article>
					<?php endforeach; ?>
				<?php endif; ?>
			</article>
		</article>
	</div>
</div>
