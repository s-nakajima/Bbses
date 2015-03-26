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

<ul class="pagination">
	<li<?php echo (! $this->Paginator->hasPrev() ? ' class="disabled"' : '') ?>>
		<?php echo $this->Paginator->prev('<', ['tag' => false], '<', ['tag' => false]); ?>
	</li>

	<?php //echo $this->Paginator->next('>', ['tag' => 'li'], '>', ['tag' => 'li']); ?>

	<?php if ((int)$this->Paginator->counter('{:pages}') > Block::PAGE_MAX_INDEX) : ?>
		<?php echo $this->Paginator->numbers(array(
				'tag' => 'li',
				'currentTag' => 'a',
				'currentClass' => 'active',
				'separator' => '',
				'first' => false,
				'last' => false,
				'modulus' => '4',
			)); ?>
	<?php else : ?>
		<?php for ($i = 1; $i <= 5; $i++) : ?>
			<?php if ($this->Paginator->hasPage($i)) : ?>
				<li class="<?php echo ($this->Paginator->current() === $i ? 'active' : ''); ?>">
					<?php echo $this->Paginator->link($i, ['page' => $i]); ?>
				</li>
			<?php else : ?>
				<li class="disabled">
					<span><?php echo $i; ?></span>
				<li>
			<?php endif; ?>
		<?php endfor; ?>
	<?php endif; ?>

	<li<?php echo (! $this->Paginator->hasNext() ? ' class="disabled"' : '') ?>>
		<?php echo $this->Paginator->next('>', ['tag' => false], '>', ['tag' => false]); ?>
	</li>
</ul>

