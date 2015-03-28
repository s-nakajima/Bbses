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

$curretStatus = isset($this->Paginator->params['named']['status']) ? $this->Paginator->params['named']['status'] : '';

$options = array(
	'BbsPost.last_status_' => array(
		'label' => __d('bbses', 'Display all posts'),
		'status' => null,
	),
	//'BbsPostUser.id' => array(
	//	'label' => __d('bbses', 'Unread'),
	//	'status' => null,
	//),
	'BbsPost.last_status_' . NetCommonsBlockComponent::STATUS_PUBLISHED => array(
		'label' => __d('bbses', 'Published'),
		'status' => NetCommonsBlockComponent::STATUS_PUBLISHED,
	),
	'BbsPost.last_status_' . NetCommonsBlockComponent::STATUS_IN_DRAFT => array(
		'label' => __d('net_commons', 'Temporary'),
		'status' => NetCommonsBlockComponent::STATUS_IN_DRAFT,
	),
	'BbsPost.last_status_' . NetCommonsBlockComponent::STATUS_APPROVED => array(
		'label' => __d('net_commons', 'Approving'),
		'status' => NetCommonsBlockComponent::STATUS_APPROVED,
	),
	'BbsPost.last_status_' . NetCommonsBlockComponent::STATUS_DISAPPROVED => array(
		'label' => __d('net_commons', 'Disapproving'),
		'status' => NetCommonsBlockComponent::STATUS_DISAPPROVED,
	),
);
?>

<span class="btn-group">
	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $options['BbsPost.last_status_' . $curretStatus]['label']; ?>
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu" role="menu">
		<?php foreach ($options as $key => $status) : ?>
			<li>
				<?php echo $this->Paginator->link($status['label'],
						array('status' => $status['status']),
						array('url' => $url)
					); ?>
			</li>
		<?php endforeach; ?>
	</ul>
</span>
