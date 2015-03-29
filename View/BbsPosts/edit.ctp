<?php
/**
 * BbsPosts edit
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php //echo $this->Html->script('/net_commons/base/js/workflow.js', false); ?>
<?php echo $this->Html->script('/net_commons/base/js/wysiwyg.js', false); ?>
<?php echo $this->Html->script('/bbses/js/bbses.js', false); ?>

<div id="nc-bbs-post-<?php echo $frameId; ?>" ng-controller="BbsPosts"
		ng-init="initialize(<?php echo h(json_encode(['bbsPostI18n' => ['content' => $bbsPostI18n['content']]])); ?>)">

	<?php echo $this->element('BbsPosts/breadcrumb'); ?>

	<?php echo $this->Form->create('BbsPost', array('novalidate' => true)); ?>
		<div class="panel panel-default">
			<div class="panel-body has-feedback">
				<?php echo $this->element('BbsPosts/edit_form'); ?>

				<?php if (! $bbsPost['rootId']) : ?>
					<hr />
					<?php echo $this->element('Comments.form'); ?>
				<?php endif; ?>

			</div>

			<div class="panel-footer text-center">
				<?php echo $this->element('NetCommons.workflow_buttons'); ?>
			</div>
		</div>

		<?php if (! $bbsPost['rootId']) : ?>
			<?php echo $this->element('Comments.index'); ?>
		<?php endif; ?>

	<?php echo $this->Form->end(); ?>

	<?php if ($this->request->params['action'] === 'edit') : ?>
		<?php echo $this->Form->create('BbsPost', array('type' => 'delete', 'action' => 'delete/' . $frameId . '/' . (int)$bbsPost['id'])); ?>
			<accordion close-others="false">
				<accordion-group is-open="dangerZone" class="panel-danger">
					<accordion-heading style="cursor: pointer">
						<span style="cursor: pointer">
							<?php echo __d('net_commons', 'Danger Zone'); ?>
						</span>
						<span class="pull-right glyphicon" ng-class="{'glyphicon-chevron-down': dangerZone, 'glyphicon-chevron-right': ! dangerZone}"></span>
					</accordion-heading>

					<div class="inline-block">
						<?php echo sprintf(__d('bbses', 'Delete all data associated with the %s.'), __d('bbses', 'article')); ?>
					</div>

					<?php echo $this->Form->hidden('BbsPost.id', array(
							'value' => isset($bbsPost['id']) ? $bbsPost['id'] : null,
						)); ?>

					<?php echo $this->Form->hidden('BbsPost.root_id', array(
							'value' => isset($bbsPost['rootId']) ? $bbsPost['rootId'] : null,
						)); ?>

					<?php echo $this->Form->hidden('BbsPost.last_status', array(
							'value' => isset($bbsPost['lastStatus']) ? $bbsPost['lastStatus'] : null,
						)); ?>

					<?php echo $this->Form->hidden('BbsPost.key', array(
							'value' => isset($bbsPost['key']) ? $bbsPost['key'] : null,
						)); ?>

					<?php echo $this->Form->button(__d('net_commons', 'Delete'), array(
							'name' => 'delete',
							'class' => 'btn btn-danger pull-right',
							'onclick' => 'return confirm(\'' . sprintf(__d('bbses', 'Deleting the %s. Are you sure to proceed?'), __d('bbses', 'article')) . '\')'
						)); ?>
				</accordion-group>
			</accordion>
		<?php echo $this->Form->end(); ?>
	<?php endif; ?>

</div>
