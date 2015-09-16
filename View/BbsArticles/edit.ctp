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

echo $this->NetCommonsHtml->script(array(
	'/net_commons/js/wysiwyg.js',
	'/bbses/js/bbses.js'
));

$bbsArticle = array();
$bbsArticle['content'] = $this->data['BbsArticle']['content'];
?>

<div class="nc-content-list" ng-controller="BbsArticlesEdit"
	ng-init="initialize(<?php echo h(json_encode(array('bbsArticle' => $bbsArticle))); ?>)">

	<article>
		<h1>
			<?php echo h($bbs['name']); ?>
		</h1>

		<div class="panel panel-default">
			<?php echo $this->NetCommonsForm->create('BbsArticle'); ?>
				<div class="panel-body">

					<?php echo $this->element('BbsArticles/edit_form'); ?>

					<?php if ($this->request->params['action'] === 'add' ||
							$this->request->params['action'] === 'edit' && ! $this->data['BbsArticleTree']['root_id']) : ?>
						<hr />

						<?php echo $this->Workflow->inputComment('BbsArticle.status'); ?>
					<?php endif; ?>
				</div>

				<?php echo $this->Workflow->buttons('BbsArticle.status'); ?>
			<?php echo $this->Form->end(); ?>

			<?php if ($this->request->params['action'] === 'edit' && $this->Workflow->canDelete('BbsArticle', $this->data)) : ?>
				<div class="panel-footer text-right">
					<?php echo $this->element('BbsArticles/delete_form'); ?>
				</div>
			<?php endif; ?>
		</div>

		<?php echo $this->Workflow->comments(); ?>
	</article>
</div>
