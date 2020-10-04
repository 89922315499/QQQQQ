<?php

require "access.php"; 

?>

<?php include_once "templates/header.php";?>

<?php if (isset($_SESSION['logged_user'])): ?>

<div class='content'>
<?php if (get_permissions()["Group"] == "admin"): ?>
<div class = 'p_card_full_size'>
    <p class='p_card_header' style='margin-left: 20px;'>Продажи</p>
    <?php //Поиск по продажам 
    isset ($_POST['get_for_id']);
    $id = $_POST['get_for_id'];
    $link = mysqli_connect("localhost", "root", "", "database");
	$query = "SELECT * FROM sale WHERE id_sale = '{$id}'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
    if ($data[0]!=null){
    
    $customers_explainer = mysqli_query($link, "SELECT * FROM customers WHERE id_customers = {$data[0]['id_customers']}") or die(mysqli_error($link)); //запрос к таблице клиентов по id продажи
		for ($cust_exp = []; $row = mysqli_fetch_assoc($customers_explainer); $cust_exp[] = $row);
		$customers_explainer='';

		$staff_explainer = mysqli_query($link, "SELECT * FROM staff WHERE id_staff = {$data[0]['id_staff']}") or die(mysqli_error($link));
		for ($staff_exp = []; $row = mysqli_fetch_assoc($staff_explainer); $staff_exp[] = $row);
		$staff_explainer='';

		$service_explainer = mysqli_query($link, "SELECT * FROM service WHERE id_service = {$data[0]['id_service']}") or die(mysqli_error($link));
		for ($service_exp = []; $row = mysqli_fetch_assoc($service_explainer); $service_exp[] = $row);
		$service_explainer='';

    echo "
    <p style='margin-left: 20px;'>В таблице продажи нашлась запись с релевантным id:<p>
    <div style='padding-left:20px; border-bottom: 2px solid black; border-top: 2px solid black; border-radius: 15px; margin-bottom:10px;'>
 
    <p style='p_card_header'><i>ID продажи:</i> {$elem['id_sale']}</p>
			<p>• <i>Услуга:</i> {$service_exp[0]['expiration']} {$service_exp[0]['view']} {$service_exp[0]['entity']} [{$data[0]['id_service']}]
			<br> • <i>Cотрудник:</i> {$staff_exp[0]['first_name']} {$staff_exp[0]['middle_name']} {$staff_exp[0]['second_name']} [{$data[0]['id_staff']}] <br>
			• <i>Клиент:</i> {$cust_exp[0]['first_name']} {$cust_exp[0]['middle_name']} {$cust_exp[0]['second_name']} [{$data[0]['id_customers']}]
			<br>• <i>Способ оплаты:</i> {$data[0]['payment_method']} <br> • <i>Итоговая сумма:</i> {$data[0]['pricetag']} (руб.)
			<br>• <i>Дата продажи:</i> {$data[0]['date_of_sale']}</p>

    </div>";
    }
    else{
        echo "<p style='margin-left: 20px;'>Поиск по таблице продаж не дал результата.</p>";
    }?>
</div>
<?php endif; ?>
<?php if (get_permissions()["Group"] == "admin"): ?>
<div class = 'p_card_full_size'>
<p class='p_card_header' style='margin-left: 20px;'>Клиенты</p>
<?php //Поиск по клиентам 
	$query = "SELECT * FROM customers WHERE id_customers = '{$id}'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
    if ($data[0]!=null){
    echo "
    <p style='margin-left: 20px;'>В таблице клиенты нашлась запись с релевантным id:<p>
    <div style='padding-left:20px; border-bottom: 2px solid black; border-top: 2px solid black; border-radius: 15px; margin-bottom:10px;'>
    <p>{$data[0]['second_name']} {$data[0]['first_name']} {$data[0]['middle_name']}</p>
    <p><i>ID клиента:</i> {$data[0]['id_customers']} • <i>Дата рождения:</i> {$data[0]['date_of_birth']} • <i>Пол:</i> {$data[0]['sex']}</p>
    <p><i>Тел.:</i> {$$data[0]['phone']} • <i>E-Mail:</i> {$data[0]['email']}</p>
    <p><i>Примечания:</i> {$data[0]['notes']}</p>

    </div>";
    }
    else{
        echo "<p style='margin-left: 20px;'>Поиск по таблице клиентов не дал результата.</p>";
    }?>
</div>
<?php endif; ?>
<?php if (get_permissions()["Group"] == "admin"): ?>
<div class = 'p_card_full_size'>
<p class='p_card_header' style='margin-left: 20px;'>Сотрудники</p>
<?php //Поиск по сотрудникам
	$query = "SELECT * FROM staff WHERE id_staff = '{$id}'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
    if ($data[0]!=null){
    echo "
    <p style='margin-left: 20px;'>В таблице сотрудники нашлась запись с релевантным id:<p>
    <div style='padding-left:20px; border-bottom: 2px solid black; border-top: 2px solid black; border-radius: 15px; margin-bottom:10px;'>
    <p>{$data[0]['second_name']} {$data[0]['first_name']} {$data[0]['middle_name']}</p>
    <p><i>ID клиента:</i> {$data[0]['id_staff']} • <i>Дата рождения:</i> {$data[0]['date_of_birth']} • <i>Пол:</i> {$data[0]['sex']}</p>
    <p><i>Тел.:</i> {$data[0]['phone']} • <i>E-Mail:</i> {$data[0]['email']}</p>

    </div>";
    }
    else{
        echo "<p style='margin-left: 20px;'>Поиск по таблице сотрудников не дал результата.</p>";
    }?>
</div>
<?php endif; ?>
<div class = 'p_card_full_size'>
<p class='p_card_header' style='margin-left: 20px;'>Услуги</p>
<?php //Поиск по оборудованию
  isset ($_POST['get_for_id']);
  $id = $_POST['get_for_id'];
  $link = mysqli_connect("localhost", "root", "", "database");
$query = "SELECT * FROM service WHERE id_service = '{$id}' OR view = '{$id}'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
    if ($data[0]!=null){
    echo "
    <p style='margin-left: 20px;'>В таблице услуг нашлась запись с релевантным id:<p>
    <div style='padding-left:20px; border-bottom: 2px solid black; border-top: 2px solid black; border-radius: 15px; margin-bottom:10px;'>
    <p style='p_card_header'>{$data[0]['view']}. {$data[0]['entity']}.</p>
			<p><i>ID услуги:</i> {$data[0]['id_service']} • <i>Лицо:</i> {$data[0]['expiration']}</p>
			<p></p>
			<p><i>Цена услуги:</i> {$data[0]['retail_price']} (руб.) • <i>Город:</i> {$data[0]['city']}</p>

    </div>";
    }
    else{
        echo "<p style='margin-left: 20px;'>Поиск по таблице услуг не дал результата.</p>";
    }?>
</div>
<?php else: ?>
<div class='content'>
<p style='color: white; font-size:30px;'>Отказано в доступе.</p>
</div>
<?php endif;?>
