<?php
/**
 * BbsPosts index
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php if (Page::isSetting()) : ?>
	<div class="text-right">
		<a href="<?php echo $this->Html->url('/bbses/blocks/index/' . $frameId) ?>" class="btn btn-default">
			<span class="glyphicon glyphicon-cog"> </span>
		</a>
	</div>
<?php endif; ?>

<div class="text-left form-group">
	<strong><?php echo $bbs['name']; ?></strong>
</div>

<div class="row form-group">
	<div class="col-xs-1">
		<?php if ($contentCreatable && $bbsPostCreatable) : ?>
			<span class="nc-tooltip" tooltip="<?php echo __d('bbses', 'Create post'); ?>">
				<a href="<?php echo $this->Html->url('/bbses/bbs_posts/add/' . $frameId); ?>" class="btn btn-success">
					<span class="glyphicon glyphicon-plus"> </span>
				</a>
			</span>
		<?php endif; ?>
	</div>
	<div class="col-xs-11">

	</div>
</div>
