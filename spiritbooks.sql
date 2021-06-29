/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100406
 Source Host           : localhost:3306
 Source Schema         : spiritbooks

 Target Server Type    : MySQL
 Target Server Version : 100406
 File Encoding         : 65001

 Date: 29/06/2021 20:27:25
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for adjustmenthistory
-- ----------------------------
DROP TABLE IF EXISTS `adjustmenthistory`;
CREATE TABLE `adjustmenthistory`  (
  `NoTransaksi` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `TglTransaksi` date NOT NULL,
  `TglPencatatan` datetime(6) NOT NULL,
  `KodeUser` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `TypeAdjustment` int(1) NOT NULL COMMENT '1: IN, 2 :Out',
  `TotalAdjustment` double(16, 2) NOT NULL,
  `CreatedBy` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Createdon` datetime(6) NOT NULL,
  `Keterangan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`NoTransaksi`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of adjustmenthistory
-- ----------------------------

-- ----------------------------
-- Table structure for inbox
-- ----------------------------
DROP TABLE IF EXISTS `inbox`;
CREATE TABLE `inbox`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `DeviceID` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `MessageDate` datetime(0) NOT NULL,
  `Message` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Read` bit(1) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of inbox
-- ----------------------------

-- ----------------------------
-- Table structure for lastlocation
-- ----------------------------
DROP TABLE IF EXISTS `lastlocation`;
CREATE TABLE `lastlocation`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kodebuku` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `lastlocation` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lastlocation
-- ----------------------------

-- ----------------------------
-- Table structure for outbox
-- ----------------------------
DROP TABLE IF EXISTS `outbox`;
CREATE TABLE `outbox`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `DeviceID` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `MessageDate` datetime(0) NOT NULL,
  `Message` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Read` bit(1) NOT NULL,
  `ReplyBy` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of outbox
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

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
INSERT INTO `permission` VALUES (8, 'Daftar Media Pembayaran', 'Home/metodepembayaran', NULL, '7', b'1', b'0', 7, b'1', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (9, 'Daftar Penjualan Buku', 'Home/daftartransaksi', NULL, '7', b'1', b'0', 8, b'1', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (10, 'Laporan', NULL, 'fa-bar-chart-o', '0', b'1', b'0', 9, b'1', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (11, 'Laporan Penjualan', 'Home/rptPenjualan', NULL, '10', b'1', b'0', 10, b'1', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (12, 'Laporan Uang Masuk', NULL, NULL, '10', b'1', b'0', 11, b'0', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (13, 'Saldo Akun', 'Home/saldoperaccount', NULL, '7', b'1', b'0', 12, b'1', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (14, 'Daftar Pembayaran Top Up', 'Home/pembayaran', NULL, '7', b'1', b'0', 13, b'1', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (15, 'Help Desk', 'Home/chat', 'fa-phone', '0', b'0', b'0', 14, b'1', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (16, 'Promo', NULL, 'fa-dollar', '0', b'0', b'0', 15, b'0', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (17, 'Tools', NULL, 'fa-cogs', '0', b'1', b'0', 16, b'1', NULL, NULL, NULL);
INSERT INTO `permission` VALUES (18, 'Test Send email', 'Home/testEmail', NULL, '17', b'1', b'0', 17, b'1', NULL, NULL, NULL);

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
INSERT INTO `permissionrole` VALUES (1, 13);
INSERT INTO `permissionrole` VALUES (1, 14);
INSERT INTO `permissionrole` VALUES (1, 15);
INSERT INTO `permissionrole` VALUES (1, 16);
INSERT INTO `permissionrole` VALUES (2, 13);
INSERT INTO `permissionrole` VALUES (2, 14);
INSERT INTO `permissionrole` VALUES (2, 15);
INSERT INTO `permissionrole` VALUES (2, 16);
INSERT INTO `permissionrole` VALUES (1, 17);
INSERT INTO `permissionrole` VALUES (1, 18);
INSERT INTO `permissionrole` VALUES (2, 17);
INSERT INTO `permissionrole` VALUES (2, 18);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rolename` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'SuperAdmin');
INSERT INTO `roles` VALUES (2, 'Admin');
INSERT INTO `roles` VALUES (3, 'Publisher');
INSERT INTO `roles` VALUES (4, 'User');
INSERT INTO `roles` VALUES (5, 'Manager');

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
  `releasedate` date NOT NULL,
  `releaseperiod` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `picture` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `picture_base64` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `harga` double(19, 2) NOT NULL,
  `ppn` double(19, 2) NOT NULL,
  `otherprice` double(10, 2) NOT NULL,
  `epub` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `epub_full` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `avgrate` double(10, 2) NOT NULL DEFAULT 0,
  `status_publikasi` int(255) NOT NULL COMMENT '1: Publish, 2:draft,3:discard,0:pasive',
  `createdby` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `createdon` datetime(6) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbuku
-- ----------------------------
INSERT INTO `tbuku` VALUES (2, '100001', 1, 'PENCARIAN', 'Test Input', '2021-05-01', '202105', 'http://192.168.1.66/spiritweb/localData/image/100001.PNG', 'data:image/jpeg;base64,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', 9000.00, 0.00, 0.00, 'http://192.168.1.66/spiritweb/localData/epub/100001.epub', 'https://project.aiscoder.com/spiritweb/localData/epub/100001_pub.epub', 0.00, 1, 'admin', '2021-06-28 09:05:29.000000');
INSERT INTO `tbuku` VALUES (3, '100002', 5, 'AKTIVITAS', 'AKTIVITAS', '2021-06-01', '202106', 'http://192.168.1.66/spiritweb/localData/image/100002.png', 'data:image/png;base64,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', 9000.00, 0.00, 0.00, 'http://192.168.1.66/spiritweb/localData/epub/100002.epub', 'http://192.168.1.66/spiritweb/localData/epub/100002_pub.epub', 0.00, 1, 'admin', '2021-06-29 07:18:35.000000');

-- ----------------------------
-- Table structure for temailsetting
-- ----------------------------
DROP TABLE IF EXISTS `temailsetting`;
CREATE TABLE `temailsetting`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `protocol` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `smtp_host` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `smtp_port` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `smtp_user` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `smtp_pass` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `smtp_crypto` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `mailtype` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `smtp_timeout` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `charset` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `wordwrap` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `emailAdminReciept` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `AliasName` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of temailsetting
-- ----------------------------
INSERT INTO `temailsetting` VALUES (1, 'smtp', 'mail.aiscoder.com', '465', 'noreply@aiscoder.com', 'lagis3nt0s4', 'ssl', 'html', '4', 'iso-8859-1', 'TRUE', 'adjia7x@gmail.com', 'Spirit Booksfield');
INSERT INTO `temailsetting` VALUES (2, 'smtp', 'smtp.gmail.com', '465', 'aissystemsolo@gmail.com', 'eijugplezooyxzeo', 'ssl', 'html', '4', 'iso-8859-1', 'TRUE', 'adjia7x@gmail.com', 'Spirit Booksfield');

-- ----------------------------
-- Table structure for testcron
-- ----------------------------
DROP TABLE IF EXISTS `testcron`;
CREATE TABLE `testcron`  (
  `tanggal` datetime(0) NOT NULL
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of testcron
-- ----------------------------

-- ----------------------------
-- Table structure for thistoryrequest
-- ----------------------------
DROP TABLE IF EXISTS `thistoryrequest`;
CREATE TABLE `thistoryrequest`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `NoTransaksi` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `TglTransaksi` datetime(0) NOT NULL,
  `TokenMidtrans` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `userid` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `GrossAmt` double(16, 2) NOT NULL,
  `Adminfee` double(16, 2) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of thistoryrequest
-- ----------------------------
INSERT INTO `thistoryrequest` VALUES (1, '202106444142793e16159b7', '0000-00-00 00:00:00', '04fd661b-66ad-4bed-8dc8-cc7accaff1a4', 'aistest', 50000.00, 0.00);
INSERT INTO `thistoryrequest` VALUES (2, '2021061164981476c1fdf3f5', '0000-00-00 00:00:00', '497791d1-ab74-4813-aafe-6df5c84f72c2', 'aistest', 75000.00, 4000.00);

-- ----------------------------
-- Table structure for tkategori
-- ----------------------------
DROP TABLE IF EXISTS `tkategori`;
CREATE TABLE `tkategori`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `NamaKategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ShowHomePage` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tkategori
-- ----------------------------
INSERT INTO `tkategori` VALUES (1, 'SPIRIT', 1);
INSERT INTO `tkategori` VALUES (2, 'MOTIVATOR', 0);
INSERT INTO `tkategori` VALUES (3, 'NEXT', 0);
INSERT INTO `tkategori` VALUES (4, 'JUNIOR', 0);
INSERT INTO `tkategori` VALUES (5, 'AKTIVITAS', 1);
INSERT INTO `tkategori` VALUES (7, 'buku2', 1);

-- ----------------------------
-- Table structure for topuppayment
-- ----------------------------
DROP TABLE IF EXISTS `topuppayment`;
CREATE TABLE `topuppayment`  (
  `NoTransaksi` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `TglTransaksi` datetime(6) NOT NULL,
  `TglPencatatan` datetime(6) NOT NULL,
  `MetodePembayaran` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `GrossAmt` double(16, 2) NOT NULL,
  `AdminFee` double(16, 2) NOT NULL,
  `Mid_PaymentType` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Mid_TransactionID` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Mid_MechantID` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Mid_Bank` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Mid_VANumber` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Mid_SignatureKey` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Mid_TransactionStatus` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Mid_FraudStatus` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Read` int(1) NOT NULL DEFAULT 0,
  `Attachment` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`NoTransaksi`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of topuppayment
-- ----------------------------
INSERT INTO `topuppayment` VALUES ('2021061164981476c1fdf3f5', '2021-06-28 22:16:17.000000', '2021-06-28 10:18:36.000000', 'AUTO', 79000.00, 0.00, 'bank_transfer', 'a4e3888a-9b00-481d-a45a-cd4d07ed0cc6', 'G799701428', 'bca', '01428819462', 'b2062c1710e4808091cb7a87f73e7a9e189af7f08fc6a337fdefd52d1c6fc40b6a3cc6f76c0f89a8ef6283a97ba5f66374e8763cca512168ea7e0c762b4a74d3', 'settlement', 'accept', 0, NULL);
INSERT INTO `topuppayment` VALUES ('202106444142793e16159b7', '2021-06-28 22:14:28.535449', '2021-06-28 22:14:28.535503', 'MANUAL', 50000.00, 79.00, '', '', '', '', '', '', 'Pending', '', 0, NULL);

-- ----------------------------
-- Table structure for tpaymentmethod
-- ----------------------------
DROP TABLE IF EXISTS `tpaymentmethod`;
CREATE TABLE `tpaymentmethod`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `NamaMedia` varchar(115) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `BiayaAdmin` double(16, 2) NOT NULL DEFAULT 0,
  `Active` int(1) NOT NULL COMMENT '1: aktif, 0 : tidakaktif',
  `JenisVerifikasi` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `NomorAkunPembayaran` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `NamaPemilikAkun` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `PersenBiayaAdmin` double(16, 2) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tpaymentmethod
-- ----------------------------
INSERT INTO `tpaymentmethod` VALUES (1, 'Manual Transfer', 0.00, 1, 'MANUAL', '123', '123', 0.00);
INSERT INTO `tpaymentmethod` VALUES (2, 'Transfer verifikasi Otomatis', 4000.00, 1, 'AUTO', '-', '-', 0.00);
INSERT INTO `tpaymentmethod` VALUES (3, 'GoPay', 0.00, 1, 'AUTO', '-', '-', 1.50);
INSERT INTO `tpaymentmethod` VALUES (4, 'QRIS', 0.00, 1, 'QRCODE', '-', '-', 0.75);

-- ----------------------------
-- Table structure for tpushemail
-- ----------------------------
DROP TABLE IF EXISTS `tpushemail`;
CREATE TABLE `tpushemail`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reqTime` datetime(6) NOT NULL,
  `NotificationType` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `BaseRef` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ReceipedEmail` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CreatedOn` datetime(6) NOT NULL,
  `Status` int(1) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tpushemail
-- ----------------------------
INSERT INTO `tpushemail` VALUES (1, '2021-06-28 10:14:30.000000', 'payment', '202106444142793e16159b7', 'prasetyoajiw@gmai.com', '2021-06-28 10:14:30.000000', 1);
INSERT INTO `tpushemail` VALUES (2, '2021-06-28 10:14:30.000000', 'notification', '202106444142793e16159b7', '', '2021-06-28 10:14:30.000000', 1);
INSERT INTO `tpushemail` VALUES (3, '2021-06-28 10:16:07.000000', 'payment', '2021061164981476c1fdf3f5', 'prasetyoajiw@gmai.com', '2021-06-28 10:16:07.000000', 1);
INSERT INTO `tpushemail` VALUES (4, '2021-06-28 10:16:07.000000', 'notification', '2021061164981476c1fdf3f5', '', '2021-06-28 10:16:07.000000', 1);

-- ----------------------------
-- Table structure for transaksi
-- ----------------------------
DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE `transaksi`  (
  `NoTransaksi` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `TglTransaksi` date NOT NULL,
  `TglPencatatan` datetime(6) NOT NULL,
  `KodeItem` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Qty` int(11) NOT NULL,
  `Harga` double(16, 2) NOT NULL,
  `StatusTransaksi` int(255) NOT NULL COMMENT '1: Berhasil, 2 : Pending, 3: Gagal, 4:Return, 99: Delete',
  `UserID` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`NoTransaksi`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of transaksi
-- ----------------------------
INSERT INTO `transaksi` VALUES ('202106001', '2021-06-28', '2021-06-28 10:20:34.000000', '100001', 1, 9000.00, 1, 'aistest');

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
INSERT INTO `userrole` VALUES (14, 2);
INSERT INTO `userrole` VALUES (43, 2);
INSERT INTO `userrole` VALUES (46, 4);
INSERT INTO `userrole` VALUES (47, 4);

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
) ENGINE = InnoDB AUTO_INCREMENT = 48 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (14, 'admin', 'admin', 'a9bdd47d7321d4089b3b00561c9c621848bd6f6e2f745a53d54913d613789c23945b66de6ded1eb336a7d526f9349a9d964d6f6c3a40e2ac90b4b16c0121f7895Xg53McbkyQ/NmW60Sf4cu3wJsi/8cyZXxeXV7g6b04=', 'mnl', '0000-00-00 00:00:00', 1, '', b'1', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', NULL);
INSERT INTO `users` VALUES (43, 'operator', 'Operator', '216a8e9520609ef5d94daf2f606bd425ff68ba564f9340e3ced8216c114825998bca4566e0e26d21553848b0641d5f954932cf105c8b253c7f7260a53610e6b4AMc30ZoMECNLImxck8z7ONNigRNBdVWsWU+/Bv03HLY=', '', '2020-04-26 10:11:27', 0, '', b'0', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', NULL);
INSERT INTO `users` VALUES (44, 'adji142', '', '78c4f6748deaafb5cff2af5557d81a5f95a196c61dd6917accce6dc9a38ae47026ebfbea291f4f92fc470872570cb1a14eb30c5d9da96e6c5ce62924566c8757BvknbOApqoDdkjeDb0+WMIn/i9qpjhMmD/IGLHGpCyI=', '', '2020-05-07 10:07:59', 0, '', b'0', '', '', 'adjia7x@gmail.com', '081325058258', 0, '', '', '', '', '', '', '', '', '', '', '', '', 'http://apps.siapaisa.com/storeimage/scaled_e43d864a-1024-4066-9ec8-d2c952a9f4fe5452118784484563293.jpg');
INSERT INTO `users` VALUES (45, 'bayu04', '', 'b8508f774492123c1401169515544a1affabb249b4b327bbf519c3db50e3026a3af97609b35b2df909e9ba6483706c1148d0eefc7634662eed220f83b43a207doXTp1Fc6pK7+SQEh703yCVjFfhJIdIlhM69Ug55EXw0=', '', '2020-06-02 05:08:44', 0, '', b'0', '', '', 'bayuchris@yahoo.com', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', NULL);
INSERT INTO `users` VALUES (46, 'aistest', '', '078131d65d5fac27e89982ccda29a69cea3b1fbc9b8c450e4481bb928d658d1654796bd05c28673de1c5cbdac56d19d29ef15cf7427aa0aa0b1b587fd757768bJrzc0Si83KxSdDgfkCd6Ln+Y2+WPNVeBKbvP3cqGrpo=', '', '2021-05-31 11:05:16', 0, '', b'0', '', '', 'prasetyoajiw@gmai.com', '08132508258', 0, '', '', '', '', '', '', '', '', '', '', '', '', NULL);
INSERT INTO `users` VALUES (47, 'tes', '', '1416fed18baa90cd771c802e6e1eda7043edd41c2561e0d1986d42fd96d781d5ddbfe0cbef8ff1d15f0987485d8652bf92fdc509df371d50e0c0d49264535b47n8m5XU69owkJybpjXG1ryr0sIPt89XogOIE3/KXdDlo=', '', '2021-06-17 02:33:12', 0, '', b'0', '', 'ASUS_X00TD - WW_X00TD', 'tes@kkkk', '098765454', 0, '', '', '', '', '', '', '', '', '', '', '', '03acb642da15b692', NULL);

-- ----------------------------
-- Procedure structure for getNewRelease
-- ----------------------------
DROP PROCEDURE IF EXISTS `getNewRelease`;
delimiter ;;
CREATE PROCEDURE `getNewRelease`()
BEGIN
	SELECT 
		a.id,a.KodeItem,a.kategoriID,a.judul,a.description,a.releasedate,
		a.releaseperiod,a.picture,a.harga,a.ppn,a.otherprice,a.epub,
		a.avgrate,a.status_publikasi, b.NamaKategori, COALESCE(c.Qty,0) JmlPembelian
	FROM tbuku a
	LEFT JOIN tkategori b on a.kategoriID = b.id
	LEFT JOIN (
		SELECT x.KodeItem, SUM(x.Qty) Qty FROM transaksi x
		WHERE DATE_FORMAT(x.TglTransaksi,'%Y%m') = DATE_FORMAT(NOW(),'%Y%m')
		GROUP BY x.Qty
	) c on a.KodeItem = c.KodeItem
	WHERE a.status_publikasi = 1 ORDER BY a.releasedate DESC LIMIT 20;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for getPaymentDetails
-- ----------------------------
DROP PROCEDURE IF EXISTS `getPaymentDetails`;
delimiter ;;
CREATE PROCEDURE `getPaymentDetails`(IN `TglAwal` DATE, IN `TglAkhir` DATE, IN `PaymentType` VARCHAR(55), `NoTransaksi` VARCHAR(55))
BEGIN
	SELECT 
		a.NoTransaksi,
		a.TglTransaksi,
		a.MetodePembayaran,
		a.GrossAmt,
		CASE WHEN COALESCE(a.AdminFee,0) = 0 THEN COALESCE(b.Adminfee,0) ELSE a.AdminFee END AdminFee,
		a.GrossAmt + CASE WHEN COALESCE(a.AdminFee,0) = 0 THEN COALESCE(b.Adminfee,0) ELSE a.AdminFee END TotalPembelian,
		a.Mid_Bank,
		a.Mid_VANumber,
		a.Mid_TransactionStatus,
		a.Attachment,
		b.userid,
		c.HardwareID,
		c.email,
		c.phone
	FROM topuppayment a
	INNER JOIN thistoryrequest b on a.NoTransaksi = b.NoTransaksi
	LEFT JOIN users c on b.userid = c.username
	WHERE CAST(a.TglTransaksi AS DATE ) BETWEEN TglAwal AND TglAkhir
	AND (COALESCE(a.MetodePembayaran,'') = PaymentType OR PaymentType = '')
	AND (a.NoTransaksi = NoTransaksi OR NoTransaksi = '')
	ORDER BY a.TglTransaksi DESC;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for getPaymentDetails_Auto
-- ----------------------------
DROP PROCEDURE IF EXISTS `getPaymentDetails_Auto`;
delimiter ;;
CREATE PROCEDURE `getPaymentDetails_Auto`(IN `TglAwal` DATE, IN `TglAkhir` DATE)
BEGIN
	SELECT 
		a.NoTransaksi,
		a.TglTransaksi,
		a.MetodePembayaran,
		a.GrossAmt,
		CASE WHEN COALESCE(a.AdminFee,0) = 0 THEN COALESCE(b.Adminfee,0) ELSE a.AdminFee END AdminFee,
		a.GrossAmt - CASE WHEN COALESCE(a.AdminFee,0) = 0 THEN COALESCE(b.Adminfee,0) ELSE a.AdminFee END TotalPembelian,
		a.Mid_Bank,
		a.Mid_VANumber,
		a.Mid_TransactionStatus,
		a.Attachment,
		b.userid,
		c.HardwareID,
		c.email,
		c.phone
	FROM topuppayment a
	INNER JOIN thistoryrequest b on a.NoTransaksi = b.NoTransaksi
	LEFT JOIN users c on b.userid = c.username
	WHERE CAST(a.TglTransaksi AS DATE ) BETWEEN TglAwal AND TglAkhir
	AND COALESCE(a.MetodePembayaran,'') IN ('AUTO','gopay')
	ORDER BY a.TglTransaksi DESC;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for getSaldoUser
-- ----------------------------
DROP PROCEDURE IF EXISTS `getSaldoUser`;
delimiter ;;
CREATE PROCEDURE `getSaldoUser`(IN `UserID` VARCHAR(55))
BEGIN
	SELECT 
		A.username,
		COALESCE(B.TopUp,0) TopUp,
		COALESCE(B.Pembelian,0) PembelianBuku,
		COALESCE(B.Adjustment,0) Adjustment,
		COALESCE(B.AdjPlus,0) AdjPlus,
		COALESCE(B.AdjMin,0) AdjMin,
		COALESCE(B.SaldoAkhir,0)  Saldo
	FROM users A
	LEFT JOIN (
		SELECT 
			Sld.userid,
			SUM(Sld.TopUp) TopUp,
			SUM(Sld.Pembelian) Pembelian,
			SUM(Sld.Adjustment) Adjustment,
			SUM(Sld.TopUp) -  SUM(Sld.Pembelian) + SUM(Sld.Adjustment) SaldoAkhir,
			SUM(Sld.AdjPlus) AdjPlus,
			SUM(Sld.AdjMin) AdjMin
		FROM (
			SELECT 
				b.userid,
				SUM(COALESCE(a.GrossAmt,0) - COALESCE(b.Adminfee,0)) TopUp,
				0 Pembelian,
				0 Adjustment,
				0 AdjPlus,
				0 AdjMin
			FROM topuppayment a
			INNER JOIN thistoryrequest b on a.NoTransaksi = b.NoTransaksi
            WHERE a.Mid_TransactionStatus = 'settlement'
			GROUP BY b.userid

			UNION ALL
			SELECT 
				x.UserID,
				0, 
				SUM(COALESCE(x.Qty,0) * COALESCE(x.Harga,0)) Pembelian,
				0,0,0
			FROM transaksi x where x.StatusTransaksi IN(1,99)
			GROUP BY x.UserID
				
			UNION ALL

			SELECT 
				y.KodeUser,
				0,0,
				SUM(CASE WHEN COALESCE(y.TypeAdjustment,0) = 1 THEN COALESCE(y.TotalAdjustment ,0)ELSE COALESCE(y.TotalAdjustment,0) * -1 END ) Adj,
				SUM(CASE WHEN COALESCE(y.TypeAdjustment,0) = 1 THEN COALESCE(y.TotalAdjustment ,0)ELSE 0 END ) Adjplus,
				SUM(CASE WHEN COALESCE(y.TypeAdjustment,0) = 2 THEN COALESCE(y.TotalAdjustment ,0)ELSE 0 END ) AdjMin
			FROM adjustmenthistory y
			GROUP BY y.KodeUser
		) Sld
		GROUP BY Sld.userid
	) B ON A.username = B.userid
	WHERE (A.username = UserID OR UserID = '');
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for getTopSeller
-- ----------------------------
DROP PROCEDURE IF EXISTS `getTopSeller`;
delimiter ;;
CREATE PROCEDURE `getTopSeller`()
BEGIN
	SELECT 
		a.id,a.KodeItem,a.kategoriID,a.judul,a.description,a.releasedate,
		a.releaseperiod,a.picture,a.harga,a.ppn,a.otherprice,a.epub,
		a.avgrate,a.status_publikasi, b.NamaKategori, COALESCE(c.Qty,0) JmlPembelian
	FROM tbuku a
	LEFT JOIN tkategori b on a.kategoriID = b.id
	LEFT JOIN (
		SELECT x.KodeItem, SUM(x.Qty) Qty FROM transaksi x
		WHERE DATE_FORMAT(x.TglTransaksi,'%Y%m') = DATE_FORMAT(NOW(),'%Y%m')
		GROUP BY x.Qty
	) c on a.KodeItem = c.KodeItem
	WHERE COALESCE(c.Qty,0) > 0 ORDER BY COALESCE(c.Qty,0) DESC;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for getTransaksi
-- ----------------------------
DROP PROCEDURE IF EXISTS `getTransaksi`;
delimiter ;;
CREATE PROCEDURE `getTransaksi`(IN `TglAwal` DATE, IN `TglAkhir` DATE)
BEGIN
	SELECT 
		a.NoTransaksi, 
		a.TglTransaksi,
		a.KodeItem, 
		b.judul,
		c.NamaKategori,
		a.Qty,
		a.Harga,
		CASE WHEN a.StatusTransaksi = 1 THEN 'BERHASIL' ELSE 
			CASE WHEN a.StatusTransaksi = 2 THEN 'TERTUNDA' ELSE  
				CASE WHEN a.StatusTransaksi = 3 THEN 'GAGAL' ELSE 
					CASE WHEN a.StatusTransaksi = 4 THEN 'RETUR' ELSE 
						CASE WHEN a.StatusTransaksi = 99 THEN 'TIDAK ADA AKSES' ELSE 
							''
						END
					END
				END
			END
		END StatusTransaksi,
		a.UserID,
		d.email,
		d.HardwareID,
		d.phone,
		CONCAT('EDISI ',LEFT(b.releaseperiod,4),'-', RIGHT(b.releaseperiod,2)) Period
	FROM transaksi a 
	LEFT JOIN tbuku b on a.KodeItem = b.KodeItem
	LEFT JOIN tkategori c on b.kategoriID = c.id
	LEFT JOIN users d on a.UserID = d.username
	WHERE CAST(a.TglTransaksi AS DATE) BETWEEN TglAwal AND TglAkhir;
END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
