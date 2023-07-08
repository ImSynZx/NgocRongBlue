/*
 Navicat MySQL Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 100427 (10.4.27-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : nro

 Target Server Type    : MySQL
 Target Server Version : 100427 (10.4.27-MariaDB)
 File Encoding         : 65001

 Date: 12/06/2023 23:57:53
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for account
-- ----------------------------
DROP TABLE IF EXISTS `account`;
CREATE TABLE `account`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `create_time` timestamp NULL DEFAULT current_timestamp,
  `update_time` timestamp NULL DEFAULT current_timestamp,
  `ban` smallint NOT NULL DEFAULT 0,
  `point_post` int NOT NULL DEFAULT 0,
  `last_post` int NOT NULL DEFAULT 0,
  `role` int NOT NULL DEFAULT -1,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `last_time_login` timestamp NOT NULL DEFAULT '2002-05-07 14:00:00',
  `last_time_logout` timestamp NOT NULL DEFAULT '2002-05-07 14:00:00',
  `ip_address` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `active` int NOT NULL DEFAULT 0,
  `thoi_vang` int NOT NULL DEFAULT 0,
  `server_login` int NOT NULL DEFAULT -1,
  `bd_player` double NULL DEFAULT 1,
  `is_gift_box` tinyint(1) NULL DEFAULT 0,
  `gift_time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '0',
  `reward` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `tongnap` int NOT NULL DEFAULT 0,
  `coin` int NOT NULL DEFAULT 0,
  `vnd` int NULL DEFAULT 0,
  `admin` int NOT NULL DEFAULT 0,
  `gioithieu` int NOT NULL DEFAULT 0,
  `recaf` int NULL DEFAULT 0,
  `tichdiem` int NOT NULL DEFAULT 0,
  `gmail` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `mkc2` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `1` int NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 117 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

SET FOREIGN_KEY_CHECKS = 1;
