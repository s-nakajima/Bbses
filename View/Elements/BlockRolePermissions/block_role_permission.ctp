<?php
/**
 * BbsSettings edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php if ($defaultPermission) : ?>
	<?php foreach ($roles as $key => $role) : ?>
		<?php if (isset($defaultPermission[$key]) && isset($rolesRooms[$key])) : ?>
			<div class="inline-block">
				<?php
					$name = 'BlockRolePermission.' . $permission . '.' . $key;
					$rolesRoomId = isset($rolesRooms[$key]) ? (int)$rolesRooms[$key]['id'] : null;

					if (! $defaultPermission[$key]['fixed']) {
						echo $this->Form->checkbox($name . '.value', array(
								'div' => false,
								'checked' => isset($blockPermission[$rolesRoomId]) ?
												(int)$blockPermission[$rolesRoomId]['value'] : (int)$defaultPermission[$key]['value'],
							));

						echo $this->Form->label($name . '.value', h($role['name']));

						echo $this->Form->hidden($name . '.id', array(
								'value' => isset($blockPermission[$rolesRoomId]) ? $blockPermission[$rolesRoomId]['id'] : null,
							));

						echo $this->Form->hidden($name . '.roles_room_id', array(
								'value' => $rolesRoomId,
							));

						echo $this->Form->hidden($name . '.block_key', array(
								'value' => $blockKey,
							));

						echo $this->Form->hidden($name . '.permission', array(
								'value' => $permission,
							));
					}
					if ($defaultPermission[$key]['fixed'] && $defaultPermission[$key]['value']) {
						echo $this->Form->checkbox($name . '.value', array(
								'div' => false,
								'disabled' => true,
								'checked' => (int)$defaultPermission[$key]['value']
							));

						echo $this->Form->label('', h($role['name']));
					}
				?>
			</div>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif;
