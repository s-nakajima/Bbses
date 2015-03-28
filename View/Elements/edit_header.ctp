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

<div class="modal-header">
	<a class="close" href="<?php echo $this->Html->url(isset($current['page']) ? '/' . $current['page']['permalink'] : null); ?>">
		<span class="glyphicon glyphicon-remove"> </span>
	</a>
	<?php echo __d('bbses', 'Plugin name'); ?>
</div>
