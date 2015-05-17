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

<?php if ($contentCommentCreatable && $bbsSetting['useComment']
			&& $status === NetCommonsBlockComponent::STATUS_PUBLISHED) : ?>

	<?php echo $this->Form->create('', array(
			'div' => false,
			'class' => 'nc-bbs-edit-link',
			'type' => 'get',
			'url' => '/bbses/bbs_articles/reply/' . $frameId . '/' . $bbsArticleKey
		)); ?>

		<label>
			<?php echo $this->Form->input('quote', array(
				'label' => false,
				'div' => false,
				'type' => 'checkbox',
				'checked' => true,
				'hiddenField' => false
			));
			echo __d('bbses', 'Quote this posts'); ?>
		</label>

		<?php echo $this->Form->button('<span class="glyphicon glyphicon-comment"></span>', array(
				'class' => 'btn btn-success btn-xs',
				'tooltip' => __d('bbses', 'Write comment')
			)); ?>

	<?php echo $this->Form->end(); ?>
<?php endif;
