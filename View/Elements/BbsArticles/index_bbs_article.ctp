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
		<a href="<?php echo $this->Html->url('/bbses/bbs_articles/view/' . $frameId . '/' . $bbsArticle['bbsArticle']['key']); ?>">
			<?php echo String::truncate($bbsArticle['bbsArticle']['title'], BbsArticle::LIST_TITLE_LENGTH); ?>
		</a>
		<small>
			<?php echo $this->element('NetCommons.status_label', array('status' => $bbsArticle['bbsArticle']['status'])); ?>
		</small>
	</h2>

	<p>
		<?php echo String::truncate(strip_tags($bbsArticle['bbsArticle']['content']), BbsArticle::LIST_CONTENT_LENGTH); ?>
	</p>

	<footer class="clearfix">
		<?php if ($bbsSetting['useComment']) : ?>
			<div class="inline-block text-muted" tooltip="<?php echo __d('bbses', 'Publishing comments'); ?>">
				<span class="glyphicon glyphicon-comment"></span>
				<?php echo (int)$bbsArticle['bbsArticleTree']['publishedCommentCount']; ?>
			</div>
		<?php endif; ?>

		<?php if ($bbsSetting['useLike']) : ?>
			<div class="inline-block text-muted">
				<span class="glyphicon glyphicon-thumbs-up"></span>
				<?php echo isset($bbsArticle['bbsArticle']['likeCounts']) ? (int)$bbsArticle['bbsArticle']['likeCounts'] : 0; ?>
			</div>
		<?php endif; ?>

		<?php if ($bbsSetting['useUnlike']) : ?>
			<div class="inline-block text-muted">
				<span class="glyphicon glyphicon-thumbs-down"></span>
				<?php echo isset($bbsArticle['bbsArticle']['unlikeCounts']) ? (int)$bbsArticle['bbsArticle']['unlikeCounts'] : 0; ?>
			</div>
		<?php endif; ?>

		<div class="pull-right">
			<?php echo $this->Date->dateFormat($bbsArticle['bbsArticle']['created']); ?>
		</div>
	</footer>

</article>
