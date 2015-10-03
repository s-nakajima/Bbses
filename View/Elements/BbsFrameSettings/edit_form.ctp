<?php
/**
 * Bbs frame setting element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->NetCommonsForm->hidden('Frame.id'); ?>
<?php echo $this->NetCommonsForm->hidden('BbsFrameSetting.id'); ?>
<?php echo $this->NetCommonsForm->hidden('BbsFrameSetting.frame_key'); ?>

<?php echo $this->DisplayNumber->select('BbsFrameSetting.articles_per_page', array(
		'label' => __d('bbses', 'Show articles per page'),
		'unit' => array(
			'single' => __d('bbses', '%s article'),
			'multiple' => __d('bbses', '%s articles')
		),
	)); ?>

<?php echo $this->DisplayNumber->select('BbsFrameSetting.comments_per_page', array(
		'label' => __d('bbses', 'Show comments per page'),
		'unit' => array(
			'single' => __d('bbses', '%s article'),
			'multiple' => __d('bbses', '%s articles')
		),
	));