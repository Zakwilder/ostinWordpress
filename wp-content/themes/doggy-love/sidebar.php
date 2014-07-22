<div id="sidebar">
	<div id="sidebar1">
		<ul>
		<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar(1) ) : ?>
			<?php wp_list_pages('title_li=<h4>Страницы</h4>'); ?>
		
			<?php wp_list_categories('show_count=1&title_li=<h4>Категории</h4>'); ?>

			<li>
				<h4>Архивы</h4>
				<ul><?php wp_get_archives('type=monthly'); ?></ul>
			</li>
			<li><h4>Календарь</h4><?php get_calendar(); ?></li>
		<?php	endif;?>		
		</ul>
	</div>
	<div id="sidebar2">
		<ul>
		<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar(2) ) : ?>
			<li><h4>Последние записи</h4><ul><?php wp_get_archives('type=postbypost&limit=5')?></ul></li>
			
			<li><h4>Облако меток</h4><?php wp_tag_cloud('smallest=10&largest=20&number=30&unit=px&format=flat&orderby=name'); ?></li>

			<?php if ( is_home() || is_page() ) { 	/* If this is the frontpage */ 
					wp_list_bookmarks('orderby=rand&title_before=<h4>&title_after=</h4>&between=<br/>&show_description=1&limit=20');

			} ?>
			<li><h4>Мета</h4>
				<ul>
				<?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<li><a href="<?php bloginfo('rss2_url'); ?>" title="Подпишитесь на записи блога через RSS 2.0"Записи в <abbr title="Really Simple Syndication">RSS<</a></li>
				<li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="Последние комментарии на блоге через RSS">Комментарии в <abbr title="Really Simple Syndication">RSS</abbr></a></li>
				
				<?php wp_meta(); ?>
				</ul>
			</li>		
		<?php	endif;?>		
		</ul>
	</div>
</div>