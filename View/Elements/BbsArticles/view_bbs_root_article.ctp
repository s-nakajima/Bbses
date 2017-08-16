<?php
/**
 * 記事詳細の根記事 Element
 *
 * ## elementの引数
 * * $bbsArticle: 記事データ
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
App::uses('BbsFrameSetting', 'Bbses.Model');

$linkFormatId = BbsArticlesController::LINK_ID_FORMAT;
?>

<header>
	<?php echo $this->LinkButton->toList(); ?>
</header>
<h1 id="<?php echo sprintf($linkFormatId, $bbsArticle['BbsArticleTree']['id']); ?>">
	<?php
		//根記事タイトル
		if ($bbsFrameSetting['display_type'] === BbsFrameSetting::DISPLAY_TYPE_FLAT) {
			echo sprintf(__d('bbses', '%s. '), $bbsArticle['BbsArticleTree']['article_no']);
		}
		echo $this->NetCommonsHtml->titleIcon($bbsArticle['BbsArticle']['title_icon']);
		echo h($bbsArticle['BbsArticle']['title']);
		echo ' ';
		echo $this->Workflow->label($bbsArticle['BbsArticle']['status']);
	?>
</h1>

<div class="bbs-article-content">
	<?php
		echo $this->element('BbsArticles/view_bbs_article_body', array(
			'bbsArticle' => $bbsArticle,
			'parentBbsArticle' => null,
		));
	?>
	<?php
		echo $this->element('BbsArticles/view_bbs_article_footer', array(
			'bbsArticle' => $bbsArticle,
			'parentBbsArticle' => null,
		));
	?>
</div>
