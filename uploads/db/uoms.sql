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

 Date: 03/03/2020 11:56:06
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for uoms
-- ----------------------------
DROP TABLE IF EXISTS `uoms`;
CREATE TABLE `uoms`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` int(1) NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of uoms
-- ----------------------------
INSERT INTO `uoms` VALUES (1, 'Pcs(Pcs)', 1);
INSERT INTO `uoms` VALUES (2, 'Pack(Pack)', 1);
INSERT INTO `uoms` VALUES (3, 'Each(ea)', 1);
INSERT INTO `uoms` VALUES (4, 'Person(er)', 1);
INSERT INTO `uoms` VALUES (5, 'Day(day)', 1);
INSERT INTO `uoms` VALUES (6, 'Bottle(Bottle)', 1);
INSERT INTO `uoms` VALUES (7, 'Liter(l)', 1);
INSERT INTO `uoms` VALUES (8, 'Box(Box)', 1);
INSERT INTO `uoms` VALUES (9, 'Box-10(Box)', 1);
INSERT INTO `uoms` VALUES (10, 'PACK50(PACK50)', 1);

SET FOREIGN_KEY_CHECKS = 1;
