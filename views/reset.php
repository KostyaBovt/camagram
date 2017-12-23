<div class="register-container" id="register-container-forgot">
	<?php 
		if (Message::exists('reset_fail')) {
			$reset_errors = Message::get('reset_fail');
			echo '<div class="register-errors">';
			
			foreach ($reset_errors as $reset_error) {
				echo '<div class="register-error">';
				echo $reset_error;
				echo '</div>';	
			}
			echo '</div>';
		}

		if (Message::exists('reset_success')) {
			echo '<div class="register-success">';
			echo Message::get('reset_success');
			echo '</div>';
		}
	?>
	<div class="register-header">
		<h1>Reset password</h1>
	</div>
	<form method="POST" action="<?php echo ROOT_PATH . 'user/reset/'; if (isset($view_data['hashes'])) {echo $view_data['hashes']['email_hash'] . '/' . $view_data['hashes']['reset_hash'];} ?>">
		<table>
			<tr>
				<td>New Password</td>
				<td><input type="password" name="password" id="password"></td>
			</tr>
			<tr>
				<td>Repeat Password</td>
				<td>
					<input type="password" name="repeat_password" id="repeat_password">
					<input type="hidden" name="email_hash" id="email_hash" value="<?php echo $view_data['hashes']['email_hash']; ?>">
					<input type="hidden" name="reset_hash" id="reset_hash" value="<?php echo $view_data['hashes']['reset_hash']; ?>">
				</td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="submit" id="submit" value="Save new password"></td>
			</tr>

		</table>
	</form>	
</div>
