/*
 Navicat MySQL Data Transfer

 Source Server         : wamp
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : beans

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 03/03/2020 11:56:14
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for types
-- ----------------------------
DROP TABLE IF EXISTS `types`;
CREATE TABLE `types`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` int(1) NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of types
-- ----------------------------
INSERT INTO `types` VALUES (1, 'AC', 1);
INSERT INTO `types` VALUES (2, 'BD', 1);
INSERT INTO `types` VALUES (3, 'CA', 1);
INSERT INTO `types` VALUES (4, 'CB', 1);
INSERT INTO `types` VALUES (5, 'MC', 1);
INSERT INTO `types` VALUES (6, 'HA', 1);
INSERT INTO `types` VALUES (7, 'RM', 1);
INSERT INTO `types` VALUES (8, 'SP', 1);

SET FOREIGN_KEY_CHECKS = 1;
