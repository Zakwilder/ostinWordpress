		<style type="text/css">
			.kea_admin_options {padding:20px 10px 0;}
			.kea_admin_options table td {padding:3px 5px; text-align:left;}
			.kea_admin_options table td span {line-height:16px;}
		</style>

		<div class="wrap">

		<div id="icon-options-general" class="icon32"><br /></div>

		<h2>Настройки Kama Easy Admin v<?=KEA_VERSION?></h2>

		<div class="kea_admin_options">
		<form method="post" action="">
			<?php wp_nonce_field('update-options'); ?>
			<h2>Настройки Меню</h2>
			
			<table class="form-table">
				<tr>
					<th>Тип картинки:</th>
					<td>
						<select id='mm_variant' name="mm_variant" size="1">
							<option value="1" <?php if ((int)$this->options['mm_variant']==1) echo "selected"; ?>>Нормальная
							<option value="2" <?php if ((int)$this->options['mm_variant']==2) echo "selected"; ?>>Компактная (тонкая полоска)
						</select>
					</td>
					<td>
						<span>Вид картинки в левой части экрана</span>
					</td>
				</tr>
				
				<tr>
					<th>Мин. ур. пользователя:</th>
					<td>
						<select id='allow_users' name="allow_users">
							<option value='2' disabled>-- Выберите роль --</option>
							<option value='10' <?php if ($this->options['allow_users']==10) echo "selected"; ?>>Администратор</option>
							<option value='7' <?php if ($this->options['allow_users']==7) echo "selected"; ?>>Редактор</option>
							<option value='2' <?php if ($this->options['allow_users']==2) echo "selected"; ?>>Автор</option>
							<option value='1' <?php if ($this->options['allow_users']==1) echo "selected"; ?>>Участник</option>
							<option value='0' <?php if ($this->options['allow_users']==0) echo "selected"; ?>>подписчик</option>
						</select>
					</td>
					<td>
						<span>Минимальный уровень пользователя, которому будет видна панель. <a href='http://codex.wordpress.org/Roles_and_Capabilities'>Подробно о ролях (англ)</a>. </span>
					</td>
				</tr>
				
				<tr>
					<th>Использовать css файл стилей:</th>
					<td>
						<select id='use_style_file' name="use_style_file" size="1">
							<option value="1" <?php if ((int)$this->options['use_style_file']== 1) echo "selected"; ?>>Да
							<option value="0" <?php if ((int)$this->options['use_style_file']== 0) echo "selected"; ?>>Нет (перенесите стили)
						</select>
					</td>
					<td>
						<span>Перенесите стили (kea_style.css) из папки плагина в ваш файл стилей, затем переключите эту опцию на "Нет". Этим мы сэкономим 1 запрос к серверу. Если вы совсем не знаете CSS, то лучше не трогайте эту настройку.</span>
					</td>
				</tr>
				
				<tr>
					<th>Отступ сверху</th>
					<td>
						<input id='top' type="text" name="top" value="<?= $this->options['top']; ?>" size="30" />
					</td>
					<td>
						<span>Отступ меню от верхней части экрана (в пикселях). По умолчанию 100</span>
					</td>
				</tr>
			</table>
			<h3>Настройка пунктов меню</h3>
				<p>Ссылки в меню (указывайте по 1 на строку). Пример: <code>&lt;a href='/wp-admin/index.php'&gt;Админ панель&lt;/a&gt;</code>. Пустая строчка - это разделитель. Вставьте тег <code>{edit}</code> он превратиться в ссылку редактирования страницы/поста, на страницах постоянных страниц или постов.
					<textarea id='munu_items' name='munu_items' style='width:95%; height:300px;'><?= $this->options['munu_items']; ?></textarea>
				</p>

			<h2>Настройки логин-формы</h2>
			Использовать логин форму?
			<select id='use_login' name="use_login" size="1" onChange='select_key_menu();'>
				<option value="1" <?php if ((int)$this->options['use_login']== 1) echo "selected"; ?>>Да</option>
				<option value="0" <?php if ((int)$this->options['use_login']== 0) echo "selected"; ?>>Нет</option>
			</select>
			
			<table id='form_table' class="form-table">		
				<tr>
					<th>Использовать надпись к логин форме?</th>
					<td>
						<select id='use_login_img' name="use_login_img" size="1">
							<option value="1" <?php if ((int)$this->options['use_login_img']== 1) echo "selected"; ?>>Да
							<option value="0" <?php if ((int)$this->options['use_login_img']== 0) echo "selected"; ?>>Нет
						</select>
					</td>
					<td>Если надпись "Вход" мешает, отключите её (уголок останется кликабельным) и прикрепите появление логин формы к любой ссылке на сайте, с помощью этого кода<code>onclick="document.getElementById('kea_login_form').style.display='block'; return false;"</code> (добавьте его к ссылке). Пример: у нас есть ссылка &lt;a href=&quot;#&quot;&gt;Войти&lt;/a&gt; изменяем её на &lt;a href=&quot;#&quot; onclick="document.getElementById('kea_login_form').style.display='block'; return false;"&gt;Войти&lt;/a&gt
					</td>
				</tr>
				<tr>
					<th>Отступ формы</th>
					<td>
						слева: <input id='login_margin_left' type="text" name="login_margin_left" value="<?= $this->options['login_margin_left']; ?>" size="10" onblur="if (this.value == '') {this.value = '0px';}"  /><br />
						сверху: <input id='login_margin_top' type="text" name="login_margin_top" value="<?= $this->options['login_margin_top']; ?>" size="10" onblur="if (this.value == '') {this.value = '0px';}" /> 
					</td>
					<td>Mожно изменить положение формы входа, указав отступы слева и сверху (указывается в пикселях или процентах - пример: 10px или 10%).</td>
				</tr>
				<tr>
					<th>Редирект после входа</th>
					<td> <input id='login_redirect_to' type="text" name="login_redirect_to" value="<?= $this->options['login_redirect_to']; ?>" size="30" onblur="if (this.value == '') {this.value = '0px';}" /> 
					</td>
					<td>На какую страницу вы попадете после того, как залогинетесь, используя логин форму. По-умолчанию <code>current</code> (вы останетесь на той же странице с которой логинились), <code>/</code> (перекинет на главную страницу сайта) или <code>/wp-admin</code> (перекинет в админку сайта). </td>
				</tr>
			</table>

				<p class="submit">
					<input type="submit" name="save_options" id='save_options' class="button-primary" class="kea_submit" value="Сохранить настройки" />
				</p>
				
			</form>
			<div style='text-align:right;'>Автор: <a href='http://wp-kama.ru' target='_blank'>Kama</a></div>
		</div>
		</div><!--wrap-->	
		<hr />

			<form method="post" action="">
				<p class="submit">
					<input type="submit" name="reset_options" id='reset_options' value="Сбросить настройки на начальные" onclick="return confirm('Вы уверены, что хотите сбросить настройки на начальные?')" />
				</p>	
				<h2>Деинсталяция</h2>
				<p>Стандартная деактивация плагина не удалит опции из Базы Данных. Если вы хотите полностью удалить этот плагин, используйте кнопку ниже: будут удалены настройки из Базы Данных, а вторым шагом произведена деактивация плагина.
				</p>
				<p class="submit">
					<input type="submit" name="kea_uninstal" value="Деинсталировать (с удалением настроек из Базы Данных)" class="button" onclick="return confirm('Вы уверены, что хотите деинсталировать Плагин?\nНастройки будут утеряны навсегда!')" />
				</p>	
			</form>
			
		<script type='text/javascript'>//<!-- <![CDATA[
		function select_key_menu (){
				document.getElementById('form_table').style.display = (document.getElementById('use_login').value == 1) ? 'block' : 'none';
		}
		select_key_menu();
		// ]]>-->
		</script>