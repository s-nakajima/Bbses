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

<?php if ($bbsArticle['BbsArticle']['status'] === WorkflowComponent::STATUS_APPROVED && Current::permission('content_publishable')) : ?>
	<?php $this->request->data = $bbsArticle; ?>
	<?php echo $this->Form->create('BbsArticle', array(
			'div' => false,
			'class' => 'nc-bbs-edit-link',
			'url' => $this->NetCommonsHtml->url(array('action' => 'approve', 'key' => $bbsArticle['BbsArticle']['key']))
		)); ?>

		<?php echo $this->Form->hidden('Frame.id', array('value' => Current::read('Frame.id'))); ?>
		<?php echo $this->Form->hidden('Block.id', array('value' => Current::read('Block.id'))); ?>
		<?php echo $this->Form->hidden('Block.key', array('value' => Current::read('Block.key'))); ?>
		<?php echo $this->Form->hidden('BbsArticle.id'); ?>
		<?php echo $this->Form->hidden('BbsArticle.key'); ?>
		<?php echo $this->Form->hidden('BbsArticle.language_id'); ?>
		<?php echo $this->Form->hidden('BbsArticleTree.id'); ?>
		<?php echo $this->Form->hidden('BbsArticleTree.root_id'); ?>

		<?php echo $this->Workflow->publishLinkButton('', array(
				'tooltip' => true,
				'iconSize' => 'xs'
			)); ?>
	<?php echo $this->Form->end(); ?>
<?php endif;
