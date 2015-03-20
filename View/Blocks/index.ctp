<?php
/**
 * faq block index template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<ul class="nav nav-tabs">
	<li role="presentation" class="active">
		<?php echo __d('frames', 'List'); ?>
	</li>
</ul>




<div class="text-right">
	<a  class="btn btn-sm btn-success"
		href="<?php echo $this->Html->url('/bbses/bbs_settings/add/' . $frameId);?>">

		<span class="glyphicon glyphicon-plus"></span>
	</a>
</div>

<div id="nc-faq-container-<?php echo $frameId; ?>"
	 ng-controller="BlocksController"
	 ng-init="
		blocks = <?php echo h(json_encode($blocks)); ?>;
		frameId = <?php echo h(json_encode($frameId)); ?>;
	 ">

	<table class="table table-striped">
		<thead>
			<tr>
				<th style="min-width:35px;"></th>
				<th style="min-width:100px;">
					<a href="#" ng-click="orderBlock('block.name')">
						<?php echo __d('blocks', 'Name'); ?>
					</a>
				</th>
				<th style="min-width:110px;">
					<a href="#" ng-click="orderBlock('block.publicType')">
						<?php echo __d('blocks', 'Public Type'); ?>
					</a>
				</th>
				<th style="min-width:100px;">
					<a href="#" ng-click="orderBlock('block.modified')">
						<?php echo __d('net_commons', 'Updated Date'); ?>
					</a>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php echo $this->Form->create(null, array(
					'name' => 'BlockForm' . $frameId,
					'novalidate' => true,
				)); ?>

			<tr ng-repeat="block in blocks | orderBy:orderByField:isOrderDesc">
				<td>
					<?php echo $this->Form->input('Block.id',
						array(
							'type' => 'radio',
							'name' => 'data[Block][id]',
							'options' => false,
							'div' => false,
							'legend' => false,
							'checked' => true,
							'ng-value' => 'block.block.id',
							'ng-click' => 'setBlock(frameId, block.block.id);',
							'ng-checked' => 'block.block.id === frame.blockId',
						)); ?>
				</td>
				<td>
					<div style="width:100px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
						<a href="<?php echo $this->Html->url('/' . $frame['pluginKey'] . '/blocks/edit/' . $frame['id'] . '/{{block.block.id}}');?>" ng-bind="block.block.name"></a>
					</div>
				</td>
				<td>
					<div ng-switch on="block.block.publicType">
						<span ng-switch-when="0">
							<?php echo __d('blocks', 'Private'); ?>
						</span>
						<span ng-switch-when="1">
							<?php echo __d('blocks', 'Public'); ?>
						</span>
						<span ng-switch-when="2">
							<?php echo __d('blocks', 'Limited Public'); ?>
						</span>
					</div>
				</td>
				<td>
					<span ng-bind="parseDate(block.block.modified) | date: 'yyyy/MM/dd'"></span>
				</td>
			</tr>

			<?php echo $this->Form->end(); ?>
		</tbody>
	</table>

</div>
