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

$linkFormatId = BbsArticlesController::LINK_ID_FORMAT;
?>

<?php if ($isRootArticle) : ?>
		<header>
			<?php echo $this->LinkButton->toList(); ?>
		</header>

		<h1 id="<?php echo sprintf($linkFormatId, $bbsArticle['BbsArticleTree']['id']); ?>">
<?php else : ?>
		<h2 id="<?php echo sprintf($linkFormatId, $bbsArticle['BbsArticleTree']['id']); ?>">
<?php endif; ?>

	<?php
		//根記事タイトル
		echo sprintf(__d('bbses', '%s. '), $bbsArticle['BbsArticleTree']['article_no']);

		if ($bbsArticle['BbsArticleTree']['root_id'] > 0) {
			echo $this->Workflow->label($bbsArticle['BbsArticle']['status'], array(
				WorkflowComponent::STATUS_IN_DRAFT => array(
					'class' => 'label-info',
					'message' => __d('net_commons', 'Temporary'),
				),
				WorkflowComponent::STATUS_APPROVED => array(
					'class' => 'label-warning',
					'message' => __d('bbses', 'Comment approving'),
				),
			));
		} else {
			echo $this->Workflow->label($bbsArticle['BbsArticle']['status']);
		}

		echo $this->NetCommonsHtml->titleIcon($bbsArticle['BbsArticle']['title_icon']) . ' ' .
				h($bbsArticle['BbsArticle']['title']);
	?>

<?php if ($isRootArticle) : ?>
		</h1>
<?php else : ?>
		</h2>
<?php endif; ?>

<?php
//根記事の作成者、作成日時
?>
<div class="bbs-article-createdby">
	<span class="bbs-article-created text-muted">
		<?php echo __d('bbses', 'Created: '); ?>
		<?php echo $this->Date->dateFormat($bbsArticle['BbsArticle']['created']); ?>
	</span>
	<span class="bbs-article-handle">
		<?php echo $this->NetCommonsHtml->handleLink($bbsArticle, array('avatar' => true)); ?>
	</span>
</div>

<div class="bbs-article-body">
	<?php if (isset($parentBbsArticle)) : ?>
		<div class="bbs-parent-article">
			<a href="#<?php echo sprintf($linkFormatId, $parentBbsArticle['BbsArticleTree']['id']); ?>">
				<?php echo sprintf(__d('bbses', '&gt;&gt; %s'), $parentBbsArticle['BbsArticleTree']['article_no']); ?>
			</a>
		</div>
	<?php endif; ?>
	<?php echo $bbsArticle['BbsArticle']['content']; ?>
</div>

<footer class="clearfix bbs-article-footer">
	<?php if ($displayFooter) : ?>
		<div class="pull-left">
			<?php echo $this->Like->buttons('BbsArticle', $bbsSetting, $bbsArticle); ?>
		</div>

		<div class="pull-right">
			<?php
				//返信ボタン
				echo $this->element('BbsArticles/reply_link', array(
					'status' => $bbsArticle['BbsArticle']['status'],
					'bbsArticleKey' => $bbsArticle['BbsArticle']['key'],
					'bbsArticleNo' => $bbsArticle['BbsArticleTree']['article_no'],
				));
			?>

			<?php
				//承認するボタン
				if ($bbsArticle['BbsArticleTree']['root_id'] > 0) {
					echo $this->element('BbsArticles/comment_approving_link', array('bbsArticle' => $bbsArticle));
				}
			?>

			<?php //根記事編集は、削除権限と同じ条件とする ?>
			<?php if ($this->Workflow->canDelete('BbsArticle', $bbsArticle)) : ?>
				<div class="nc-bbs-edit-link">
					<?php echo $this->Button->editLink('', array('key' => $bbsArticle['BbsArticle']['key']), array(
							'tooltip' => true,
							'iconSize' => 'btn-xs'
						)); ?>
				</div>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</footer>
