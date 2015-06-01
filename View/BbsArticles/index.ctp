<?php
/**
 * BbsArticles index
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="nc-content-list">
	<article>
		<h1>
			<small>
				<?php echo h($bbs['name']); ?>
			</small>
		</h1>

		<div class="clearfix">
			<div class="pull-left">
				<?php echo $this->element('BbsArticles/select_sort'); ?>

				<?php echo $this->element('BbsArticles/select_limit'); ?>

				<span class="glyphicon glyphicon-duplicate"></span>
				<?php echo __d('bbses', '%s articles', (int)$this->Paginator->param('count')); ?>
			</div>

			<div class="pull-right">
				<?php if ($contentCreatable) : ?>
					<span class="nc-tooltip " tooltip="<?php echo __d('bbses', 'Create article'); ?>">
						<a href="<?php echo $this->Html->url('/bbses/bbs_articles/add/' . $frameId); ?>" class="btn btn-success">
							<span class="glyphicon glyphicon-plus"> </span>
						</a>
					</span>
				<?php endif; ?>
			</div>
		</div>

		<hr>

		<?php if ($bbsArticles) : ?>
			<?php foreach ($bbsArticles as $bbsArticle) : ?>
				<?php echo $this->element('BbsArticles/index_bbs_article', array(
						'bbsArticle' => $bbsArticle
					)); ?>

				<hr>
			<?php endforeach; ?>

			<footer class="text-center">
				<?php echo $this->element('NetCommons.paginator', array(
						'url' => Hash::merge(
							array('controller' => 'bbs_articles', 'action' => 'index', $frameId),
							$this->Paginator->params['named']
						)
					)); ?>
			</footer>

		<?php else : ?>
			<?php echo __d('bbses', 'No article found.') ?>
		<?php endif; ?>

	</article>
</div>
