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

				<!-- TODO:コメント数 -->
				<?php if ($bbsPost['bbsPostI18n'][0]['status'] === NetCommonsBlockComponent::STATUS_PUBLISHED) : ?>
					&nbsp;
					<span class="glyphicon glyphicon-comment"> </span>
					<span tooltip="<?php echo __d('bbses', 'Publishing comments'); ?>">99999<?php //echo $bbsPost['comment_num']; ?></span>
				<?php endif; ?>
			</a>
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
					<span class="glyphicon glyphicon-thumbs-up">99999<?php //echo $bbsPost['likesNum']; ?></span>
				<?php endif; ?>
			<?php endif; ?>

			&nbsp;

			<?php if ($bbsPost['bbsPostI18n'][0]['status'] === NetCommonsBlockComponent::STATUS_PUBLISHED) : ?>
				<?php if ($bbsSetting['useUnlike']) : ?>
					<!-- TODO:わるいね数 -->
					<span class="glyphicon glyphicon-thumbs-down">99999<?php //echo $bbsPost['unlikesNum']; ?></span>
				<?php endif; ?>
			<?php endif; ?>
		</div>

		<div class="col-xs-6 text-right">
			<!-- TODO:公開権限があれば編集／削除できる -->
			<!-- もしくは　編集権限があり、公開されていなければ、編集／削除できる -->
			<!-- もしくは 作成権限があり、自分の書いた記事で、公開されていなければ、編集／削除できる -->
			<?php if ($contentPublishable ||
					($contentEditable &&
						$bbsPost['bbsPostI18n'][0]['status'] !== NetCommonsBlockComponent::STATUS_PUBLISHED) ||
					($contentCreatable &&
						$bbsPost['bbsPostI18n'][0]['status'] !== NetCommonsBlockComponent::STATUS_PUBLISHED &&
							$bbsPost['bbsPost']['created_user'] === $userId)): ?>

				<a href="<?php echo $this->Html->url('/bbses/bbs_posts/edit/' . $frameId . '/' . $bbsPost['bbsPost']['id']); ?>"
					class="btn btn-primary btn-xs" tooltip="<?php echo __d('bbses', 'Edit'); ?>">

					<span class="glyphicon glyphicon-edit"> </span>
				</a>
			<?php endif; ?>
		</div>
	</div>
</td></tr>
