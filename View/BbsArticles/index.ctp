<?php
/**
 * BbsArticles index template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->NetCommonsHtml->css('/bbses/css/style.css');
?>

<div class="nc-content-list">
	<h1>
		<?php echo h($bbs['name']); ?>
	</h1>

	<div class="clearfix">
		<div class="pull-left">
			<?php echo $this->element('BbsArticles/select_sort'); ?>

			<?php echo $this->DisplayNumber->dropDownToggle(); ?>

			<span class="glyphicon glyphicon-duplicate"></span>
			<?php echo __d('bbses', '%s articles', (int)$this->Paginator->param('count')); ?>
		</div>

		<div class="pull-right">
			<?php if (Current::permission('content_creatable')) : ?>
				<?php echo $this->Button->addLink('', null, array('tooltip' => __d('bbses', 'Create article'))); ?>
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

		<?php echo $this->element('NetCommons.paginator'); ?>

	<?php else : ?>
		<?php echo __d('bbses', 'No article found.') ?>
	<?php endif; ?>
</div>
