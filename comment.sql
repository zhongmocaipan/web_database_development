/*
 Navicat Premium Data Transfer

 Source Server         : demo
 Source Server Type    : MySQL
 Source Server Version : 80036 (8.0.36)
 Source Host           : localhost:3306
 Source Schema         : yii2advanced

 Target Server Type    : MySQL
 Target Server Version : 80036 (8.0.36)
 File Encoding         : 65001

 Date: 04/12/2024 00:34:34
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for comment
-- ----------------------------
DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `movie_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_id` int NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of comment
-- ----------------------------
INSERT INTO `comment` VALUES (1, '1303954', 2, '6666!', 2024);
INSERT INTO `comment` VALUES (2, '1303954', 2, '好好看', 1733148311);
INSERT INTO `comment` VALUES (3, '1303954', 2, '超级好看!', 1733149863);
INSERT INTO `comment` VALUES (4, '1303954', 2, '很好笑！', 1733150001);
INSERT INTO `comment` VALUES (5, '1303954', 2, '不好看', 1733150258);
INSERT INTO `comment` VALUES (6, '1303954', 2, '哈哈哈哈', 1733150713);
INSERT INTO `comment` VALUES (7, '1303954', 2, '哈哈', 1733150738);
INSERT INTO `comment` VALUES (8, '1303954', 2, '贾冰最帅', 1733151476);
INSERT INTO `comment` VALUES (9, '1303954', 2, '贾冰最帅', 1733151502);
INSERT INTO `comment` VALUES (10, '1303954', 2, '男神！', 1733151660);
INSERT INTO `comment` VALUES (11, '1303954', 2, '好帅', 1733151767);
INSERT INTO `comment` VALUES (12, '1303954', 2, '不是很好看', 1733151932);
INSERT INTO `comment` VALUES (13, '1303954', 2, '出道！', 1733152432);
INSERT INTO `comment` VALUES (14, '1303954', 2, '出道！', 1733152724);
INSERT INTO `comment` VALUES (15, '1303954', 2, '出道！', 1733152826);
INSERT INTO `comment` VALUES (16, '1303954', 2, '出道！', 1733152923);
INSERT INTO `comment` VALUES (17, '1303954', 2, '出道！', 1733153063);
INSERT INTO `comment` VALUES (18, '1303955', 2, 'dfgdfgd', 1733239470);
INSERT INTO `comment` VALUES (19, '1303955', 2, 'ghfghfhf', 1733239484);
INSERT INTO `comment` VALUES (20, '1303954', 2, 'hdsfj\r\n', 1733239538);
INSERT INTO `comment` VALUES (21, '1303970', 2, 'edsj', 1733243147);
INSERT INTO `comment` VALUES (22, '1303981', 2, '点击开发商', 1733243321);

SET FOREIGN_KEY_CHECKS = 1;
