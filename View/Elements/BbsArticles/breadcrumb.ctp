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
		<?php echo $this->NetCommonsHtml->link(
				CakeText::truncate($bbs['name'], BbsArticle::BREADCRUMB_TITLE_LENGTH),
				NetCommonsUrl::backToIndexUrl(),
				array('title' => $bbs['name'])
			); ?>
	</li>

	<?php if (isset($rootBbsArticle)) : ?>
		<li>
			<?php echo $this->NetCommonsHtml->link(
					CakeText::truncate($rootBbsArticle['BbsArticle']['title'], BbsArticle::BREADCRUMB_TITLE_LENGTH),
					array('key' => $rootBbsArticle['BbsArticle']['key']),
					array('title' => $rootBbsArticle['BbsArticle']['title'])
				); ?>
		</li>
	<?php endif; ?>

	<?php if (isset($parentBbsArticle) && $parentBbsArticle['BbsArticleTree']['root_id']) : ?>
		<li>
			<?php echo $this->NetCommonsHtml->link(
					CakeText::truncate($parentBbsArticle['BbsArticle']['title'], BbsArticle::BREADCRUMB_TITLE_LENGTH),
					array('key' => $parentBbsArticle['BbsArticle']['key']),
					array('title' => $parentBbsArticle['BbsArticle']['title'])
				); ?>
		</li>
	<?php endif; ?>

	<?php if (isset($currentBbsArticle)) : ?>
		<li class="active">
			<?php if (in_array($this->request->params['action'], array('add', 'edit'), true)) : ?>
				<?php echo $this->NetCommonsHtml->link(
						CakeText::truncate($currentBbsArticle['BbsArticle']['title'], BbsArticle::BREADCRUMB_TITLE_LENGTH),
						array('key' => $currentBbsArticle['BbsArticle']['key']),
						array('title' => $currentBbsArticle['BbsArticle']['title'])
					); ?>
			<?php else : ?>
				<?php echo CakeText::truncate($currentBbsArticle['BbsArticle']['title'], BbsArticle::LIST_TITLE_LENGTH); ?>
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
