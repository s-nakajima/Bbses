<?php
/**
 * Breadcrumb element of BbsArticles index
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<ol class="breadcrumb">
	<li>
		<a href="<?php echo $this->Html->url(isset($current['page']) ? '/' . $current['page']['permalink'] : null) ?>"
			title="<?php echo h($bbs['name']); ?>">

			<?php echo String::truncate($bbs['name'], BbsArticle::BREADCRUMB_TITLE_LENGTH); ?>
		</a>
	</li>

	<?php if (isset($rootBbsArticle)) : ?>
		<li>
			<a href="<?php echo $this->Html->url('/bbses/bbs_articles/view/' . $frameId . '/' . $rootBbsArticle['bbsPost']['id']) ?>"
				title="<?php echo h($rootBbsArticle['bbsArticle']['title']); ?>">

				<?php echo String::truncate($rootBbsArticle['bbsArticle']['title'], BbsArticle::BREADCRUMB_TITLE_LENGTH); ?>
			</a>
		</li>
	<?php endif; ?>

	<?php if (isset($parentBbsArticle) && $parentBbsArticle['bbsPost']['rootId']) : ?>
		<li>
			<a href="<?php echo $this->Html->url('/bbses/bbs_articles/view/' . $frameId . '/' . $parentBbsArticle['bbsPost']['id']) ?>"
				title="<?php echo h($parentBbsArticle['bbsArticle']['title']); ?>">

				<?php echo String::truncate($parentBbsArticle['bbsArticle']['title'], BbsArticle::BREADCRUMB_TITLE_LENGTH); ?>
			</a>
		</li>
	<?php endif; ?>

	<?php if (isset($currentBbsArticle)) : ?>
		<li class="active">
			<?php if ($this->request->params['action'] === 'add' || $this->request->params['action'] === 'edit') : ?>
				<a href="<?php echo $this->Html->url('/bbses/bbs_articles/view/' . $frameId . '/' . $currentBbsArticle['bbsPost']['id']) ?>"
					title="<?php echo h($currentBbsArticle['bbsArticle']['title']); ?>">
			<?php endif; ?>

				<?php echo String::truncate($currentBbsArticle['bbsArticle']['title'], BbsArticle::LIST_TITLE_LENGTH); ?>

			<?php if ($this->request->params['action'] === 'add' || $this->request->params['action'] === 'edit') : ?>
				</a>
			<?php endif; ?>
		</li>
	<?php endif; ?>

	<?php if ($this->request->params['action'] === 'add') : ?>
		<li class="active">
			<?php echo __d('bbses', 'Create article'); ?>
		</li>
	<?php elseif ($this->request->params['action'] === 'edit') : ?>
		<li class="active">
			<?php echo __d('net_commons', 'Edit'); ?>
		</li>
	<?php endif; ?>
</ol>
