<?php

require "db.php"; 

/*
* Вызывает функцию получения группы пользователя.
*/
function get_permissions() {
	/*
	* Если пользовательнская группа admin и сессия активна, создаём массив с информацией об аккаунте,
	* полученной из базы данных.
	*/
	if ($_SESSION['logged_user']->user_group == "admin") { 
		return array(
			"Id" => $_SESSION['logged_user']->id,
			"FirstName" => $_SESSION['logged_user']->first_name,
			"SecondName" => $_SESSION['logged_user']->second_name,
			"MiddleName" => $_SESSION['logged_user']->middle_name,
			"Login" => $_SESSION['logged_user']->login,
			"E_Mail" => $_SESSION['logged_user']->email,
			"Group" => $_SESSION['logged_user']->user_group,
			"Post" => $_SESSION['logged_user']->post
		); 
	}
	/*
	* Если пользовательнская группа user и сессия активна, создаём массив с информацией об аккаунте,
	* полученной из базы данных.
	*/
	else if ($_SESSION['logged_user']->user_group == "user") { 
		return array(
			"Id" => $_SESSION['logged_user']->id,
			"FirstName" => $_SESSION['logged_user']->first_name,
			"SecondName" => $_SESSION['logged_user']->second_name,
			"MiddleName" => $_SESSION['logged_user']->middle_name,
			"Login" => $_SESSION['logged_user']->login,
			"E_Mail" => $_SESSION['logged_user']->email,
			"Group" => $_SESSION['logged_user']->user_group,
			"Post" => $_SESSION['logged_user']->post
		); 
	}
	/*
	* В ином случае при активной сессии - учётная запись не подтверждена администратором.
	*/
	else if ($_SESSION['logged_user']->user_group == null) { 
		return array(
			"Id" => null,
			"FirstName" => $_SESSION['logged_user']->first_name,
			"SecondName" => $_SESSION['logged_user']->second_name,
			"MiddleName" => $_SESSION['logged_user']->middle_name,
			"Login" => $_SESSION['logged_user']->login,
			"E_Mail" => $_SESSION['logged_user']->email,
			"Group" => "no_accept",
			"Post" => "<i>Учётная запись не подтверждена</i>",
		); 
	}
	/*
	* Обрыв сессии во всех остальных случаях.
	*/
	else { unset($_SESSION['logged_user']); }
}
/*
* Вывод записей в таблице "Клиенты". 
*/
function display_customers($_sorting) {
	
	if ($_SESSION['logged_user']->user_group == 'admin') { 
	$link = mysqli_connect("localhost", "root", "", "database");
	$query = "SELECT * FROM customers ORDER BY id_customers DESC";
	$result = mysqli_query($link, $query) or die(mysqli_error($link));
	for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
	
	$result = "";
	foreach ($data as $elem) {
		$result .= "
		<div style='padding-left:20px; margin-bottom:10px; background: #F08080; padding-top:5px; padding-bottom:10px; border-radius:10px; width: 863px; margin-left: -152px; box-shadow: 0 0 5px;'>
			<p style='p_card_header'>{$elem['second_name']} {$elem['first_name']} {$elem['middle_name']}</p>
			<p><i>ID клиента:</i> {$elem['id_customers']} • <i>Дата рождения:</i> {$elem['date_of_birth']} • <i>Пол:</i> {$elem['sex']}</p>
			<p><i>Тел.:</i> {$elem['phone']} • <i>E-Mail:</i> {$elem['email']}</p>
			<p><i>Примечания:</i> {$elem['notes']}</p>
		";
		if (get_permissions()["Group"] == "admin") {
			$result .= "
				<form action='access.php' method='POST'>
					<input type='hidden' name='id' value='{$elem['id_customers']}'>
					<button class='btn_change' name='remove_customer' type='submit'>Удалить запись</button>
					<button class='edit_change' name='edit_customer' type='submit'>Изменить запись</button>
				</form>
			</div>
			";
		}
		else {
			$result .= "
			</div>
			";
		}
	}
	return $result;
}
}
/*

*/
function display_service($_sorting) {
	
	$link = mysqli_connect("localhost", "root", "", "database");

	$query = "SELECT * FROM service ORDER BY id_service DESC";
	$result = mysqli_query($link, $query) or die(mysqli_error($link));
	for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
	
	$result = "";
	foreach ($data as $elem) {
		$result .= "
		<div style='padding-left:20px; margin-bottom:10px; background: #F08080; padding-top:5px; padding-bottom:10px; border-radius:10px;  width: 863px; margin-left: -152px; box-shadow: 0 0 5px;'>
			<p style='p_card_header'>Вид услуги: {$elem['view']}</p>
			<p><i>ID услуги:</i> {$elem['id_service']} • <i>Для лица:</i> {$elem['expiration']}(-кого)</p>
			<p>Срок действия договора: {$elem['entity']}</p>
			<p><i>Цена услуги:</i> {$elem['retail_price']} (руб.)</p>
			<p><i>Город:</i> {$elem['city']}</p>
		";
		if ($_SESSION['logged_user']->user_group == "admin") {
			$result .= "
				<form action='access.php' method='POST'>
					<input type='hidden' name='id' value='{$elem['id_service']}'>
					<button class='btn_change' name='remove_service' type='submit'>Удалить запись</button>
					<button class='edit_change' name='edit_service' type='submit'>Изменить запись</button>
				</form>
			</div>
			";
		}
		else {
			$result .= "
			</div>
			";
		}
	}
	return $result;
}
/*
* Вывод записей в таблице "Сотрудники". 
*/
function display_staff($_sorting) {
	if ($_SESSION['logged_user']->user_group == "admin"){
	$link = mysqli_connect("localhost", "root", "", "database");
	$query = "SELECT * FROM staff ORDER BY id_staff DESC";
	$result = mysqli_query($link, $query) or die(mysqli_error($link));
	for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
	
	$result = "";
	foreach ($data as $elem) {
		$result .= "
		<div style='padding-left:20px; margin-bottom:10px; background: #F08080; padding-top:5px; padding-bottom:10px; border-radius:10px; width: 863px; margin-left: -152px; box-shadow: 0 0 5px;'>
			<p style='p_card_header'>{$elem['second_name']} {$elem['first_name']} {$elem['middle_name']}</p>
			<p><i>ID сотрудника:</i> {$elem['id_staff']} • <i>Дата рождения:</i> {$elem['date_of_birth']} • <i>Пол:</i> {$elem['sex']}</p>
			<p><i>Должность:</i> {$elem['position']}</p>
			<p><i>Дата трудоустройства:</i> {$elem['date_of_employment']} • <i>Тел.:</i> {$elem['phone']} • <i>E-Mail:</i> {$elem['email']}</p>
		";
		if (get_permissions()["Group"] == "admin") {
			$result .= "
				<form action='access.php' method='POST'>
					<input type='hidden' name='id' value='{$elem['id_staff']}'>
					<button class='btn_change' name='remove_staff' type='submit'>Удалить запись</button>
					<button class='edit_change' name='edit_staff' type='submit'>Изменить запись</button>
				</form>
			</div>
			";
		}
		else {
			$result .= "
			</div>
			";
		}
	}
	return $result;
}}
/*
* Вывод записей в таблице "Продажи". 
*/
function display_sale($_sorting) {
	if ($_SESSION['logged_user']->user_group == "admin"){
	$link = mysqli_connect("localhost", "root", "", "database");
	$query = "SELECT * FROM sale ORDER BY id_sale DESC";
	$result = mysqli_query($link, $query) or die(mysqli_error($link));
	for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
	$result = "";
	foreach ($data as $elem) 
	{

		$customers_explainer = mysqli_query($link, "SELECT * FROM customers WHERE id_customers = $elem[id_customers]") or die(mysqli_error($link)); //запрос к таблице клиентов по id продажи
		for ($cust_exp = []; $row = mysqli_fetch_assoc($customers_explainer); $cust_exp[] = $row);
		$customers_explainer='';

		$staff_explainer = mysqli_query($link, "SELECT * FROM staff WHERE id_staff = $elem[id_staff]") or die(mysqli_error($link));
		for ($staff_exp = []; $row = mysqli_fetch_assoc($staff_explainer); $staff_exp[] = $row);
		$staff_explainer='';
		$fixer='service';
		$service_explainer = mysqli_query($link, "SELECT * FROM {$fixer} WHERE id_service = $elem[id_service]") or die(mysqli_error($link));
		for ($serv_exp = []; $row = mysqli_fetch_assoc($service_explainer); $serv_exp[] = $row);
		$service_explainer='';

		$result .= "
		<div style='padding-left:20px; margin-bottom:10px; background: #F08080; padding-top:5px; padding-bottom:10px; border-radius:10px; width: 863px; margin-left: -152px; box-shadow: 0 0 5px;'>
			<p style='p_card_header'><i>ID продажи:</i> {$elem['id_sale']}</p>
			<p>• <i>Услуга:</i> {$serv_exp[0]['expiration']} лицо, вид: {$serv_exp[0]['view']}, {$serv_exp[0]['entity']} срок, ID: [{$elem['id_service']}]
			<br> • <i>Cотрудник:</i> {$staff_exp[0]['first_name']} {$staff_exp[0]['middle_name']} {$staff_exp[0]['second_name']} [{$elem['id_staff']}] <br>
			• <i>Клиент:</i> {$cust_exp[0]['first_name']} {$cust_exp[0]['middle_name']} {$cust_exp[0]['second_name']} [{$elem['id_customers']}]
			<br>• <i>Способ оплаты:</i> {$elem['payment_method']} <br> • <i>Итоговая сумма:</i> {$elem['pricetag']} (руб.)
			<br>• <i>Дата продажи:</i> {$elem['date_of_sale']}</p>
		";
		if (get_permissions()["Group"] == "admin") {
			$result .= "
				<form action='access.php' method='POST'>
					<input type='hidden' name='id' value='{$elem['id_sale']}'>
					<button class='btn_change' name='remove_sale' type='submit'>Удалить запись</button>
				</form>
			</div>
			";
		}
		else {
			$result .= "
			</div>
			";
		}
	}
	return $result;
}
}
/*
* Вывод настроек учётной записи пользователя. 
*/
function display_user_settings() {
	$_local_login = get_permissions()['Login'];
	$_local_email = get_permissions()['E_Mail'];
	$_local_second_name = get_permissions()['SecondName'];
	$_local_first_name = get_permissions()['FirstName'];
	$_local_midde_name = get_permissions()['MiddleName'];
	return "
	<div>
		<form action='access.php' method='POST'>
			<input class='entry_field_value' name='login' type='text' placeholder='Логин' value='{$_local_login}' required><br>
			<input class='entry_field_value' name='email' type='text' placeholder='E-Mail' value='{$_local_email}' required><br>
			<input class='entry_field_value' name='second_name' type='text' placeholder='Фамилия' value='{$_local_second_name}' required><br>
			<input class='entry_field_value' name='first_name' type='text' placeholder='Имя' value='{$_local_first_name}' required><br>
			<input class='entry_field_value' name='middle_name' type='text' placeholder='Отчество' value='{$_local_midde_name}'><br>
			<button class='btn_interface' name='change_user_settings' type='submit'>Применить изменения</button>
		</form>
		<form action='access.php' method='POST'>
			<input class='entry_field_value' name='password' type='text' placeholder='Новый пароль' required><br>
			<input class='entry_field_value' name='repeat_password' type='text' placeholder='Повторите пароль' required><br>
			<button class='btn_interface' name='change_user_password' type='submit'>Сохранить пароль</button>
		</form>
	</div>
	";
}
/*
* Вывод записей в таблице "Пользователи". 
*/
function display_users() {
	$link = mysqli_connect("localhost", "root", "", "registered_users");

	$query = "SELECT * FROM users";
	$result = mysqli_query($link, $query) or die(mysqli_error($link));
	for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
	
	$result = "";
	foreach ($data as $elem) {
		$result .= "
		<div class='p_card_display_db'>
			<p style='p_card_header'>{$elem['second_name']} {$elem['first_name']} {$elem['middle_name']}</p>
			<p><i>ID учётной записи:</i> {$elem['id']} • <i>Логин:</i> {$elem['login']} • <i>E-Mail:</i> {$elem['email']}</p>
			<p><i>Должность:</i> {$elem['post']}</p>
			<p><i>Группа:</i> <u>{$elem['user_group']}</u></p>
			<form action='access.php' method='POST'>
				<input type='hidden' name='id' value='{$elem['id']}'>
				<input class='entry_field_value' name='post' type='text' placeholder='Должность' required><br>
				<button class='btn_interface' name='record_post' type='submit'>Назначить должность</button>
			</form>
			<form action='access.php' method='POST'>
				<input type='hidden' name='id' value='{$elem['id']}'>
				<button class='btn_interface' name='accept_user' type='submit'>Добавить в User</button>
				<button class='btn_interface' name='accept_admin' type='submit'>Добавить в Admin</button>
				<button class='btn_change' name='remove_account' type='submit'>Удалить учётную запись</button>
			</form>
		</div>
		";
	}
	return $result;
}
/*
* Сортровка записей в таблицах базы данных.
*/
function sorting($_table, $_key) {
	if ($_table == "customers") {
		if ($_key == "idUpper"){
			$link = mysqli_connect("localhost", "root", "", "database");
			$query = "SELECT * FROM customers ORDER BY id_customers ASC";
			$result = mysqli_query($link, $query) or die(mysqli_error($link));
			header("Location: /data.php#tab_customers");
		}
		else if ($_key == "idLower") {
			send_request();
		}
	}
}
/* 
* Устанавливает (и закрывает по окончанию работы) соединение с базой данных, отправляет запрос.
* Входные данные для локального сервера $_data - данные, $_action - действие.
*/
function send_request($_data, $_action) {
	/*
	* Запись данных о клиентах.
	*/
	if ($_action == "record_customer") {
		$connection = new PDO("mysql:host=localhost;dbname=database", "root", "");
		$sql_motion = "INSERT INTO customers (second_name, first_name, middle_name, date_of_birth, sex, phone, email, notes) 
		VALUES (:second_name, :first_name, :middle_name, :date_of_birth, :sex, :phone, :email, :notes)";
		$statement = $connection->prepare($sql_motion);
		$result = $statement->execute($_data);
		header("Location: /data.php#tab_customers");
	}
	/*
	* Проверка соответствий записей клиентов.
	*/
	else if ($_action == "check_customer") {

	}	
	/*
	* Удаление записей о клиентах.
	*/
	else if ($_action == "remove_customer") {
		$link = mysqli_connect("localhost", "root", "", "database");
		$query = "DELETE FROM customers WHERE id_customers={$_data['id']}";
		$result = mysqli_query($link, $query) or die(mysqli_error($link));
		header("Location: /data.php#tab_customers");
	}
	/*
	* Запись данных об товаре.
	*/
	else if ($_action == "record_service") {
		$connection = new PDO("mysql:host=localhost;dbname=database", "root", "");
		$sql_motion = "INSERT INTO service (view, entity, expiration, retail_price, city)
		VALUES (:view, :entity,  :expiration, :retail_price, :city)";
		$statement = $connection->prepare($sql_motion);
		$result = $statement->execute($_data);
		header("Location: /data.php#tab_cars");
	}
	/*

	*/
	else if ($_action == "remove_service") {
		$link = mysqli_connect("localhost", "root", "", "database");
		$query = "DELETE FROM service WHERE id_service={$_data['id']}";
		$result = mysqli_query($link, $query) or die(mysqli_error($link));
		header("Location: /data.php#tab_cars");
	}
	/*
	* Запись данных о сотрудниках.
	*/
	else if ($_action == "record_staff") {		
		$connection = new PDO("mysql:host=localhost;dbname=database", "root", "");
		$sql_motion = "INSERT INTO staff (second_name, first_name, middle_name, date_of_birth, phone, email, position, date_of_employment, sex) 
		VALUES (:second_name, :first_name, :middle_name, :date_of_birth, :phone, :email, :position, :date_of_employment, :sex)";
		$statement = $connection->prepare($sql_motion);
		$result = $statement->execute($_data);
		header("Location: /data.php#tab_staff");
	}
	/*
	* Удаление записей о сотрудние.
	*/
	else if ($_action == "remove_staff") {
		$link = mysqli_connect("localhost", "root", "", "database");
		$query = "DELETE FROM staff WHERE id_staff={$_data['id']}";
		$result = mysqli_query($link, $query) or die(mysqli_error($link));
		header("Location: /data.php#tab_staff");
	}
	/*
	* Запись данных о продажах.
	*/
	else if ($_action == "record_sale") {
		$connection = new PDO("mysql:host=localhost;dbname=database", "root", "");
		$sql_motion = "INSERT INTO sale (id_service, id_customers, id_staff, date_of_sale, payment_method, pricetag) 
		VALUES (:id_service, :id_customers, :id_staff, :date_of_sale, :payment_method, :pricetag)";
		$statement = $connection->prepare($sql_motion);
		$result = $statement->execute($_data);
		header("Location: /data.php#tab_sale");
	}
	/*
	* Удаление записей о продаже.
	*/
	else if ($_action == "remove_sale") {
		$link = mysqli_connect("localhost", "root", "", "database");
		$query = "DELETE FROM sale WHERE id_sale={$_data['id']}";
		$result = mysqli_query($link, $query) or die(mysqli_error($link));
		header("Location: /data.php#tab_sale");
	}
	/*
	* Добавить пользователя в группу "admin".
	*/
	else if ($_action == "accept_admin") {
		$link = mysqli_connect("localhost", "root", "", "registered_users");
		$query = "UPDATE users SET user_group='admin' WHERE id={$_data['id']}";
		$result = mysqli_query($link, $query) or die(mysqli_error($link));
		header("Location: /#tab_account_administration");
	}
	/*
	* Добавить пользователя в группу "user".
	*/
	else if ($_action == "accept_user") {
		$link = mysqli_connect("localhost", "root", "", "registered_users");
		$query = "UPDATE users SET user_group='user' WHERE id={$_data['id']}";
		$result = mysqli_query($link, $query) or die(mysqli_error($link));
		header("Location: /#tab_account_administration");
	}
	/*
	* Удалить пользователя.
	*/
	else if ($_action == "remove_account") {
		$link = mysqli_connect("localhost", "root", "", "registered_users");
		$query = "DELETE FROM users WHERE id={$_data['id']}";
		$result = mysqli_query($link, $query) or die(mysqli_error($link));
		header("Location: /#tab_account_administration");
	}
	/*
	* Изменить личные настройки пользователя.
	*/
	else if ($_action == "change_user_settings") {
		$connection = new PDO("mysql:host=localhost;dbname=registered_users", "root", "");
		$sql_motion = "UPDATE users SET 
		login='{$_data['login']}', 
		email='{$_data['email']}', 
		second_name='{$_data['second_name']}', 
		first_name='{$_data['first_name']}',
		middle_name='{$_data['middle_name']}'
		WHERE `users`.`id`={$_data['id']}";
		$statement = $connection->prepare($sql_motion);
		$result = $statement->execute($_data);
		header("Location: /#tab_account_settings");
	}
	/*
	* Изменить личный пароль пользователя.
	*/
	else if ($_action == "change_user_password") {
		$connection = new PDO("mysql:host=localhost;dbname=registered_users", "root", "");
		$sql_motion = "UPDATE users SET password='{$_data['password']}' WHERE `users`.`id`={$_data['id']}";
		$statement = $connection->prepare($sql_motion);
		$result = $statement->execute($_data);
		header("Location: /#tab_account_settings");
	}
	/*
	* Изменить должность.
	*/
	else if ($_action == "record_post") {
		$link = mysqli_connect("localhost", "root", "", "registered_users");
		$query = "UPDATE users SET post='{$_data['post']}' WHERE id={$_data['id']}";
		$result = mysqli_query($link, $query) or die(mysqli_error($link));
		header("Location: /#tab_account_administration");
	}
	/*
	* Исключение.
	*/
	else if ($_action == "exception") {
		header("Location: /data.php"); 
	}
}
/*
* Запросы допустимые для выполнения группам user и admin.
* Запрос на добавление записей во все таблицы и просмотр содержимых всех таблиц.
*/
/*
 * Код выполняется, если группа user или admin и запрос на запись информации о клиентах.
 */
try {
	if ((get_permissions()["Group"] == "user" or get_permissions()["Group"] == "admin") and 
	(isset($_POST['record_customer']))) {
		$get_post = array(
			"second_name" => $_POST["second_name"],
			"first_name" => $_POST["first_name"],
			"middle_name" => $_POST["middle_name"],
			"date_of_birth" => $_POST["date_of_birth"],
			"sex" => $_POST["sex"],
			"phone" => $_POST["phone"],
			"email" => $_POST["email"],
			"notes" => $_POST["notes"]
		);
		send_request($get_post, "record_customer");
	}
	else if ((get_permissions()["Group"] == "admin") and 
	(isset($_POST['remove_customer']))) {
		$get_post = array(
			"id" => $_POST["id"]
		);
		send_request($get_post, "remove_customer");
	}
	else if ((get_permissions()["Group"] == "admin") and 
	(isset($_POST['edit_customer']))) { /* ТУТ ПРОИСЗПВДБД ЫААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААА */
		$file=fopen("file.txt", "a");
		fwrite ($file, $_POST["id"]." customers");
		shell_exec('C:\Python37\pythonw.exe C:\Users\emtyk\Desktop\1\OSPanel\domains\db\changer.py');
		header("Location: /data.php#tab_customers");
	}

	
	else if ((get_permissions()["Group"] == "admin") and 
	(isset($_POST['edit_service']))) { /* ТУТ ПРОИСЗПВДБД ЫАААААААААААААААААААА22222222222222222АААААААААААААААААААААААААААААА */
		$file=fopen("file.txt", "a");
		fwrite ($file, $_POST["id"]." service");
		shell_exec('C:\Python37\pythonw.exe C:\Users\emtyk\Desktop\1\OSPanel\domains\db\changer.py');
		header("Location: /data.php#tab_cars");
	}
	else if ((get_permissions()["Group"] == "admin") and 
	(isset($_POST['edit_staff']))) { /* ТУТ ПРОИСЗПВДБД ЫАААААААААААААААААААА22222222222222222АААААААААААААААААААААААААААААА */
		$file=fopen("file.txt", "a");
		fwrite ($file, $_POST["id"]." staff");
		shell_exec('C:\Python37\pythonw.exe C:\Users\emtyk\Desktop\1\OSPanel\domains\db\changer.py');
		header("Location: /data.php#tab_staff");
	}
	else if ((get_permissions()["Group"] == "user" or get_permissions()["Group"] == "admin") and 
	(isset($_POST['record_service']))) {
		$get_post = array(
			"view" => $_POST["view"],
			"entity" => $_POST["entity"],
			"expiration" => $_POST["expiration"],
			"retail_price" => $_POST["retail_price"],
			"city" => $_POST["city"],
		);
		send_request($get_post, "record_service");
	}
	else if ((get_permissions()["Group"] == "admin") and 
	(isset($_POST['remove_service']))) {
		$get_post = array(
			"id" => $_POST["id"]
		);
		send_request($get_post, "remove_service");
	}
	else if ((get_permissions()["Group"] == "user" or get_permissions()["Group"] == "admin") and 
	(isset($_POST['record_staff']))) {
		$get_post = array(
			"second_name" => $_POST["second_name"],
			"first_name" => $_POST["first_name"],
			"middle_name" => $_POST["middle_name"],
			"date_of_birth" => $_POST["date_of_birth"],
			"phone" => $_POST["phone"],
			"email" => $_POST["email"],
			"position" => $_POST["position"],
			"date_of_employment" => $_POST["date_of_employment"],
			"sex" => $_POST["sex"],
		);
		send_request($get_post, "record_staff");
	}
	else if ((get_permissions()["Group"] == "admin") and 
	(isset($_POST['remove_staff']))) {
		$get_post = array(
			"id" => $_POST["id"]
		);
		send_request($get_post, "remove_staff");
	}
	else if ((get_permissions()["Group"] == "user" or get_permissions()["Group"] == "admin") and 
	(isset($_POST['record_sale']))) {
		$get_post = array(
			"id_service" => $_POST["id_service"],
			"id_customers" => $_POST["id_customers"],
			"id_staff" => $_POST["id_staff"],
			"payment_method" => $_POST["payment_method"],
			"date_of_sale" => $_POST["date_of_sale"],
			"pricetag" => $_POST["pricetag"]
		);
		send_request($get_post, "record_sale");
	}
	else if ((get_permissions()["Group"] == "admin") and 
	(isset($_POST['remove_sale']))) {
		$get_post = array(
			"id" => $_POST["id"]
		);
		send_request($get_post, "remove_sale");
	}
	else if ((get_permissions()["Group"] == "admin") and 
	(isset($_POST['accept_admin']))) {
		$get_post = array(
			"id" => $_POST["id"]
		);
		send_request($get_post, "accept_admin");
	}
	else if ((get_permissions()["Group"] == "admin") and 
	(isset($_POST['accept_user']))) {
		$get_post = array(
			"id" => $_POST["id"]
		);
		send_request($get_post, "accept_user");
	}
	else if ((get_permissions()["Group"] == "admin") and 
	(isset($_POST['remove_account']))) {
		$get_post = array(
			"id" => $_POST["id"]
		);
		send_request($get_post, "remove_account");
	}
	else if ((get_permissions()["Group"] == "admin") and 
	(isset($_POST['record_post']))) {
		$get_post = array(
			"id" => $_POST["id"],
			"post" => $_POST["post"]
		);
		send_request($get_post, "record_post");
	}
	else if ((get_permissions()["Group"] == "user" or get_permissions()["Group"] == "admin") and 
	(isset($_POST['change_user_settings']))) {
		$get_post = array(
			"id" => get_permissions()['Id'],
			"login" => $_POST["login"],
			"email" => $_POST["email"],
			"second_name" => $_POST["second_name"],
			"first_name" => $_POST["first_name"],
			"middle_name" => $_POST["middle_name"]
		);
		send_request($get_post, "change_user_settings");
	}
	else if ((get_permissions()["Group"] == "user" or get_permissions()["Group"] == "admin") and 
	(isset($_POST['change_user_password']))) {
		if ($get_post["password"] == $get_post["repeat_password"]) 
		{ 		
			$get_post = array(
				"id" => get_permissions()['Id'],
				"password" => password_hash($_POST["password"], PASSWORD_DEFAULT)
			);
			//echo $get_post["password"];
			send_request($get_post, "change_user_password"); 
		}
		else { header("Location: /#tab_account_settings"); }		
	}
	else if ((get_permissions()["Group"] == "user" or get_permissions()["Group"] == "admin") and 
	(isset($_POST['sorting']))) {
		sorting($_POST['table'], $_POST["key"]);
	}
} catch (Exception $e) { 
	send_request(null, "exception");
}
?>