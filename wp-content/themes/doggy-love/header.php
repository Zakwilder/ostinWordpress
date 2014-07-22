<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
	<link rel="alternate" type="application/rss+xml" title="RSS-лента <?php bloginfo('name'); ?>" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_get_archives('type=yearly&format=link'); ?>
	<title><?php wp_title('&raquo; ',true,'right'); ?><?php bloginfo('name'); ?><?php echo ($paged>1)? " - Page $paged":"";?></title>
	<?php if(is_singular()){ wp_enqueue_script('comment-reply');}?>
	<?php wp_enqueue_script('jquery');?>
	<?php wp_head(); ?>
	<style type="text/css">
		#header {<?php
			$tmp=file_exists(dirname(__FILE__)."/images/bg_header_new.jpg")? "bg_header_new.jpg":"bg_header.jpg";
			echo "background:url(".get_bloginfo('template_directory')."/images/{$tmp}) no-repeat center top;";
		?>}
	</style>
</head>
<body>
<div id="bg_top"><div id="base">
	<div id="header">
		<?php if($tmp=="bg_header.jpg"){?>
			<?php $tmp=(is_single() || is_page())? "div":"h1";?>
			<<?php echo $tmp;?>  id="blogtitle"><a href="<?php echo get_option('home'); ?>"><?php bloginfo('name'); ?></a></<?php echo $tmp;?>>
			<div id="subtitle"><?php bloginfo('description');?></div>
		<?php }?>
		<a href="<?php bloginfo('url'); ?>/" title="Главная"><img src="<?php bloginfo('template_directory'); ?>/images/spacer.gif" alt="Главная" class="home"/></a>
		<a href="<?php bloginfo('rss2_url'); ?>" title="RSS-лента" class="rss"></a>
		<div id="mainsearch">
			<form id="mainsearchform" action="<?php bloginfo('url'); ?>/" method="get">
				<input class="input" type="text" value="Поиск ..." onfocus="if (this.value == 'Поиск ...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Поиск ...';}" name="s" id="s" />
			</form>
		</div>
		<div id="menu">
			<ul>
			<?php
				$options = get_option('widget_pages'); 
				$exclude = empty($options['exclude'] ) ? '' : $options['exclude']; 
				wp_list_pages('sort_column=menu_order&depth=1&title_li=&exclude='.$exclude);
			?>
			</ul>
		</div>
	</div>
	<div id="container">