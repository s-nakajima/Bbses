<?php
/**
 * BbsPosts view
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<ol class="breadcrumb">
	<li>
		<a href="<?php echo $this->Html->url('/bbses/bbses/index/' . $frameId . '/') ?>">
			<?php echo h($bbs['name']); ?>
		</a>
	</li>
	<li class="active">
		<?php echo String::truncate($bbsPost['bbsPostI18n'][0]['title'], BbsPostI18n::DISPLAY_MAX_TITLE_LENGTH); ?>
	</li>
</ol>

<?php if (! $bbsPost['bbsPost']['parentId']) : ?>
	<?php echo $this->element('BbsPosts/view_root_bbs_post', array('rootBbsPost' => $bbsPost)); ?>
<?php endif; ?>

