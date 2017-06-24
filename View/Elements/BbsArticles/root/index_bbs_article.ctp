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

<article class="clearfix bbs-root-index">
	<h2 class="pull-left">
		<?php
			$title = $this->NetCommonsHtml->titleIcon($bbsArticle['BbsArticle']['title_icon']) . ' ' .
					h(CakeText::truncate($bbsArticle['BbsArticle']['title'], BbsArticle::LIST_TITLE_LENGTH));

			echo $this->NetCommonsHtml->link(
				$title,
				array('action' => 'view', 'key' => $bbsArticle['BbsArticle']['key']),
				array('escape' => false)
			);
		?>
		<?php echo $this->Workflow->label($bbsArticle['BbsArticle']['status']); ?>
	</h2>

	<div class="pull-left bbs-root-comment">
		<?php if ($bbsSetting['use_comment']) : ?>
			<div class="inline-block bbses-comment-count">
				<span class="glyphicon glyphicon-comment text-muted" aria-hidden="true"></span>
				<?php if (Hash::get($bbsArticle['BbsArticleTree'], 'approval_bbs_article_child_count')) : ?>
					<?php
						echo __d(
							'bbses',
							'%s comments(%s approval waited comments)',
							$bbsArticle['BbsArticleTree']['bbs_article_child_count'],
							Hash::get($bbsArticle['BbsArticleTree'], 'approval_bbs_article_child_count')
						);
					?>
				<?php else : ?>
					<?php
						echo __d(
							'bbses',
							'%s comments',
							$bbsArticle['BbsArticleTree']['bbs_article_child_count']
						);
					?>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>

	<div class="pull-right bbs-root-datetime">
		<?php echo $this->Date->dateFormat($bbsArticle['BbsArticle']['created']); ?>
	</div>
</article>
