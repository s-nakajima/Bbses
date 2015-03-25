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

	<div>
		<?php echo $this->Form->create('BbsPost', array(
				'name' => 'form',
				'novalidate' => true,
			)); ?>

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
	</div>

</div>
