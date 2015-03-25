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

<?php echo $this->element('BlockRolePermissions/block_role_permission', array(
		'permission' => 'bbs_post_creatable',
		'label' => __d('bbses', 'Post creatable authority'),
		'defaultPermission' => $defaultPermissions['bbsPostCreatable'],
		'blockPermission' => isset($blockPermissions['bbsPostCreatable']) ? $blockPermissions['bbsPostCreatable'] : null
	)); ?>

<?php echo $this->element('BlockRolePermissions/block_role_permission', array(
		'permission' => 'bbs_post_publishable',
		'label' => __d('bbses', 'Post publishable authority'),
		'defaultPermission' => $defaultPermissions['bbsPostPublishable'],
		'blockPermission' => isset($blockPermissions['bbsPostPublishable']) ? $blockPermissions['bbsPostPublishable'] : null
	)); ?>

<?php echo $this->element('BlockRolePermissions/block_role_permission', array(
		'permission' => 'bbs_comment_creatable',
		'label' => __d('bbses', 'Comment creatable authority'),
		'defaultPermission' => $defaultPermissions['bbsCommentCreatable'],
		'blockPermission' => isset($blockPermissions['bbsCommentCreatable']) ? $blockPermissions['bbsCommentCreatable'] : null
	)); ?>

<?php echo $this->element('BlockRolePermissions/block_role_permission', array(
		'permission' => 'bbs_comment_publishable',
		'label' => __d('bbses', 'Comment publishable authority'),
		'defaultPermission' => $defaultPermissions['bbsCommentPublishable'],
		'blockPermission' => isset($blockPermissions['bbsCommentPublishable']) ? $blockPermissions['bbsCommentPublishable'] : null
	));

