<?php 
	$photo_hash = (explode('.', $view_data['photo_data']->file_name))[0]; 
?>

<div class="container-photo">
	<div class="photo-single">
		<a href="<?php echo ROOT_PATH . 'user/account/' . $view_data['photo_user']->getUserData()->login; ?>"><?php echo $view_data['photo_user']->getUserData()->login; ?></a>
		<a href="<?php echo ROOT_PATH . 'photo/delete/' . $photo_hash ?>"> | delete </a>
		<img src="<?php echo PHOTO_PATH . $view_data['photo_data']->file_name;?>">
	</div>
	<div class="photo-likes">
		<span 	<?php if ($view_data['photo_is_liked']) {echo 'class="liked"';}?> >
			<a href="<?php echo ROOT_PATH . 'photo/like/' . $photo_hash; ?>">&#10084;</a>
		</span>
		<?php echo $view_data['photo_likes_n']?>
	</div>
	<div class="photo-add-comment">
		<form method="POST" action="<?php echo ROOT_PATH . 'photo/comment/' . $photo_hash; ?>">
			<input maxlength="1000" type="text" name="comment" placeholder="add comment...">
			<input type="submit" name="submit" value=">">
		</form>
	</div>
	<div class="photo-comments">
		<?php 
			$comments = $view_data['photo_comments'];
			if ($comments) {
				foreach ($comments as $comment) {
					echo '<div class="photo-comment">';
					echo '<span class="photo-comment-author">';
					echo '<a href="' .  ROOT_PATH . 'user/account/' . $comment->login .	 '">';
					echo $comment->login . ' ';
					echo '</a>';
					echo '</span>';
					echo $comment->comment;
					if ($view_data['current_user']->exists() &&
						
						($view_data['current_user']->getUserData()->id == $view_data['photo_user']->getUserData()->id || 
						$comment->user_id == $view_data['current_user']->getUserData()->id)) {

						echo '<span class="photo-comment-delete">';
						echo '<a href="' . ROOT_PATH . 'comment/delete/' . $comment->comment_id . '">';
						echo ' delete';
						echo '</a>';
						echo '</span>';
					}
					echo '</div>';
				}
			}
		?>			
	</div>
</div>