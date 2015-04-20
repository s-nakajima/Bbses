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

<div class="row form-group">
	<div class="col-xs-10">
		<h2 class="h4"><?php echo $bbs['name']; ?></h2>
	</div>

	<div class="col-xs-2 text-right">
		<?php if ($contentCreatable && $bbsPostCreatable) : ?>
			<span class="nc-tooltip " tooltip="<?php echo __d('bbses', 'Create post'); ?>">
				<a href="<?php echo $this->Html->url('/bbses/bbs_posts/add/' . $frameId); ?>" class="btn btn-success">
					<span class="glyphicon glyphicon-plus"> </span>
				</a>
			</span>
		<?php endif; ?>
	</div>
</div>

<div class="row form-group">
	<div class="col-xs-4">
		<?php if ($contentCreatable && $bbsPostCreatable) : ?>
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
			<tr><td>
				<div class="row">
					<div class="col-xs-10">
						<a href="<?php echo $this->Html->url('/bbses/bbs_posts/view/' . $frameId . '/' . $bbsPost['bbsPost']['id']); ?>">
							<?php echo String::truncate($bbsPost['bbsPostI18n']['title'], BbsPostI18n::LIST_TITLE_LENGTH); ?>
						</a>
						<?php echo $this->element('NetCommons.status_label', array('status' => $bbsPost['bbsPostI18n']['status'])); ?>
					</div>

					<div class="col-xs-2 text-right">
						<?php echo $this->Date->dateFormat($bbsPost['bbsPost']['created']); ?>
					</div>
				</div>

				<div class="row bbses-root-posts">
					<div class="col-xs-12 text-muted">
						<small>
							<?php echo String::truncate(strip_tags($bbsPost['bbsPostI18n']['content']), BbsPostI18n::LIST_CONTENT_LENGTH); ?>
						</small>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-12">
						<?php if ($bbsSetting['useComment']) : ?>
							<div class="inline-block text-muted" tooltip="<?php echo __d('bbses', 'Publishing comments'); ?>">
								<span class="glyphicon glyphicon-comment"></span>
								<?php echo (int)$bbsPost['bbsPost']['publishedCommentCounts']; ?>
							</div>
						<?php endif; ?>

						<?php if ($bbsSetting['useLike']) : ?>
							<!-- TODO:いいね数 -->
							<div class="inline-block text-muted">
								<span class="glyphicon glyphicon-thumbs-up"></span>
								<?php echo (int)$bbsPost['bbsPost']['likeCounts']; ?>
							</div>
						<?php endif; ?>

						<?php if ($bbsSetting['useUnlike']) : ?>
							<!-- TODO:わるいね数 -->
							<div class="inline-block text-muted">
								<span class="glyphicon glyphicon-thumbs-down"></span>
								<?php echo (int)$bbsPost['bbsPost']['unlikeCounts']; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</td></tr>
		<?php endforeach; ?>
	</table>
	<div class="text-center">
		<?php echo $this->element('NetCommons.paginator', array(
				'url' => Hash::merge(
					array('controller' => 'bbs_posts', 'action' => 'index', $frameId),
					$this->Paginator->params['named']
				)
			)); ?>
	</div>

<?php else : ?>
	<?php echo __d('bbses', 'No article found.') ?>
<?php endif;
