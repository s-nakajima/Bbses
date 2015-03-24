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

<ol class="breadcrumb">
	<li>
		<a href="<?php echo $this->Html->url('/bbses/bbses/index/' . $frameId . '/') ?>">
			<?php echo h($bbs['name']); ?>
		</a>
	</li>
	<li class="active">
		<?php echo String::truncate($bbsPost['bbsPostI18n']['title'], BbsPostI18n::DISPLAY_MAX_TITLE_LENGTH); ?>
	</li>
</ol>
