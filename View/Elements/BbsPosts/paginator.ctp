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
	<?php echo $this->Paginator->numbers(array(
			'tag' => 'li',
			'currentTag' => 'a',
			'currentClass' => 'active',
			'separator' => '',
			'first' => '<<',
			'last' => '>>',
			'modulus' => '4',
		)); ?>
	</li>
</ul>

