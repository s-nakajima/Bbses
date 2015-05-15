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

<div class="panel panel-default">

	<div class="panel-heading">
		<?php echo __d('blocks', 'Creatable settings') ?>
	</div>

	<div class="panel-body">
		<div class="form-group">
			<div>
				<strong><?php echo __d('blocks', 'Content creatable roles'); ?></strong>
			</div>
			<div>
				<?php echo $this->element('Blocks.block_role_permission', array(
						'permission' => 'content_creatable',
						'roles' => $roles,
						'rolePermissions' => isset($blockRolePermissions['contentCreatable']) ? $blockRolePermissions['contentCreatable'] : null
					)); ?>
			</div>
		</div>

		<div class="form-group">
			<div>
				<strong><?php echo __d('blocks', 'Content comment creatable roles'); ?></strong>
			</div>
			<div>
				<?php echo $this->element('Blocks.block_role_permission', array(
						'permission' => 'content_comment_creatable',
						'roles' => $roles,
						'rolePermissions' => isset($blockRolePermissions['contentCommentCreatable']) ? $blockRolePermissions['contentCommentCreatable'] : null
					)); ?>
			</div>
		</div>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<?php echo __d('blocks', 'Approval settings') ?>
	</div>

	<div class="panel-body">
		<div class="form-group">
			<?php
				$options = array(
					BbsSetting::NEED_BOTH_APPROVAL => __d('blocks', 'Need approval in both %s and comments ', __d('bbses', 'articles')),
					BbsSetting::NEED_COMMENT_APPROVAL => __d('blocks', 'Need only comments approval'),
					BbsSetting::NOT_NEED_APPROVAL => __d('blocks', 'Not need approval'),
				);

				echo $this->Form->radio('BbsSetting.approval_type', $options, array(
					'value' => isset($bbsSetting['approvalType']) ? $bbsSetting['approvalType'] : '',
					'legend' => false,
					'separator' => '<br>'
				));
			?>
		</div>

		<div class="form-group">
			<div>
				<strong><?php echo __d('blocks', 'Content comment publishable roles'); ?></strong>
			</div>
			<div>
				<?php echo $this->element('Blocks.block_role_permission', array(
						'permission' => 'content_comment_publishable',
						'roles' => $roles,
						'rolePermissions' => isset($blockRolePermissions['contentCommentPublishable']) ? $blockRolePermissions['contentCommentPublishable'] : null
					)); ?>
			</div>
		</div>
	</div>
</div>

