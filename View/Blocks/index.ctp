<?php
/**
 * block index template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */


?>

<div class="modal-header">
	<?php echo __d('bbses', 'Plugin name'); ?>
</div>

<div class="modal-body">
	<?php echo $this->element('setting_form_tab', array('active' => 'block_index')); ?>

	<div class="tab-content">
		<div class="text-right">
			<a class="btn btn-success" href="<?php echo $this->Html->url('/bbses/bbs_settings/add/' . $frameId);?>">
				<span class="glyphicon glyphicon-plus"> </span>
			</a>
		</div>

		<div id="nc-bbs-setting-<?php echo $frameId; ?>">
			<?php echo $this->Form->create('', array(
					'url' => '/bbses/blocks/current/' . $frameId
				)); ?>

				<?php echo $this->Form->hidden('Frame.id', array(
						'value' => $frameId,
					)); ?>

				<table class="table table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>
								<a href="">
									<?php echo __d('blocks', 'Name'); ?>
								</a>
							</th>
							<th>
								<a href="">
									<?php echo __d('blocks', 'Public Type'); ?>
								</a>
							</th>
							<th>
								<a href="">
									<?php echo __d('net_commons', 'Updated Date'); ?>
								</a>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($bbses as $bbs) : ?>
							<tr<?php echo ($blockId === $bbs['block']['id'] ? ' class="active"' : ''); ?>>
								<td>
									<?php echo $this->Form->input('Frame.block_id',
										array(
											'type' => 'radio',
											'name' => 'data[Frame][block_id]',
											'options' => array((int)$bbs['block']['id'] => ''),
											'div' => false,
											'legend' => false,
											'label' => false,
											'hiddenField' => false,
											'checked' => (int)$bbs['block']['id'] === (int)$blockId,
											'onclick' => 'submit()'
										)); ?>
								</td>
								<td>
									<a href="<?php echo $this->Html->url('/bbses/bbs_settings/edit/' . $frameId . '/' . (int)$bbs['block']['id']); ?>">
										<?php echo h($bbs['bbs']['name']); ?>
									</a>
								</td>
								<td>
									<?php if ($bbs['block']['publicType'] === '0') : ?>
										<?php echo __d('blocks', 'Private'); ?>
									<?php elseif ($bbs['block']['publicType'] === '1') : ?>
										<?php echo __d('blocks', 'Public'); ?>
									<?php elseif ($bbs['block']['publicType'] === '2') : ?>
										<?php echo __d('blocks', 'Limited Public'); ?>
									<?php endif; ?>
								</td>
								<td>
									<?php echo $this->Date->dateFormat($bbs['bbs']['modified']); ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php echo $this->Form->end(); ?>

			<div class="text-center">
				<?php echo $this->element('paginator'); ?>
			</div>
		</div>
	</div>
</div>




