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
				<?php echo String::truncate($bbsPost['bbsPostI18n'][0]['title'], BbsPostI18n::DISPLAY_MAX_TITLE_LENGTH); ?>
				<?php echo $this->element('NetCommons.status_label', array('status' => $bbsPost['bbsPostI18n'][0]['status'])); ?>
			</a>
			&nbsp;

			<!-- TODO:コメント数 -->
			<?php if ($bbsPost['bbsPostI18n'][0]['status'] === NetCommonsBlockComponent::STATUS_PUBLISHED) : ?>
				<div class="inline-block text-success">
					<span class="glyphicon glyphicon-comment"> </span>
					<span tooltip="<?php echo __d('bbses', 'Publishing comments'); ?>">99999<?php //echo $bbsPost['comment_num']; ?></span>
				</div>
			<?php endif; ?>
		</div>

		<div class="col-xs-2 text-right">
			<?php echo $this->Date->dateFormat($bbsPost['bbsPost']['created']); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<small><em>
				<?php echo String::truncate(strip_tags($bbsPost['bbsPostI18n'][0]['content']), BbsPostI18n::DISPLAY_MAX_CONTENT_LENGTH); ?>
			</em></small>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-6">
			<?php if ($bbsPost['bbsPostI18n'][0]['status'] === NetCommonsBlockComponent::STATUS_PUBLISHED) : ?>
				<?php if ($bbsSetting['useLike']) : ?>
					<!-- TODO:いいね数 -->
					<div class="inline-block glyphicon glyphicon-thumbs-up">99999<?php //echo $bbsPost['likesNum']; ?></div>
				<?php endif; ?>
			<?php endif; ?>

			<?php if ($bbsPost['bbsPostI18n'][0]['status'] === NetCommonsBlockComponent::STATUS_PUBLISHED) : ?>
				<?php if ($bbsSetting['useUnlike']) : ?>
					<!-- TODO:わるいね数 -->
					<div class="inline-block glyphicon glyphicon-thumbs-down">99999<?php //echo $bbsPost['unlikesNum']; ?></div>
				<?php endif; ?>
			<?php endif; ?>
		</div>

		<div class="col-xs-6 text-right">
			<?php echo $this->element('BbsPosts/edit_link', array(
					'status' => $bbsPost['bbsPostI18n'][0]['status'],
					'bbsPostId' => (int)$bbsPost['bbsPost']['id'],
					'createUser' => $bbsPost['bbsPost']['createdUser'],
				)); ?>
		</div>
	</div>
</td></tr>
