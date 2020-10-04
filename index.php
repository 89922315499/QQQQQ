<?php

//require "db.php";
require "access.php"; 

?>

<?php include_once "templates/header.php"; ?>

<?php if (isset($_SESSION['logged_user'])): ?>
<div class="content">
	<div class="p_header">
		<p class="p_header_page"><?php echo $TITLE_PAGE; ?></p>
	</div>
		<div class="p_card">
			<p class="p_card_header"><?php echo get_permissions()["SecondName"] . " " . get_permissions()["FirstName"] . " " . get_permissions()["MiddleName"]; ?></p>
			<p><?php echo get_permissions()["Post"]; ?></p>
			<p><?php echo $DEALERSHIP_ADDRESS; ?></p>
		</div>
		<?php if (get_permissions()["Group"] != "no_accept"): ?>
		<div class="p_card">
			<p class="p_card_header">Меню</p>
			<div class="p_card_navigate">
				<ul>
					<li>
					<?php if ($_SESSION['logged_user']->user_group == "admin"):?>
						<a href="#tab_reports" style="margin-left: 10px; ">
							<p>Создать отчет</p>
						</a>
						<?php endif ; ?>
					</li>
					<li>
						<a href="#tab_account_settings" style="margin-left: 10px;">
							<p>Настройки</p>
						</a>
					</li>
					<li style="background: black; border-radius: 5px; width: 120px;">
						<a href="/logout.php" style="margin-left: 10px;">
							<p>Выйти</p>
						</a>
					</li>
				</ul>
			</div>
			</div>
		<?php if (get_permissions()["Group"] == "admin"): ?>

		<div class="p_card">
			<p class="p_card_header">Управление</p>
			<div class="p_card_navigate">
				<ul>
					<li>
						<a href="#tab_account_administration">
							<p>Управление аккаунтами</p>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<?php endif ; ?>
		<?php else : ?>
			<div class="p_card">
				<p class="p_card_header">Профиль</p>
				<div class="p_card_navigate">
					<ul>
						<li>
							<a style="color: #a82200;" href="/logout.php">
								<p>Завершить сеанс</p>
							</a>
						</li>
					</ul>
				</div>
			</div>   
		<?php endif ; ?>
		<div class="tabs">
		<div id="tab_reports" class="tabs_items">
		<?php
				if ($_SESSION['logged_user']->user_group == 'admin'){
					echo '
				<div class="p_card_content">
				
					
					<p class="p_card_header">Создание отчетов</p>
					<p>Скачать таблицу CSV, в которой записаны данные из соответствующих таблиц</p>
					<div class="form">
					<form action="_get_reply.php" method="POST">
					<button class="btn_interface" name="_get_reply_sale" type="submit">Продажи</button>
					</form>
					<form action="_get_reply.php" method="POST">
					<button class="btn_interface" name="_get_reply_customers" type="submit">Клиенты</button>
					</form>
					<form action="_get_reply.php" method="POST">
					<button class="btn_interface" name="_get_reply_staff" type="submit">Сотрудники</button>
					</form>
					<form action="_get_reply.php" method="POST">
					<button class="btn_interface" name="_get_reply_service" type="submit">Услуги</button>
					</form>
					</div>
					</div>
					';
				}
				
			?>
					
				
			</div>
			<div id="tab_account_settings" class="tabs_items">
				<div class="p_card_content">
					<p class="p_card_header">Настройки аккаунта</p>
					<p>Измените данные аккаунта, если нужно... Изменения вступят в силу <i>только после следующего входа.</i>.</p>
					<?php echo display_user_settings(); ?>
				</div>				
			</div>
			<div id="tab_account_administration" class="tabs_items">
				<div class="p_card_content">
					<p class="p_card_header">Управление учётными записями</p>
				</div>
				<?php echo display_users(); ?>
			</div>
		</div>
	</div>
<?php else : ?>    
<div class="content">
	<div class="p_header">
		<p class="p_header_page"><?php echo $TITLE_PAGE; ?></p>
	</div>
	<div>
		<div class="p_card_full_size">
			<p class="p_card_auth_header">Для начала, давайте познакомимся</p>
			<div class="form_auth">
				<a class="btn_auth" href="/login.php">Войти</a> 
				<a class="btn_register" href="/singup.php">Зарегистрироваться</a>
			</div>
		</div>
	</div>
</div>


<?php endif ; ?>

<?php include_once "templates/footer.php"; ?>