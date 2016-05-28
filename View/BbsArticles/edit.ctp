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

echo $this->NetCommonsHtml->css('/bbses/css/style.css');

echo $this->NetCommonsHtml->script(array(
	'/bbses/js/bbses.js'
));

$bbsArticle = array();
$bbsArticle['content'] = $this->data['BbsArticle']['content'];
?>

<div ng-controller="BbsArticlesEdit"
	ng-init="initialize(<?php echo h(json_encode(array('bbsArticle' => $bbsArticle))); ?>)">

	<article>
		<?php echo $this->NetCommonsHtml->blockTitle($bbs['name']); ?>

		<?php
			if ($this->params['action'] === 'reply') {
				if (isset($rootBbsArticle)) {
					echo $this->element('BbsArticles/view_bbs_article', array(
						'bbsArticle' => $rootBbsArticle,
						'parentBbsArticle' => null,
						'bodyHide' => 'false',
						'footerHide' => true,
						'panelClass' => 'panel-info',
					));

					if (isset($parentParentBbsArticle)) {
						echo $this->element('BbsArticles/view_bbs_article', array(
							'bbsArticle' => $parentBbsArticle,
							'parentBbsArticle' => $parentParentBbsArticle,
							'bodyHide' => 'false',
							'footerHide' => true,
							'panelClass' => 'panel-warning',
						));
					}

					if (isset($parentBbsArticle)) {
						echo $this->element('BbsArticles/view_bbs_article', array(
							'bbsArticle' => $currentBbsArticle,
							'parentBbsArticle' => $parentBbsArticle,
							'bodyHide' => 'true',
							'footerHide' => true,
							'panelClass' => 'panel-success',
						));
					} else {
						echo $this->element('BbsArticles/view_bbs_article', array(
							'bbsArticle' => $currentBbsArticle,
							'parentBbsArticle' => null,
							'bodyHide' => 'true',
							'footerHide' => true,
							'panelClass' => 'panel-success',
						));
					}
				} else {
					echo $this->element('BbsArticles/view_bbs_article', array(
						'bbsArticle' => $currentBbsArticle,
						'parentBbsArticle' => null,
						'panelClass' => 'panel-info',
						'bodyHide' => 'false',
						'footerHide' => true,
					));
				}
			}
		?>

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

				<?php
					if ($this->params['action'] === 'edit' && $this->data['BbsArticleTree']['root_id']) {
						echo $this->BbsesForm->replyEditButtons('BbsArticle.status');
					} else {
						if ($this->params['action'] === 'reply') {
							$cancelUrl = $this->NetCommonsHtml->url(
								array('action' => 'view', 'key' => Hash::get($currentBbsArticle, 'BbsArticle.key'))
							);
						} elseif ($this->params['action'] === 'edit') {
							$cancelUrl = $this->NetCommonsHtml->url(
								array('action' => 'view', 'key' => Hash::get($this->request->data, 'BbsArticle.key'))
							);
						} else {
							$cancelUrl = null;
						}
						echo $this->Workflow->buttons('BbsArticle.status', $cancelUrl);
					}
				?>
			<?php echo $this->NetCommonsForm->end(); ?>

			<?php if ($this->request->params['action'] === 'edit' && $this->Workflow->canDelete('BbsArticle', $this->data)) : ?>
				<div class="panel-footer text-right">
					<?php echo $this->element('BbsArticles/delete_form'); ?>
				</div>
			<?php endif; ?>
		</div>

		<?php echo $this->Workflow->comments(); ?>
	</article>
</div>
