<?php
/**
 * Bbs post breadcrumb view  for editor template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<ol class="breadcrumb form-group">
	<li>
		<a href="<?php echo $this->Html->url('/bbses/bbses/index/' . $frameId . '/') ?>"
			title="<?php echo h($bbs['name']); ?>">

			<?php echo String::truncate($bbs['name'], BbsPostI18n::BREADCRUMB_TITLE_LENGTH); ?>
		</a>
	</li>

	<?php if (isset($rootBbsPost)) : ?>
		<li>
			<a href="<?php echo $this->Html->url('/bbses/bbs_posts/view/' . $frameId . '/' . $rootBbsPost['bbsPost']['id']) ?>"
				title="<?php echo h($rootBbsPost['bbsPostI18n']['title']); ?>">

				<?php echo String::truncate($rootBbsPost['bbsPostI18n']['title'], BbsPostI18n::BREADCRUMB_TITLE_LENGTH); ?>
			</a>
		</li>
	<?php endif; ?>

	<?php if (isset($parentBbsPost) && $parentBbsPost['bbsPost']['rootId']) : ?>
		<li>
			<a href="<?php echo $this->Html->url('/bbses/bbs_posts/view/' . $frameId . '/' . $parentBbsPost['bbsPost']['id']) ?>"
				title="<?php echo h($parentBbsPost['bbsPostI18n']['title']); ?>">

				<?php echo String::truncate($parentBbsPost['bbsPostI18n']['title'], BbsPostI18n::BREADCRUMB_TITLE_LENGTH); ?>
			</a>
		</li>
	<?php endif; ?>

	<?php if (isset($currentBbsPost)) : ?>
		<li class="active">
			<?php echo String::truncate($currentBbsPost['bbsPostI18n']['title'], BbsPostI18n::LIST_TITLE_LENGTH); ?>
		</li>
	<?php endif; ?>
</ol>
