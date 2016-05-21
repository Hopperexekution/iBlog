-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 20. Mai 2016 um 16:49
-- Server-Version: 10.1.10-MariaDB
-- PHP-Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `blog_project`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_german2_ci NOT NULL,
  `text` text COLLATE utf8mb4_german2_ci,
  `user_id` varchar(50) COLLATE utf8mb4_german2_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_german2_ci;

--
-- Daten für Tabelle `article`
--

INSERT INTO `article` (`id`, `title`, `text`, `user_id`, `date`) VALUES
(31, 'Wassersport im Aktivurlaub in Hurghada', '				Nicht nur Tauchen gehÃ¶rt zu den sportlichen VergnÃ¼gungen wÃ¤hrend eines \r\nAktivurlaubs in Hurghada, sondern auch Kite- und Wassersurfer finden \r\nhier ideale Bedingungen vor. Die Wassertemperatur ist &lt;b&gt;angenehm warm um \r\ndie 22Â°C&lt;/b&gt; und das Rote Meer weist durchgehend gute WindverhÃ¤ltnisse auf. \r\nWeiterhin kann ich Wassersportarten wie Jetski, Wasserski und \r\nWakeboarden, das in den vorgesehenen Zonen angeboten wird, empfehlen. \r\nAuch am weiÃŸen Strand finden sich genÃ¼gend MÃ¶glichkeiten fÃ¼r Fitness und\r\n Bewegung: von Volleyball Ã¼ber Golf bis hin zum Reiten.&lt;br&gt;Sommerliche GrÃ¼ÃŸe!!						', '34', '2016-05-20 14:26:00'),
(32, 'Outfit mit Lace Up Flats, Blazer und Destroyed Jeans', 'Mit dem FrÃ¼hling kommt meine Lust auf Farbe zurÃ¼ck. Zumindest nach der \r\nFarbe Rosa, denn die habe ich diesen FrÃ¼hling ununterbrochen getragen. \r\nGenau deshalb liebe ich mein &lt;strong&gt;Outfit mit einem rosa Blazer&lt;/strong&gt;,\r\n der leicht ins Apricot abdriftet. Der Blazer macht Lust auf Farbe und \r\nlÃ¤utet fÃ¼r mich den Sommer mit seinen knalligen Farben ein. Ebenso unverzichtbar \r\nsind in diesem Sommer fÃ¼r mich &lt;strong&gt;Lace Up Flats&lt;/strong&gt;, die flachen Sandalen bringen den FuÃŸ zum Leuchten und sind dabei super bequem.										', '35', '2016-05-20 14:03:58'),
(33, 'Essen auf der Insel RÃ¼gen', '				In der Brasserie Loev&lt;strong&gt;&lt;/strong&gt;\r\n zaubert Chefkoch Michael Raatz eine hervorragende frische und moderne \r\nKÃ¼che â€“ immer mit dem Bezug zur Region, was wir bei einem ganz tollen \r\nSanddornmenÃ¼ erleben durften. Die Einrichtung der Brasserie zaubert mit \r\nihren dunklen HÃ¶lzern, den bequemen SitzmÃ¶beln und dem prÃ¤gnanten \r\nKronleuchter ein wenig franzÃ¶sisches Flair auf die Insel.																', '36', '2016-05-20 14:09:33'),
(34, 'Unterwegs in der WÃ¼ste: Trekking, Klettern oder Quads', 'Bei einem Sporturlaub in Hurghada lohnt sich unbedingt auch ein \r\nAbstecher in die Arabische WÃ¼ste. Buchen Sie eine Tagestour mit dem Jeep\r\n oder Quad und dÃ¼sen Sie durch das weite Sandmeer. Fast immer steht bei \r\neiner WÃ¼stentour auch ein Besuch eines Beduinendorfs auf dem Programm, \r\nbei dem Sie die Traditionen der Beduinen kennenlernen.&lt;br /&gt;Es macht sehr viel SpaÃŸ! Versuchen Sie es mal...', '37', '2016-05-20 14:13:01'),
(35, 'Volti', '																				    Mit dem 2. Platz beim CVIO in Verden&amp;nbsp;sicherten sich Jannis, Simone und Dino&amp;nbsp;die Nominierung fÃ¼r die Europameisterschaft\r\n    in Verden.\r\n    Selten waren die drei PlÃ¤tze so umkÃ¤mpft wie in diesem Jahr. &lt;br /&gt;Sieben Herren standen auf der Longlist, alle hatten sich bereits\r\n    international erfolgreich prÃ¤sentiert.\r\n\r\n    In Verden lieferten sich die Deutschen Voltigierer dann wie erwartet ein Kopf-an-Kopf Rennen.\r\n\r\n    Nach\r\n einem kleinen Fehler in der Pflicht lag Jannis zunÃ¤chst noch auf Rang \r\n7, konnte sich dann aber mit der KÃ¼r auf den 3. Platz\r\n    vorkÃ¤mpfen. &lt;br /&gt;Richtig gut lief es dann in Technikprogramm, in dem er \r\nsich deutlich vom restlichen Starterfeld absetzte. Am Ende lag er nur \r\nknapp hinter Viktor BrÃ¼sewitz, der einen Start-Ziel-Sieg\r\n    hinlegte.&lt;br /&gt;&lt;br&gt;Was ein spannender Artikel! Mehr dazu &lt;a href=&quot;http://voltiteam-birkenhof.jimdo.com/aktuelles/&quot;&gt;hier&lt;/a&gt;!																														', '35', '2016-05-20 14:23:41'),
(36, 'Smoothie', '&lt;div class=&quot;recipe-title-container a-c&quot;&gt;\r\n			&lt;h1 class=&quot;page-title&quot;&gt;Himbeer - Orangen - Smoothie&lt;/h1&gt;\r\n\r\n					&lt;/div&gt;&lt;h2 class=&quot;h2-medium&quot;&gt;Zutaten&lt;/h2&gt;&lt;ul&gt;&lt;li&gt;250 g Himbeeren, ob frisch oder TK-Ware ist egal&lt;/li&gt;&lt;li&gt;200 g Naturjoghurt&lt;/li&gt;&lt;li&gt;300ml Orange(n), der Saft (frisch gepresst)&lt;/li&gt;&lt;/ul&gt;&lt;b&gt;AuÃŸerdem:&lt;/b&gt; Zucker&lt;h2&gt;Zubereitung&lt;/h2&gt;&lt;strong&gt;Arbeitszeit:&lt;/strong&gt;\r\n				ca. 10 Min.\r\n				\r\n				\r\n				/ &lt;strong&gt;Schwierigkeitsgrad:&lt;/strong&gt;\r\neinfach\r\n							\r\n\r\n						\r\n\r\n				Die Himbeeren mit dem Joghurt in einen Mixer geben und etwa 1 Min. \r\npÃ¼rieren, bis alles schÃ¶n cremig ist. Verwendet man frische Himbeeren, \r\nsollten diese gekÃ¼hlt sein. Den Orangensaft dazu geben und alles \r\nnochmals durchmixen. \r\nIch sÃ¼ÃŸe diesen Smoothie nicht, was man aber gerne tun kann. In GlÃ¤ser fÃ¼llen und mit Strohhalmen servieren.\r\n			&lt;br&gt;&lt;br&gt;&lt;b&gt;SUPER LECKERES REZEPT!!!!&lt;/b&gt; Unbedingt ausprobieren! 																								', '37', '2016-05-20 14:34:31'),
(37, 'Jetzt wirklich?', '&lt;h1&gt;Bauprojekt am Hafen: Monaco-Grand-Prix gefÃ¤hrdet?&lt;/h1&gt;&lt;h2&gt;Ein Bauprojekt gefÃ¤hrdet laut Cheforganisator Michel \r\nBoeri das Rennen in Monte Carlo - Es werde &quot;unweigerlich zum Aus des \r\nGroÃŸen Preises von Monaco fÃ¼hren&quot;&lt;/h2&gt;FÃ¤hrt die Formel 1 das letzte Mal in Monaco?(Motorsport-Total.com) - Der glamourÃ¶se Monaco-Grand-Prix zÃ¤hlt zu \r\nden Highlights im Formel-1-Kalender - bisher zumindest. &lt;br&gt; Denn der \r\nPrÃ¤sident des Automobile Club de Monaco (ACM) und damit auch Organisator\r\n des Monaco-Rennens warnt vor einem Bauprojekt, das im Hafen von Monte \r\nCarlo geplant ist: &lt;i&gt;&quot;Wenn das Projekt von Herrn Caroli Wirklichkeit wird,\r\n wÃ¼rde es automatisch das Ende des Grand Prix in der Formel 1 bedeuten. \r\nDas garantiere ich Ihnen&quot;&lt;/i&gt;, warnt ACM-PrÃ¤sident Michel Boeri. &lt;br&gt; Es \r\ngeht um ein umstrittenes Bauprojekt im Hafen. Dort soll ein neues \r\nViertel mit Wohneinheiten, GeschÃ¤ften, Restaurants sowie zwei Museen \r\nentstehen. Verantwortlich ist die Caroli-Gruppe, die sich seit den \r\n1970er-Jahren auf den Bau von WohnhÃ¤usern und Luxushotels in der Gegend \r\nkonzentriert.&lt;br&gt;&lt;br&gt;&lt;br /&gt;&lt;a href=&quot;http://www.motorsport-total.com/f1/news/2016/05/monaco-aus-durch-bauprojekt-16051919.html&quot;&gt;Hier&lt;/a&gt; zum Artikel...						', '36', '2016-05-20 14:40:15');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `text` text COLLATE utf8mb4_german2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_german2_ci;

--
-- Daten für Tabelle `comment`
--

INSERT INTO `comment` (`id`, `user_id`, `article_id`, `date`, `text`) VALUES
(15, 35, 31, '2016-05-20 14:25:14', 'Gibt es dort auch die MÃ¶glichkeit am Strand lang zu reiten?\r\n\r\nKlingt ja nach einem Traumurlaub!'),
(16, 34, 31, '2016-05-20 14:27:15', 'Ja, es war ein Traumurlaub!! \r\n\r\nLeider weiÃŸ ich nicht, ob man mit den Pferden auch am Strand entlang reiten kann. Aber die Leute dort sind super nett und du findest bestimmt etwas! :)'),
(17, 37, 32, '2016-05-20 14:35:16', 'Dein Outfit hÃ¶rt sich SUPER an!'),
(18, 36, 34, '2016-05-20 14:40:52', 'Klingt gut!!'),
(19, 34, 36, '2016-05-20 14:41:55', 'Das Rezept ist echt empfehlenswert!!\r\n\r\nDanke fÃ¼r den Tipp!');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `theme`
--

CREATE TABLE `theme` (
  `id` int(11) NOT NULL,
  `description` varchar(100) COLLATE utf8mb4_german2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_german2_ci;

--
-- Daten für Tabelle `theme`
--

INSERT INTO `theme` (`id`, `description`) VALUES
(18, 'Essen'),
(15, 'Mode'),
(17, 'Pferde'),
(16, 'Restaurantempfehlung'),
(19, 'Sport'),
(14, 'Urlaub');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `theme_article`
--

CREATE TABLE `theme_article` (
  `theme_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_german2_ci;

--
-- Daten für Tabelle `theme_article`
--

INSERT INTO `theme_article` (`theme_id`, `article_id`) VALUES
(14, 31),
(14, 34),
(15, 32),
(16, 33),
(17, 35),
(18, 36),
(19, 37);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `lastname` varchar(60) COLLATE utf8mb4_german2_ci NOT NULL,
  `firstname` varchar(60) COLLATE utf8mb4_german2_ci NOT NULL,
  `mail` varchar(50) COLLATE utf8mb4_german2_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_german2_ci NOT NULL,
  `unlocked` tinyint(1) NOT NULL DEFAULT '0',
  `code` varchar(100) COLLATE utf8mb4_german2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_german2_ci;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `lastname`, `firstname`, `mail`, `password`, `unlocked`, `code`) VALUES
(34, 'Leinkenjost', 'Anna', 'annaleinkenjost@web.de', '$2y$10$ECaE8iothaIFrsehmwJJleMXqcZJjWAjXM/sYJQZrGlPhzyPDvigi', 1, '$2y$10$7lrCokdzm0PEnjbG2LcRTuYGEMcAQp2Oh36OiiBOyKZve/VQTSGzu'),
(35, 'SchÃ¤fers', 'Claudia', 'claudia_schaefers@gmx.de', '$2y$10$0xpvyM10FCnzqtc1M3GZO.l3WQ9lkhB4xydQ6a/cTUJAfJk8CMXDu', 1, '$2y$10$DBqO9BiReFyjPiRFkoST/uvcpVHdJRieZR31yp1IOHf1Cb16YYIzS'),
(36, 'Raupach', 'Jan', 'jan.raupach@gmail.com', '$2y$10$cvsXFsopcwjtIh0gD1u50.weQNhxk3isZ9HviGNmOoTDuhc6Rt8om', 1, '$2y$10$a/YvL62Zzx6AFVNgtZmCe./DHIn9pLfZ57wbWVBSR9ziiIUd55KcS'),
(37, 'Kottig', 'Ann-Katrin', 'ann-katrin.kottig@web.de', '$2y$10$xXGU2fXoGfR8EPbt5KuUDOECSIHWpp65gNxQkzmN9ZuppW3nHB7kS', 1, '$2y$10$caQT1JAcK70nTUBvVjThGusfkn4GaDYc47fBEWPqq/MFzex.UWAYq');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_likes_article`
--

CREATE TABLE `user_likes_article` (
  `user_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_german2_ci;

--
-- Daten für Tabelle `user_likes_article`
--

INSERT INTO `user_likes_article` (`user_id`, `article_id`) VALUES
(34, 33),
(34, 34),
(34, 36),
(35, 31),
(36, 34),
(37, 31),
(37, 32),
(37, 33),
(37, 35);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Title` (`title`);

--
-- Indizes für die Tabelle `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `theme`
--
ALTER TABLE `theme`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `description` (`description`);

--
-- Indizes für die Tabelle `theme_article`
--
ALTER TABLE `theme_article`
  ADD PRIMARY KEY (`theme_id`,`article_id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- Indizes für die Tabelle `user_likes_article`
--
ALTER TABLE `user_likes_article`
  ADD PRIMARY KEY (`user_id`,`article_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT für Tabelle `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT für Tabelle `theme`
--
ALTER TABLE `theme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
