<?php
/**
 * Bbs post view template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$url = Hash::merge(
	array('controller' => 'bbs_posts', 'action' => 'index', $frameId),
	$this->Paginator->params['named']
);

$curretSort = isset($this->Paginator->params['named']['sort']) ? $this->Paginator->params['named']['sort'] : 'BbsPost.created';
$curretDirection = isset($this->Paginator->params['named']['direction']) ? $this->Paginator->params['named']['direction'] : 'desc';

$options = array(
	'BbsPost.created.desc' => array(
		'label' => __d('bbses', 'Latest post order'),
		'sort' => 'BbsPost.created',
		'direction' => 'desc'
	),
	'BbsPost.created.asc' => array(
		'label' => __d('bbses', 'Older post order'),
		'sort' => 'BbsPost.created',
		'direction' => 'asc'
	),
	'BbsPost.id.asc' => array(
		'label' => __d('bbses', 'Descending order of comments'),
		'sort' => 'BbsPost.id',
		'direction' => 'asc'
	),
);

?>

<span class="btn-group">
	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $options[$curretSort . '.' . $curretDirection]['label']; ?>
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu" role="menu">
		<?php foreach ($options as $key => $sort) : ?>
			<li>
				<?php echo $this->Paginator->link($sort['label'], array('sort' => $sort['sort'], 'direction' => $sort['direction']), array('url' => $url)); ?>
			</li>
		<?php endforeach; ?>
	</ul>
</span>
