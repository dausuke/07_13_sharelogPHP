-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2020-12-24 10:32:13
-- サーバのバージョン： 10.4.17-MariaDB
-- PHP のバージョン: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `gsacf_d07_13`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `content_table`
--

CREATE TABLE `content_table` (
  `id` int(100) NOT NULL,
  `shopname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pnumber` int(100) NOT NULL,
  `evaluation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `freetext` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `getday` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `content_table`
--

INSERT INTO `content_table` (`id`, `shopname`, `area`, `pnumber`, `evaluation`, `category`, `freetext`, `getday`) VALUES
(1, 'test', 'testtest', 987654321, '★★', 'ディナー', 'test', '2020-12-24 10:32:55');

-- --------------------------------------------------------

--
-- テーブルの構造 `todo_table`
--

CREATE TABLE `todo_table` (
  `id` int(12) NOT NULL,
  `todo` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deadline` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `todo_table`
--

INSERT INTO `todo_table` (`id`, `todo`, `deadline`, `created_at`, `updated_at`) VALUES
(1, 'PHPの課題', '2020-12-24', '2020-12-19 15:50:52', '2020-12-19 15:50:52'),
(2, '課題', '2020-12-06', '2020-12-19 15:54:41', '2020-12-19 15:54:41'),
(3, 'クリスマス会', '2020-12-19', '2020-12-19 15:55:21', '2020-12-19 15:55:21'),
(4, '挨拶回り', '2020-12-10', '2020-12-19 15:56:04', '2020-12-19 15:56:04'),
(5, '卒制', '2021-04-27', '2020-12-19 15:57:16', '2020-12-19 15:57:16'),
(6, 'jsの課題', '2020-12-11', '2020-12-19 15:57:48', '2020-12-19 15:57:48'),
(7, '課題4', '2020-11-06', '2020-12-19 15:58:49', '2020-12-19 15:58:49'),
(8, '課題10', '0000-00-00', '2020-12-19 15:59:22', '2020-12-19 15:59:22'),
(9, '買い物', '2020-12-09', '2020-12-19 15:59:56', '2020-12-19 15:59:56'),
(10, '掃除', '2020-12-24', '2020-12-19 16:00:45', '2020-12-19 16:00:45'),
(11, 'test', '2020-12-17', '2020-12-19 16:45:30', '2020-12-19 16:45:30'),
(12, 'testtest', '2021-01-09', '2020-12-19 17:17:30', '2020-12-19 17:17:30');

-- --------------------------------------------------------

--
-- テーブルの構造 `userdata_table`
--

CREATE TABLE `userdata_table` (
  `id` int(100) NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` int(100) NOT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userpassword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `userdata_table`
--

INSERT INTO `userdata_table` (`id`, `username`, `age`, `city`, `email`, `userpassword`, `created_at`) VALUES
(1, 'test', 44, '千葉', 'test.kadai20201216@gmail.com', '123456', '2020-12-24 10:30:23');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `content_table`
--
ALTER TABLE `content_table`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `todo_table`
--
ALTER TABLE `todo_table`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `userdata_table`
--
ALTER TABLE `userdata_table`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `content_table`
--
ALTER TABLE `content_table`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- テーブルの AUTO_INCREMENT `todo_table`
--
ALTER TABLE `todo_table`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- テーブルの AUTO_INCREMENT `userdata_table`
--
ALTER TABLE `userdata_table`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
