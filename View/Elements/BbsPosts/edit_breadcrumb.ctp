<?php
/**
 * Bbs post breadcrumb view  for editor template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<ol class="breadcrumb form-group">
	<li>
		<a href="<?php echo $this->Html->url('/bbses/bbses/index/' . $frameId) ?>">
			<?php echo $bbs['name']; ?>
		</a>
	</li>
	<?php if (isset($bbsPost['id']) && $this->request->params['action'] !== 'add') : ?>
		<li>
			<a href="<?php echo $this->Html->url('/bbses/bbs_posts/view/' . $frameId . '/' . $bbsPost['id']) ?>">
				<?php echo $bbsPost['title']; ?>
			</a>
		</li>
	<?php endif; ?>

	<li class="active">
		<?php if ($this->request->params['action'] === 'add') : ?>
			<?php echo __d('bbses', 'Create post'); ?>
		<?php else : ?>
			<?php echo __d('bbses', 'Edit'); ?>
		<?php endif; ?>
	</li>
</ol>
