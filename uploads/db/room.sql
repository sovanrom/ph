/*
 Navicat MySQL Data Transfer

 Source Server         : wamp
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : room

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 27/11/2019 10:58:10
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for aauth_group_to_group
-- ----------------------------
DROP TABLE IF EXISTS `aauth_group_to_group`;
CREATE TABLE `aauth_group_to_group`  (
  `group_id` int(11) UNSIGNED NOT NULL,
  `subgroup_id` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`group_id`, `subgroup_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for aauth_groups
-- ----------------------------
DROP TABLE IF EXISTS `aauth_groups`;
CREATE TABLE `aauth_groups`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `definition` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of aauth_groups
-- ----------------------------
INSERT INTO `aauth_groups` VALUES (1, 'Admin', 'Super Admin Group');
INSERT INTO `aauth_groups` VALUES (2, 'Public', 'Public Access Group');
INSERT INTO `aauth_groups` VALUES (3, 'Default', 'Default Access Group');

-- ----------------------------
-- Table structure for aauth_login_attempts
-- ----------------------------
DROP TABLE IF EXISTS `aauth_login_attempts`;
CREATE TABLE `aauth_login_attempts`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(39) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0',
  `timestamp` datetime(0) NULL DEFAULT NULL,
  `login_attempts` tinyint(2) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of aauth_login_attempts
-- ----------------------------
INSERT INTO `aauth_login_attempts` VALUES (1, '::1', '2019-11-27 10:05:15', 1);

-- ----------------------------
-- Table structure for aauth_perm_to_group
-- ----------------------------
DROP TABLE IF EXISTS `aauth_perm_to_group`;
CREATE TABLE `aauth_perm_to_group`  (
  `perm_id` int(11) UNSIGNED NOT NULL,
  `group_id` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`perm_id`, `group_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for aauth_perm_to_user
-- ----------------------------
DROP TABLE IF EXISTS `aauth_perm_to_user`;
CREATE TABLE `aauth_perm_to_user`  (
  `perm_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`perm_id`, `user_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for aauth_perms
-- ----------------------------
DROP TABLE IF EXISTS `aauth_perms`;
CREATE TABLE `aauth_perms`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `definition` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for aauth_pms
-- ----------------------------
DROP TABLE IF EXISTS `aauth_pms`;
CREATE TABLE `aauth_pms`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) UNSIGNED NOT NULL,
  `receiver_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `message` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `date_sent` datetime(0) NULL DEFAULT NULL,
  `date_read` datetime(0) NULL DEFAULT NULL,
  `pm_deleted_sender` int(1) NULL DEFAULT NULL,
  `pm_deleted_receiver` int(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `full_index`(`id`, `sender_id`, `receiver_id`, `date_read`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for aauth_user_to_group
-- ----------------------------
DROP TABLE IF EXISTS `aauth_user_to_group`;
CREATE TABLE `aauth_user_to_group`  (
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`user_id`, `group_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of aauth_user_to_group
-- ----------------------------
INSERT INTO `aauth_user_to_group` VALUES (1, 1);
INSERT INTO `aauth_user_to_group` VALUES (1, 3);

-- ----------------------------
-- Table structure for aauth_user_variables
-- ----------------------------
DROP TABLE IF EXISTS `aauth_user_variables`;
CREATE TABLE `aauth_user_variables`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL,
  `data_key` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `value` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id_index`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for aauth_users
-- ----------------------------
DROP TABLE IF EXISTS `aauth_users`;
CREATE TABLE `aauth_users`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pass` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `banned` tinyint(1) NULL DEFAULT 0,
  `last_login` datetime(0) NULL DEFAULT NULL,
  `last_activity` datetime(0) NULL DEFAULT NULL,
  `date_created` datetime(0) NULL DEFAULT NULL,
  `forgot_exp` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `remember_time` datetime(0) NULL DEFAULT NULL,
  `remember_exp` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `verification_code` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `totp_secret` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ip_address` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of aauth_users
-- ----------------------------
INSERT INTO `aauth_users` VALUES (1, 'admin@gmail.com', 'dd5073c93fb477a167fd69072e95455834acd93df8fed41a2c468c45b394bfe3', 'admin', 0, '2019-11-27 10:42:06', '2019-11-27 10:42:06', NULL, NULL, NULL, NULL, NULL, NULL, '::1');

SET FOREIGN_KEY_CHECKS = 1;
