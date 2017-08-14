<?php
/**
 * 記事詳細のフッター部 Element
 *
 * ## elementの引数
 * * $bbsArticle: 記事データ
 * * $attributes: 属性配列
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$attrFooterStr = '';
if (isset($attributes)) {
	foreach ($attributes as $key => $attr) {
		$attrFooterStr .= ' ' . $key . '="' . $attr . '"';
	}
}
?>

<footer class="clearfix"<?php echo $attrFooterStr; ?>>
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
		<?php // WorkflowBehavior::canEditWorkflowContentをBbsArticle::canEditWorkflowContentでoverride ?>
		<?php if ($this->Workflow->canEdit('BbsArticle', $bbsArticle)) : ?>
			<div class="nc-bbs-edit-link">
				<?php echo $this->Button->editLink('', array('key' => $bbsArticle['BbsArticle']['key']), array(
						'tooltip' => true,
						'iconSize' => 'btn-xs'
					)); ?>
			</div>
		<?php endif; ?>
	</div>
</footer>
