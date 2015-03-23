<?php
/**
 * Bbs post view template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php if ($rootBbsPost) : ?>

<div class="panel-group">
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="row">
				<div class="col-xs-3 col-sm-2">
					<span>
						<?php echo $this->Html->image('/bbses/img/avatar.PNG', array('alt' => 'アバターが設定されていません')); ?>
					</span>
					<span>
						<a href="">
							<?php echo h($rootBbsPost['trackableCreator']['username']); ?>
						</a>
					</span>
				</div>

				<div class="col-xs-7 col-sm-8">
					<?php echo h($rootBbsPost['bbsPostI18n'][0]['title']); ?>
				</div>

				<div class="col-xs-2 col-sm-2 text-right">
					<?php echo $this->Date->dateFormat($rootBbsPost['bbsPost']['created']); ?>
				</div>
			</div>
		</div>

		<div class="panel-body">
			<?php echo $rootBbsPost['bbsPostI18n'][0]['content']; ?>
		</div>

		<div class="panel-footer">
			<div class="row">
				<div class="col-xs-6">

				</div>
				<div class="col-xs-6 text-right">
					<a href="<?php echo $this->Html->url('/bbses/bbs_posts/edit/' . $frameId . '/' . (int)$rootBbsPost['bbsPost']['id']); ?>"
							class="btn btn-primary btn-xs" tooltip="<?php echo __d('bbses', 'Edit'); ?>">

						<span class="glyphicon glyphicon-edit"></span>
					</a>

					
				</div>
			</div>
		</div>
	</div>
</div>

<?php endif;
