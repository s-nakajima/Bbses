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

<?php if ($bbsPost['bbsPostI18n']['status'] === NetCommonsBlockComponent::STATUS_APPROVED && $contentPublishable) : ?>
	<?php echo $this->Form->create('', array(
			'div' => false,
			'class' => 'inline-block-left',
			'type' => 'post',
			'url' => '/bbses/bbs_posts/approve/' . $frameId . '/' . $bbsPost['bbsPost']['id']
		)); ?>

		<?php echo $this->Form->hidden('BbsPost.id', array(
				'value' => isset($bbsPost['bbsPost']['id']) ? (int)$bbsPost['bbsPost']['id'] : null,
			)); ?>

		<?php echo $this->Form->hidden('BbsPostI18n.id', array(
				'value' => isset($bbsPost['bbsPostI18n']['id']) ? (int)$bbsPost['bbsPostI18n']['id'] : null,
			)); ?>

		<?php echo $this->Form->button('<span class="glyphicon glyphicon-ok"></span>', array(
				'name' => 'save_' . NetCommonsBlockComponent::STATUS_PUBLISHED,
				'class' => 'btn btn-warning btn-xs',
				'tooltip' => __d('bbses', 'Approving')
			)); ?>
	<?php echo $this->Form->end(); ?>
<?php endif;
