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

<?php if ($bbsArticle['bbsArticle']['status'] === NetCommonsBlockComponent::STATUS_APPROVED && $contentPublishable) : ?>
	<?php echo $this->Form->create('', array(
			'div' => false,
			'class' => 'nc-bbs-edit-link',
			'type' => 'post',
			'url' => '/bbses/bbs_articles/approve/' . $frameId . '/' . $bbsArticle['bbsArticle']['key']
		)); ?>

		<?php echo $this->Form->hidden('BbsArticle.id', array(
				'value' => isset($bbsArticle['bbsArticle']['id']) ? (int)$bbsArticle['bbsArticle']['key'] : null,
			)); ?>

		<?php echo $this->Form->hidden('BbsArticleTree.id', array(
				'value' => isset($bbsArticle['BbsArticleTree']['id']) ? (int)$bbsArticle['BbsArticleTree']['id'] : null,
			)); ?>

		<?php echo $this->Form->button('<span class="glyphicon glyphicon-ok"></span>', array(
				'name' => 'save_' . NetCommonsBlockComponent::STATUS_PUBLISHED,
				'class' => 'btn btn-warning btn-xs',
				'tooltip' => __d('bbses', 'Approving')
			)); ?>
	<?php echo $this->Form->end(); ?>
<?php endif;
