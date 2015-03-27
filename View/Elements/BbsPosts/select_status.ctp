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
?>

<div class="btn-group inline-block">
	<button type="button" class="btn btn-default" data-toggle="dropdown" aria-expanded="false">
		<?php //echo $narrowDown; ?>
		<?php echo __d('bbses', 'Display all posts'); ?>
	</button>
	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<span class="caret"></span>
		<span class="sr-only"></span>
	</button>
	<ul class="dropdown-menu" role="menu">
		<li>
			<a href="">
				<?php echo __d('bbses', 'Display all posts'); ?>
			</a>
		</li>
		<li>
			<a href="">
				<?php echo __d('bbses', 'Unread'); ?>
			</a>
		</li>
		<li>
			<a href="">
				<?php echo __d('bbses', 'Published'); ?>
			</a>
		</li>
		<li>
			<a href="">
				<?php echo __d('net_commons', 'Temporary'); ?>
			</a>
		</li>
		<li>
			<a href="">
				<?php echo __d('bbses', 'Remand'); ?>
			</a>
		</li>
		<li>
			<a href="">
				<?php echo __d('net_commons', 'Approving'); ?>
			</a>
		</li>
	</ul>
</div>
