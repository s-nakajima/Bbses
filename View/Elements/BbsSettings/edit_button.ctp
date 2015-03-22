<?php
/**
 * BbsSettings edit button template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<button type="button" class="btn btn-default" onclick="location.href = '/bbses/blocks/index/<?php echo $frameId; ?>'">
	<span class="glyphicon glyphicon-remove"></span>
	<?php echo __d('net_commons', 'Cancel'); ?>
</button>

<?php echo $this->Form->button(__d('net_commons', 'OK'), array(
		'class' => 'btn btn-primary',
		'name' => 'save',
	));


