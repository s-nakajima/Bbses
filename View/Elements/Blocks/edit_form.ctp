<?php
/**
 * BbsSettings edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Form->hidden('id', array(
		'value' => isset($bbsSetting['id']) ? (int)$bbsSetting['id'] : null,
	)); ?>

<?php echo $this->element('Blocks.form_hidden'); ?>

<?php echo $this->Form->hidden('Bbs.id', array(
		'value' => isset($bbs['id']) ? (int)$bbs['id'] : null,
	)); ?>

<?php echo $this->Form->hidden('Bbs.key', array(
		'value' => isset($bbs['key']) ? $bbs['key'] : null,
	)); ?>

<?php echo $this->Form->hidden('BbsSetting.id', array(
		'value' => isset($bbsSetting['id']) ? (int)$bbsSetting['id'] : null,
	)); ?>

<div class="row form-group">
	<div class="col-xs-12">
		<?php echo $this->Form->input(
				'Bbs.name', array(
					'type' => 'text',
					'label' => __d('bbses', 'Bbs name') . $this->element('NetCommons.required'),
					'error' => false,
					'class' => 'form-control',
					'value' => (isset($bbs['name']) ? $bbs['name'] : '')
				)
			); ?>
	</div>

	<div class="col-xs-12">
		<?php echo $this->element(
			'NetCommons.errors', [
				'errors' => $this->validationErrors,
				'model' => 'Bbs',
				'field' => 'name',
			]); ?>
	</div>
</div>

<?php echo $this->element('Blocks.public_type'); ?>

<div class="row form-group">
	<div class="col-xs-12">
		<?php echo $this->Form->checkbox('BbsSetting.use_comment', array(
					'div' => false,
					//'hiddenField' => false,
					'checked' => (int)$bbsSetting['useComment']
				)
			); ?>
		<?php echo $this->Form->label('BbsSetting.use_comment', __d('bbses', 'Use comment')); ?>
	</div>
</div>

<div class="row form-group">
	<div class="col-xs-12">
		<?php echo $this->Form->checkbox('BbsSetting.use_like', array(
					'div' => false,
					'checked' => (int)$bbsSetting['useLike'],
					'ng-click' => 'useLike()'
				)
			); ?>

		<?php echo $this->Form->label('BbsSetting.use_like',
				'<span class="glyphicon glyphicon-thumbs-up"> </span> ' .
				__d('likes', 'Use like button')
			); ?>
	</div>

	<div class="col-xs-11 col-xs-offset-1">
		<?php echo $this->Form->checkbox('BbsSetting.use_unlike', array(
					'div' => false,
					'checked' => (int)$bbsSetting['useUnlike'],
					'disabled' => ! (int)$bbsSetting['useLike']
				)
			); ?>

		<?php echo $this->Form->label('BbsSetting.use_unlike',
				'<span class="glyphicon glyphicon-thumbs-down"> </span> ' .
				__d('likes', 'Use unlike button')
			); ?>
	</div>
</div>
