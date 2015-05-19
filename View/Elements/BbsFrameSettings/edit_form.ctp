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

<?php echo $this->Form->hidden('Frame.id', array(
	'value' => $frameId,
	)); ?>

<?php echo $this->Form->hidden('BbsFrameSetting.id', array(
	'value' => isset($bbsFrameSetting['id']) ? (int)$bbsFrameSetting['id'] : null,
	)); ?>

<?php echo $this->Form->hidden('BbsFrameSetting.frame_key', array(
	'value' => $frameKey,
	)); ?>

<div class="form-group">
	<?php echo $this->Form->label(__d('bbses', 'Show articles per page')); ?>
	<?php echo $this->Form->select('BbsFrameSetting.articles_per_page',
			BbsFrameSetting::$displayNumberOptions,
			array(
				//'label' => false,
				'type' => 'select',
				'class' => 'form-control',
				'value' => $bbsFrameSetting['articlesPerPage'],
				//'legend' => false,
				'empty' => false,
			)
		); ?>
</div>

<div class="form-group">
	<?php echo $this->Form->label(__d('bbses', 'Show comments per page')); ?>
	<?php echo $this->Form->select('BbsFrameSetting.comments_per_page',
			BbsFrameSetting::$displayNumberOptions,
			array(
				//'label' => false,
				'type' => 'select',
				'class' => 'form-control',
				'value' => $bbsFrameSetting['commentsPerPage'],
				//'legend' => false,
				'empty' => false,
			)
		); ?>
</div>
