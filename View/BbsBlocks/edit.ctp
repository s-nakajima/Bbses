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

<div class="modal-body" ng-controller="Bbses">
	<?php echo $this->element('NetCommons.setting_tabs', $settingTabs); ?>

	<div class="tab-content">
		<?php echo $this->element('Blocks.setting_tabs', $blockSettingTabs); ?>

		<?php echo $this->element('Blocks.edit_form', array(
				'controller' => 'BbsBlocks',
				'action' => h($this->request->params['action']) . '/' . $frameId . '/' . $blockId,
				'callback' => 'Bbses.BbsBlocks/edit_form',
				'cancelUrl' => '/bbses/bbs_blocks/index/' . $frameId
			)); ?>

		<?php if ($this->request->params['action'] === 'edit') : ?>
			<?php echo $this->element('Blocks.delete_form', array(
					'controller' => 'BbsBlocks',
					'action' => 'delete/' . $frameId . '/' . $blockId,
					'callback' => 'Bbses.BbsBlocks/delete_form'
				)); ?>
		<?php endif; ?>
	</div>
</div>
