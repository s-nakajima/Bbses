<?php
/**
 * Element of BbsArticle delete
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->NetCommonsForm->create('BbsArticle', array(
		'type' => 'delete',
		'action' => 'delete/' . Current::read('Frame.id') . '/' . h($this->data['BbsArticle']['key'])
	)); ?>

	<?php echo $this->NetCommonsForm->hidden('Frame.id'); ?>
	<?php echo $this->NetCommonsForm->hidden('Block.id'); ?>
	<?php echo $this->NetCommonsForm->hidden('Block.key'); ?>

	<?php echo $this->NetCommonsForm->hidden('Bbs.id'); ?>
	<?php echo $this->NetCommonsForm->hidden('Bbs.key'); ?>
	<?php echo $this->NetCommonsForm->hidden('BbsArticle.id'); ?>
	<?php echo $this->NetCommonsForm->hidden('BbsArticle.key'); ?>
	<?php echo $this->NetCommonsForm->hidden('BbsArticle.language_id'); ?>
	<?php echo $this->NetCommonsForm->hidden('BbsArticleTree.root_id'); ?>

	<?php echo $this->Button->delete('',
			sprintf(__d('net_commons', 'Deleting the %s. Are you sure to proceed?'), __d('bbses', 'article'))
		); ?>
<?php echo $this->NetCommonsForm->end();
