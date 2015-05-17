<?php
/**
 * BbsArticles edit
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Html->script('/net_commons/js/wysiwyg.js', false); ?>
<?php echo $this->Html->script('/bbses/js/bbses.js', false); ?>

<div class="frame">
	<div class="nc-content-list" id="nc-bbs-article-<?php echo $frameId; ?>" ng-controller="BbsArticlesEdit"
			ng-init="initialize(<?php echo h(json_encode(['bbsArticle' => ['content' => $bbsArticle['content']]])); ?>)">

		<article>
			<h1>
				<?php echo h($bbs['name']); ?>
			</h1>

			<div class="panel panel-default">
				<?php echo $this->Form->create('BbsArticle', array('novalidate' => true)); ?>
					<div class="panel-body">

						<?php echo $this->element('BbsArticles/edit_form'); ?>

						<hr />

						<?php echo $this->element('Comments.form'); ?>

					</div>
					<div class="panel-footer text-center">
						<?php echo $this->element('NetCommons.workflow_buttons'); ?>
					</div>
				<?php echo $this->Form->end(); ?>

				<?php if ($this->request->params['action'] === 'edit') : ?>
					<div class="panel-footer text-right">
						<?php echo $this->element('BbsArticles/delete_form'); ?>
					</div>
				<?php endif; ?>
			</div>

			<?php echo $this->element('Comments.index'); ?>

		</article>
	</div>
</div>
