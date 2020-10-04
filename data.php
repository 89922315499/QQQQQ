<?php

require "access.php"; 

?>

<?php include_once "templates/header.php";?>

<?php if (isset($_SESSION['logged_user'])): ?>
<?php if (get_permissions()["Group"] != "no_accept"): ?>

<div class="content">
	<div class="p_header">
	<?php if ($_SESSION['logged_user']->user_group == "admin"):?>
		<p class="p_header_page">База данных адвокатской конторы</p>
	<?php else:?>
		<p class="p_header_page">Наши услуги</p>
		<div style='text-align: center; background: #F08080; height: 30px; border-radius:5px;'>
		<p>(!) Для того, что бы заказать какую нибудь услугу, позвоните по тел. +7923123456, или напишите на почту advo@kat.ru</p>
		</div>
	<?php endif;?>
	</div>
	<?php if ($_SESSION['logged_user']->user_group == "admin"):?>
	<div class="p_top_panel">
		<div class="p_card_horizontal">
			<p class="p_card_horizontal_header">Выберите таблицу</p>
			<div class="p_card_horizontal_navigate">
				<ul>
				
					<li>
						<a href="#tab_sale">
							<p>Продажи</p>
						</a>
					</li>
					<li>
						<a href="#tab_customers">
							<p>Клиенты</p>
						</a>
					</li>
					<li>
						<a href="#tab_staff">
							<p>Сотрудники</p>
						</a>
					</li>
					
					<li>
						<a href="#tab_cars">
							<p>Услуги</p>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<?php endif;?>
	<div class="p_bottom_panel">
		<div class="tabs">
			<div id="tab_sale" class="tabs_items">
				<div class="p_card_full_size">
					<div style="background: #F08080; padding-top:5px; padding-bottom:10px; border-radius:10px; margin-bottom: 10px; width: 882px; margin-left: -152px; box-shadow: 0 0 5px black;">
						<p class="p_card_header" style='margin-left: 15px;'>Добавить продажу</p>
						<form action="access.php" method="POST" style='margin-left: 15px;'>
							<div>
								<?php
								if ($_SESSION['logged_user']->user_group == 'admin') { 
									$connetcrion = mysqli_connect("localhost", "root", "", "database");
									$sql = "SELECT * FROM service"; /* НАЗВАНИЕ ТАБЛЫ*/
									$result_select = mysqli_query($connetcrion,$sql);
									/*Выпадающий список*/
									echo "Услуга <select name = 'id_service' class = 'entry_field_value' style='height: 40px; width:853px; margin-bottom:10px;color: black;' required>";
									while($object = mysqli_fetch_object($result_select)){
									echo "<option value = '$object->id_service' >Для: $object->expiration лицо, вид: $object->view $object->entity срок ($object->retail_price руб.) [$object->id_service] </option>"; /*НАЗВАНИЕ СТОЛБЦА*/
									}
									echo "</select>";

									$connetcrion = mysqli_connect("localhost", "root", "", "database");
									$sql = "SELECT * FROM customers"; /* НАЗВАНИЕ ТАБЛЫ*/
									$result_select = mysqli_query($connetcrion,$sql);
									/*Выпадающий список*/
									echo "Клиент  <select name = 'id_customers' class = 'entry_field_value' style='height: 40px; width:853px; margin-bottom:10px;color: black;' required>"; /*Выбор имени элемента*/
									while($object = mysqli_fetch_object($result_select)){
									echo "<option value = '$object->id_customers'>$object->second_name $object->first_name $object->middle_name ($object->phone) [$object->id_customers] </option>"; /*НАЗВАНИЕ СТОЛБЦА*/
									}
									echo "</select>";

									$connetcrion = mysqli_connect("localhost", "root", "", "database");
									$sql = "SELECT * FROM staff"; /* НАЗВАНИЕ ТАБЛЫ*/
									$result_select = mysqli_query($connetcrion,$sql);
									/*Выпадающий список*/
									echo "Сотрудник  <select name = 'id_staff' class = 'entry_field_value' style='height: 40px; width:853px; margin-bottom:10px;color: black;' required>"; /*Выбор имени элемента*/
									while($object = mysqli_fetch_object($result_select)){
									echo "<option value = '$object->id_staff' >$object->second_name $object->first_name $object->middle_name ($object->phone) [$object->id_staff] </option>"; /*НАЗВАНИЕ СТОЛБЦА*/
									}
									echo "</select>";

									echo "Способ платежа  <select name = 'payment_method' class = 'entry_field_value' style='height: 40px; width:853px; margin-bottom:10px; color: black;' required>"; /*Выбор имени элемента*/
									echo "<option value = 'Карта' >Карта</option>";
									echo "<option value = 'Наличные' >Наличные</option>"; /*НАЗВАНИЕ СТОЛБЦА*/
									echo "</select>";
									echo '
									<input class="entry_field_value" name="date_of_sale" type="date" name="calendar" style="color: black;" required>
									<input class="entry_field_value" name="pricetag" type="text" placeholder="Стоимость" style="color: black;" required>  (руб.)
									<button class="btn_interface" name="record_sale" type="submit">Добавить запись</button>
									';
								}
								else{
									echo '<p style="color: white;">Вы не имеете достаточно прав для просмотра этой таблицы.</p>';
								}
								?>
							</div>
						</form>
					</div>
					<?php echo display_sale(null); ?>
				</div>
			</div>
			<div id="tab_customers" class="tabs_items">
				<div class="p_card_full_size">
					<div style="background: #F08080; padding-top:5px; padding-bottom:10px; border-radius:10px; margin-bottom: 10px; width: 882px; margin-left: -152px; box-shadow: 0 0 5px black;">
						<p class="p_card_header" style='margin-left: 20px;'>Добавить клиента</p>
						<form action="access.php" method="POST" style='margin-left: 20px;'>
							<?php
							if ($_SESSION['logged_user']->user_group == 'admin') { 
							echo '<div>
							<input class="entry_field_value" name="second_name" type="text" placeholder="Фамилия" required>
							<input class="entry_field_value" name="phone" type="text" placeholder="Телефон (пример: +79501234567)">
							<input class="entry_field_value" name="first_name" type="text" placeholder="Имя" required>
							<input class="entry_field_value" name="notes" type="text" placeholder="Примечания">
							<input class="entry_field_value" name="middle_name" type="text" placeholder="Отчество (при наличии)">
							<input class="entry_field_value" name="date_of_birth" type="text" placeholder="Дата рождения" required>
							<input class="entry_field_value" name="email" type="text" placeholder="E-Mail">
							<input class="entry_field_value" name="sex" type="text" placeholder="Пол" required>
						</div>
						<button class="btn_interface" name="record_customer" type="submit">Добавить запись</button>';}
						else{
							echo '<p style="color: white;">Вы не имеете достаточно прав для просмотра этой таблицы.</p>';
						}
							?>
						</form>
					</div>
					<?php echo display_customers(null); ?>
				</div>
			</div>
			
			<div id="tab_cars" class="tabs_items">
				<div class="p_card_full_size">
				<?php if ($_SESSION['logged_user']->user_group == "admin"):?>
					<div style="background: #F08080; padding-top:5px; padding-bottom:10px; border-radius:10px; margin-bottom: 10px; width: 882px; margin-left: -152px; box-shadow: 0 0 5px black;">
						<p class="p_card_header" style='margin-left: 20px;'>Добавить услугу</p>
						<form action="access.php" method="POST" style='margin-left: 20px;'>
							<div>
									Вид услуги  <select name = 'view' class = 'entry_field_value' style='height: 40px; width:853px; margin-bottom:10px; color: black;' required>
									<option value = 'Юридическая консультация' >Юридическая консультация</option>
									<option value = 'Разовые услуги' >Разовые услуги</option>
									<option value = 'Юридическое сопровождение сделок' >Юридическое сопровождение сделок</option>
									<option value = 'Составление претензии и ведение переписки' >Составление претензии и ведение переписки</option>
									<option value = 'Составление судебного иска' >Разовые услуги</option>
									<option value = 'Представление интересов клиента в суде' >Юридическое сопровождение сделок</option>
									<option value = 'Защита по уголовным делам' >Составление претензии и ведение переписки</option>
									</select>
								<input class="entry_field_value" name="expiration" type="text" placeholder="Лицо" required>
								<input class="entry_field_value" name="entity" type="text" placeholder="Срок действия договора" required>
								<input class="entry_field_value" name="retail_price" type="text" placeholder="Цена услуги" required>
								<input class="entry_field_value" name="city" type="text" placeholder="Город" required>
							</div>
							<button class="btn_interface" name="record_service" type="submit">Добавить запись</button>
						</form>
					</div>
				<?php endif;?>
					<?php echo display_service(null); ?>
				</div>
			</div>

			<div id="tab_staff" class="tabs_items">
				<div class="p_card_full_size">
					<div style="background: #F08080; padding-top:5px; padding-bottom:10px; border-radius:10px; margin-bottom: 10px; width: 882px; margin-left: -152px; box-shadow: 0 0 5px black;">
						<p class="p_card_header" style='margin-left: 20px;'>Добавить сотрудника</p>
						<form action="access.php" method="POST" style='margin-left: 20px;'>
							<?php
							if ($_SESSION['logged_user']->user_group == 'admin') { 
								echo'
							<div>
								<input class="entry_field_value" name="second_name" type="text" placeholder="Фамилия" required>
								<input class="entry_field_value" name="phone" type="text" placeholder="Телефон (пример: +79501234567)" required>
								<input class="entry_field_value" name="first_name" type="text" placeholder="Имя" required>
								<input class="entry_field_value" name="date_of_birth" type="text" placeholder="Дата рождения" required>
								<input class="entry_field_value" name="middle_name" type="text" placeholder="Отчество (при наличии)" required>
								<input class="entry_field_value" name="email" type="text" placeholder="E-Mail" required>
								<input class="entry_field_value" name="date_of_employment" type="text" placeholder="Дата трудоустройства" required>
								<input class="entry_field_value" name="position" type="text" placeholder="Должность" required>
								<input class="entry_field_value" name="sex" type="text" placeholder="Пол" required>
							</div>
							<button class="btn_interface" name="record_staff" type="submit">Добавить запись</button>
							';
							}
							else{
								echo '<p style="color: red;">Вы не имеете достаточно прав для добавления записей в эту таблицу.</p>';
							}
							?>
						</form>
					</div>					
					<?php echo display_staff(null); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php else : ?>  
<div class="content">
	<div class="p_header">
		<p class="p_header_page">Произошла ошибка :(</p>
	</div>
	<div class="p_card_full_size">
		<p>Обратитесь к системному администратору.</p>
	</div>
</div>
<?php endif ; ?>
<?php else : ?>    
<div class="content">
	<div class="p_header">
		<p class="p_header_page"><?php echo $TITLE_PAGE; ?></p>
	</div>
	<div>
		<div class="p_card_full_size">
			<p class="p_card_auth_header">Нужно представиться системе</p>
			<div class="form_auth">
				<a class="btn_auth" href="/login.php">Войти</a> 
				<a class="btn_register" href="/singup.php">Зарегистрироваться</a>
			</div>
		</div>
	</div>
</div>
<?php endif ; ?>

<?php include_once "templates/footer.php"; ?>