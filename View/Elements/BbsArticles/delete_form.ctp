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

<?php echo $this->Form->create('BbsArticle', array('type' => 'delete', 'action' => 'delete/' . $frameId . '/' . $bbsArticle['key'])); ?>
	<?php echo $this->Form->hidden('BbsArticle.id', array(
			'value' => isset($bbsArticle['id']) ? $bbsArticle['id'] : null,
		)); ?>
	<?php echo $this->Form->hidden('BbsArticle.key', array(
			'value' => isset($bbsArticle['key']) ? $bbsArticle['key'] : null,
		)); ?>
	<?php echo $this->Form->hidden('BbsArticleTree.root_id', array(
			'value' => isset($bbsArticleTree['rootId']) ? $bbsArticleTree['rootId'] : null,
		)); ?>
	<?php echo $this->Form->button('<span class="glyphicon glyphicon-trash"> </span>', array(
			'name' => 'delete',
			'class' => 'btn btn-danger',
			'onclick' => 'return confirm(\'' . sprintf(__d('net_commons', 'Deleting the %s. Are you sure to proceed?'), __d('bbses', 'article')) . '\')'
		)); ?>
<?php echo $this->Form->end();