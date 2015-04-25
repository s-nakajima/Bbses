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

<?php echo $this->Form->hidden('BbsSetting.id', array(
		'value' => isset($bbsSetting['id']) ? (int)$bbsSetting['id'] : null,
	)); ?>

<?php echo $this->element('Blocks.content_role_setting', array(
		'roles' => $roles,
		'permissions' => isset($blockRolePermissions) ? $blockRolePermissions : null,
		'useWorkflow' => array(
			'name' => 'BbsSetting.use_workflow',
			'value' => $bbsSetting['useWorkflow']
		),
	)); ?>

<?php echo $this->element('Blocks.comment_role_setting', array(
		'roles' => $roles,
		'permissions' => isset($blockRolePermissions) ? $blockRolePermissions : null,
		'isAutoApproval' => array(
			'name' => 'BbsSetting.is_comment_auto_approval',
			'value' => $bbsSetting['isCommentAutoApproval']
		),
	));
