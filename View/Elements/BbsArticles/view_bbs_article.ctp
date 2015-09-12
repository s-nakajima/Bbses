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

if ($currentBbsArticle['BbsArticle']['key'] === $bbsArticle['BbsArticle']['key']) {
	$headTag = 'h1';
} elseif ((int)$bbsArticle['BbsArticleTree']['root_id'] === 0) {
	$headTag = 'h2';
} else {
	$headTag = 'h3';
}
?>

<div class="panel-heading">
	<div class="row">
		<div class="col-xs-3 col-sm-2">
			<span>
				<?php echo sprintf(__d('bbses', '%s. '), $bbsArticle['BbsArticleTree']['article_no']); ?>
			</span>
			<span>
				<?php echo $this->Html->image('/bbses/img/avatar.PNG', array('alt' => 'no image')); ?>
			</span>
			<a href="">
				<?php echo h($bbsArticle['CreatedUser']['handlename']); ?>
			</a>
		</div>

		<div class="col-xs-9 col-sm-10">
			<div class="clearfix">
				<<?php echo $headTag; ?> class="nc-bbses-view-title clearfix">
					<?php if ($headTag === 'h1') : ?>
						<small>
					<?php endif; ?>

						<?php
							if (! isset($bbsArticle['BbsArticlesUser']['id']) || ! $bbsArticle['BbsArticlesUser']) {
								$title = '<strong>' . h($bbsArticle['BbsArticle']['title']) . '</strong>';
							} else {
								$title = h($bbsArticle['BbsArticle']['title']);
							}
							echo $this->NetCommonsHtml->link($title, array('key' => $bbsArticle['BbsArticle']['key']), array('escape' => false));
						?>

						<small>
							<?php if ($bbsArticle['BbsArticleTree']['root_id'] > 0) : ?>
								<?php echo $this->Workflow->label($bbsArticle['BbsArticle']['status'], array(
										WorkflowComponent::STATUS_IN_DRAFT => array(
											'class' => 'label-info',
											'message' => __d('net_commons', 'Temporary'),
										),
										WorkflowComponent::STATUS_APPROVED => array(
											'class' => 'label-warning',
											'message' => __d('bbses', 'Comment approving'),
										),
									)); ?>
							<?php else : ?>
								<?php echo $this->Workflow->label($bbsArticle['BbsArticle']['status']); ?>
							<?php endif; ?>
						</small>

						<div class="pull-right">
							<?php echo $this->Date->dateFormat($bbsArticle['BbsArticle']['created']); ?>
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
		<h4>
			<?php echo $this->NetCommonsHtml->link(
					sprintf(__d('bbses', '&gt;&gt; %s'), $parentBbsArticle['BbsArticleTree']['article_no']),
					array('key' => $parentBbsArticle['BbsArticle']['key']),
					array('title' => $parentBbsArticle['BbsArticle']['title'], 'escape' => false)
				); ?>
		</h4>
	<?php endif; ?>
	<?php echo $bbsArticle['BbsArticle']['content']; ?>
</div>

<div class="panel-footer">
	<div class="clearfix">
		<div class="pull-left">
			<?php echo $this->Like->buttons('BbsArticle', $bbsSetting, $bbsArticle, array('div' => true)); ?>
		</div>

		<div class="pull-right">
			<?php echo $this->element('BbsArticles/reply_link', array(
					'status' => $bbsArticle['BbsArticle']['status'],
					'bbsArticleKey' => $bbsArticle['BbsArticle']['key'],
				)); ?>

			<?php if ($bbsArticle['BbsArticleTree']['root_id'] > 0) : ?>
				<?php echo $this->element('BbsArticles/comment_approving_link', array('bbsArticle' => $bbsArticle)); ?>
			<?php endif; ?>

			<?php //掲示板の編集は、削除権限と同じ条件とする ?>
			<?php if ($this->Workflow->canDelete('BbsArticle', $bbsArticle)) : ?>
				<div class="nc-bbs-edit-link">
					<?php echo $this->Button->editLink('', array('key' => $bbsArticle['BbsArticle']['key']), array(
							'tooltip' => true,
							'iconSize' => 'xs'
						)); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
