<?php
/**
 * Bbs view for editor template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="row form-group">
	<div class="col-xs-6">
		<a class="btn btn-default" href="<?php echo $this->Html->url(isset($current['page']) ? '/' . $current['page']['permalink'] : null); ?>">
			<span class="glyphicon glyphicon-remove"> </span>
			<?php echo __d('bbses', 'Edit Exit'); ?>
		</a>
	</div>
	<div class="col-xs-6 text-right">
		<a class="btn btn-success" href="<?php echo $this->Html->url('/bbses/blocks/add/' . $frameId);?>">
			<span class="glyphicon glyphicon-plus"> </span>
		</a>
	</div>
</div>
