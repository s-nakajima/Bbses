<?php
/**
 * Bbs post view template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<tr><td>
	<div class="row">
		<div class="col-xs-10">
			<a href="<?php echo $this->Html->url('/bbses/bbs_posts/view/' . $frameId . '/' . $bbsPost['bbsPost']['id']); ?>">
				<?php echo String::truncate($bbsPost['bbsPostI18n']['title'], BbsPostI18n::LIST_TITLE_LENGTH); ?>
				<?php echo $this->element('NetCommons.status_label', array('status' => $bbsPost['bbsPostI18n']['status'])); ?>
			</a>
		</div>

		<div class="col-xs-2 text-right">
			<?php echo $this->Date->dateFormat($bbsPost['bbsPost']['created']); ?>
		</div>
	</div>

	<div class="row bbses-root-posts">
		<div class="col-xs-12 text-muted">
			<small>
				<?php echo String::truncate(strip_tags($bbsPost['bbsPostI18n']['content']), BbsPostI18n::LIST_CONTENT_LENGTH); ?>
			</small>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<?php if ($bbsSetting['useComment']) : ?>
				<div class="inline-block text-success" tooltip="<?php echo __d('bbses', 'Publishing comments'); ?>">
					<span class="glyphicon glyphicon-comment"></span>
					<?php echo (int)$bbsPost['bbsPost']['publishedCommentCounts']; ?>
				</div>
			<?php endif; ?>

			<?php if ($bbsSetting['useLike']) : ?>
				<!-- TODO:いいね数 -->
				<div class="inline-block text-success">
					<span class="glyphicon glyphicon-thumbs-up"></span>
					<?php echo (int)$bbsPost['bbsPost']['likeCounts']; ?>
				</div>
			<?php endif; ?>

			<?php if ($bbsSetting['useUnlike']) : ?>
				<!-- TODO:わるいね数 -->
				<div class="inline-block text-success">
					<span class="glyphicon glyphicon-thumbs-down"></span>
					<?php echo (int)$bbsPost['bbsPost']['unlikeCounts']; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</td></tr>
