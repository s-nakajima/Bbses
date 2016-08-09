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

<article>
	<?php echo $this->NetCommonsHtml->blockTitle($bbs['name']); ?>

	<header class="clearfix">
		<div class="pull-left">
			<?php echo $this->element('BbsArticles/select_sort'); ?>

			<?php echo $this->DisplayNumber->dropDownToggle(); ?>
		</div>

		<div class="pull-right">
			<?php if (Current::permission('content_creatable')) : ?>
				<?php echo $this->Button->addLink('', null, array('tooltip' => __d('bbses', 'Create article'))); ?>
			<?php endif; ?>
		</div>
	</header>

	<?php if ($bbsArticles) : ?>
		<div class="nc-content-list">
			<?php foreach ($bbsArticles as $bbsArticle) : ?>
				<?php echo $this->element('BbsArticles/index_bbs_article', array(
						'bbsArticle' => $bbsArticle
					)); ?>
			<?php endforeach; ?>

			<?php echo $this->element('NetCommons.paginator'); ?>
		</div>

	<?php else : ?>
		<article class="nc-not-found">
			<?php echo __d('bbses', 'No article found.') ?>
		</article>
	<?php endif; ?>
</article>
