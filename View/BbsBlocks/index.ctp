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

		<?php echo $this->Form->create('', array('url' => '/frames/frames/edit/' . $this->data['Frame']['id'])); ?>

			<?php echo $this->Form->hidden('Frame.id'); ?>

			<table class="table table-hover">
				<thead>
					<tr>
						<th></th>
						<th>
							<?php echo $this->Paginator->sort('Bbs.name', __d('bbses', 'Bbs name')); ?>
						</th>
						<th class="text-right">
							<?php echo $this->Paginator->sort('Bbs.article_count', __d('bbses', 'Article count')); ?>
						</th>
						<th class="text-right">
							<?php echo $this->Paginator->sort('Bbs.article_modified', __d('bbses', 'Article modified')); ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($bbses as $bbs) : ?>
						<tr<?php echo ($this->data['Frame']['block_id'] === $bbs['Block']['id'] ? ' class="active"' : ''); ?>>
							<td>
								<?php echo $this->NetCommonsForm->radio('Frame.block_id', array($bbs['Block']['id'] => ''), array(
										'onclick' => 'submit()',
										'ng-click' => 'sending=true',
										'ng-disabled' => 'sending'
									)); ?>
							</td>
							<td>
								<?php echo $this->NetCommonsForm->editLink($bbs['Block']['id'], $bbs['Bbs']['name']); ?>
							</td>
							<td class="text-right">
								<?php echo h($bbs['Bbs']['article_count']); ?>
							</td>
							<td class="text-right">
								<?php echo $this->Date->dateFormat($bbs['Bbs']['article_modified']); ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php echo $this->Form->end(); ?>

		<?php echo $this->element('NetCommons.paginator'); ?>
	</div>
</article>




