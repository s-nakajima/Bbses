<?php
/**
 * 記事詳細の内容 Element
 *
 * ## elementの引数
 * * $bbsArticle: 記事データ
 * * $parentBbsArticle: 親記事データ
 * * $attributes['createdby']: createdby属性配列
 * * $attributes['body']: body属性配列
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$linkFormatId = BbsArticlesController::LINK_ID_FORMAT;
$attrCreatedByStr = '';
if (isset($attributes['createdby'])) {
	foreach ($attributes['createdby'] as $key => $attr) {
		$attrCreatedByStr .= ' ' . $key . '="' . $attr . '"';
	}
}
$attrBodyStr = '';
if (isset($attributes['body'])) {
	foreach ($attributes['body'] as $key => $attr) {
		$attrBodyStr .= ' ' . $key . '="' . $attr . '"';
	}
}
?>

<?php //根記事の作成者、作成日時 ?>
<div class="bbs-article-createdby"<?php echo $attrCreatedByStr; ?>>
	<span class="bbs-article-created text-muted">
		<?php echo __d('bbses', 'Created: '); ?>
		<?php echo $this->Date->dateFormat($bbsArticle['BbsArticle']['created']); ?>
	</span>
	<span class="bbs-article-handle">
		<?php echo $this->NetCommonsHtml->handleLink($bbsArticle, array('avatar' => true)); ?>
	</span>
</div>

<article class="bbs-article-body"<?php echo $attrBodyStr; ?>>
	<?php if (isset($parentBbsArticle)) : ?>
		<div class="bbs-parent-article">
			<a href="#<?php echo sprintf($linkFormatId, $parentBbsArticle['BbsArticleTree']['id']); ?>">
				<?php echo sprintf(__d('bbses', '&gt;&gt; %s'), $parentBbsArticle['BbsArticleTree']['article_no']); ?>
			</a>
		</div>
	<?php endif; ?>
	<?php echo $bbsArticle['BbsArticle']['content']; ?>
</article>
