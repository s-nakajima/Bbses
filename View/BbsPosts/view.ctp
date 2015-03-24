<?php
/**
 * BbsPosts view
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<ol class="breadcrumb">
	<li>
		<a href="<?php echo $this->Html->url('/bbses/bbses/index/' . $frameId . '/') ?>">
			<?php echo h($bbs['name']); ?>
		</a>
	</li>
	<li class="active">
		<?php echo String::truncate($bbsPost['bbsPostI18n']['title'], BbsPostI18n::DISPLAY_MAX_TITLE_LENGTH); ?>
	</li>
</ol>

<div class="panel-group">
	<div class="panel panel-info">
		<?php if (isset($rootBbsPost)) : ?>
			<?php echo $this->element('BbsPosts/view_bbs_post', array(
				'bbsPost' => $rootBbsPost,
				'parentBbsPost' => null
			)); ?>
		<?php else : ?>
			<?php echo $this->element('BbsPosts/view_bbs_post', array(
				'bbsPost' => $bbsPost,
				'parentBbsPost' => null
			)); ?>
		<?php endif; ?>
	</div>
</div>

<?php if (isset($parentBbsPost)) : ?>
	<div class="panel-group">
		<div class="panel panel-success">
			<?php echo $this->element('BbsPosts/view_bbs_post', array(
				'bbsPost' => $bbsPost,
				'parentBbsPost' => $parentBbsPost
			)); ?>
		</div>
	</div>
<?php endif; ?>

<?php if ($bbsPostChildren) : ?>
	<?php foreach ($bbsPostChildren as $childBbsPost) : ?>
		<div class="row">
			<div class="col-xs-offset-1 col-xs-11">
				<div class="panel-group">
					<div class="panel panel-default">
						<?php echo $this->element('BbsPosts/view_bbs_post', array(
							'bbsPost' => $childBbsPost,
							'parentBbsPost' => isset($bbsPostChildren[$childBbsPost['bbsPost']['parentId']]) ? $bbsPostChildren[$childBbsPost['bbsPost']['parentId']] : $bbsPost
						)); ?>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
<?php endif; ?>

