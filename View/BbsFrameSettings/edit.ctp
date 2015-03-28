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

<div class="modal-header">
	<?php echo __d('bbses', 'Plugin name'); ?>
</div>

<div class="modal-body">
	<?php echo $this->element('setting_form_tab', array('active' => 'bbs_frame_setting')); ?>

	<div class="tab-content">
		<?php echo $this->Form->create('BbsFrameSetting', array(
				'name' => 'form',
				'novalidate' => true,
			)); ?>
		<div class="panel panel-default">
				<div class="panel-body has-feedback">
					<?php echo $this->element('Bbses.BbsFrameSettings/edit_form'); ?>
				</div>

				<div class="panel-footer text-center">
					<a class="btn btn-default" href="<?php echo $this->Html->url(isset($current['page']) ? '/' . $current['page']['permalink'] : null); ?>">
						<span class="glyphicon glyphicon-remove"> </span>
						<?php echo __d('net_commons', 'Cancel'); ?>
					</a>

					<?php echo $this->Form->button(__d('net_commons', 'OK'), array(
							'class' => 'btn btn-primary',
							'name' => 'save',
						)); ?>
				</div>
			</div>

		<?php echo $this->Form->end(); ?>
	</div>
</div>
