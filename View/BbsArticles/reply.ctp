<?php
/**
 * コメントを書く
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

	<article class="bbs-article">
		<?php
			//親記事
			if ($this->params['action'] === 'reply') {
				echo $this->element('BbsArticles/view_bbs_root_article', array(
					'bbsArticle' => $currentBbsArticle,
				));
			}
		?>

		<article class="row">
			<div class="col-xs-offset-1 col-xs-11">
				<?php echo $this->element('BbsArticles/edit_form'); ?>
			</div>
		</article>
	</article>
</div>
