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
		<?php echo __d('bbses', 'Posts') ?>
	</div>

	<div class="panel-body has-feedback">
		<div class="row form-group">
			<div class="col-xs-12">
				<strong><?php echo __d('bbses', 'Post creatable authority'); ?></strong>
			</div>
			<div class="col-xs-12">
				<?php echo $this->element('BlockRolePermissions/block_role_permission', array(
						'permission' => 'bbs_post_creatable',
						'defaultPermission' => $defaultPermissions['bbsPostCreatable'],
						'blockPermission' => isset($blockPermissions['bbsPostCreatable']) ? $blockPermissions['bbsPostCreatable'] : null
					)); ?>
			</div>
		</div>

		<div class="row form-group">
			<div class="col-xs-12">
				<strong><?php echo __d('bbses', 'Approval'); ?></strong>
			</div>
			<div class="col-xs-12">
				<?php
					$options = array(
						'0' => __d('bbses', 'Unused'),
						'1' => __d('bbses', 'Use')
					);
					echo $this->Form->radio('BbsSetting.use_post_approval', $options, array(
							'value' => (int)$bbsSetting['usePostApproval'],
							'legend' => false,
							'separator' => '<span class="inline-block"></span>',
						));
				?>
			</div>
		</div>

		<div class="row form-group">
			<div class="col-xs-offset-1 col-xs-11">
				<strong><?php echo __d('bbses', 'Post publishable authority'); ?></strong>
			</div>

			<div class="col-xs-offset-1 col-xs-11">
				<?php echo $this->element('BlockRolePermissions/block_role_permission', array(
						'permission' => 'bbs_post_publishable',
						'defaultPermission' => $defaultPermissions['bbsPostPublishable'],
						'blockPermission' => isset($blockPermissions['bbsPostPublishable']) ? $blockPermissions['bbsPostPublishable'] : null
					)); ?>
			</div>
		</div>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<?php echo __d('bbses', 'Comments') ?>
	</div>

	<div class="panel-body has-feedback">
		<div class="row form-group">
			<div class="col-xs-12">
				<strong><?php echo __d('bbses', 'Comment creatable authority'); ?></strong>
			</div>
			<div class="col-xs-12">
				<?php echo $this->element('BlockRolePermissions/block_role_permission', array(
						'permission' => 'bbs_comment_creatable',
						'defaultPermission' => $defaultPermissions['bbsCommentCreatable'],
						'blockPermission' => isset($blockPermissions['bbsCommentCreatable']) ? $blockPermissions['bbsCommentCreatable'] : null
					)); ?>
			</div>
		</div>

		<div class="row form-group">
			<div class="col-xs-12">
				<strong><?php echo __d('bbses', 'Approval'); ?></strong>
			</div>
			<div class="col-xs-12">
				<?php
					$options = array(
						'0' => __d('bbses', 'Unused'),
						'1' => __d('bbses', 'Use')
					);
					echo $this->Form->radio('BbsSetting.use_comment_approval', $options, array(
							'value' => (int)$bbsSetting['useCommentApproval'],
							'legend' => false,
							'separator' => '<span class="inline-block"></span>',
						));
				?>
			</div>
		</div>

		<div class="row form-group">
			<div class="col-xs-offset-1 col-xs-11">
				<strong><?php echo __d('bbses', 'Comment publishable authority'); ?></strong>
			</div>
			<div class="col-xs-offset-1 col-xs-11">
				<?php echo $this->element('BlockRolePermissions/block_role_permission', array(
						'permission' => 'bbs_comment_publishable',
						'defaultPermission' => $defaultPermissions['bbsCommentPublishable'],
						'blockPermission' => isset($blockPermissions['bbsCommentPublishable']) ? $blockPermissions['bbsCommentPublishable'] : null
					)); ?>
			</div>
		</div>
	</div>
</div>




