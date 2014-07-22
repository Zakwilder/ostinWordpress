<?php 
/*
Plugin Name: ¤ Kama Easy Admin
Description: Добавляет настраиваемое, всплывающее меню админки на сам сайт (когда юзер залогинен). Менюшка удобно ходит сбоку не мешая работе. Так же, появляется удобная форма входа (если не залогинены).  <a href='/wp-admin/options-general.php?page=kama-easy-admin/kama_easy_admin.php'>Настроить</a>
Version: 3.1.2
Author: Timur Kamaev 
Plugin URI: http://wp-kama.ru/?p=127
*/
if (!defined('ABSPATH')) die('Это разрыв');

	
define('KEA_FOLDER', 'kama-easy-admin');
define('KEA_BASE', KEA_FOLDER .'/kama_easy_admin.php');
	
	
class KamaEasyAdmin
{
	var $options;
	var $site;
	
	public static function instance(){
		static $self = false;
		if(!$self)
			$self = new KamaEasyAdmin();
		return $self;
	}
	
	private function __construct(){
		$this->kea_options();
		$this->site = get_bloginfo('url');
		
		add_action ( 'admin_menu', array($this, 'admin_menu') );
		add_action ( 'wp_head', array($this, 'init'), 100 );
	}
		
	public function init(){
		if ( $this->options['use_style_file'] && file_exists(WP_PLUGIN_DIR .'/'. KEA_FOLDER . "/kea_style.css") ) 
			echo "\n<link href='". WP_PLUGIN_URL . '/'. KEA_FOLDER ."/kea_style.css' type='text/css' rel='stylesheet' />";
		
		if ( is_user_logged_in() && $this->available() )
			add_action ('wp_footer', array($this, 'kea_menu') );

		elseif( $this->options['use_login'] && !is_user_logged_in() )	
			add_action ('wp_footer', array($this, 'login_form') );
	}
	
	function available(){
		global $user_level, $current_user; // 10 - админ(administrator), 7 - редактор(editor), 2 - автор(author), 1 - участник,  0 - подписчик
		//$role = $current_user->roles[0];
		if( $user_level >= $this->repair_from_last_versions($this->options['allow_users']) )
			return true;
			return false;
	}
	
	function repair_from_last_versions($a){
		if( strpos($this->options['allow_users'], ',' )!==false ){
			preg_match('![0-9]$!', $this->options['allow_users'] , $m);
			return $m[0];
		} else
		return $a;
	}

	public function admin_menu(){
		add_options_page( 'НАСТРОЙКИ: Kama Easy Admin', '¤ Панель админки' , 'manage_options', __FILE__, array($this, 'admin_options_page') );
	}
	
	public function kea_menu(){
		global $post;
		$mm_style = ($this->options['mm_variant']==1) ? "width:20px;" : "width:3px;";
		$mm_text  = ($this->options['mm_variant']==1) ? "<b>У п р а в л е н и е</b>" : "";
		$top = "top:{$this->options['top']}px;";

		$munu_items = trim( str_replace("\r" , '' , $this->options['munu_items']) );
		if( strpos($munu_items, '{edit}')!==false ){
			if( is_singular() )
				$munu_items = str_replace( '{edit}' , "<a href='{$this->site}/wp-admin/post.php?post={$post->ID}&action=edit'>Изменить</a>" , $munu_items);
			else 
				$munu_items = preg_replace( '!{edit}\n*!' ,'' , $munu_items);
		}
		$munu_items = str_replace( "\n\n" , "</li><hr /><li>" , $munu_items);
		$munu_items = str_replace( "\n" , "</li><li>" , $munu_items);
		
		echo "
		<div id='kea_admin' style='{$mm_style}{$top}'>$mm_text
			<ul class='kea_admin'>
				<li>
					$munu_items
				</li>
				<li><a href='". wp_logout_url($_SERVER['REQUEST_URI']) ."'>Выход</a></li>
			</ul>
		</div>
		";
	}
	
	
	function kea_options(){		
		static $done = false;
		if(!$done){
			$done = true;

			$this->options = get_option('kea_options');
			if(!$this->options)	
				$this->default_options();
		}		
	}

	function default_options(){
			$default_opt = array(
			/* логин-форма */
			'use_login' => 1					// Использовать логин форму?
			,'use_login_img' => 1				// Использовать картинку на логин форме?
			,'login_margin_left' => '40%'		// отступ формы слева
			,'login_margin_top' => '100px'		// отступ формы сверху
			,'login_redirect_to' => 'current'	// Перенаправление после логина. /wp-admin (админка) или current (останемся на тойж странице)

			/* Меню */
			,'mm_variant' => 1 				// 1 - не компактно, 2 компактно. Тип картинки.
			,'allow_users' => 2				// Уровень пользователя, которому будет видно меню. Перечислить через запятую. Пример: 8
			,'use_style_file' => 1 			// Использовать файл стилей? 1, если использовать 0, если не нужно использовать. ВНИМАНИЕ! Стили нужно переносить вместе с файлами картинок.
			,'top' => 100 					// Отступ сверху
			,'munu_items' => "
{edit}

<a href='{$this->site}/wp-admin/index.php'>Админ панель</a>
<a href='{$this->site}/wp-admin/post-new.php'>Новая Запись</a>
<a href='{$this->site}/wp-admin/".(floor($GLOBALS['wp_version'])>=3 ? "post-new.php?post_type=page" : "page-new.php")."'>Новая Страница</a>

<a href='{$this->site}/wp-admin/edit.php?post_status=draft'>Черновики</a>
<a href='{$this->site}/wp-admin/edit.php?post_status=private'>Личные Записи</a>

<a href='{$this->site}/wp-admin/edit-comments.php?comment_status=moderated'>Комментарии ожид. одобрения</a>
<a href='{$this->site}/wp-admin/edit-comments.php'>Все Комментарии</a>

<a href='{$this->site}/wp-admin/edit-tags.php?taxonomy=post_tag'>Метки</a>
<a href='{$this->site}/wp-admin/".(floor($GLOBALS['wp_version'])>=3 ? "edit-tags.php?taxonomy=category" : "categories.php")."'>Рубрики</a>
<a href='{$this->site}/wp-admin/plugins.php'>Плагины</a>

<a href='{$this->site}/wp-admin/options-general.php?page=kama-easy-admin/kama_easy_admin.php'>Настройки</a>
			"
			);
		$this->options = $default_opt;
	}
	
	# Cтраница админки
	public function admin_options_page(){
		if (isset($_POST['kea_uninstal'])){ // деинсталяция
			$deactivate_url = wp_nonce_url("plugins.php?action=deactivate&plugin=". KEA_BASE, "deactivate-plugin_" . KEA_BASE);

			echo "<div class='wrap'>
			<h2>Опции в Безе данных были удалены</h2>
			<p><strong>Теперь, <a href='{$deactivate_url}'>Нажмите сюда</a>, чтобы закончить деинсталяцию. После нажития, Kama easy admin будет деактивирован автоматически.</strong></p>
			</div>";
			delete_option('kea_options');
			
		} else {
			if( isset($_POST['reset_options']) ){ // сброс опций
					$this->default_options();
					update_option( 'kea_options', $this->options );
					echo "<div id='message' class='updated fade'><strong>Настройки были сброшены на начальные</strong></div>";
			
			} elseif( isset($_POST['save_options']) ){ // сохранение опций
					$this->options = array();
					$this->options['use_login'] 		= stripslashes(trim($_POST['use_login']));
					$this->options['use_login_img'] 	= stripslashes(trim($_POST['use_login_img']));
					$this->options['login_margin_left'] = stripslashes(trim($_POST['login_margin_left']));
					$this->options['login_margin_top'] 	= stripslashes(trim($_POST['login_margin_top']));
					$this->options['login_redirect_to'] = stripslashes(trim($_POST['login_redirect_to']));
					$this->options['mm_variant'] 		= stripslashes(trim($_POST['mm_variant']));
					$this->options['allow_users'] 		= stripslashes(trim($_POST['allow_users']));
					$this->options['use_style_file'] 	= stripslashes(trim($_POST['use_style_file']));
					$this->options['top'] 				= stripslashes(trim($_POST['top']));
					$this->options['munu_items']		= stripslashes(trim($_POST['munu_items']));
					
					update_option('kea_options', $this->options );
					echo "<div id='message' class='updated fade'><strong>Новые настройки сохранены в базу данных</strong></div>";
			}

			include WP_PLUGIN_DIR .'/'. KEA_FOLDER .'/admin.php';
		}
	}

	# логин форма
	function login_form(){
	 if ($this->options['login_redirect_to']=='current') 
		$this->options['login_redirect_to'] = $_SERVER['REQUEST_URI'];
		
		$style = "style='left:{$this->options['login_margin_left']}; top:{$this->options['login_margin_top']}'";
		$entry = $this->options['use_login_img'] ? "<b>В х о д</b>" : '';
		?>
		<div  id='kea_login' onclick="document.getElementById('kea_login_form').style.display='block';" title='Кликните для входа'><?=$entry?></div>
		<div id='kea_login_form' <?=$style?> ><div class="kea_login_close" title='Закрыть' onclick="document.getElementById('kea_login_form').style.display='none'; return false;">X</div>
			<form id="loginform" action="<?=$this->site?>/wp-login.php" method="post">
				<p><label>Логин<br />
					<input type="text" name="log" id="user_login" class="input" value="" size="20" tabindex="20" /></label></p>
				<p><label>Пароль<br />
					<input type="password" name="pwd" id="user_pass" class="input" value="" size="20" tabindex="21" /></label></p>
				<p class="forgetmenot"><label>
					<input name="rememberme" type="checkbox" id="rememberme" value="forever" tabindex="22" /> Запомнить меня</label></p>
				<p class="submit">
					<input type="submit" name="wp-submit" id="kea_submit" value="Войти" tabindex="23" /></p>
				<p>
				<?php if( get_option('users_can_register') )
					echo "<a href='{$this->site}/wp-login.php?action=register'>Регистрация</a> | "; ?>
					<a href="<?= "{$this->site}/wp-login.php?action=lostpassword" ?>">Забыли пароль?</a>
					<input type="hidden" name="redirect_to" value="<?= $this->options['login_redirect_to'] ?>" /></p>
			</form>
		</div>
		
		<?php 
	}
}

KamaEasyAdmin::instance();