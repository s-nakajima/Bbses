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
	<?php echo $this->BlockTabs->main(BlockTabsHelper::MAIN_TAB_BLOCK_INDEX); ?>

	<?php echo $this->BlockIndex->description(); ?>

	<div class="tab-content">
		<?php echo $this->BlockIndex->create(); ?>
			<?php echo $this->BlockIndex->addLink(); ?>

			<?php echo $this->BlockIndex->startTable(); ?>
				<thead>
					<tr>
						<?php echo $this->BlockIndex->tableHeader(
								'Frame.block_id'
							); ?>
						<?php echo $this->BlockIndex->tableHeader(
								'Block.name', __d('bbses', 'Bbs name'),
								array('sort' => true)
							); ?>
						<?php echo $this->BlockIndex->tableHeader(
								'TrackableCreator.handlename', __d('net_commons', 'Created user'),
								array('sort' => true, 'type' => 'handle')
							); ?>
						<?php echo $this->BlockIndex->tableHeader(
								'Bbs.bbs_article_count', __d('bbses', 'Article count'),
								array('sort' => true, 'type' => 'numeric')
							); ?>
						<?php echo $this->BlockIndex->tableHeader(
								'Bbs.bbs_article_modified', __d('bbses', 'Article modified'),
								array('sort' => true, 'type' => 'datetime')
							); ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($bbses as $bbs) : ?>
						<?php echo $this->BlockIndex->startTableRow($bbs['Block']['id']); ?>
							<?php echo $this->BlockIndex->tableData(
									'Frame.block_id', $bbs['Block']['id']
								); ?>
							<?php echo $this->BlockIndex->tableData(
									'Block.name', $bbs['Block']['name'],
									array('editUrl' => array('block_id' => $bbs['Block']['id']))
								); ?>
							<?php echo $this->BlockIndex->tableData(
									'TrackableCreator', $bbs,
									array('type' => 'handle')
								); ?>
							<?php echo $this->BlockIndex->tableData(
									'Bbs.bbs_article_count', $bbs['Bbs']['bbs_article_count'],
									array('type' => 'numeric')
								); ?>
							<?php echo $this->BlockIndex->tableData(
									'Bbs.bbs_article_count', $bbs['Bbs']['bbs_article_modified'],
									array('type' => 'datetime')
								); ?>
						<?php echo $this->BlockIndex->endTableRow(); ?>
					<?php endforeach; ?>
				</tbody>
			<?php echo $this->BlockIndex->endTable(); ?>

		<?php echo $this->BlockIndex->end(); ?>

		<?php echo $this->element('NetCommons.paginator'); ?>
	</div>
</article>
