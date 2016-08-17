<?php
/**
 * 記事編集・根記事追加
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
		<?php echo $this->NetCommonsHtml->blockTitle($bbs['name']); ?>
		<?php echo $this->element('BbsArticles/edit_form'); ?>
	</article>
</div>
