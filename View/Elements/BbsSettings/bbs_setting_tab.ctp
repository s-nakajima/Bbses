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
				'/bbses/bbs_settings/' . ($this->request->params['action'] === 'add' ? 'add' : 'edit') . '/' . $frameId); ?>">

			<?php echo __d('bbses', 'BBS Setting'); ?>
		</a>
	</li>
	<li class="<?php if ($active === 'authority_setting') : ?>active<?php endif; ?>">
		<a href="<?php echo $this->Html->url('/bbses/authority_settings/edit/' . $frameId); ?>">
			<?php echo __d('bbses', 'Authority Setting'); ?>
		</a>
	</li>
</ul>
<br />
