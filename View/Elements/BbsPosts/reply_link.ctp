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

<?php if ($bbsCommentCreatable && $bbsSetting['useComment']
			&& $status === NetCommonsBlockComponent::STATUS_PUBLISHED) : ?>

	<?php echo $this->Form->create('', array(
			'div' => false,
			'class' => 'inline-block',
			'type' => 'get',
			'url' => '/bbses/bbs_posts/reply/' . $frameId . '/' . $parentPostId
		)); ?>

		<label>
			<?php echo $this->Form->input('quote', array(
				'label' => false,
				'div' => false,
				'type' => 'checkbox',
				'checked' => true,
				'hiddenField' => false
			)); ?><?php echo __d('bbses', 'Quote this posts'); ?>
		</label>

		<button type="submit" class="btn btn-success btn-xs" tooltip="<?php echo __d('bbses', 'Write comment'); ?>">
			<span class="glyphicon glyphicon-comment"></span>
		</button>
	<?php echo $this->Form->end(); ?>

<?php endif;
