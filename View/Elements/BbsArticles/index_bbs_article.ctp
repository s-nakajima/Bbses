<?php
/**
 * Article element of BbsArticles index
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<article>
	<h2 class="clearfix">
		<?php echo $this->NetCommonsHtml->link(
				String::truncate($bbsArticle['BbsArticle']['title'], BbsArticle::LIST_TITLE_LENGTH),
				array('action' => 'view', 'key' => $bbsArticle['BbsArticle']['key'])
			); ?>
		<small>
			<?php echo $this->Workflow->label($bbsArticle['BbsArticle']['status']); ?>
		</small>
	</h2>

	<p>
		<?php echo String::truncate(strip_tags($bbsArticle['BbsArticle']['content']), BbsArticle::LIST_CONTENT_LENGTH); ?>
	</p>

	<footer class="clearfix">
		<div class="pull-left">
			<?php if ($bbsSetting['use_comment']) : ?>
				<div class="inline-block bbses-comment-count">
					<span class="glyphicon glyphicon-comment text-muted" tooltip="<?php echo __d('bbses', 'Publishing comments'); ?>"></span>
					<?php echo (int)$bbsArticle['BbsArticleTree']['bbs_article_child_count']; ?>
				</div>
			<?php endif; ?>

			<?php echo $this->Like->display($bbsSetting, $bbsArticle, array('div' => true)); ?>
		</div>

		<div class="pull-right">
			<?php echo $this->Date->dateFormat($bbsArticle['BbsArticle']['created']); ?>
		</div>
	</footer>

</article>
