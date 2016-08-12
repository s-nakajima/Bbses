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
			<?php
				$paginatorUrl = NetCommonsUrl::actionUrlAsArray(Hash::merge(array(
					'plugin' => 'bbses',
					'controller' => 'bbs_articles',
					'action' => 'index',
					'block_id' => Current::read('Block.id'),
					'frame_id' => Current::read('Frame.id'),
				), $this->Paginator->params['named']));

				$currentLabel = $options[$curretSort . '.' . $curretDirection]['label'];
			?>
			<span class="btn-group">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					<?php echo $currentLabel; ?>
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<?php foreach ($options as $key => $sort) : ?>
						<li>
							<?php echo $this->Paginator->link(
								$sort['label'],
								array('sort' => $sort['sort'], 'direction' => $sort['direction']),
								array('url' => $paginatorUrl)
							); ?>
						</li>
					<?php endforeach; ?>
				</ul>
			</span>

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
