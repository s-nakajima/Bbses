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

<?php echo $this->Form->hidden('Block.id', array(
		'value' => $blockId,
	)); ?>

<?php echo $this->Form->hidden('BbsSetting.bbs_key', array(
		'value' => isset($bbsSetting['bbsKey']) ? $bbsSetting['bbsKey'] : null,
	)); ?>

<?php echo $this->Form->hidden('BbsSetting.id', array(
		'value' => isset($bbsSetting['id']) ? (int)$bbsSetting['id'] : null,
	)); ?>

<?php echo $this->element('Blocks.block_role_setting', array(
		'roles' => $roles,
		'model' => 'BbsSetting',
		'useWorkflow' => 'use_workflow',
		'useCommentApproval' => 'use_comment_approval',
		'creatablePermissions' => array(
			'contentCreatable' => __d('blocks', 'Content creatable roles'),
			'contentCommentCreatable' => __d('blocks', 'Content comment creatable roles'),
		),
		'approvalPermissions' => array(
			'contentCommentPublishable' => __d('blocks', 'Content comment publishable roles'),
		),
		'options' => array(
			Block::NEED_APPROVAL => __d('blocks', 'Need approval in both %s and comments ', __d('bbses', 'articles')),
			Block::NEED_COMMENT_APPROVAL => __d('blocks', 'Need only comments approval'),
			Block::NOT_NEED_APPROVAL => __d('blocks', 'Not need approval'),
		),
	));
