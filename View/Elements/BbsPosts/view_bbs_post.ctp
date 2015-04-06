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

<div class="panel-heading">
	<div class="row">
		<div class="col-xs-3 col-sm-2">
			<span>
				<?php echo sprintf(__d('bbses', '%s. '), $bbsPost['bbsPost']['postNo']); ?>
			</span>
			<span>
				<?php echo $this->Html->image('/bbses/img/avatar.PNG', array('alt' => 'no image')); ?>
			</span>
			<a href="">
				<?php echo h($bbsPost['createdUser']['value']); ?>
			</a>
		</div>

		<div class="col-xs-7 col-sm-8">
			<a href="<?php echo $this->Html->url('/bbses/bbs_posts/view/' . $frameId . '/' . $bbsPost['bbsPost']['id']); ?>">
				<?php if (! $bbsPost['bbsPostsUser']) : ?>
					<strong>
				<?php endif; ?>

				<?php echo h($bbsPost['bbsPostI18n']['title']); ?>

				<?php if (! $bbsPost['bbsPostsUser']) : ?>
					</strong>
				<?php endif; ?>
			</a>
			<span>
				<?php if ($bbsPost['bbsPost']['rootId'] > 0) : ?>
					<?php echo $this->element('BbsPosts/comment_status_label', array('status' => $bbsPost['bbsPostI18n']['status'])); ?>
				<?php else : ?>
					<?php echo $this->element('NetCommons.status_label', array('status' => $bbsPost['bbsPostI18n']['status'])); ?>
				<?php endif; ?>
			</span>
		</div>

		<div class="col-xs-2 col-sm-2 text-right">
			<?php echo $this->Date->dateFormat($bbsPost['bbsPost']['created']); ?>
		</div>
	</div>
</div>

<div class="panel-body">
	<?php if (isset($parentBbsPost)) : ?>
		<div>
			<a href="<?php echo $this->Html->url('/bbses/bbs_posts/view/' . $frameId . '/' . $parentBbsPost['bbsPost']['id']); ?>">
				<?php echo sprintf(__d('bbses', '&gt;&gt; %s'), $parentBbsPost['bbsPost']['postNo']) ?>
			</a>
		</div>
	<?php endif; ?>
	<?php echo $bbsPost['bbsPostI18n']['content']; ?>
</div>

<div class="panel-footer">
	<div class="row">
		<div class="col-xs-6">
			<?php if ($bbsSetting['useLike']) : ?>
				 <div class="inline-block text-muted">
					  <?php if (! isset($bbsPost['like']) && $bbsPost['bbsPostI18n']['status'] === NetCommonsBlockComponent::STATUS_PUBLISHED) : ?>
						   <?php echo $this->element('Likes.like', array(
									'likeCounts' => (int)$bbsPost['bbsPost']['likeCounts'],
									'contentKey' => $bbsPost['bbsPost']['key'],
								)); ?>
					  <?php else : ?>
						   <span class="glyphicon glyphicon-thumbs-up"></span>
						   <?php echo (int)$bbsPost['bbsPost']['likeCounts']; ?>
					  <?php endif; ?>
				 </div>
			<?php endif; ?>

			<?php if ($bbsSetting['useUnlike']) : ?>
				 <div class="inline-block text-muted">
					  <?php if (! isset($bbsPost['like']) && $bbsPost['bbsPostI18n']['status'] === NetCommonsBlockComponent::STATUS_PUBLISHED) : ?>
						   <?php echo $this->element('Likes.unlike', array(
									'unlikeCounts' => (int)$bbsPost['bbsPost']['unlikeCounts'],
									'contentKey' => $bbsPost['bbsPost']['key'],
								)); ?>
					  <?php else : ?>
						   <span class="glyphicon glyphicon-thumbs-down"></span>
						   <?php echo (int)$bbsPost['bbsPost']['unlikeCounts']; ?>
					  <?php endif; ?>
				 </div>
			<?php endif; ?>
		 </div>
		<div class="col-xs-6 text-right">
			<?php echo $this->element('BbsPosts/reply_link', array(
					'status' => $bbsPost['bbsPostI18n']['status'],
					'parentPostId' => (int)$bbsPost['bbsPost']['id'],
				)); ?>

			<?php if ($bbsPost['bbsPost']['rootId'] > 0) : ?>
				<?php echo $this->element('BbsPosts/comment_approving_link', array(
						'bbsPost' => $bbsPost,
					)); ?>
			<?php endif; ?>

			<?php echo $this->element('BbsPosts/edit_link', array(
					'status' => $bbsPost['bbsPostI18n']['status'],
					'bbsPostId' => (int)$bbsPost['bbsPost']['id'],
					'createUser' => (int)$bbsPost['trackableCreator']['id'],
				)); ?>
		</div>
	</div>
</div>
