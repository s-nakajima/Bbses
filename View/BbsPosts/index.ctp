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

<?php echo $this->Html->css('/bbses/css/style.css', false); ?>

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
	<div class="col-xs-4">
		<?php if ($contentCreatable && $bbsPostCreatable) : ?>
			<span class="nc-tooltip" tooltip="<?php echo __d('bbses', 'Create post'); ?>">
				<a href="<?php echo $this->Html->url('/bbses/bbs_posts/add/' . $frameId); ?>" class="btn btn-success">
					<span class="glyphicon glyphicon-plus"> </span>
				</a>
			</span>

			<?php echo $this->element('BbsPosts/select_status'); ?>
		<?php endif; ?>
	</div>

	<div class="col-xs-8 text-right">
		<span class="glyphicon glyphicon-duplicate"></span>
		<?php echo (int)$this->Paginator->param('count'); ?>
		<small><?php echo __d('bbses', 'Posts'); ?></small>

		<?php echo $this->element('BbsPosts/select_sort'); ?>

		<?php echo $this->element('BbsPosts/select_limit'); ?>
	</div>
</div>

<?php if ($bbsPosts) : ?>
	<table class="table table-striped">
		<?php foreach ($bbsPosts as $bbsPost) : ?>
			<?php echo $this->element('BbsPosts/index_bbs_post', array('bbsPost' => $bbsPost)); ?>
		<?php endforeach; ?>
	</table>
<?php endif; ?>

<div class="text-center">
	<?php echo $this->element('paginator', array(
			'url' => Hash::merge(
				array('controller' => 'bbs_posts', 'action' => 'index', $frameId),
				$this->Paginator->params['named']
			)
		)); ?>
</div>

