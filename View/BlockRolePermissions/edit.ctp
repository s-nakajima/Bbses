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
<?php echo $this->Html->script('/blocks/js/block_role_permissions.js', false); ?>

<div class="modal-body">
	<?php echo $this->element('NetCommons.setting_tabs', $settingTabs); ?>

	<div class="tab-content"
		ng-controller="BlockRolePermissions"
		ng-init="initialize(<?php echo h(json_encode(array(
				'roles' => $roles, 'frameId' => $frameId
			))); ?>)">

		<?php echo $this->element('Blocks.setting_tabs', $blockSettingTabs); ?>

		<?php echo $this->element('Blocks.edit_form', array(
				'controller' => 'BlockRolePermission',
				'action' => 'edit' . '/' . $frameId . '/' . $blockId,
				'callback' => 'Bbses.BlockRolePermissions/edit_form',
				'cancel' => '/bbses/blocks/index/' . $frameId,
				'options' => array('ng-controller' => 'Bbses'),
			)); ?>
	</div>
</div>
