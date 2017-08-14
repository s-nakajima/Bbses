<?php
/**
 * 子記事詳細(フラット) Element
 *
 * ## elementの引数
 * * $bbsArticle: 記事データ
 * * $parentBbsArticle: 親記事データ
 * * $linkId: ページ内リンク(ex. bbs-article-1)
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>
<article class="row">
	<div class="col-xs-offset-1 col-xs-11">
		<h2 id="<?php echo $linkId; ?>" class="bbs-artile-title">
			<?php
				//記事タイトル
				echo sprintf(__d('bbses', '%s. '), $bbsArticle['BbsArticleTree']['article_no']);
				echo $this->NetCommonsHtml->titleIcon($bbsArticle['BbsArticle']['title_icon']);
				echo h($bbsArticle['BbsArticle']['title']);
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
		</h2>
		<div class="bbs-article-content">
			<?php
				echo $this->element('BbsArticles/view_bbs_article_body', array(
					'bbsArticle' => $bbsArticle,
					'parentBbsArticle' => $parentBbsArticle,
				));
			?>
			<?php
				echo $this->element('BbsArticles/view_bbs_article_footer', array(
					'bbsArticle' => $bbsArticle,
				));
			?>
		</div>
	</div>
</article>
