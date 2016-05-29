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

<?php if (Current::permission('content_comment_creatable') && $bbsSetting['use_comment']
			&& $status === WorkflowComponent::STATUS_PUBLISHED) : ?>

	<?php echo $this->NetCommonsForm->create('', array(
			'div' => false,
			'class' => 'nc-bbs-edit-link',
			'type' => 'get',
			'url' => $this->NetCommonsHtml->url(array('action' => 'reply', 'key' => $bbsArticleKey))
		)); ?>

		<?php echo $this->NetCommonsForm->checkbox('quote', array(
				'type' => 'checkbox',
				'checked' => false,
				'hiddenField' => false,
				'label' => __d('bbses', 'Quote this posts'),
				'inline' => true,
				'id' => 'quote' . $bbsArticleKey
			)); ?>

		<?php echo $this->NetCommonsForm->button('<span class="glyphicon glyphicon-comment"></span>', array(
				'class' => 'btn btn-success btn-xs bbs-write-comment-link',
				'tooltip' => __d('bbses', 'Write comment')
			)); ?>


		<?php echo $this->NetCommonsForm->hidden('frame_id', array(
			'value' => Current::read('Frame.id')
		)); ?>

	<?php echo $this->NetCommonsForm->end(); ?>
<?php endif;
