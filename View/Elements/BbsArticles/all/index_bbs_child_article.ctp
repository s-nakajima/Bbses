<?php
/**
 * 子記事一覧 Element
 *
 * ## elementの引数
 * * $bbsArticle: 記事データ
 * * $indent: インデント
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>
<div class="bbs-indent-<?php echo $indent; ?> clearfix">
	<div class="bbs-artile-title pull-left">
		<?php
			//記事タイトル
			echo $this->NetCommonsHtml->titleIcon($bbsArticle['BbsArticle']['title_icon']);
			echo $this->NetCommonsHtml->link(
				$bbsArticle['BbsArticle']['title'],
				array('action' => 'view', 'key' => $bbsArticle['BbsArticle']['key'])
			);
			echo ' ';
			echo $this->Workflow->label($bbsArticle['BbsArticle']['status'], array(
				WorkflowComponent::STATUS_IN_DRAFT => array(
					'class' => 'label-info',
					'message' => __d('net_commons', 'Temporary'),
				),
				WorkflowComponent::STATUS_APPROVAL_WAITING => array(
					'class' => 'label-warning',
					'message' => __d('bbses', 'Comment approving'),
				),
			));
		?>
	</div>
	<div class="pull-right bbs-article-creator">
		<span class="bbs-article-created text-muted">
			<?php echo $this->Date->dateFormat($bbsArticle['BbsArticle']['created']); ?>
		</span>
		<span class="bbs-article-handle">
			<?php echo $this->NetCommonsHtml->handleLink($bbsArticle, array('avatar' => true)); ?>
		</span>
	</div>
</div>
