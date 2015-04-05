<?php
/**
 * faq block index template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Form->hidden('Frame.id', array(
	'value' => $frameId,
	)); ?>

<?php echo $this->Form->hidden('BbsFrameSetting.id', array(
	'value' => (int)$bbsFrameSetting['id'],
	)); ?>

<?php echo $this->Form->hidden('BbsFrameSetting.frame_key', array(
	'value' => $frameKey,
	)); ?>

<div class="row form-group">
	<div class="col-xs-12">
		<?php echo $this->Form->label(__d('bbses', 'Show articles per page')); ?>
	</div>
	<div class="col-xs-12">
		<?php echo $this->Form->select('BbsFrameSetting.posts_per_page',
				BbsFrameSetting::getDisplayNumberOptions(),
				array(
					//'label' => false,
					'type' => 'select',
					'class' => 'form-control',
					'value' => $bbsFrameSetting['postsPerPage'],
					//'legend' => false,
					'empty' => false,
				)
			); ?>
	</div>
</div>

<div class="row form-group">
	<div class="col-xs-12">
		<?php echo $this->Form->label(__d('bbses', 'Show comments per page')); ?>
	</div>
	<div class="col-xs-12">
		<?php echo $this->Form->select('BbsFrameSetting.comments_per_page',
				BbsFrameSetting::getDisplayNumberOptions(),
				array(
					//'label' => false,
					'type' => 'select',
					'class' => 'form-control',
					'value' => $bbsFrameSetting['commentsPerPage'],
					//'legend' => false,
					'empty' => false,
				)
			); ?>
	</div>
</div>
