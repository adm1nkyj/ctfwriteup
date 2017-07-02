-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- 호스트: localhost
-- 처리한 시간: 17-06-30 23:00
-- 서버 버전: 5.5.50-0ubuntu0.14.04.1
-- PHP 버전: 5.5.9-1ubuntu4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 데이터베이스: `simple_board`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `board`
--

CREATE TABLE IF NOT EXISTS `board` (
  `idx` int(255) NOT NULL AUTO_INCREMENT,
  `uploader_nick` varchar(200) NOT NULL,
  `uploader_id` varchar(200) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` varchar(200) NOT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- 테이블의 덤프 데이터 `board`
--

INSERT INTO `board` (`idx`, `uploader_nick`, `uploader_id`, `title`, `content`) VALUES
(1, 'adm1nkyjhi', 'reallyid', 'test', '1234'),
(2, 'adm1nkyjhi', 'reallyid', 'fda', 'fads'),
(3, 'adm1nkyjhi', 'reallyid', 'hello <img src=1>', 'ffdsfdsfsdafsad');

-- --------------------------------------------------------

--
-- 테이블 구조 `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `id` varchar(200) NOT NULL,
  `pw` varchar(200) NOT NULL,
  `nick` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 테이블의 덤프 데이터 `member`
--

INSERT INTO `member` (`id`, `pw`, `nick`) VALUES
('adm1nkyj', 'efcd6632bd42163a1e62b9e7e4dddb3f572a1606', 'adm1nkyj'),
('adm1nkyj1', 'efcd6632bd42163a1e62b9e7e4dddb3f572a1606', 'adm1nkyj1'),
('adm1nkyj2', 'efcd6632bd42163a1e62b9e7e4dddb3f572a1606', 'adm1nkyj2'),
('adm1nkyj4', 'efcd6632bd42163a1e62b9e7e4dddb3f572a1606', 'adm1nkyj4'),
('fdjsaklfjsakldfj', 'efcd6632bd42163a1e62b9e7e4dddb3f572a1606', 'fsdakfkdsalfjlksfjlksdjflsajflksajkdlf'),
('testid1', 'e9d62aad46c9e081d2ca89fac7c14a51702e408f', 'testid'),
('reallyid', 'efcd6632bd42163a1e62b9e7e4dddb3f572a1606', 'adm1nkyjhi');

-- --------------------------------------------------------

--
-- 테이블 구조 `read_me`
--

CREATE TABLE IF NOT EXISTS `read_me` (
  `flag` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 테이블의 덤프 데이터 `read_me`
--

INSERT INTO `read_me` (`flag`) VALUES
('SECU[wow_i_respect_you_XDD]');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
