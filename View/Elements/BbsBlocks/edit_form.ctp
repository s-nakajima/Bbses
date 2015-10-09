<?php
/**
 * BbsSettings edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->element('Blocks.form_hidden'); ?>

<?php echo $this->NetCommonsForm->hidden('Bbs.id'); ?>
<?php echo $this->NetCommonsForm->hidden('Bbs.key'); ?>
<?php echo $this->NetCommonsForm->hidden('BbsSetting.id'); ?>
<?php echo $this->NetCommonsForm->hidden('BbsFrameSetting.id'); ?>
<?php echo $this->NetCommonsForm->hidden('BbsFrameSetting.frame_key'); ?>
<?php echo $this->NetCommonsForm->hidden('BbsFrameSetting.articles_per_page'); ?>
<?php echo $this->NetCommonsForm->hidden('BbsFrameSetting.comments_per_page'); ?>

<?php echo $this->NetCommonsForm->input('Bbs.name', array(
		'type' => 'text',
		'label' => __d('bbses', 'Bbs name'),
	)); ?>

<?php echo $this->element('Blocks.public_type'); ?>

<?php echo $this->NetCommonsForm->inlineCheckbox('BbsSetting.use_comment', array(
			'label' => __d('bbses', 'Use comment')
	)); ?>

<?php echo $this->Like->setting('BbsSetting.use_like', 'BbsSetting.use_unlike');
