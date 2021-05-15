/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100419
 Source Host           : localhost:3306
 Source Schema         : spiritbooks

 Target Server Type    : MySQL
 Target Server Version : 100419
 File Encoding         : 65001

 Date: 16/05/2021 00:44:46
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for permission
-- ----------------------------
DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permissionname` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `link` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ico` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `menusubmenu` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `multilevel` bit(1) NULL DEFAULT NULL,
  `separator` bit(1) NULL DEFAULT NULL,
  `order` int(255) NULL DEFAULT NULL,
  `status` bit(1) NULL DEFAULT NULL,
  `AllowMobile` bit(1) NULL DEFAULT NULL,
  `MobileRoute` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `MobileLogo` int(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permission
-- ----------------------------
INSERT INTO `permission` VALUES (1, 'User Management', NULL, 'fa-user', '0', b'1', b'0', 0, b'1', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (2, 'Daftar Pengguna Aplikasi', 'Home/user', NULL, '1', b'1', b'0', 1, b'1', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (3, 'Daftar Pengguna Aplikasi', NULL, NULL, '1', b'1', b'0', 2, b'0', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (4, 'Management Content', NULL, 'fa-folder-open', '0', b'1', b'0', 3, b'1', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (5, 'Kategori Buku', 'Home/kategori', NULL, '4', b'1', b'0', 4, b'1', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (6, 'Daftar Buku', 'Home/buku', NULL, '4', b'1', b'0', 5, b'1', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (7, 'Transaksi', NULL, 'fa-briefcase', '0', b'1', b'0', 6, b'1', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (8, 'Daftar Media Pembayaran', NULL, NULL, '7', b'1', b'0', 7, b'1', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (9, 'Daftar Transaksi', NULL, NULL, '7', b'1', b'0', 8, b'1', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (10, 'Laporan', NULL, 'fa-bar-chart-o', '0', b'1', b'0', 9, b'1', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (11, 'Laporan Penjualan', NULL, NULL, '10', b'1', b'0', 10, b'1', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (12, 'Laporan Uang Masuk', NULL, NULL, '10', b'1', b'0', 11, b'1', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for permissionrole
-- ----------------------------
DROP TABLE IF EXISTS `permissionrole`;
CREATE TABLE `permissionrole`  (
  `roleid` int(11) NOT NULL,
  `permissionid` int(11) NOT NULL
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissionrole
-- ----------------------------
INSERT INTO `permissionrole` VALUES (1, 1);
INSERT INTO `permissionrole` VALUES (1, 2);
INSERT INTO `permissionrole` VALUES (1, 3);
INSERT INTO `permissionrole` VALUES (1, 4);
INSERT INTO `permissionrole` VALUES (1, 5);
INSERT INTO `permissionrole` VALUES (1, 6);
INSERT INTO `permissionrole` VALUES (1, 7);
INSERT INTO `permissionrole` VALUES (1, 8);
INSERT INTO `permissionrole` VALUES (1, 9);
INSERT INTO `permissionrole` VALUES (1, 10);
INSERT INTO `permissionrole` VALUES (1, 11);
INSERT INTO `permissionrole` VALUES (1, 12);
INSERT INTO `permissionrole` VALUES (2, 1);
INSERT INTO `permissionrole` VALUES (2, 2);
INSERT INTO `permissionrole` VALUES (2, 3);
INSERT INTO `permissionrole` VALUES (2, 4);
INSERT INTO `permissionrole` VALUES (2, 5);
INSERT INTO `permissionrole` VALUES (2, 6);
INSERT INTO `permissionrole` VALUES (2, 7);
INSERT INTO `permissionrole` VALUES (2, 8);
INSERT INTO `permissionrole` VALUES (2, 9);
INSERT INTO `permissionrole` VALUES (2, 10);
INSERT INTO `permissionrole` VALUES (2, 11);
INSERT INTO `permissionrole` VALUES (2, 12);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rolename` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'SuperAdmin');
INSERT INTO `roles` VALUES (2, 'Admin');
INSERT INTO `roles` VALUES (3, 'Publisher');
INSERT INTO `roles` VALUES (4, 'User');

-- ----------------------------
-- Table structure for tbuku
-- ----------------------------
DROP TABLE IF EXISTS `tbuku`;
CREATE TABLE `tbuku`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `KodeItem` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kategoriID` int(11) NOT NULL,
  `judul` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `releasedate` datetime(0) NOT NULL,
  `releaseperiod` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `picture` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `picture_base64` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `harga` double(19, 2) NOT NULL,
  `ppn` double(19, 2) NOT NULL,
  `otherprice` double(10, 2) NOT NULL,
  `epub` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `epub_base64` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `avgrate` double(10, 2) NOT NULL DEFAULT 0,
  `status_publikasi` int(255) NOT NULL COMMENT '1: Publish, 2:draft,3:discard,0:pasive',
  `createdby` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `createdon` datetime(6) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tkategori
-- ----------------------------
DROP TABLE IF EXISTS `tkategori`;
CREATE TABLE `tkategori`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `NamaKategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tkategori
-- ----------------------------
INSERT INTO `tkategori` VALUES (1, 'Junior');
INSERT INTO `tkategori` VALUES (2, 'go back 2');

-- ----------------------------
-- Table structure for userrole
-- ----------------------------
DROP TABLE IF EXISTS `userrole`;
CREATE TABLE `userrole`  (
  `userid` int(11) NOT NULL,
  `roleid` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`userid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of userrole
-- ----------------------------
INSERT INTO `userrole` VALUES (14, 1);
INSERT INTO `userrole` VALUES (43, 2);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(75) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama` varchar(75) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `createdby` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `createdon` datetime(0) NOT NULL,
  `HakAkses` int(255) NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `verified` bit(1) NOT NULL,
  `ip` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `browser` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `RecordOwnerID` int(11) NOT NULL,
  `CompanyName` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CompanyAddress` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CompanyPhone` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `IPPublic` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Nations` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Provinsi` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Kota` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Kelurahan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Kecamatan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `KodePOS` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Location` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `HardwareID` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ImageProfile` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 46 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (14, 'admin', 'admin', 'a9bdd47d7321d4089b3b00561c9c621848bd6f6e2f745a53d54913d613789c23945b66de6ded1eb336a7d526f9349a9d964d6f6c3a40e2ac90b4b16c0121f7895Xg53McbkyQ/NmW60Sf4cu3wJsi/8cyZXxeXV7g6b04=', 'mnl', '0000-00-00 00:00:00', 1, '', b'1', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', NULL);
INSERT INTO `users` VALUES (43, 'operator', 'Operator', '216a8e9520609ef5d94daf2f606bd425ff68ba564f9340e3ced8216c114825998bca4566e0e26d21553848b0641d5f954932cf105c8b253c7f7260a53610e6b4AMc30ZoMECNLImxck8z7ONNigRNBdVWsWU+/Bv03HLY=', '', '2020-04-26 10:11:27', 0, '', b'0', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', NULL);
INSERT INTO `users` VALUES (44, 'adji142', '', '1691476a18aa7f470a9f8fc3eeb677c45b548b4b9d0cac12bc2d77c3ea6c8f4190f0a3cff8fc6b96dbd8e50dfaab57e7dd2a6806832bd1488b4cf5438d49fa92oi0g8vZcx31EfvWDBAe/7O6sGYV95W2jxbnwsDzFCzc=', '', '2020-05-07 10:07:59', 0, '', b'0', '', '', 'prasetyoajiw@gmail.com', '081325058258', 0, '', '', '', '', '', '', '', '', '', '', '', '', 'http://apps.siapaisa.com/storeimage/scaled_e43d864a-1024-4066-9ec8-d2c952a9f4fe5452118784484563293.jpg');
INSERT INTO `users` VALUES (45, 'bayu04', '', 'b8508f774492123c1401169515544a1affabb249b4b327bbf519c3db50e3026a3af97609b35b2df909e9ba6483706c1148d0eefc7634662eed220f83b43a207doXTp1Fc6pK7+SQEh703yCVjFfhJIdIlhM69Ug55EXw0=', '', '2020-06-02 05:08:44', 0, '', b'0', '', '', 'bayuchris@yahoo.com', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', NULL);

SET FOREIGN_KEY_CHECKS = 1;
