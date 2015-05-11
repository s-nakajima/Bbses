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

<div class="modal-body">
	<?php echo $this->element('NetCommons.setting_tabs', array(
			'tabs' => array(
				'block_index' => array('url' => '/bbses/blocks/index/' . $frameId),
				'frame_settings' => array('url' => '/bbses/bbs_frame_settings/edit/' . $frameId),
			),
			'active' => 'block_index'
		)); ?>

	<div class="tab-content">
		<?php echo $this->element('Blocks.setting_tabs', array(
				'tabs' => array(
					'block_settings' => array('url' => '/bbses/blocks/' . h($this->request->params['action']) . '/' . $frameId . '/' . $blockId),
					'role_permissions' => array('url' => '/bbses/block_role_permissions/' . h($this->request->params['action']) . '/' . $frameId . '/' . $blockId)
				),
				'active' => 'role_permissions'
			)); ?>

		<?php echo $this->element('Blocks.edit_form', array(
				'controller' => 'BlockRolePermission',
				'action' => 'edit' . '/' . $frameId . '/' . $blockId,
				'callback' => 'Bbses.BlockRolePermissions/edit_form',
				'cancel' => '/bbses/blocks/index/' . $frameId,
				'options' => array('ng-controller' => 'Bbses'),
			)); ?>
	</div>
</div>
