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

<!-- TODO:公開権限があれば編集／削除できる -->
<!-- もしくは　編集権限があり、公開されていなければ、編集／削除できる -->
<!-- もしくは 作成権限があり、自分の書いた記事で、公開されていなければ、編集／削除できる -->
<?php if ($contentPublishable ||
		($contentEditable &&
			$status !== NetCommonsBlockComponent::STATUS_PUBLISHED) ||
		($contentCreatable &&
			$status !== NetCommonsBlockComponent::STATUS_PUBLISHED &&
				$createUser === $userId)): ?>

	<a href="<?php echo $this->Html->url('/bbses/bbs_posts/edit/' . $frameId . '/' . $bbsPostId); ?>"
		class="btn btn-primary btn-xs" tooltip="<?php echo __d('bbses', 'Edit'); ?>">

		<span class="glyphicon glyphicon-edit"> </span>
	</a>
<?php endif;
