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

<?php echo $this->Html->script('/bbses/js/bbses.js', false); ?>

<div class="modal-header">
	<?php echo __d('bbses', 'Plugin name'); ?>
</div>

<div class="modal-body">
	<?php echo $this->element('setting_form_tab', array('active' => 'list')); ?>

	<div class="tab-content">
		<?php echo $this->element('Bbses.BbsSettings/bbs_setting_tab', array('active' => 'bbs_setting')); ?>

		<?php echo $this->Form->create('BbsSetting', array(
				'name' => 'form',
				'novalidate' => true,
				'ng-controller' => 'Bbses'
			)); ?>

		<div class="panel panel-default" >
			<div class="panel-body has-feedback">
				<?php echo $this->element('Bbses.BbsSettings/edit_form'); ?>
			</div>
			<div class="panel-footer text-center">
				<?php echo $this->element('Bbses.BbsSettings/edit_button'); ?>
			</div>
		<?php echo $this->Form->end(); ?>
	</div>

</div>