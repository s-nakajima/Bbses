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

<div class="row form-group">
	<div class="col-xs-12">
		<?php echo $this->Form->label('Block.public_type', __d('blocks', 'Publishing setting')); ?>
	</div>

	<div class="col-xs-offset-1 col-xs-11">
		<?php
			$options = array(
				'0' => __d('blocks', 'No display'),
				'1' => __d('blocks', 'Display'),
				'2' => __d('blocks', 'Limited Public'),
			);

			echo $this->Form->radio('Block.public_type', $options, array(
				'value' => isset($block['publicType']) ? $block['publicType'] : '0',
				'legend' => false,
				'separator' => '<br />',
			));

			$publicTypePeriod = $block['publicType'] === '2';
		?>
	</div>

	<div class="col-xs-offset-1 col-xs-11">
		<div class="input-group inline-block" style="margin-left: 20px;">
			<div class="input-group">
				<?php echo $this->Form->time('Block.from', array(
					'value' => (isset($block['from']) ? $block['from'] : null),
					'label' => false,
					'class' => 'form-control',
					'placeholder' => 'yyyy-mm-dd hh:nn'
				)); ?>

				<span class="input-group-addon">
					<span class="glyphicon glyphicon-minus"></span>
				</span>

				<?php echo $this->Form->time('Block.to', array(
					'value' => (isset($block['to']) ? $block['to'] : null),
					'label' => false,
					'class' => 'form-control',
					'placeholder' => 'yyyy-mm-dd hh:nn'
				)); ?>
			</div>
		</div>
	</div>
</div>

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
				__d('bbses', 'Use like button')
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
				__d('bbses', 'Use unlike button')
			); ?>
	</div>
</div>
