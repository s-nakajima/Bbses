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
$options = BbsFrameSetting::getDisplayNumberOptions();
?>

<span class="btn-group">
	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $options[$this->Paginator->param('limit')]; ?>
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu" role="menu">
		<?php foreach ($options as $count => $label) : ?>
			<li<?php echo (int)$this->Paginator->param('limit') === $count ? ' class="active"' : ''; ?>>
				<?php echo $this->Paginator->link($label, array('limit' => $count), array('url' => $url)); ?>
			</li>
		<?php endforeach; ?>
	</ul>
</span>
