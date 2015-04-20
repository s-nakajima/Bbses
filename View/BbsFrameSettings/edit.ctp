<?php
/**
 * faq block index template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="modal-body">
	<?php echo $this->element('NetCommons.setting_tabs', array(
			'tabs' => array(
				'block_index' => '/bbses/blocks/index/' . $frameId,
				'frame_settings' => '/bbses/bbs_frame_settings/edit/' . $frameId,
			),
			'active' => 'frame_settings'
		)); ?>

	<div class="tab-content">
		<?php echo $this->Form->create('BbsFrameSetting', array(
				'name' => 'form',
				'novalidate' => true,
			)); ?>

		<?php echo $this->element('Blocks.edit_form', array(
				'controller' => 'Blocks',
				'action' => 'edit' . '/' . $frameId,
				'callback' => 'Bbses.BbsFrameSettings/edit_form',
				'cancel' => $this->Html->url(isset($current['page']) ? '/' . $current['page']['permalink'] : null)
			)); ?>
	</div>
</div>
