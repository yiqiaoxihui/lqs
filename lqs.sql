-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 04, 2019 at 04:34 上午
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lqs`
--

-- --------------------------------------------------------

--
-- Table structure for table `baseImages`
--

CREATE TABLE `baseImages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `server_id` int(11) NOT NULL COMMENT '服务器id',
  `type` int(11) NOT NULL COMMENT '文件系统类型',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'create time',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'update time',
  `status` tinyint(4) NOT NULL COMMENT '镜像状态',
  `absPath` varchar(255) NOT NULL COMMENT '绝对路径'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='base images table';

--
-- Dumping data for table `baseImages`
--

INSERT INTO `baseImages` (`id`, `name`, `server_id`, `type`, `created_at`, `updated_at`, `status`, `absPath`) VALUES
(1, 'base.img', 1, 1, '2017-03-05 16:00:00', '2018-01-19 07:46:38', 0, '/var/lib/libvirt/images/base.img'),
(2, 'not_exist.img', 1, 1, '2017-03-20 16:00:00', '2017-04-25 22:51:05', -1, '/var/lib/libvirt/images/not_exist.img'),
(5, 'winxp.img', 1, 2, '2017-04-25 22:53:06', '2018-01-19 05:07:17', 0, '/var/lib/libvirt/images/winxp.img'),
(7, 'base1.img', 1, 1, '2017-05-26 16:48:21', '2017-05-26 16:48:21', -1, '/var/lib/libvirt/images/base1.img'),
(8, 'win10.img', 1, 2, '2017-07-06 04:52:32', '2017-07-06 04:52:32', -1, '/var/lib/libvirt/images/win10.img'),
(9, 'ubuntu14.04.img', 1, 1, '2018-01-19 07:46:22', '2018-02-03 00:26:30', 0, '/var/lib/libvirt/images/ubuntu14.04.img'),
(10, 'winxp2.img', 1, 2, '2018-01-21 06:20:46', '2018-02-03 00:26:32', 1, '/var/lib/libvirt/images/winxp2.img');

-- --------------------------------------------------------

--
-- Table structure for table `dataBase`
--

CREATE TABLE `dataBase` (
  `id` int(10) UNSIGNED NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dataBase`
--

INSERT INTO `dataBase` (`id`, `url`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'localhost', 'root', '', '0000-00-00 00:00:00', '2017-05-25 23:37:38');

-- --------------------------------------------------------

--
-- Table structure for table `fileRestore`
--

CREATE TABLE `fileRestore` (
  `id` int(11) NOT NULL,
  `fileId` int(11) NOT NULL COMMENT '文件id',
  `restoreStatus` int(1) NOT NULL COMMENT '还原状态',
  `restoreReason` int(1) NOT NULL COMMENT '还原原因',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fileRestoreRecord`
--

CREATE TABLE `fileRestoreRecord` (
  `id` int(11) NOT NULL,
  `fileId` int(11) NOT NULL COMMENT '文件id',
  `restoreReason` int(1) NOT NULL COMMENT '还原原因',
  `restoreType` int(1) NOT NULL COMMENT '还原方式',
  `result` int(1) NOT NULL COMMENT '还原结果',
  `message` int(1) NOT NULL DEFAULT '0' COMMENT '还原信息是否查看',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fileRestoreRecord`
--

INSERT INTO `fileRestoreRecord` (`id`, `fileId`, `restoreReason`, `restoreType`, `result`, `message`, `created_at`, `updated_at`) VALUES
(22, 32, 2, 1, 1, 1, '2017-06-02 03:01:22', '2017-06-01 19:01:22'),
(23, 34, 1, 1, 1, 1, '2017-06-02 03:01:22', '2017-06-01 19:01:22'),
(24, 1, 1, 1, 1, 1, '2017-06-10 02:03:41', '2017-06-09 18:03:41'),
(25, 34, 2, 1, 1, 1, '2017-06-10 02:03:41', '2017-06-09 18:03:41');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `overlayId` int(11) NOT NULL,
  `absPath` varchar(255) NOT NULL,
  `inode` int(11) NOT NULL,
  `mode` int(11) NOT NULL COMMENT '文件类型',
  `size` int(11) NOT NULL,
  `firstAddFlag` tinyint(4) NOT NULL DEFAULT '0' COMMENT '首次监控标志',
  `hash` varchar(64) NOT NULL COMMENT '特征值',
  `isModified` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否被修改',
  `lost` int(1) NOT NULL DEFAULT '0' COMMENT '文件丢失',
  `restore` tinyint(1) NOT NULL COMMENT '还原状态',
  `createTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '文件创建时间',
  `accessTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modifyTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleteTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `inodePosition` tinyint(4) NOT NULL DEFAULT '0',
  `dataPosition` tinyint(4) NOT NULL DEFAULT '0',
  `baseHas` int(1) NOT NULL COMMENT '原始镜像中有此文件',
  `beforeInode` int(11) NOT NULL,
  `isdelete` tinyint(4) NOT NULL COMMENT '是否删除',
  `status` int(11) NOT NULL COMMENT '文件状态',
  `beforeSize` int(11) NOT NULL,
  `beforeCreateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `beforeAccessTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `beforeModifyTime` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='监控文件信息' ROW_FORMAT=COMPACT;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `overlayId`, `absPath`, `inode`, `mode`, `size`, `firstAddFlag`, `hash`, `isModified`, `lost`, `restore`, `createTime`, `accessTime`, `modifyTime`, `deleteTime`, `inodePosition`, `dataPosition`, `baseHas`, `beforeInode`, `isdelete`, `status`, `beforeSize`, `beforeCreateTime`, `beforeAccessTime`, `beforeModifyTime`, `created_at`, `updated_at`) VALUES
(1, 1, '/home/base/Desktop/a.txt', 140848, 33188, 8, 1, 'b07bb0a5625d0fc66dd72b2b26875410', 0, 0, 0, '2017-06-10 02:03:18', '2017-06-10 02:03:18', '2017-06-10 02:03:18', '0000-00-00 00:00:00', 2, 2, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2018-01-19 05:11:42'),
(4, 1, '/home/base/Desktop/open.c', 159470, 33204, 428, 1, '481868cd24dafd1f8dc0f2aa417bcad7', 1, 0, 0, '2017-06-16 04:36:44', '2017-06-16 04:36:45', '2017-06-16 04:36:44', '0000-00-00 00:00:00', 2, 2, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2018-01-19 05:11:43'),
(5, 2, '/home/base/Desktop/open.c', 140894, 33204, 424, 1, '481868cd24dafd1f8dc0f2aa417bcad7', 0, 0, 0, '2017-03-17 07:15:05', '2017-05-04 11:53:23', '2017-03-17 07:15:05', '0000-00-00 00:00:00', 2, 2, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-05-08 01:07:49'),
(6, 3, '/home/base/Desktop/open.c', 138787, 33204, 424, 1, '481868cd24dafd1f8dc0f2aa417bcad7', 0, 0, 0, '2017-04-26 15:04:21', '2017-05-05 14:16:15', '2017-04-26 15:04:21', '0000-00-00 00:00:00', 2, 2, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-05-08 01:07:50'),
(7, 4, '/home/base/Desktop/open.c', 155803, 33204, 424, 1, '481868cd24dafd1f8dc0f2aa417bcad7', 0, 0, 0, '2017-04-26 14:07:35', '2017-04-26 14:07:35', '2017-04-26 14:07:35', '0000-00-00 00:00:00', 2, 2, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-05-08 01:07:54'),
(8, 5, '/home/base/Desktop/open.c', 0, 0, 0, 0, '', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-05-08 01:07:57'),
(9, 6, '/home/base/Desktop/open.c', 140996, 33204, 424, 1, '481868cd24dafd1f8dc0f2aa417bcad7', 0, 0, 0, '2017-04-27 02:16:27', '2017-04-27 02:16:28', '2017-04-27 02:16:27', '0000-00-00 00:00:00', 2, 2, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-04-26 18:42:38'),
(10, 7, '/home/base/Desktop/open.c', 0, 0, 0, 0, '', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-05-08 01:08:00'),
(11, 8, '/home/base/Desktop/open.c', 0, 0, 0, 0, '', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-05-08 01:08:00'),
(12, 9, '/home/base/Desktop/open.c', 0, 0, 0, 0, '', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-05-08 01:08:06'),
(13, 10, '/home/base/Desktop/open.c', 0, 0, 0, 0, '', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-05-08 01:08:09'),
(14, 2, '/home/base/Desktop/a.txt', 140863, 33204, 8, 1, 'b07bb0a5625d0fc66dd72b2b26875410', 0, 0, 0, '2017-03-01 15:26:23', '2017-05-04 03:35:49', '2017-03-01 15:26:22', '0000-00-00 00:00:00', 2, 1, 1, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-05-08 01:07:50'),
(15, 3, '/home/base/Desktop/a.txt', 155666, 33204, 8, 1, 'b07bb0a5625d0fc66dd72b2b26875410', 0, 0, 0, '2017-04-27 00:39:38', '2017-05-05 09:49:33', '2017-04-27 00:39:38', '0000-00-00 00:00:00', 2, 2, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-05-08 01:07:51'),
(16, 4, '/home/base/Desktop/a.txt', 155725, 33204, 8, 1, 'b07bb0a5625d0fc66dd72b2b26875410', 0, 0, 0, '2017-04-26 14:00:51', '2017-04-26 14:00:52', '2017-04-26 14:00:51', '0000-00-00 00:00:00', 2, 2, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-05-08 01:07:52'),
(17, 5, '/home/base/Desktop/a.txt', 0, 0, 0, 0, '', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-05-08 01:07:58'),
(18, 6, '/home/base/Desktop/a.txt', 135406, 33204, 8, 1, 'b07bb0a5625d0fc66dd72b2b26875410', 0, 0, 0, '2017-04-27 02:20:02', '2017-04-27 02:20:03', '2017-04-27 02:20:02', '0000-00-00 00:00:00', 2, 2, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-04-26 18:42:36'),
(19, 7, '/home/base/Desktop/a.txt', 0, 0, 0, 0, '', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-05-08 01:08:03'),
(20, 8, '/home/base/Desktop/a.txt', 0, 0, 0, 0, '', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-05-08 01:08:02'),
(21, 9, '/home/base/Desktop/a.txt', 0, 0, 0, 0, '', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-05-08 01:08:06'),
(22, 10, '/home/base/Desktop/a.txt', 0, 0, 0, 0, '', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-05-08 01:08:07'),
(29, 6, '/home/base/Desktop/base_test1', 140997, 33204, 9, 1, 'ba096fc198228372db5087ca43ed93f1', 0, 0, 0, '2017-04-27 02:32:12', '2017-04-27 02:32:13', '2017-04-27 02:32:12', '0000-00-00 00:00:00', 2, 2, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-04-26 18:21:28', '2017-05-08 01:07:59'),
(30, 11, '/liuyang.txt', 10720, 33279, 15, 1, '406848afb6e5f5cb58761e26a17c9914', 0, 0, 0, '2017-04-16 05:53:06', '2017-04-16 05:53:06', '2017-04-16 05:53:06', '0000-00-00 00:00:00', 2, 2, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-05-02 19:23:47', '2017-05-08 01:08:08'),
(31, 11, '/WINDOWS/DtcInstall.log', 5625, 33279, 130, 1, '886a587e658d6e1379131e6badf8019f', 0, 0, 0, '2017-04-11 04:49:50', '2017-04-11 04:49:50', '2017-04-11 04:49:50', '0000-00-00 00:00:00', 2, 2, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-05-02 19:24:47', '2017-05-08 01:08:16'),
(32, 1, '/home/base/Desktop/base_test1', 155303, 33188, 9, 1, 'ba096fc198228372db5087ca43ed93f1', 0, 1, 0, '2017-06-02 03:00:45', '2017-06-10 01:53:04', '2017-06-02 03:00:45', '0000-00-00 00:00:00', 2, 2, 1, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-05-05 06:15:31', '2018-01-19 05:11:43'),
(34, 1, '/home/base/Desktop/base_test', 155870, 33188, 8, 1, 'b07bb0a5625d0fc66dd72b2b26875410', 0, 0, 0, '2017-06-10 02:03:18', '2017-06-16 04:32:11', '2017-06-10 02:03:18', '0000-00-00 00:00:00', 2, 2, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-05-31 00:37:57', '2018-01-19 05:11:48');

-- --------------------------------------------------------

--
-- Table structure for table `fileScanRecord`
--

CREATE TABLE `fileScanRecord` (
  `id` int(11) NOT NULL,
  `overlayId` int(11) NOT NULL,
  `allFiles` int(11) NOT NULL,
  `overlayFiles` int(11) NOT NULL,
  `scanTime` int(5) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fileScanRecord`
--

INSERT INTO `fileScanRecord` (`id`, `overlayId`, `allFiles`, `overlayFiles`, `scanTime`, `created_at`, `updated_at`) VALUES
(1, 3, 74295, 660, 154, '2017-05-21 07:23:01', '0000-00-00 00:00:00'),
(2, 11, 19397, 1137, 58, '2018-01-21 13:45:42', '0000-00-00 00:00:00'),
(4, 1, 89558, 1074, 133, '2018-01-19 15:27:48', '0000-00-00 00:00:00'),
(5, 4, 89038, 272, 124, '2018-01-19 13:43:54', '0000-00-00 00:00:00'),
(6, 14, 176029, 2, 539, '2017-07-06 13:10:14', '0000-00-00 00:00:00'),
(7, 15, 6, 0, 86, '2017-07-06 15:38:07', '0000-00-00 00:00:00'),
(8, 16, 19412, 0, 48, '2018-01-21 13:48:27', '0000-00-00 00:00:00'),
(9, 2, 89020, 0, 126, '2018-01-19 13:39:14', '0000-00-00 00:00:00'),
(10, 9, 51791, 2085, 65, '2018-01-19 13:53:39', '0000-00-00 00:00:00'),
(11, 17, 162892, 7068, 196, '2018-02-03 16:12:52', '0000-00-00 00:00:00'),
(12, 18, 168898, 0, 211, '2018-01-20 12:52:42', '0000-00-00 00:00:00'),
(13, 20, 13487, 5691, 51, '2018-01-23 14:11:01', '0000-00-00 00:00:00'),
(14, 21, 13211, 0, 41, '2018-02-03 08:38:46', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `filesystemType`
--

CREATE TABLE `filesystemType` (
  `name` varchar(10) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `filesystemType`
--

INSERT INTO `filesystemType` (`name`, `id`) VALUES
('EXT2', 1),
('NTFS', 2);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2016_07_06_100952_create_article_table', 2),
('2016_07_11_132255_create_yktrend_table', 3),
('2016_07_11_132717_create_yktrend_table', 4),
('2016_07_11_133142_create_yktrend_table', 5),
('2016_07_12_011208_create_yktype_table', 6),
('2016_07_12_012312_create_yknumber_table', 7),
('2016_07_12_012837_create_yksource_table', 8),
('2016_07_12_013943_create_ykcompare_table', 9),
('2016_07_12_014247_create_incomecompare_table', 10),
('2016_07_12_014557_create_incomesource_table', 11),
('2016_07_12_020150_create_incomesum_table', 12),
('2016_07_12_020513_create_incomeaccumulate_table', 13),
('2016_07_13_122600_create_yktype_table', 14),
('2016_07_14_021820_create_yktype_table', 15),
('2016_07_14_030139_create_yktype_table', 16),
('2016_07_14_144526_create_ykcompare_table', 17),
('2016_07_15_030608_create_incomecompare_table', 18),
('2016_07_17_133455_create_spotskys_table', 19),
('2017_04_19_102739_create_servers_table', 20),
('2017_05_26_020955_create_database_table', 21);

-- --------------------------------------------------------

--
-- Table structure for table `overlays`
--

CREATE TABLE `overlays` (
  `id` int(11) NOT NULL,
  `baseImageId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '镜像名称',
  `status` tinyint(4) NOT NULL COMMENT '镜像状态',
  `scan` int(1) NOT NULL DEFAULT '0',
  `backupPath` varchar(255) NOT NULL COMMENT '在主机中的备份文件夹',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'create time',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `absPath` varchar(255) NOT NULL COMMENT '绝对路径'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='增量镜像表';

--
-- Dumping data for table `overlays`
--

INSERT INTO `overlays` (`id`, `baseImageId`, `name`, `status`, `scan`, `backupPath`, `created_at`, `updated_at`, `absPath`) VALUES
(1, 1, 'snap1.img', 0, 0, '1snap1', '2017-03-12 16:00:00', '2018-01-19 07:47:11', '/var/lib/libvirt/images/snap1.img'),
(2, 1, 'snap2.img', 0, 0, '2snap2', '2017-03-16 16:00:00', '2018-01-19 05:41:05', '/var/lib/libvirt/images/snap2.img'),
(3, 1, 'snap3.img', 0, 0, '3snap3', '2017-04-07 16:00:00', '2017-05-24 05:26:08', '/var/lib/libvirt/images/snap3.img'),
(4, 1, 'snap4.img', 0, 0, '4snap4', '2017-04-07 16:00:00', '2018-01-19 05:51:38', '/var/lib/libvirt/images/snap4.img'),
(5, 1, 'snap5.img', 0, 0, '5snap5', '2017-04-07 16:00:00', '0000-00-00 00:00:00', '/var/lib/libvirt/images/snap5.img'),
(6, 1, 'snap6.img', 0, 0, '6snap6', '2017-04-07 16:00:00', '2017-04-26 19:01:17', '/var/lib/libvirt/images/snap6.img'),
(7, 1, 'snap7.img', 0, 0, '7snap7', '2017-04-07 16:00:00', '0000-00-00 00:00:00', '/var/lib/libvirt/images/snap7.img'),
(8, 1, 'snap8.img', 0, 0, '8snap8', '2017-04-07 16:00:00', '0000-00-00 00:00:00', '/var/lib/libvirt/images/snap8.img'),
(9, 1, 'snap9.img', 0, 0, '9snap9', '2017-04-07 16:00:00', '2018-01-19 06:11:46', '/var/lib/libvirt/images/snap9.img'),
(10, 1, 'snap10.img', 0, 0, '10snap10', '2017-04-07 16:00:00', '0000-00-00 00:00:00', '/var/lib/libvirt/images/snap10.img'),
(11, 5, 'winxp_snap1.img', 0, 0, '11snap11', '2017-05-02 19:20:32', '2018-01-21 05:47:31', '/var/lib/libvirt/images/winxp_snap1.img'),
(13, 7, 'base1_snap1.img', 0, 0, '', '2017-05-26 16:49:05', '2017-06-01 04:24:42', '	/var/lib/libvirt/images/base1_snap1.img'),
(14, 8, 'win10_snap1.img', 0, 0, '', '2017-07-06 04:53:13', '2017-07-06 05:26:22', '/var/lib/libvirt/images/win10_snap1.img'),
(15, 8, 'win10_snap2.img', 0, 0, '', '2017-07-06 05:22:33', '2017-07-06 20:27:46', '/var/lib/libvirt/images/win10_snap2.img'),
(16, 5, 'winxp_snap2.img', 0, 0, '', '2017-07-06 05:29:20', '2018-01-22 04:54:16', '/var/lib/libvirt/images/winxp_snap2.img'),
(17, 9, 'u14_snap1.img', 0, 1, '', '2018-01-19 07:47:00', '2018-02-03 05:23:29', '/var/lib/libvirt/images/u14_snap1.img'),
(18, 9, 'u14_snap2.img', 0, 0, '', '2018-01-19 08:11:03', '2018-01-21 04:28:14', '/var/lib/libvirt/images/u14_snap2.img'),
(19, 9, 'u14_snap3.img', 0, 0, '', '2018-01-19 08:11:25', '2018-01-19 08:11:25', '/var/lib/libvirt/images/u14_snap3.img'),
(20, 10, 'winxp2_snap1.img', 0, 0, '', '2018-01-22 04:55:37', '2018-02-03 00:14:36', '/var/lib/libvirt/images/winxp2_snap1.img'),
(21, 10, 'winxp2_snap2.img', 0, 0, '', '2018-02-03 00:14:24', '2018-02-03 05:18:31', '/var/lib/libvirt/images/winxp2_snap2.img');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('937285794@qq.com', '342a2945d42eda8708ae87b88d5e49727e5528a2bac8e71344d46531c8b1f891', '2017-04-26 06:29:24');

-- --------------------------------------------------------

--
-- Table structure for table `servers`
--

CREATE TABLE `servers` (
  `id` int(11) NOT NULL,
  `serverNumber` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `IP` char(15) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `backupRoot` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '备份根目录',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `servers`
--

INSERT INTO `servers` (`id`, `serverNumber`, `name`, `address`, `IP`, `status`, `backupRoot`, `created_at`, `updated_at`) VALUES
(1, 8323329, 'heaven', 'localhost', '127.0.0.1', 1, '/.8323329heaven', '2017-04-18 16:00:00', '2017-06-01 05:21:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(1) NOT NULL DEFAULT '1' COMMENT '用户类型',
  `status` smallint(1) NOT NULL COMMENT '状态',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `type`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', '937285794@qq.com', '$2y$10$oMLS6yPj5Aq8t1LySKE1DuXIUTiM0tV3W/.m/0.mB3zLXngH4txB2', 2, 1, 'idu3imZ0QfUgMVkuBGIabvW9szPAa0nLLmGykcpQUkGTWiKArmh7In6PwiyS', '2016-07-05 05:59:29', '2017-06-01 18:07:34');

-- --------------------------------------------------------

--
-- Table structure for table `virus`
--

CREATE TABLE `virus` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `virus`
--

INSERT INTO `virus` (`id`, `name`, `hash`, `created_at`, `updated_at`, `code`) VALUES
(1, 'usb脚本病毒', '309e4806ec5c609a33fe7f739bad2a7b', '2017-06-01 12:43:53', '2017-06-01 04:43:53', 'CE-VE2079'),
(2, 'usb脚本病毒', '9ae0e85c4c4fd4f6167f45af65cc3879', '2017-06-01 12:43:58', '2017-06-01 04:43:58', 'CE-VE2079'),
(3, 'usb脚本病毒', '53c9b22cb0a40a126c8422362c2f78d8', '2017-06-01 12:44:03', '2017-06-01 04:44:03', 'CE-VE2079'),
(4, 'windows恶意激活软件', 'a02164371a50c5ff9fa2870ef6e8cfa3', '2017-05-27 09:21:35', '2017-05-27 01:21:35', 'CE-VE2079');

-- --------------------------------------------------------

--
-- Table structure for table `virusKill`
--

CREATE TABLE `virusKill` (
  `id` int(11) NOT NULL,
  `overlayId` int(11) NOT NULL,
  `virusId` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `virusKill`
--

INSERT INTO `virusKill` (`id`, `overlayId`, `virusId`, `filename`) VALUES
(1, 11, 4, '/Documents and Settings/heaven/æ¡Œé¢/KMSpico_setup/KMSpico_setup.exe'),
(2, 11, 1, '/Documents and Settings/heaven/æ¡Œé¢/usb_virus/helper.vbs'),
(3, 11, 2, '/Documents and Settings/heaven/æ¡Œé¢/usb_virus/installer.vbs'),
(4, 11, 3, '/Documents and Settings/heaven/æ¡Œé¢/usb_virus/movemenoreg.vbs');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `baseImages`
--
ALTER TABLE `baseImages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `server_id` (`server_id`),
  ADD KEY `id` (`id`),
  ADD KEY `id_2` (`id`),
  ADD KEY `server_id_2` (`server_id`),
  ADD KEY `type` (`type`),
  ADD KEY `server_id_3` (`server_id`);

--
-- Indexes for table `dataBase`
--
ALTER TABLE `dataBase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fileRestore`
--
ALTER TABLE `fileRestore`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `fileId` (`fileId`);

--
-- Indexes for table `fileRestoreRecord`
--
ALTER TABLE `fileRestoreRecord`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `fileId` (`fileId`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `overlayId` (`overlayId`);

--
-- Indexes for table `fileScanRecord`
--
ALTER TABLE `fileScanRecord`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `overlayId` (`overlayId`);

--
-- Indexes for table `filesystemType`
--
ALTER TABLE `filesystemType`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `overlays`
--
ALTER TABLE `overlays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `base_image_index` (`baseImageId`),
  ADD KEY `id` (`id`),
  ADD KEY `baseImageId` (`baseImageId`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `servers`
--
ALTER TABLE `servers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `id_2` (`id`),
  ADD KEY `serverNumber` (`serverNumber`),
  ADD KEY `serverNumber_2` (`serverNumber`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `virus`
--
ALTER TABLE `virus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `virusKill`
--
ALTER TABLE `virusKill`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `overlayId` (`overlayId`),
  ADD KEY `virusId` (`virusId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `baseImages`
--
ALTER TABLE `baseImages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `dataBase`
--
ALTER TABLE `dataBase`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `fileRestore`
--
ALTER TABLE `fileRestore`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fileRestoreRecord`
--
ALTER TABLE `fileRestoreRecord`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `fileScanRecord`
--
ALTER TABLE `fileScanRecord`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `filesystemType`
--
ALTER TABLE `filesystemType`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `overlays`
--
ALTER TABLE `overlays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `servers`
--
ALTER TABLE `servers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `virus`
--
ALTER TABLE `virus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `virusKill`
--
ALTER TABLE `virusKill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `baseImages`
--
ALTER TABLE `baseImages`
  ADD CONSTRAINT `baseImages_ibfk_1` FOREIGN KEY (`server_id`) REFERENCES `servers` (`id`);

--
-- Constraints for table `fileRestore`
--
ALTER TABLE `fileRestore`
  ADD CONSTRAINT `fileRestore_ibfk_1` FOREIGN KEY (`fileId`) REFERENCES `files` (`id`);

--
-- Constraints for table `fileRestoreRecord`
--
ALTER TABLE `fileRestoreRecord`
  ADD CONSTRAINT `fileRestoreRecord_ibfk_1` FOREIGN KEY (`fileId`) REFERENCES `files` (`id`);

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`overlayId`) REFERENCES `overlays` (`id`);

--
-- Constraints for table `fileScanRecord`
--
ALTER TABLE `fileScanRecord`
  ADD CONSTRAINT `fileScanRecord_ibfk_1` FOREIGN KEY (`overlayId`) REFERENCES `overlays` (`id`);

--
-- Constraints for table `filesystemType`
--
ALTER TABLE `filesystemType`
  ADD CONSTRAINT `filesystemType_ibfk_1` FOREIGN KEY (`id`) REFERENCES `baseImages` (`type`);

--
-- Constraints for table `overlays`
--
ALTER TABLE `overlays`
  ADD CONSTRAINT `overlays_ibfk_1` FOREIGN KEY (`baseImageId`) REFERENCES `baseImages` (`id`);

--
-- Constraints for table `virusKill`
--
ALTER TABLE `virusKill`
  ADD CONSTRAINT `virusKill_ibfk_1` FOREIGN KEY (`virusId`) REFERENCES `virus` (`id`),
  ADD CONSTRAINT `virusKill_ibfk_2` FOREIGN KEY (`overlayId`) REFERENCES `overlays` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
