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

<?php
	$this->Html->css(
		array(
			'/bbses/css/style.css',
			'/likes/css/style.css'
		),
		array(
			'plugin' => false,
			'once' => true,
			'inline' => false
		)
	);
	$this->Html->script(
		'/likes/js/likes.js',
		array(
			'plugin' => false,
			'once' => true,
			'inline' => false
		)
	);
?>

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
