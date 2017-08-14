<?php
/**
 * 根記事リスト(index)の根記事タイトル Element
 *
 * ## elementの引数
 * * $bbsArticle: 記事データ
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$title = $this->NetCommonsHtml->titleIcon($bbsArticle['BbsArticle']['title_icon']);
$title .= ' ';
$title .= h(CakeText::truncate($bbsArticle['BbsArticle']['title'], BbsArticle::LIST_TITLE_LENGTH));

echo $this->NetCommonsHtml->link(
	$title,
	array('action' => 'view', 'key' => $bbsArticle['BbsArticle']['key']),
	array('escape' => false)
);

echo $this->Workflow->label($bbsArticle['BbsArticle']['status']);
