<?php 

require "access.php"; 

$data = $_POST;

if (isset($data['do_singup']))
{
	$errors = array();

	if (trim($data['login']) == '') { $errors[] = 'Введите логин'; }

	if (trim($data['email']) == '') { $errors[] = 'Введите E-Mail'; }
	
	if (trim($data['first_name']) == '') { $errors[] = 'Введите имя'; }

	if (trim($data['second_name']) == '') { $errors[] = 'Введите фамилию'; }

	if ($data['password'] == '') { $errors[] = 'Введите пароль'; }
	
	if ($data['repeat_password'] != $data['password']) 
	{ $errors[] = 'Пароли не совпадают'; }

	if (R::count('users', 'login = ?', array($data['login'])) > 0) 
	{ $errors[] = 'Такой логин уже используется'; }
	
	if (R::count('users', 'email = ?', array($data['email'])) > 0) 
	{ $errors[] = 'Такой E-Mail уже используется'; }

	// Регистрация при отсутствии ошибок
	if (empty($errors)) 
	{ 
		$user = R::dispense('users');
		$user->login = $data['login'];
		$user->email = $data['email'];
		$user->first_name = $data['first_name'];
		$user->second_name = $data['second_name'];
		$user->middle_name = $data['middle_name'];
		$user->password = password_hash($data['password'], PASSWORD_DEFAULT);
		R::store($user);
		echo "<div class='p_card_successful'>Вы успешно зарегистрированы</div>";
	}
	else { 
		$errors = array_shift($errors);
		echo "<div class='p_card_errors'>{$errors}</div>"; 
	}
}

?>

<?php include_once "templates/header.php"; ?>


<div class="content">       
	<div class="p_header">
			<p class="p_header_page"><?php echo $TITLE_PAGE; ?></p>
	</div>
	<div>
		<div class="p_card_full_size">
			<p class="p_card_auth_header">Расскажите о себе</p>
			<div class="form_auth">
				<form action="singup.php" method="POST">
					<input class="entry_field_auth" type="text" name="login" placeholder="Введите логин" value="<?php echo @$data['login']; ?>"><br>
					<input class="entry_field_auth" type="email" name="email" placeholder="E-Mail" value="<?php echo @$data['email']; ?>"><br>
					<input class="entry_field_auth" type="text" name="first_name" placeholder="Имя" value="<?php echo @$data['first_name']; ?>"><br>
					<input class="entry_field_auth" type="text" name="second_name" placeholder="Фамилия" value="<?php echo @$data['second_name']; ?>"><br>
					<input class="entry_field_auth" type="text" name="middle_name" placeholder="Отчество (при наличии)" value="<?php echo @$data['middle_name']; ?>"><br>
					<input class="entry_field_auth" type="password" name="password" placeholder="Пароль" value="<?php echo @$data['password']; ?>"><br>
					<input class="entry_field_auth" type="password" name="repeat_password" placeholder="Повторите пароль" value="<?php echo @$data['repeat_password']; ?>">
					<p>
						<button class="btn_auth" name="do_singup" type="submit">Регистрация</button>
					</p>
				</form>
					<a class="btn_register" href="/index.php">Вернуться на главную</a><br><br><br>
				</div>
			</div>
		</div>
</div>

<?php include_once "templates/footer.php"; ?>