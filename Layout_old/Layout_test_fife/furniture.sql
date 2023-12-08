-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Сен 27 2022 г., 22:13
-- Версия сервера: 10.4.24-MariaDB
-- Версия PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `furniture_factory`
--

-- --------------------------------------------------------

--
-- Структура таблицы `furniture`
--

CREATE TABLE `furniture` (
  `id` int(11) UNSIGNED NOT NULL,
  `check_photo` varchar(45) NOT NULL DEFAULT 'no_img png',
  `deal_number` varchar(45) NOT NULL,
  `id_buyer` int(11) UNSIGNED NOT NULL,
  `composition` varchar(255) DEFAULT NULL,
  `weight` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `furniture`
--

INSERT INTO `furniture` (`id`, `check_photo`, `deal_number`, `id_buyer`, `composition`, `weight`) VALUES
(1, 'lb2/inc_img/bedandhandrid.jpg', '112', 1, 'Стол, кровать', 150),
(2, 'livingroom.jpg', '113', 15, 'Мебель для гостиной(Столы, стулья, шкаф, диван)', 500),
(3, 'divan.jpg', '145', 1, 'Диван', 100),
(4, 'bedandtympochka.jpg', '325', 11, 'Тумбочки, кровать', 80),
(5, 'kitchen.jpg', '784', 12, 'Полки, мебель на кухню(сборный комплект)', 800),
(6, 'prihojay.jpg', '453', 10, 'Мебель в прихожую(Шкаф, полки)', 200),
(7, 'bar.jpg', '795', 3, 'Барная стойка', 150),
(8, 'polki.jpg', '463', 19, 'Полки, подставки', 50),
(9, 'shkafandstol.jpg', '778', 18, 'Открытый Шкаф, стол', 200),
(10, 'beed2jpg.jpg', '446', 17, 'Кровать двухспальная', 250),
(11, 'beed1.jpg', '6953', 3, 'Кровать односпальная', 100),
(12, 'metalstol.jpg', '745', 10, 'Металлический стол', 300),
(13, 'stolizdypa.jpg', '335', 17, 'Стол из дуба', 150),
(14, 'prihojay.jpg', '442', 17, 'Мебель в прихожую(Шкаф, полки)', 200),
(15, 'beed2jpg.jpg', '856', 19, 'Кровать двухспальная', 250),
(16, 'beed1.jpg', '412', 4, 'Односпальная кровать', 150),
(17, 'bedandtympochka.jpg', '350', 9, 'Тумбочки, кровать', 80),
(18, 'stolizdypa.jpg', '456', 5, 'Стол из дуба', 150),
(19, 'rascladstol.jpg', '746', 15, 'Раскладываюищйся стол', 50),
(20, 'livingroo.jpg', '632', 16, 'Мебель для гостиной(Столы, стулья, шкаф, диван) 	', 800);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `furniture`
--
ALTER TABLE `furniture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_1` (`id_buyer`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `furniture`
--
ALTER TABLE `furniture`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `furniture`
--
ALTER TABLE `furniture`
  ADD CONSTRAINT `foreign_key_1` FOREIGN KEY (`id_buyer`) REFERENCES `buyer` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
