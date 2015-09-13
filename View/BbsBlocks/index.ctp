<?php
/**
 * Block index template
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
		<div class="text-right">
			<?php echo $this->Button->addLink(); ?>
		</div>

		<?php echo $this->Form->create('', array(
				'url' => NetCommonsUrl::actionUrl(array('plugin' => 'frames', 'controller' => 'frames', 'action' => 'edit'))
			)); ?>

			<?php echo $this->Form->hidden('Frame.id'); ?>

			<table class="table table-hover">
				<thead>
					<tr>
						<th></th>
						<th>
							<?php echo $this->Paginator->sort('Bbs.name', __d('bbses', 'Bbs name')); ?>
						</th>
						<th class="text-right">
							<?php echo $this->Paginator->sort('Bbs.bbs_article_count', __d('bbses', 'Article count')); ?>
						</th>
						<th class="text-right">
							<?php echo $this->Paginator->sort('Bbs.bbs_article_modified', __d('bbses', 'Article modified')); ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($bbses as $bbs) : ?>
						<tr<?php echo ($this->data['Frame']['block_id'] === $bbs['Block']['id'] ? ' class="active"' : ''); ?>>
							<td>
								<?php echo $this->BlockForm->displayFrame('Frame.block_id', $bbs['Block']['id']); ?>
							</td>
							<td>
								<?php echo $this->NetCommonsHtml->editLink($bbs['Bbs']['name'], array('block_id' => $bbs['Block']['id'])); ?>
							</td>
							<td class="text-right">
								<?php echo h($bbs['Bbs']['bbs_article_count']); ?>
							</td>
							<td class="text-right">
								<?php echo $this->Date->dateFormat($bbs['Bbs']['bbs_article_modified']); ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php echo $this->Form->end(); ?>

		<?php echo $this->element('NetCommons.paginator'); ?>
	</div>
</article>




