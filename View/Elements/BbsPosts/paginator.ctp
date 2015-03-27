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

<?php if ((int)$this->Paginator->param('count') > 0) : ?>

	<ul class="pagination">
		<?php echo $this->Paginator->first('«', array(
				'tag' => 'li',
				'url' => Hash::merge(
					array('controller' => 'bbs_posts', 'action' => 'index', $frameId),
					$this->Paginator->params['named']
				)
			)); ?>

		<?php echo $this->Paginator->numbers(array(
				'tag' => 'li',
				'currentTag' => 'a',
				'currentClass' => 'active',
				'separator' => '',
				'first' => false,
				'last' => false,
				'modulus' => '4',
				'url' => Hash::merge(
					array('controller' => 'bbs_posts', 'action' => 'index', $frameId),
					$this->Paginator->params['named']
				)
			)); ?>

		<?php echo $this->Paginator->last('»', array(
				'tag' => 'li',
				'url' => Hash::merge(
					array('controller' => 'bbs_posts', 'action' => 'index', $frameId),
					$this->Paginator->params['named']
				)
			)); ?>
		</li>
	</ul>

<?php endif;
