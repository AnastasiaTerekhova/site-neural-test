-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 18 2021 г., 22:20
-- Версия сервера: 5.7.29
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `soc_set_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `userone` int(11) NOT NULL,
  `usertwo` int(11) NOT NULL,
  `messages_json` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `userone`, `usertwo`, `messages_json`) VALUES
(1, 12, 13, '[{\"id\":\"12\",\"text\":\"234567890-\"},{\"id\":\"12\",\"text\":\"234567890-\"},{\"id\":\"12\",\"text\":\"234567890-\"},{\"id\":\"12\",\"text\":\"234567890-\"},{\"id\":\"12\",\"text\":\"123\"},{\"id\":\"12\",\"text\":\"ebal\"},{\"id\":\"12\",\"text\":\"suska\"},{\"id\":\"12\",\"text\":\"Сука ты санная, я найду тебя, твоих родителей, родителей твоих родителей, переверну там всё верх дном!\"},{\"id\":\"13\",\"text\":\"Я тебя тварь ненавижу!!\"},{\"id\":\"12\",\"text\":\"будь ты сука проклят\"},{\"id\":\"12\",\"text\":\"1\"},{\"id\":\"12\",\"text\":\"2\"},{\"id\":\"12\",\"text\":\"3\"},{\"id\":\"12\",\"text\":\"1\"},{\"id\":\"12\",\"text\":\"1\"},{\"id\":\"12\",\"text\":\"refreerferferferf\"},{\"id\":\"12\",\"text\":\"ergerg<br />ergerg<br />hyt htyhty\"},{\"id\":\"12\",\"text\":\"gergerg<br />erg<br />er<br />ge<br />rg<br />erg<br />er<br />g<br />er<br />gerg\"}]'),
(2, 12, 14, '[{\"id\":\"12\",\"text\":\"Test message\"}]'),
(5, 15, 12, '[{\"id\":\"15\",\"text\":\"123\"},{\"id\":\"15\",\"text\":\"ПЕРЕРИСКА УРА!!<br />\"}]'),
(6, 20, 20, '[{\"id\":\"20\",\"text\":\"\"},{\"id\":\"20\",\"text\":\"fwefwefwef\"}]');

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `images_json` text NOT NULL,
  `groupid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `fromuser` int(11) DEFAULT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `message`, `images_json`, `groupid`, `userid`, `fromuser`, `date`) VALUES
(2, 'rgtersgegrtggertgrtgrtgtrgrt', '[]', NULL, 17, 17, '2020-10-13 07:58:49'),
(3, 'reoeop[rkgoperkpogkeropkgpekrpogkporekpog', '[\"https://miro.medium.com/max/1200/1*mk1-6aYaf_Bes1E3Imhc0A.jpeg\",\"data:image/png;base64,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\"]', NULL, 17, 17, '2020-10-13 08:02:50'),
(4, 'gergergergegregerger', '[]', NULL, 20, 20, '2020-10-13 09:37:39'),
(5, 'папарпрарпрар папрапраррпррарпрр парпрарпрапрапрапр рпарпрарпрра папр рпапарпрр арпр #семья ', '[]', NULL, 23, 23, '2021-03-11 18:53:19'),
(6, 'gjjjjg gfjgjfjgj gjfjgjfjgj jgjjfjg jjfg fjgjfj jgjfj gjfjgjjbd n n nfndnfnndnf nnfndnn nnfn dnfndnfndnfnrpepr peprpeprppw e;wewe;w; ;e;we;;w;;e;; ; e;renrnn nnn nrntntnntnnn ntnrntnr', '[\"https://uk.ellas-cookies.com/images/obrazovanie/udivitelnaya-i-izmenchivaya-plotnost-vodi_2.jpg\"]', NULL, 24, 24, '2021-03-11 19:00:15'),
(7, 'gfgfgggggggggggggggggggggggggggggggggggggggggggg g gggggggggggggggg g gggg', '[]', NULL, 23, 23, '2021-03-11 19:13:28'),
(8, 'В каменном веке художники создавали изображения или рисунки на камнях[2]. Первыми известными художниками были древние греки V веке до н. э. (Агатарх и Полигнот). Первым мифологическим художником считался Дедал, хотя он являлся одновременно скульптором и инженером. В Древнем Египте художники украшали гробницы и каменные дома, а ремесло художника было тесно связано с изготовлением красок[3]. В Древнем Египте создание изображений считалось магическим действием, а сами художники почитались как жрецы. Поскольку изображения были сакральны, то художники обладали знанием определённого канона и пропорций[4].\r\n\r\nВ средние века художник становился иконописцем (например, Андрей Рублёв[5]), создателем фресок, мозаики и книжных миниатюр, творчество которого сковывали каноны. В Италии эпохи Возрождения сформировался современный образ художника-портретиста, чьё искусство стало живописью с присущей ей свойствами (Джотто)[6].', '[]', NULL, 21, 21, '2021-04-01 19:33:53'),
(10, 'Респу́блика Коре́я (кор. 대한민국?, 大韓民國? Тэханмингук, устар. Коре́йская Респу́блика[7]) — государство в Восточной Азии, широко известное под неофициальным названием Ю́жная Коре́я.\r\n\r\nПлощадь страны составляет 100 210 км²[* 1], население, по оценке 2017 года — более 51 миллиона человек. Занимает сто седьмое место в мире по территории и двадцать седьмое по населениюПерейти к разделу «#Население».\r\n\r\nСтолица и крупнейший город — Сеул. Государственные языки — корейский и корейский жестовый язык.\r\n\r\nУнитарное государство, президентская республика. С 10 мая 2017 года президентом страны является Мун Чжэ Ин, избранный на этот пост на выборах 2017 годаПерейти к разделу «#Государственное устройство».\r\n\r\nПодразделяется на 16 административно-территориальных единиц, из которых 9 являются провинциями, 6 — городами-метрополиями со статусом, приравненным к провинциям, и 1 — городом особого статуса (Сеул)Перейти к разделу «#Административное деление».\r\n\r\nРасположено в южной части Корейского полуострова. Имеет сухопутную границу с Корейской Народно-Демократической Республикой (государства разделены демилитаризованной зоной) и морскую — с Японией. С запада страна омывается Жёлтым морем, с востока — Японским морем, а с юга — Корейским проливом и Восточно-Китайским моремПерейти к разделу «#География».\r\n\r\nРеспублика Корея — моноэтническое государство, корейцы составляют около 96 % населения. Более 65 % населения страны нерелигиозны, основные религии — буддизм и христианствоПерейти к разделу «#Религия».', '[]', NULL, 29, 29, '2021-04-02 20:06:47'),
(11, 'Коре́йская Респу́блика[7]) — государство в Восточной Азии, широко известное под неофициальным названием Ю́жная Коре́я. ', '[\"http://pm1.narvii.com/7179/d33f919711e58431aef85f4b0b0427f206b885a6r1-2048-1365v2_uhq.jpg\"]', NULL, 29, 29, '2021-04-02 20:08:23'),
(12, 'В лесу родилась ёлочка', '[]', NULL, 29, 29, '2021-04-02 20:12:35'),
(13, 'дддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддд ддддддд      прап       пппппппппппппппппппппппппппппппп              ппппппппппппппппп пппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппп ппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппппп', '[]', NULL, 25, 25, '2021-04-15 18:27:59'),
(14, 'Представляет элемент управления Windows \"поле рисунка\", предназначенный для отображения рисунков', '[]', NULL, 30, 30, '2021-04-18 07:26:08');

-- --------------------------------------------------------

--
-- Структура таблицы `pushes`
--

CREATE TABLE `pushes` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `fromuser` int(11) NOT NULL,
  `type` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pushes`
--

INSERT INTO `pushes` (`id`, `userid`, `fromuser`, `type`) VALUES
(3, 13, 15, 'tofriend'),
(4, 14, 15, 'tofriend'),
(5, 20, 23, 'tofriend'),
(7, 22, 23, 'tofriend'),
(8, 27, 23, 'tofriend');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `login` varchar(8) NOT NULL,
  `password` text NOT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `info_json` text,
  `posts_json` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `login`, `password`, `date`, `info_json`, `posts_json`) VALUES
(20, 'Yagir', 'Yagir', '$2y$10$HAdzXDLK6nEGYa18Da0iEuDwvhzPXzgpT0cVUyKGgz4musfyj9wyO', '2020-10-13 08:31:33', '{\"location\":\"\",\"born\":\"\",\"job\":\"\",\"study\":\"\",\"type\":\"\",\"hobby\":\"\",\"email\":\"\",\"background\":\"img/background.jpg\",\"avatar\":\"img/avatar.jpg\",\"friends\":[\"21\"]}', '[4]'),
(21, 'Yagir1', 'Yagir1', '$2y$10$HAdzXDLK6nEGYa18Da0iEuDwvhzPXzgpT0cVUyKGgz4musfyj9wyO', '2020-10-13 08:31:33', '{\"location\":\"gfgfg\",\"born\":\"hghgh\",\"job\":\"Yes\",\"study\":\"Ye\",\"type\":\"Yeааааа\",\"hobby\":\"АААААААААААААААААА\",\"email\":\"\",\"background\":\"https://www.nastol.com.ua/download.php?img=201404/1920x1080/nastol.com.ua-93135.jpg\",\"avatar\":\"https://mir-s3-cdn-cf.behance.net/project_modules/max_1200/c4b5f297550069.5ec79824b8a41.jpg\",\"friends\":{\"0\":\"21\",\"2\":\"24\",\"3\":\"29\"}}', '[4,8,9]'),
(22, 'Nika', 'Nika', '$2y$10$FAEQ.0tADukxzt0EjHQb0endWAh2WGzKxm7p9ZMUC3XJQfmSiPWIu', '2020-10-13 10:27:33', '', '[]'),
(23, 'Julia1', 'Julia1', '$2y$10$aRooas0EINKdii4zSPaIvuWf5Yiq8CEsc2FN0d4VaRFf95p0Sseoe', '2021-03-11 18:50:14', '{\"location\":\"\",\"born\":\"\",\"job\":\"\",\"study\":\"\",\"type\":\"\",\"hobby\":\"\",\"email\":\"\",\"background\":\"img/background.jpg\",\"avatar\":\"https://avatars.mds.yandex.net/get-zen_doc/244664/pub_5b25395c3d857800aaba5c81_5b253a754c398b00a9b1ac17/scale_1200\",\"friends\":null}', '[5,7]'),
(24, 'Pasha1', 'Pasha1', '$2y$10$ZMca/TUMROp9E7vRdBTxLuoOj3CUVC1kWwKnOKcaNjF.10C5D79w.', '2021-03-11 18:58:43', '{\"location\":\"\",\"born\":\"\",\"job\":\"\",\"study\":\"\",\"type\":\"\",\"hobby\":\"\",\"email\":\"\",\"background\":\"img/background.jpg\",\"avatar\":\"https://mir-s3-cdn-cf.behance.net/project_modules/max_1200/c4b5f297550069.5ec79824b8a41.jpg\",\"friends\":null}', '[6]'),
(25, 'Sasha1', 'Sasha1', '$2y$10$.qT3SLwbb1b2S5rmN0xas./0yuIA10aC.etSYrVECTBR6F0n9g0w6', '2021-03-11 19:18:22', '{\"friends\":null}', '[13]'),
(26, 'Julia2', 'Julia2', '$2y$10$bDgJzP7BTF3g8vWUcCHAOuluVvhroR.MlDWwcvCLR124FFHsW0IIW', '2021-03-11 19:19:46', '{\"friends\":null}', '[]'),
(27, 'Yarik', 'Yarik', '$2y$10$CD8QbMuB.6GOOYcNa1wlv.5pJ0XGY41iwxnmjqf.TZhc6OWADAQdK', '2021-03-24 18:09:21', '{\"location\":\"Феодосия\",\"born\":\"12.03.1999\",\"job\":\"Yes\",\"study\":\"Ye\",\"type\":\"Yes\",\"hobby\":\"Yes\",\"email\":\"yarik@gmail.com\",\"background\":\"img/background.jpg\",\"avatar\":\"img/avatar.jpg\",\"friends\":[]}', '[]'),
(28, 'Vitalik', 'Vitalik', '$2y$10$lI3WLIpnWUSkLhv/JY61..C69MBlQoOlSN5eLkok9YeGfAiag9nfS', '2021-03-24 18:14:41', '{\"location\":\"Sity\",\"born\":\"12.03.1999\",\"job\":\"Yes\",\"study\":\"Ye\",\"type\":\"Yes\",\"hobby\":\"Yes\",\"email\":\"Vitalik@gmail.com\",\"background\":\"img/background.jpg\",\"avatar\":\"img/avatar.jpg\",\"friends\":[]}', '[]'),
(29, 'Yashan', 'Yashan', '$2y$10$GO/zh7wNx5fqTP8gXVOSXemMXwAGCYHVE/TbCy.RTYNA6nWBjYgzW', '2021-04-02 19:52:13', '{\"location\":\"Sity\",\"born\":\"Sity\",\"job\":\"Yes\",\"study\":\"Yes\",\"type\":\"Yes\",\"hobby\":\"Yes\",\"email\":\"\",\"background\":\"http://st.gde-fon.com/wallpapers_original/655292_zamok-gogentsollern_baden-vyurtemberg_germaniya_2048x1365_www.Gde-Fon.com.jpgimg/background.jpg\",\"avatar\":\"https://get.wallhere.com/photo/landscape-forest-hill-building-castle-coast-cliff-monastery-Hohenzollern-chateau-Terrain-mountain-landmark-aerial-photography-mountain-range-136091.jpg\",\"friends\":[\"21\",\"23\"]}', '[10,11,12]'),
(30, 'Masha1', 'Masha1', '$2y$10$4QQUiggL.9GYutufEeXc5OnSJ.P0yp0x9R3ezQybFjUoQl1g5ycES', '2021-04-18 06:46:39', '{\"location\":\"Москва\",\"born\":\"01.01.1997\",\"job\":\"дддааа\",\"study\":\"Yes\",\"type\":\"Не замужем\",\"hobby\":\"Yes\",\"email\":\"\",\"background\":\"https://wallpaperaccess.com/full/479271.jpg\",\"avatar\":\"https://domfotooboev.com.ua/home/products_images/0282.jpg\",\"friends\":[\"24\"]}', '[14]');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pushes`
--
ALTER TABLE `pushes`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `pushes`
--
ALTER TABLE `pushes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
