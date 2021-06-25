/*
 Navicat Premium Data Transfer

 Source Server         : Localhost
 Source Server Type    : MySQL
 Source Server Version : 100411
 Source Host           : localhost:3306
 Source Schema         : fastpizza

 Target Server Type    : MySQL
 Target Server Version : 100411
 File Encoding         : 65001

 Date: 25/06/2021 15:54:39
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ingridients
-- ----------------------------
DROP TABLE IF EXISTS `ingridients`;
CREATE TABLE `ingridients`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(10, 2) NOT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ingridients
-- ----------------------------
INSERT INTO `ingridients` VALUES (1, 'Abobrinha', 3.50, NULL);
INSERT INTO `ingridients` VALUES (5, 'Brócolis', 5.20, '2021-06-23 11:49:00');
INSERT INTO `ingridients` VALUES (6, 'Bacon', 8.25, '2021-06-23 11:49:54');
INSERT INTO `ingridients` VALUES (7, 'Calabresa', 7.50, '2021-06-23 11:52:31');
INSERT INTO `ingridients` VALUES (8, 'Catupiry', 5.50, '2021-06-23 12:01:55');
INSERT INTO `ingridients` VALUES (9, 'Cebola', 4.99, '2021-06-23 12:02:58');
INSERT INTO `ingridients` VALUES (10, 'Frango', 6.50, '2021-06-23 12:03:12');
INSERT INTO `ingridients` VALUES (11, 'Ovo', 3.99, '2021-06-23 12:03:26');
INSERT INTO `ingridients` VALUES (12, 'Queijo', 6.50, '2021-06-23 12:03:41');

-- ----------------------------
-- Table structure for pizza_ingridients
-- ----------------------------
DROP TABLE IF EXISTS `pizza_ingridients`;
CREATE TABLE `pizza_ingridients`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pizza` int(11) NOT NULL,
  `id_ingridient` int(11) NOT NULL,
  `price` decimal(10, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 91 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pizza_ingridients
-- ----------------------------
INSERT INTO `pizza_ingridients` VALUES (76, 1, 7, 7.50);
INSERT INTO `pizza_ingridients` VALUES (77, 1, 9, 4.99);
INSERT INTO `pizza_ingridients` VALUES (78, 1, 8, 5.50);
INSERT INTO `pizza_ingridients` VALUES (79, 1, 12, 6.50);
INSERT INTO `pizza_ingridients` VALUES (80, 2, 8, 5.50);
INSERT INTO `pizza_ingridients` VALUES (81, 2, 10, 6.50);
INSERT INTO `pizza_ingridients` VALUES (82, 2, 12, 6.50);
INSERT INTO `pizza_ingridients` VALUES (83, 3, 6, 8.25);
INSERT INTO `pizza_ingridients` VALUES (84, 3, 5, 5.20);
INSERT INTO `pizza_ingridients` VALUES (85, 3, 12, 6.50);
INSERT INTO `pizza_ingridients` VALUES (86, 3, 8, 5.50);
INSERT INTO `pizza_ingridients` VALUES (87, 5, 1, 3.50);
INSERT INTO `pizza_ingridients` VALUES (88, 5, 10, 6.50);
INSERT INTO `pizza_ingridients` VALUES (89, 5, 11, 3.99);

-- ----------------------------
-- Table structure for pizzas
-- ----------------------------
DROP TABLE IF EXISTS `pizzas`;
CREATE TABLE `pizzas`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `price` decimal(10, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pizzas
-- ----------------------------
INSERT INTO `pizzas` VALUES (1, 'Pizza de Calabresa c/ Catupiry', 'images/2021/06/catupiri-png.png', NULL, 24.49);
INSERT INTO `pizzas` VALUES (2, 'Pizza de Frango', 'images/2021/06/frango-png.png', NULL, 18.50);
INSERT INTO `pizzas` VALUES (3, 'Pizza de Brócolis com Bacon', 'images/2021/06/brocolis-png.png', NULL, 25.45);
INSERT INTO `pizzas` VALUES (5, 'Pizza Light', 'images/2021/06/abobrinha-png.png', '2021-06-23 01:16:39', 13.99);
INSERT INTO `pizzas` VALUES (6, 'Sua Pizza', 'images/2021/06/makeyourown-jpg.jpg', '2021-06-25 13:52:21', 0.00);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `level` int(255) NULL DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Administrador', 'admin@fastpizza.com.br', '21232f297a57a5a743894a0e4a801fc3', '2021-06-21 19:26:47', NULL, 10, 1);

SET FOREIGN_KEY_CHECKS = 1;
