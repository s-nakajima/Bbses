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

<!-- Todo:フレーム管理に移動する -->
<?php if (Page::isSetting()) : ?>
	<div class="text-right">
		<a href="<?php echo $this->Html->url('/bbses/blocks/index/' . $frameId) ?>" class="btn btn-default">
			<span class="glyphicon glyphicon-cog"> </span>
		</a>
	</div>
<?php endif; ?>

<div class="text-left">
	<?php echo __d('bbses', 'Not found published bbs.'); ?>
</div>
