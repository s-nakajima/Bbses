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

<?php echo $this->Form->hidden('Frame.id', array(
	'value' => $frameId,
)); ?>

<?php echo $this->Form->hidden('Block.id', array(
	'value' => $block['id'],
)); ?>
<?php echo $this->Form->hidden('Block.key', array(
	'value' => $block['key'],
)); ?>
<?php echo $this->Form->hidden('Block.language_id', array(
	'value' => $languageId,
)); ?>
<?php echo $this->Form->hidden('Block.room_id', array(
	'value' => $roomId,
)); ?>
<?php echo $this->Form->hidden('Block.plugin_key', array(
	'value' => 'bbses',
)); ?>

<?php echo $this->Form->hidden('Bbs.id', array(
	'value' => isset($bbs['id']) ? (int)$bbs['id'] : null,
)); ?>
<?php echo $this->Form->hidden('Bbs.key', array(
	'value' => isset($bbs['key']) ? $bbs['key'] : null,
)); ?>

<?php echo $this->element('input_text_field', array(
			'model' => 'Bbs',
			'field' => 'name',
			'label' => __d('bbses', 'Bbs name') . $this->element('NetCommons.required'),
		)
	); ?>

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
					//'hiddenField' => false,
					'checked' => (int)$bbsSetting['useLike'],
					'ng-click' => 'useLike()'
				)
			); ?>

		<?php echo $this->Form->label('BbsSetting.use_like',
				'<span class="glyphicon glyphicon-thumbs-up"> </span> ' .
				__d('bbses', 'Use like button')
			); ?>
	</div>

	<div class="col-xs-11 col-xs-offset-1">
		<?php echo $this->Form->checkbox('BbsSetting.use_unlike', array(
					'div' => false,
					//'hiddenField' => false,
					'checked' => (int)$bbsSetting['useUnlike'],
					'disabled' => ! (int)$bbsSetting['useLike']
				)
			); ?>

		<?php echo $this->Form->label('BbsSetting.use_unlike',
				'<span class="glyphicon glyphicon-thumbs-down"> </span> ' .
				__d('bbses', 'Use unlike button')
			); ?>
	</div>
</div>

