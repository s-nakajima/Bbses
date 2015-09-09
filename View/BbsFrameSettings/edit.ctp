<?php
/**
 * Bbs frame setting template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<article class="block-setting-body">
	<?php echo $this->element('NetCommons.setting_tabs', $settingTabs); ?>

	<div class="tab-content">
		<?php echo $this->element('Blocks.edit_form', array(
				'model' => 'BbsFrameSetting',
//				'action' => 'edit' . '/' . Current::read('Frame.id'),
				'callback' => 'Bbses.BbsFrameSettings/edit_form',
				'cancelUrl' => Current::backToPageUrl(),
			)); ?>
	</div>
</article>
