-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 24 2020 г., 14:06
-- Версия сервера: 10.3.13-MariaDB-log
-- Версия PHP: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `database`
--

-- --------------------------------------------------------

--
-- Структура таблицы `customers`
--

CREATE TABLE `customers` (
  `id_customers` int(11) NOT NULL COMMENT 'ID клиента',
  `second_name` varchar(191) NOT NULL COMMENT 'Фамилия',
  `first_name` varchar(191) NOT NULL COMMENT 'Имя',
  `middle_name` varchar(191) DEFAULT NULL COMMENT 'Отчество (при наличии)',
  `date_of_birth` date NOT NULL COMMENT 'Дата рождения',
  `sex` varchar(191) NOT NULL COMMENT 'Пол',
  `phone` varchar(191) DEFAULT NULL COMMENT 'Телефон',
  `email` varchar(191) DEFAULT NULL COMMENT 'Электронная почта',
  `notes` varchar(191) DEFAULT NULL COMMENT 'Примечания'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Информация о клиентах';

--
-- Дамп данных таблицы `customers`
--

INSERT INTO `customers` (`id_customers`, `second_name`, `first_name`, `middle_name`, `date_of_birth`, `sex`, `phone`, `email`, `notes`) VALUES
(47, 'Батиков', 'Евгений', 'Павлович', '1999-05-06', 'Мужской', '+79124981409', 'bad@edian.com', 'Особо буйный'),
(48, 'Милонова', 'Лена', 'Артемовна', '1999-05-06', 'Мужской', '+79124251409', 'never@see.like', 'Ценный кадр');

-- --------------------------------------------------------

--
-- Структура таблицы `sale`
--

CREATE TABLE `sale` (
  `id_sale` int(11) NOT NULL COMMENT 'ID договора',
  `id_service` int(5) NOT NULL COMMENT 'ID электрооборудования',
  `id_customers` int(11) NOT NULL COMMENT 'ID клиента',
  `id_staff` int(11) NOT NULL COMMENT 'ID сотрудника',
  `date_of_sale` date NOT NULL COMMENT 'Дата продажи',
  `payment_method` varchar(191) NOT NULL COMMENT 'Способ оплаты',
  `pricetag` decimal(11,2) NOT NULL COMMENT 'Стоимость продажи'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `sale`
--

INSERT INTO `sale` (`id_sale`, `id_service`, `id_customers`, `id_staff`, `date_of_sale`, `payment_method`, `pricetag`) VALUES
(17, 5, 48, 9, '2020-05-07', 'Карта', '2500.00'),
(18, 9, 47, 9, '2020-05-31', 'Наличные', '1500.00'),
(19, 10, 48, 10, '2020-05-15', 'Карта', '1000.00');

-- --------------------------------------------------------

--
-- Структура таблицы `service`
--

CREATE TABLE `service` (
  `id_service` int(11) NOT NULL COMMENT 'ID услуги',
  `view` varchar(191) NOT NULL COMMENT 'Вид услуги',
  `entity` varchar(191) NOT NULL COMMENT 'Лицо (физ/юр)',
  `expiration` varchar(191) NOT NULL COMMENT 'Срок действия договора',
  `retail_price` int(119) NOT NULL COMMENT 'Розничная цена',
  `city` varchar(191) NOT NULL COMMENT 'Город'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `service`
--

INSERT INTO `service` (`id_service`, `view`, `entity`, `expiration`, `retail_price`, `city`) VALUES
(14, 'Юридическая консультация', 'Долгосрочный', 'Физическое', 1500, 'Пермь'),
(16, 'Составление судебного иска', 'Краткосрочный', 'Юридическое', 5000, 'Махачкала');

-- --------------------------------------------------------

--
-- Структура таблицы `staff`
--

CREATE TABLE `staff` (
  `id_staff` int(11) NOT NULL COMMENT 'ID сотрудника',
  `second_name` varchar(191) NOT NULL COMMENT 'Фамилия',
  `first_name` varchar(191) NOT NULL COMMENT 'Имя',
  `middle_name` varchar(191) DEFAULT NULL COMMENT 'Отчество (при наличии)',
  `date_of_birth` date NOT NULL COMMENT 'Дата рождения',
  `phone` varchar(191) NOT NULL COMMENT 'Телефон',
  `email` varchar(191) NOT NULL COMMENT 'Электронная почта',
  `position` varchar(191) NOT NULL COMMENT 'Должность',
  `date_of_employment` date NOT NULL COMMENT 'Дата трудоустройства',
  `sex` varchar(191) NOT NULL COMMENT 'Пол'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Информация о сотрудниках';

--
-- Дамп данных таблицы `staff`
--

INSERT INTO `staff` (`id_staff`, `second_name`, `first_name`, `middle_name`, `date_of_birth`, `phone`, `email`, `position`, `date_of_employment`, `sex`) VALUES
(9, 'Рыбина', 'Наталья', 'Степановна', '1999-05-06', '+725612356513', 'ryb@ryb.ryb', 'Старший сотрудник', '2019-05-05', 'Женский'),
(10, 'Сычева', 'Карина', 'Андреевна', '1999-02-10', '+79259600754', 'buffalo@mail.ru', 'Продавец', '2018-09-20', 'Женский');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id_customers`);

--
-- Индексы таблицы `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`id_sale`),
  ADD KEY `id_auto` (`id_service`),
  ADD KEY `id_customer` (`id_customers`),
  ADD KEY `id_staff` (`id_staff`);

--
-- Индексы таблицы `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id_service`) USING BTREE;

--
-- Индексы таблицы `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id_staff`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `customers`
--
ALTER TABLE `customers`
  MODIFY `id_customers` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID клиента', AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT для таблицы `sale`
--
ALTER TABLE `sale`
  MODIFY `id_sale` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID договора', AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `service`
--
ALTER TABLE `service`
  MODIFY `id_service` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID услуги', AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `staff`
--
ALTER TABLE `staff`
  MODIFY `id_staff` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID сотрудника', AUTO_INCREMENT=11;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `sale`
--
ALTER TABLE `sale`
  ADD CONSTRAINT `sale_ibfk_1` FOREIGN KEY (`id_service`) REFERENCES `service` (`id_service`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `sale_ibfk_2` FOREIGN KEY (`id_customers`) REFERENCES `customers` (`id_customers`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `sale_ibfk_3` FOREIGN KEY (`id_staff`) REFERENCES `staff` (`id_staff`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
