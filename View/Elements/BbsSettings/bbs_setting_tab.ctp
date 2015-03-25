<?php
/**
 * Bbs view for editor template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<ul class="nav nav-pills" role="tablist">
	<li class="<?php if ($active === 'bbs_setting') : ?>active<?php endif; ?>">
		<a href="<?php echo $this->Html->url(
				'/bbses/bbs_settings/' . h($this->request->params['action']) . '/' . $frameId . '/' . $blockId); ?>">

			<?php echo __d('bbses', 'BBS Setting'); ?>
		</a>
	</li>
	<?php if ($this->request->params['action'] === 'edit') : ?>
		<li class="<?php if ($active === 'block_role_permission') : ?>active<?php endif; ?>">
			<a href="<?php echo $this->Html->url('/bbses/block_role_permissions/edit/' . $frameId . '/' . $blockId); ?>">
				<?php echo __d('bbses', 'Authority Setting'); ?>
			</a>
		</li>
	<?php endif; ?>
</ul>
<br />
