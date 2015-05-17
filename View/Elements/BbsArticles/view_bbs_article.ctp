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
				<?php echo sprintf(__d('bbses', '%s. '), $bbsArticle['bbsArticleTree']['articleNo']); ?>
			</span>
			<span>
				<?php echo $this->Html->image('/bbses/img/avatar.PNG', array('alt' => 'no image')); ?>
			</span>
			<a href="">
				<?php echo h($bbsArticle['createdUser']['value']); ?>
			</a>
		</div>

		<div class="col-xs-9 col-sm-10">
			<div class="clearfix">
				<<?php echo $headTag; ?> class="nc-bbses-view-title clearfix">
					<?php if ($headTag === 'h1') : ?>
						<small>
					<?php endif; ?>

						<a href="<?php echo $this->Html->url('/bbses/bbs_articles/view/' . $frameId . '/' . $bbsArticle['bbsArticle']['key']); ?>">
							<?php if (! $bbsArticle['bbsArticlesUser']) : ?>
								<strong>
							<?php endif; ?>

							<?php echo h($bbsArticle['bbsArticle']['title']); ?>

							<?php if (! $bbsArticle['bbsArticlesUser']) : ?>
								</strong>
							<?php endif; ?>
						</a>

						<?php if ($bbsArticle['bbsArticleTree']['rootId'] > 0) : ?>
							<?php echo $this->element('BbsArticles/comment_status_label', array('status' => $bbsArticle['bbsArticle']['status'])); ?>
						<?php else : ?>
							<?php echo $this->element('NetCommons.status_label', array('status' => $bbsArticle['bbsArticle']['status'])); ?>
						<?php endif; ?>

						<div class="pull-right">
							<small>
								<?php echo $this->Date->dateFormat($bbsArticle['bbsArticle']['created']); ?>
							</small>
						</div>

					<?php if ($headTag === 'h1') : ?>
						</small>
					<?php endif; ?>
				</<?php echo $headTag; ?>>
			</div>
		</div>
	</div>
</div>

<div class="panel-body">
	<?php if (isset($parentBbsArticle)) : ?>
		<div>
			<a href="<?php echo $this->Html->url('/bbses/bbs_articles/view/' . $frameId . '/' . $parentBbsArticle['bbsArticle']['key']); ?>">
				<?php echo sprintf(__d('bbses', '&gt;&gt; %s'), $parentBbsArticle['bbsArticleTree']['articleNo']) ?>
			</a>
		</div>
	<?php endif; ?>
	<?php echo $bbsArticle['bbsArticle']['content']; ?>
</div>

<div class="panel-footer">
	<div class="clearfix">
		<div class="pull-left" <?php echo $this->element('Likes.like_init_attributes', array(
					'contentKey' => $bbsArticle['bbsArticle']['key'],
					'disabled' => !(! isset($bbsArticle['like']) && $bbsArticle['bbsArticle']['status'] === NetCommonsBlockComponent::STATUS_PUBLISHED),
					'likeCounts' => (int)$bbsArticle['bbsArticle']['likeCounts'],
					'unlikeCounts' => (int)$bbsArticle['bbsArticle']['unlikeCounts'],
				)); ?>>

			<?php if ($bbsSetting['useLike']) : ?>
				 <div class="inline-block">
					<?php echo $this->element('Likes.like_button', array('isLiked' => Like::IS_LIKE)); ?>
				 </div>
			<?php endif; ?>

			<?php if ($bbsSetting['useUnlike']) : ?>
				 <div class="inline-block">
					<?php echo $this->element('Likes.like_button', array('isLiked' => Like::IS_UNLIKE)); ?>
				 </div>
			<?php endif; ?>
		</div>

		<div class="pull-right">
			<?php echo $this->element('BbsArticles/reply_link', array(
					'status' => $bbsArticle['bbsArticle']['status'],
					'bbsArticleKey' => $bbsArticle['bbsArticle']['key'],
				)); ?>

			<?php if ($bbsArticle['bbsArticleTree']['rootId'] > 0) : ?>
				<?php echo $this->element('BbsArticles/comment_approving_link', array(
						'bbsArticle' => $bbsArticle,
					)); ?>
			<?php endif; ?>

			<?php echo $this->element('BbsArticles/edit_link', array(
					'status' => $bbsArticle['bbsArticle']['status'],
					'bbsArticleKey' => $bbsArticle['bbsArticle']['key'],
					'createdUser' => (int)$bbsArticle['trackableCreator']['id'],
				)); ?>
		</div>
	</div>
</div>
