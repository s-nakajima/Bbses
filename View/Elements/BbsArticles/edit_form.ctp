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

<?php echo $this->Form->hidden('Frame.id', array(
		'value' => $frameId,
	)); ?>

<?php echo $this->Form->hidden('Block.id', array(
		'value' => $blockId,
	)); ?>

<?php echo $this->Form->hidden('Block.key', array(
		'value' => $blockKey,
	)); ?>

<?php echo $this->Form->hidden('Bbs.id', array(
		'value' => $bbs['id'],
	)); ?>

<?php echo $this->Form->hidden('Bbs.key', array(
		'value' => $bbs['key'],
	)); ?>

<?php echo $this->Form->hidden('BbsArticle.id', array(
		'value' => isset($bbsArticle['id']) ? (int)$bbsArticle['id'] : null,
	)); ?>

<?php echo $this->Form->hidden('BbsArticle.key', array(
		'value' => $bbsArticle['key'],
	)); ?>

<?php echo $this->Form->hidden('BbsArticle.language_id', array(
		'value' => $languageId,
	)); ?>

<?php echo $this->Form->hidden('BbsArticle.bbs_id', array(
		'value' => $bbs['id'],
	)); ?>

<?php echo $this->Form->hidden('BbsArticleTree.id', array(
		'value' => isset($bbsArticleTree['id']) ? (int)$bbsArticleTree['id'] : null,
	)); ?>

<?php echo $this->Form->hidden('BbsArticleTree.bbs_key', array(
		'value' => $bbs['key'],
	)); ?>

<?php echo $this->Form->hidden('BbsArticleTree.bbs_article_key', array(
		'value' => isset($bbsArticleTree['bbsArticleKey']) ? (int)$bbsArticleTree['bbsArticleKey'] : null,
	)); ?>

<?php echo $this->Form->hidden('BbsArticleTree.root_id', array(
		'value' => isset($bbsArticleTree['rootId']) ? (int)$bbsArticleTree['rootId'] : null,
	)); ?>

<?php echo $this->Form->hidden('BbsArticleTree.parent_id', array(
		'value' => isset($bbsArticleTree['parentId']) ? (int)$bbsArticleTree['parentId'] : null,
	)); ?>

<div class="form-group">
	<?php echo $this->Form->input(
			'BbsArticle.title', array(
				'type' => 'text',
				'label' => __d('bbses', 'Title') . $this->element('NetCommons.required'),
				'error' => false,
				'class' => 'form-control',
				'value' => (isset($bbsArticle['title']) ? $bbsArticle['title'] : null)
			)
		); ?>

	<?php echo $this->element(
		'NetCommons.errors', [
			'errors' => $this->validationErrors,
			'model' => 'BbsArticle',
			'field' => 'title',
		]); ?>
</div>

<div class="form-group">
	<label class="control-label">
		<?php echo __d('bbses', 'Content'); ?>
		<?php echo $this->element('NetCommons.required'); ?>
	</label>
	<?php echo $this->Form->textarea('BbsArticle.content', array(
			'label' => false,
			'class' => 'form-control',
			'ui-tinymce' => 'tinymce.options',
			'ng-model' => 'bbsArticle.content',
			'rows' => 5,
			'required' => 'required',
		)); ?>

	<?php echo $this->element(
		'NetCommons.errors', [
			'errors' => $this->validationErrors,
			'model' => 'BbsArticle',
			'field' => 'content',
		]); ?>
</div>

