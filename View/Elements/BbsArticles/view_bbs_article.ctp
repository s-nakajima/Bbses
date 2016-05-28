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

<?php
	$options = array('escape' => false);
	$articleBody = 'articleBodyShow' . $bbsArticle['BbsArticleTree']['article_no'];
	if (isset($bodyHide)) {
		$articleBodyShow = $bodyHide;
		$options['onclick'] = 'return false;';
		$options['ng-click'] = $articleBody . ' = !' . $articleBody;
		$ngInit = ' ng-init="' . $articleBody . '=' . $articleBodyShow . '"';
		$ngShow = ' ng-show="' . $articleBody . '" ng-cloak';
	} else {
		$articleBodyShow = 'true';
		$ngInit = '';
		$ngShow = '';
	}
?>

<div <?php echo 'class="panel ' . $panelClass . '"' . $ngInit; ?>>
	<div class="panel-heading clearfix">
		<h3 class="bbses-view-title pull-left">
			<?php echo sprintf(__d('bbses', '%s. '), $bbsArticle['BbsArticleTree']['article_no']); ?>
			<?php
				$title = $this->NetCommonsHtml->titleIcon(
					$bbsArticle['BbsArticle']['title_icon']) . ' ' . h($bbsArticle['BbsArticle']['title']
				);
				echo $this->NetCommonsHtml->link($title, array('key' => $bbsArticle['BbsArticle']['key']), $options);
			?>

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
		</h3>
		<div class="pull-right">
			<span class="bbses-view-handle">
				<?php echo $this->NetCommonsHtml->handleLink($bbsArticle, array('avatar' => true)); ?>
			</span>
			<?php echo $this->Date->dateFormat($bbsArticle['BbsArticle']['created']); ?>
		</div>
	</div>

	<div class="panel-body"<?php echo $ngShow; ?>>
		<?php if (isset($parentBbsArticle)) : ?>
			<h4>
				<?php echo $this->NetCommonsHtml->link(
						sprintf(__d('bbses', '&gt;&gt; %s'), $parentBbsArticle['BbsArticleTree']['article_no']),
						array('action' => 'view', 'key' => $parentBbsArticle['BbsArticle']['key']),
						array('title' => $parentBbsArticle['BbsArticle']['title'], 'escape' => false)
					); ?>
			</h4>
		<?php endif; ?>
		<?php echo $bbsArticle['BbsArticle']['content']; ?>
	</div>

	<?php if (! isset($footerHide) || ! $footerHide) : ?>
		<div class="panel-footer clearfix"<?php echo $ngShow; ?>>
			<div class="pull-left">
				<?php echo $this->Like->buttons('BbsArticle', $bbsSetting, $bbsArticle); ?>
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
								'iconSize' => 'btn-xs'
							)); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>
</div>