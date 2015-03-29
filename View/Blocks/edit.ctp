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

<?php echo $this->element('edit_header'); ?>

<div class="modal-body" ng-controller="Bbses">
	<?php echo $this->element('setting_form_tab', array('active' => 'block_index')); ?>

	<div class="tab-content">
		<?php echo $this->element('Bbses.Blocks/bbs_setting_tab', array('active' => 'bbs_setting')); ?>

		<?php echo $this->Form->create('Blocks', array('novalidate' => true)); ?>
			<div class="panel panel-default">
				<div class="panel-body has-feedback">
					<?php echo $this->element('Bbses.Blocks/edit_form'); ?>
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

		<?php if ($this->request->params['action'] === 'edit') : ?>
			<?php echo $this->Form->create('Blocks', array('type' => 'delete', 'action' => 'delete/' . $frameId . '/' . (int)$bbs['blockId'])); ?>
				<accordion close-others="false">
					<accordion-group is-open="dangerZone" class="panel-danger">
						<accordion-heading style="cursor: pointer">
							<span style="cursor: pointer">
								<?php echo __d('net_commons', 'Danger Zone'); ?>
							</span>
							<span class="pull-right glyphicon" ng-class="{'glyphicon-chevron-down': dangerZone, 'glyphicon-chevron-right': ! dangerZone}"></span>
						</accordion-heading>

						<div class="inline-block">
							<?php echo sprintf(__d('bbses', 'Delete all data associated with the %s.'), __d('bbses', 'BBS')); ?>
						</div>

						<?php echo $this->Form->hidden('Block.id', array(
								'value' => isset($block['id']) ? $block['id'] : null,
							)); ?>

						<?php echo $this->Form->hidden('Block.key', array(
								'value' => isset($block['key']) ? $block['key'] : null,
							)); ?>

						<?php echo $this->Form->hidden('Bbs.key', array(
								'value' => isset($bbs['key']) ? $bbs['key'] : null,
							)); ?>

						<?php echo $this->Form->button(__d('net_commons', 'Delete'), array(
								'name' => 'delete',
								'class' => 'btn btn-danger pull-right',
								'onclick' => 'return confirm(\'' . sprintf(__d('bbses', 'Deleting the %s. Are you sure to proceed?'), __d('bbses', 'BBS')) . '\')'
							)); ?>
					</accordion-group>
				</accordion>
			<?php echo $this->Form->end(); ?>
		<?php endif; ?>
	</div>
</div>
