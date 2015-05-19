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
?>
<?php echo $this->Html->css('/bbses/css/style.css', false); ?>
<?php echo $this->Html->script('/likes/js/likes.js', false); ?>
<?php echo $this->Html->css('/likes/css/style.css', false); ?>

<div class="frame">
	<div class="nc-content-list">
		<nav>
			<?php echo $this->element('BbsArticles/breadcrumb'); ?>
		</nav>

		<article>
			<div class="panel-group">
				<div class="panel panel-info">
					<?php if (isset($rootBbsArticle)) : ?>
						<?php echo $this->element('BbsArticles/view_bbs_article', array(
							'bbsArticle' => $rootBbsArticle,
							'parentBbsArticle' => null,
						)); ?>
					<?php else : ?>
						<?php echo $this->element('BbsArticles/view_bbs_article', array(
							'bbsArticle' => $currentBbsArticle,
							'parentBbsArticle' => null,
						)); ?>
					<?php endif; ?>
				</div>
			</div>

			<article>
				<?php if (isset($parentBbsArticle)) : ?>
					<div class="panel-group">
						<div class="panel panel-success">
							<?php echo $this->element('BbsArticles/view_bbs_article', array(
								'bbsArticle' => $currentBbsArticle,
								'parentBbsArticle' => $parentBbsArticle,
							)); ?>
						</div>
					</div>
				<?php endif; ?>

				<?php if ($bbsArticleChildren) : ?>
					<?php foreach ($bbsArticleChildren as $childBbsArticle) : ?>
						<article>
							<div class="row">
								<div class="col-xs-offset-1 col-xs-11">
									<div class="panel-group">
										<div class="panel panel-default">
											<?php if (isset($bbsArticleChildren[$childBbsArticle['bbsArticleTree']['parentId']])) : ?>
												<?php echo $this->element('BbsArticles/view_bbs_article', array(
														'bbsArticle' => $childBbsArticle,
														'parentBbsArticle' => $bbsArticleChildren[$childBbsArticle['bbsArticleTree']['parentId']],
													)); ?>

											<?php else : ?>
												<?php echo $this->element('BbsArticles/view_bbs_article', array(
														'bbsArticle' => $childBbsArticle,
														'parentBbsArticle' => $currentBbsArticle,
													)); ?>

											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>
						</article>
					<?php endforeach; ?>
				<?php endif; ?>
			</article>
		</article>
	</div>
</div>
