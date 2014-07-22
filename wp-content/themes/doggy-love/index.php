<?php get_header(); ?>
<div id="content">
<?php 
	if(is_home()||is_front_page()) echo '<div class="spacer">&nbsp;</div>';
	if (have_posts()) :
		$post = $posts[0]; // Hack. Set $post so that the_date() works.
		if(is_category()){
			echo '<h3 class="archivetitle">Архив категории &raquo;'.single_cat_title('',FALSE).' &laquo;</h3>';
		}elseif(is_day()){
			echo '<h3 class="archivetitle">Архив за &raquo; '.get_the_time('j F Y').'&laquo;</h3>';
		}elseif(is_month()){
			echo '<h3 class="archivetitle">Архив за &raquo; '.get_the_time('F, Y').' &laquo;</h3>';
		}elseif(is_year()){
			echo '<h3 class="archivetitle">Архив за &raquo; '.get_the_time('Y').' &laquo;</h3>';
		} elseif(is_search()){
			echo '<h3 class="archivetitle">Результаты поиска</h3>';
		}elseif(is_author()){
			echo '<h3 class="archivetitle">Архив автора</h3>';
		}elseif(isset($_GET['paged']) && !empty($_GET['paged'])){ // If this is a paged archive
			echo '<h3 class="archivetitle">Архив блога</h3>';
		}elseif(is_tag()){
			echo '<h3 class="archivetitle">Архив меток &raquo; '.single_tag_title('',FALSE).' &laquo; </h3>';
		}
		while (have_posts()) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h2 class="post_title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Постоянная ссылка на <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
				<div class="post_author">Автор: <?php the_author_posts_link('nickname'); ?> <?php edit_post_link(' Edit ',' // &raquo;','&laquo;'); ?></div>
				<div class="post_date"><div class="post_date_day"><?php the_time('d');?></div><div class="post_date_month"><?php the_time('M');?> <?php the_time('Y');?></div></div>
				<div class="entry">
				<?php 
					if (is_search()){
						the_excerpt();
					}else{
						the_content('далее...'); 
					}
				?>
					<div class="clear"></div>
				</div>
				<div class="info">
					<span class="category">Категория: <?php the_category(', ') ?></span>
					<?php the_tags('&nbsp;<span class="tags">Метки: ', ', ', '</span>'); ?>
					&nbsp;<span class="bubble"><?php comments_popup_link('Оставить комментарий!','Комментарии (1)', 'Комментарии (%)', '','Комментарии закрыты'); ?></span>
				</div>
			</div>
<?php 
		endwhile; 
?>
		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Предыдущие записи') ?></div>
			<div class="alignright"><?php previous_posts_link('Следующие записи &raquo;') ?></div>
		</div>
<?php 
	else : ?>
		<h3 class="archivetitle">Не найдено</h3>
		<p class="sorry">"Извините, ничего не нашлось. Воспользуйтесь навигацией или поиском, чтобы найти необходимую вам информацию. Try something else.</p>
<?php
	endif;
?>	
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>