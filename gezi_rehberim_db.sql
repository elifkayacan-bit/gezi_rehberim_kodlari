-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 27 May 2026, 13:48:42
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `gezi_rehberim_db`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `begeniler`
--

CREATE TABLE `begeniler` (
  `id` int(11) NOT NULL,
  `gonderi_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `begeniler`
--

INSERT INTO `begeniler` (`id`, `gonderi_id`, `username`, `tarih`) VALUES
(7, 1, 'kayacan', '2026-05-25 19:44:00'),
(8, 1, 'elif', '2026-05-26 09:45:51'),
(9, 5, 'Alper otuzoglu', '2026-05-27 08:26:18'),
(10, 7, 'Alperrrr', '2026-05-27 09:14:33'),
(11, 5, 'Alperrrr', '2026-05-27 09:14:34'),
(12, 6, 'Alperrrr', '2026-05-27 09:14:35');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `blocks`
--

CREATE TABLE `blocks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `blocked_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `follows`
--

CREATE TABLE `follows` (
  `id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL,
  `following_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `gonderiler`
--

CREATE TABLE `gonderiler` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `aciklama` text NOT NULL,
  `gorsel` varchar(500) DEFAULT NULL,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp(),
  `begeni_sayisi` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `gonderiler`
--

INSERT INTO `gonderiler` (`id`, `username`, `baslik`, `aciklama`, `gorsel`, `tarih`, `begeni_sayisi`) VALUES
(5, 'elifff', 'es', 'çok güzel bir şehir', 'yuklemeler/kesif_6a15e59c22c13.jpg', '2026-05-26 18:25:32', 0),
(6, 'Alper otuzoglu', 'eskişehir', 'şlfgjaiefbfdnşk', 'yuklemeler/kesif_6a16aabbbb69e.jpg', '2026-05-27 08:26:35', 0),
(7, 'Alperrrr', 'det', 'cnxv', 'yuklemeler/kesif_6a16b5e4c2fbf.jpg', '2026-05-27 09:14:12', 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `onerilen_yerler`
--

CREATE TABLE `onerilen_yerler` (
  `id` int(11) NOT NULL,
  `baslik` varchar(150) NOT NULL,
  `sehir` varchar(100) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `aciklama` text NOT NULL,
  `puan` float NOT NULL DEFAULT 5,
  `konum_tipi` enum('turkiye','yurtdisi') NOT NULL DEFAULT 'turkiye'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `onerilen_yerler`
--

INSERT INTO `onerilen_yerler` (`id`, `baslik`, `sehir`, `foto`, `aciklama`, `puan`, `konum_tipi`) VALUES
(1, 'Karanlık Kanyon', 'Erzincan / Kemaliye', 'https://images.unsplash.com/photo-1590004953392-5aba2e72269a?w=600', 'Dünyanın en büyük kanyonlarından biridir. Bot turları ve uçurumlara oyulmuş Taş Yolu ile macera severler için tam bir gizli cennettir.', 4.8, 'turkiye'),
(2, 'Cehennem Deresi Kanyonu', 'Artvin / Ardanuç', 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=600', 'Dünyada az sayıda bulunan dik duvarlı kanyonlardandır. Dar yollardan geçilerek ulaşılan bu kanyon büyüleyici bir vahşi doğaya sahiptir.', 4.7, 'turkiye'),
(3, 'Frig Vadisi ve Midas Anıtı', 'Eskişehir / Afyon', 'https://images.unsplash.com/photo-1541432901042-2d8bd64b4a9b?w=600', 'Kapadokya\'ya benzeyen kaya yapısı ve binlerce yıllık devasa kaya anıtlarıyla, kalabalıktan uzak tarih kokan mistik bir vadidir.', 4.9, 'turkiye'),
(4, 'Kaklık Mağarası (Yeraltı Pamukkalesi)', 'Denizli', 'https://images.unsplash.com/photo-1518495973542-4542c06a5843?w=600', 'Pamukkale\'nin yer altındaki şubesi gibidir. Mağaranın içinde travertenler, termal sular ve eşine az rastlanır sarkıtlar bulunur.', 4.8, 'turkiye'),
(5, 'Gideros Koyu', 'Kastamonu / Cide', 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=600', 'Karadeniz\'in hırçın dalgalarından saklanmış, yemyeşil ağaçların denizle birleştiği, akvaryum gibi durgun ve gizli bir balıkçı koyudur.', 4.9, 'turkiye'),
(6, 'Blaundus Antik Kenti', 'Uşak', 'https://images.unsplash.com/photo-1566121318342-8c10444fc600?w=600', 'Derin bir kanyonun ortasındaki yarımada üzerine kurulmuş, Stonehenge anıtlarını andıran kapılarıyla geceleri harika gökyüzü manzarası sunan antik kent.', 4.6, 'turkiye'),
(7, 'Giethoorn (Arabasız Köy)', 'Hollanda', 'https://images.unsplash.com/photo-1513694203232-719a280e022f?w=600', 'Hiç araba yolunun olmadığı, ulaşımın tamamen kanallarda sandallarla veya ahşap köprülerden yürüyerek sağlandığı masal köyü.', 4.9, 'yurtdisi'),
(8, 'Bled Gölü ve Kilisesi', 'Slovenya', 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=600', 'Alp Dağları\'nın eteğinde, gölün tam ortasındaki mini adada yer alan kilisesiyle dünyadan soyutlanmış gibi duran huzur rotası.', 5, 'yurtdisi'),
(9, 'Hallstatt Kasabası', 'Avusturya', 'https://images.unsplash.com/photo-1528127269322-539801943592?w=600', 'Bir dağın yamacına dizilmiş tarihi ahşap evleri ve göl manzarasıyla dünyanın en güzel korunan göl kenarı kasabalarından biridir.', 4.8, 'yurtdisi');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sehir_adi` varchar(100) NOT NULL,
  `aciklama` text NOT NULL,
  `fotograf` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `rehber_icerik`
--

CREATE TABLE `rehber_icerik` (
  `id` int(11) NOT NULL,
  `tip` enum('sehir','ulke') NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `isim` varchar(100) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `gezilecek_yerler` text NOT NULL,
  `ne_yenir` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `rehber_icerik`
--

INSERT INTO `rehber_icerik` (`id`, `tip`, `kategori`, `isim`, `foto`, `gezilecek_yerler`, `ne_yenir`) VALUES
(1, 'sehir', 'Karadeniz', 'Trabzon', 'https://images.unsplash.com/photo-1601931343759-dd9a29baea92?w=600', 'Sümela Manastırı, Uzungöl, Atatürk Köşkü ve Boztepe en popüler rotalardır.', 'Meşhur Akçaabat köftesi, kuymak (muhlama), hamsili pilav ve Karadeniz pidesi mutlaka tadılmalı.'),
(2, 'sehir', 'Karadeniz', 'Rize', 'https://images.unsplash.com/photo-1543872084-c7bd3822856f?w=600', 'Ayder Yaylası, Pokut Yaylası, Fırtına Deresi ve Zilkale gezilecek yerlerin başında gelir.', 'Rize kavurması, muhlama, hamsikoli ve fırın sütlaç yemeden dönmeyin.'),
(3, 'ulke', 'Yurt Disi', 'İtalya', 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?w=600', 'Roma Kolezyum, Venedik Kanalları, Floransa Katedrali ve Pisa Kulesi görülmesi gereken yerlerdir.', 'Gerçek taş fırın İtalyan pizzası, taze makarna çeşitleri, lazanya ve tatlı olarak tiramisu.');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `seferler`
--

CREATE TABLE `seferler` (
  `id` int(11) NOT NULL,
  `ulasim_tipi` enum('otobus','ucak','tren') NOT NULL,
  `firma_adi` varchar(100) NOT NULL,
  `firma_logo` varchar(100) NOT NULL,
  `nereden` varchar(100) NOT NULL,
  `nereye` varchar(100) NOT NULL,
  `kalkis_saati` time NOT NULL,
  `fiyat` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `seferler`
--

INSERT INTO `seferler` (`id`, `ulasim_tipi`, `firma_adi`, `firma_logo`, `nereden`, `nereye`, `kalkis_saati`, `fiyat`) VALUES
(1, 'otobus', 'Kamil Koç', 'fas fa-bus', 'Istanbul', 'Erzincan', '08:30:00', 850.00),
(2, 'otobus', 'Metro Turizm', 'fas fa-bus', 'Istanbul', 'Erzincan', '14:15:00', 800.00),
(3, 'otobus', 'Pamukkale Turizm', 'fas fa-bus', 'Ankara', 'Denizli', '09:00:00', 450.00),
(4, 'ucak', 'Türk Hava Yolları', 'fas fa-plane', 'Istanbul', 'Erzincan', '06:15:00', 1850.00),
(5, 'ucak', 'Pegasus', 'fas fa-plane', 'Istanbul', 'Erzincan', '11:45:00', 1400.00),
(6, 'tren', 'TCDD Taşımacılık (YHT)', 'fas fa-train', 'Ankara', 'Denizli', '07:10:00', 320.00);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `takip_sistemi`
--

CREATE TABLE `takip_sistemi` (
  `id` int(11) NOT NULL,
  `takip_eden` varchar(255) NOT NULL,
  `takip_edilen` varchar(255) NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `takip_sistemi`
--

INSERT INTO `takip_sistemi` (`id`, `takip_eden`, `takip_edilen`, `tarih`) VALUES
(3, 'kayacan', 'elif', '2026-05-20 12:32:37'),
(6, 'Alperrrr', 'elifff', '2026-05-27 08:32:10');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT 'image/silder_1.jpg',
  `puan` int(11) DEFAULT 340,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `gezi_puani` int(11) NOT NULL DEFAULT 50,
  `profil_resmi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `avatar`, `puan`, `created_at`, `gezi_puani`, `profil_resmi`) VALUES
(1, 'elifff', 'elif.kayacan@gmail.com', '$2y$10$gZJytX/Pt3IlhE3U3H/BX.iNudlJyzgHjZMH5Cn3izdQo/L1HiJf.', 'uploads/avatar_1_1779819296.png', 340, '2026-05-20 11:45:58', 150, NULL),
(2, 'kayacan', 'kayacanelif922@gmail.com', '$2y$10$gxzQZaED1h29uCbc9uFQvuUnLwLlJO4sTWWVrS.2b51sFk0hJ7uzW', 'image/silder_1.jpg', 340, '2026-05-20 12:14:08', 50, NULL),
(3, 'Alperrrr', 'alperotuzoglu@gmail.com', '$2y$10$DhYoa8yj4fblnDUsZjmRkeuVkARuQIRrbu.yCtq3SqZc6PSoyQHJ.', 'uploads/avatar_3_1779870688.jpg', 340, '2026-05-27 08:25:15', 90, NULL);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `begeniler`
--
ALTER TABLE `begeniler`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `benzersiz_begeni` (`gonderi_id`,`username`);

--
-- Tablo için indeksler `blocks`
--
ALTER TABLE `blocks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_block` (`user_id`,`blocked_user_id`),
  ADD KEY `blocked_user_id` (`blocked_user_id`);

--
-- Tablo için indeksler `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_follow` (`follower_id`,`following_id`),
  ADD KEY `following_id` (`following_id`);

--
-- Tablo için indeksler `gonderiler`
--
ALTER TABLE `gonderiler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_like` (`user_id`,`post_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Tablo için indeksler `onerilen_yerler`
--
ALTER TABLE `onerilen_yerler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `rehber_icerik`
--
ALTER TABLE `rehber_icerik`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `seferler`
--
ALTER TABLE `seferler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `takip_sistemi`
--
ALTER TABLE `takip_sistemi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `benzersiz_takip` (`takip_eden`,`takip_edilen`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `begeniler`
--
ALTER TABLE `begeniler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `blocks`
--
ALTER TABLE `blocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `follows`
--
ALTER TABLE `follows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `gonderiler`
--
ALTER TABLE `gonderiler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `onerilen_yerler`
--
ALTER TABLE `onerilen_yerler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `rehber_icerik`
--
ALTER TABLE `rehber_icerik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `seferler`
--
ALTER TABLE `seferler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `takip_sistemi`
--
ALTER TABLE `takip_sistemi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `blocks`
--
ALTER TABLE `blocks`
  ADD CONSTRAINT `blocks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blocks_ibfk_2` FOREIGN KEY (`blocked_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `follows_ibfk_1` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `follows_ibfk_2` FOREIGN KEY (`following_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
