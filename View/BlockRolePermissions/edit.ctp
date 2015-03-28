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
	<?php echo $this->element('setting_form_tab', array('active' => 'block_index')); ?>

	<div class="tab-content">
		<?php echo $this->element('Bbses.Blocks/bbs_setting_tab', array('active' => 'block_role_permission')); ?>

		<?php echo $this->Form->create('BlockRolePermission', array(
				'name' => 'form',
				'novalidate' => true,
				'ng-controller' => 'Bbses'
			)); ?>

			<div class="panel panel-default">
				<div class="panel-body has-feedback">
					<?php echo $this->element('Bbses.BlockRolePermissions/edit_form'); ?>
				</div>

				<div class="panel-footer text-center">
					<button type="button" class="btn btn-default" onclick="location.href = '/bbses/blocks/index/<?php echo $frameId; ?>'">
						<span class="glyphicon glyphicon-remove"></span>
						<?php echo __d('net_commons', 'Cancel'); ?>
					</button>

					<?php echo $this->Form->button(__d('net_commons', 'OK'), array(
							'class' => 'btn btn-primary',
							'name' => 'save',
						)); ?>
				</div>
			</div>

		<?php echo $this->Form->end(); ?>
	</div>
</div>
