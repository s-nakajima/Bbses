<?php
/**
 * Element of BbsArticles edit
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->NetCommonsForm->hidden('Frame.id'); ?>
<?php echo $this->NetCommonsForm->hidden('Frame.block_id'); ?>
<?php echo $this->NetCommonsForm->hidden('Block.id'); ?>
<?php echo $this->NetCommonsForm->hidden('Block.key'); ?>
<?php echo $this->NetCommonsForm->hidden('Bbs.id'); ?>
<?php echo $this->NetCommonsForm->hidden('Bbs.key'); ?>
<?php echo $this->NetCommonsForm->hidden('Bbs.name'); ?>
<?php echo $this->NetCommonsForm->hidden('BbsArticle.id'); ?>
<?php echo $this->NetCommonsForm->hidden('BbsArticle.key'); ?>
<?php echo $this->NetCommonsForm->hidden('BbsArticle.language_id'); ?>
<?php echo $this->NetCommonsForm->hidden('BbsArticle.bbs_id'); ?>
<?php echo $this->NetCommonsForm->hidden('BbsArticleTree.id'); ?>
<?php echo $this->NetCommonsForm->hidden('BbsArticleTree.bbs_key'); ?>
<?php echo $this->NetCommonsForm->hidden('BbsArticleTree.bbs_article_key'); ?>
<?php echo $this->NetCommonsForm->hidden('BbsArticleTree.root_id'); ?>
<?php echo $this->NetCommonsForm->hidden('BbsArticleTree.parent_id'); ?>

<?php echo $this->NetCommonsForm->inputWithTitleIcon('BbsArticle.title', 'BbsArticle.title_icon', array(
		'label' => __d('bbses', 'Title'),
		'required' => true,
	)); ?>

<?php echo $this->NetCommonsForm->wysiwyg('BbsArticle.content', array(
		'label' => __d('bbses', 'Content'),
		'required' => true,
	));


