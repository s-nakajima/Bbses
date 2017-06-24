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

App::uses('BbsFrameSetting', 'Bbses.Model');
?>

<?php echo $this->NetCommonsForm->hidden('Frame.id'); ?>
<?php echo $this->NetCommonsForm->hidden('BbsFrameSetting.id'); ?>
<?php echo $this->NetCommonsForm->hidden('BbsFrameSetting.frame_key'); ?>

<?php
	echo $this->NetCommonsForm->input('BbsFrameSetting.display_type', array(
		'type' => 'select',
		'options' => array(
			BbsFrameSetting::DISPLAY_TYPE_ROOT => __d('bbses', 'List of root articles'),
			BbsFrameSetting::DISPLAY_TYPE_FLAT => __d('bbses', 'Flat list of root articles'),
		),
		'label' => __d('bbses', 'Display method'),
	));
?>

<?php echo $this->DisplayNumber->select('BbsFrameSetting.articles_per_page', array(
		'label' => __d('bbses', 'Show articles per page'),
		'unit' => array(
			'single' => __d('bbses', '%s article'),
			'multiple' => __d('bbses', '%s articles')
		),
	));
