<?php 

require "access.php"; 

$data = $_POST;

if (isset($data['do_login'])) 
{
	$errors = array();

	$user = R::findOne('users', 'login = ?', array($data['login']));

	if ($user) 
	{
		if (password_verify($data['password'], $user->password)) 
		{ 
				$_SESSION['logged_user'] = $user;
				header('Location: /#tab_reports');
		}
		else { 
			echo "<div class='p_card_errors'>Неверно введён пароль</div>";
		}
	}
	else { 
		echo "<div class='p_card_errors'>Пользователь не найден</div>"; 
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
			<p class="p_card_auth_header">Мы уже знакомы?</p>
			<form action="login.php" method="POST">
				<input class="entry_field_auth" name="login" id="login" type="text" placeholder="Введите логин" required><br>
				<input class="entry_field_auth" name="password" id="password" type="password" placeholder="Введите пароль" required><br>
				<button class="btn_auth" name="do_login" type="submit">Войти</button>
			</form>
			<a class="btn_register" href="/index.php">Вернуться на главную</a><br><br><br>
		</div>
	</div>
</div>

<?php include_once "templates/footer.php"; ?>