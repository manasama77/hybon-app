/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 80100 (8.1.0)
 Source Host           : localhost:3306
 Source Schema         : app_carbon

 Target Server Type    : MySQL
 Target Server Version : 80100 (8.1.0)
 File Encoding         : 65001

 Date: 29/01/2024 18:16:16
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for barang_jadis
-- ----------------------------
DROP TABLE IF EXISTS `barang_jadis`;
CREATE TABLE `barang_jadis`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_jual` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of barang_jadis
-- ----------------------------
INSERT INTO `barang_jadis` VALUES (1, 'SPAKBOARD MIO', 2000000, '2024-01-29 17:57:26', '2024-01-29 17:57:26', NULL);

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for manufacture_materials
-- ----------------------------
DROP TABLE IF EXISTS `manufacture_materials`;
CREATE TABLE `manufacture_materials`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `sales_order_id` bigint UNSIGNED NOT NULL,
  `stock_monitor_id` bigint UNSIGNED NOT NULL,
  `metode` enum('lembar','satuan') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int NOT NULL,
  `panjang` decimal(8, 2) NOT NULL DEFAULT 0.00,
  `lebar` decimal(8, 2) NOT NULL DEFAULT 0.00,
  `price` decimal(10, 2) NOT NULL,
  `notes` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phase_seq` enum('1','2','3','cutting','infuse','finishing 1','finishing 2','finishing 3') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `revisi_seq` int NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `manufacture_materials_sales_order_id_foreign`(`sales_order_id` ASC) USING BTREE,
  INDEX `manufacture_materials_stock_monitor_id_foreign`(`stock_monitor_id` ASC) USING BTREE,
  CONSTRAINT `manufacture_materials_sales_order_id_foreign` FOREIGN KEY (`sales_order_id`) REFERENCES `sales_orders` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `manufacture_materials_stock_monitor_id_foreign` FOREIGN KEY (`stock_monitor_id`) REFERENCES `stock_monitors` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of manufacture_materials
-- ----------------------------
INSERT INTO `manufacture_materials` VALUES (1, 1, 1, 'lembar', 0, 100.00, 50.00, 1000000.00, 'New', 'cutting', 0, '2024-01-29 18:00:11', '2024-01-29 18:00:11', NULL, 1, 1, NULL);
INSERT INTO `manufacture_materials` VALUES (2, 1, 2, 'lembar', 1, 0.00, 0.00, 1000.00, 'New', 'infuse', 0, '2024-01-29 18:03:41', '2024-01-29 18:03:41', NULL, 1, 1, NULL);
INSERT INTO `manufacture_materials` VALUES (3, 1, 2, 'lembar', 1, 0.00, 0.00, 1000.00, 'New', 'finishing 1', 0, '2024-01-29 18:08:16', '2024-01-29 18:08:16', NULL, 1, 1, NULL);

-- ----------------------------
-- Table structure for master_barangs
-- ----------------------------
DROP TABLE IF EXISTS `master_barangs`;
CREATE TABLE `master_barangs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe_barang_id` bigint UNSIGNED NOT NULL,
  `nama_vendor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe_stock` enum('satuan','lembar') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `master_barangs_tipe_barang_id_foreign`(`tipe_barang_id` ASC) USING BTREE,
  CONSTRAINT `master_barangs_tipe_barang_id_foreign` FOREIGN KEY (`tipe_barang_id`) REFERENCES `tipe_barangs` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of master_barangs
-- ----------------------------
INSERT INTO `master_barangs` VALUES (1, 'CARB', 'CARBON BATIK', 1, 'test vendor', 'lembar', 'cm²', '2024-01-29 17:57:26', '2024-01-29 17:57:26', NULL, 1, 1, NULL);
INSERT INTO `master_barangs` VALUES (2, 'KUAS', 'KUAS', 2, 'test vendor', 'satuan', 'pcs', '2024-01-29 17:57:26', '2024-01-29 17:57:26', NULL, 1, 1, NULL);

-- ----------------------------
-- Table structure for metode_moldings
-- ----------------------------
DROP TABLE IF EXISTS `metode_moldings`;
CREATE TABLE `metode_moldings`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of metode_moldings
-- ----------------------------
INSERT INTO `metode_moldings` VALUES (1, 'Metode Molding A', '2024-01-29 17:57:26', '2024-01-29 17:57:26', NULL);
INSERT INTO `metode_moldings` VALUES (2, 'Metode Molding B', '2024-01-29 17:57:26', '2024-01-29 17:57:26', NULL);
INSERT INTO `metode_moldings` VALUES (3, 'Metode Molding C', '2024-01-29 17:57:26', '2024-01-29 17:57:26', NULL);

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 267 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (248, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (249, '2014_10_12_100000_create_password_reset_tokens_table', 1);
INSERT INTO `migrations` VALUES (250, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (251, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (252, '2024_01_15_140426_create_barang_jadis_table', 1);
INSERT INTO `migrations` VALUES (253, '2024_01_15_140427_create_motifs_table', 1);
INSERT INTO `migrations` VALUES (254, '2024_01_15_164011_create_order_froms_table', 1);
INSERT INTO `migrations` VALUES (255, '2024_01_15_165221_create_tipe_barangs_table', 1);
INSERT INTO `migrations` VALUES (256, '2024_01_15_171138_create_master_barangs_table', 1);
INSERT INTO `migrations` VALUES (257, '2024_01_15_172004_create_stock_monitors_table', 1);
INSERT INTO `migrations` VALUES (258, '2024_01_15_172005_create_stocks_table', 1);
INSERT INTO `migrations` VALUES (259, '2024_01_15_172711_create_stock_seqs_table', 1);
INSERT INTO `migrations` VALUES (260, '2024_01_18_173213_create_metode_moldings_table', 1);
INSERT INTO `migrations` VALUES (261, '2024_01_18_180224_create_sub_moldings_table', 1);
INSERT INTO `migrations` VALUES (262, '2024_01_18_211951_create_sales_orders_table', 1);
INSERT INTO `migrations` VALUES (263, '2024_01_18_211952_create_sales_order_seqs_table', 1);
INSERT INTO `migrations` VALUES (264, '2024_01_18_211953_create_pure_status_logs_table', 1);
INSERT INTO `migrations` VALUES (265, '2024_01_20_224431_create_manufacture_materials_table', 1);
INSERT INTO `migrations` VALUES (266, '2024_01_25_031552_create_tracking_logs_table', 1);

-- ----------------------------
-- Table structure for motifs
-- ----------------------------
DROP TABLE IF EXISTS `motifs`;
CREATE TABLE `motifs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of motifs
-- ----------------------------
INSERT INTO `motifs` VALUES (1, 'BATIK', '2024-01-29 17:57:26', '2024-01-29 17:57:26', NULL);
INSERT INTO `motifs` VALUES (2, 'TRIBAL', '2024-01-29 17:57:26', '2024-01-29 17:57:26', NULL);
INSERT INTO `motifs` VALUES (3, 'HEXAGON', '2024-01-29 17:57:26', '2024-01-29 17:57:26', NULL);

-- ----------------------------
-- Table structure for order_froms
-- ----------------------------
DROP TABLE IF EXISTS `order_froms`;
CREATE TABLE `order_froms`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of order_froms
-- ----------------------------
INSERT INTO `order_froms` VALUES (1, 'TIKTOK', '2024-01-29 17:57:26', '2024-01-29 17:57:26', NULL);
INSERT INTO `order_froms` VALUES (2, 'SHOPEE', '2024-01-29 17:57:26', '2024-01-29 17:57:26', NULL);
INSERT INTO `order_froms` VALUES (3, 'TOKPED', '2024-01-29 17:57:26', '2024-01-29 17:57:26', NULL);

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token` ASC) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type` ASC, `tokenable_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for pure_status_logs
-- ----------------------------
DROP TABLE IF EXISTS `pure_status_logs`;
CREATE TABLE `pure_status_logs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `sales_order_id` bigint UNSIGNED NOT NULL,
  `notes` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pure_status_logs
-- ----------------------------
INSERT INTO `pure_status_logs` VALUES (1, 1, 'test', '2024-01-29 17:58:00', '2024-01-29 17:58:00', NULL, 1, 1, NULL);

-- ----------------------------
-- Table structure for sales_order_seqs
-- ----------------------------
DROP TABLE IF EXISTS `sales_order_seqs`;
CREATE TABLE `sales_order_seqs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `seq` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sales_order_seqs
-- ----------------------------
INSERT INTO `sales_order_seqs` VALUES (1, 2, '2024-01-29 17:57:26', '2024-01-29 17:57:26');

-- ----------------------------
-- Table structure for sales_orders
-- ----------------------------
DROP TABLE IF EXISTS `sales_orders`;
CREATE TABLE `sales_orders`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code_order` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `motif_id` bigint UNSIGNED NOT NULL,
  `metode` enum('pure','skinning') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dp` int NOT NULL DEFAULT 0,
  `harga_jual` int NOT NULL DEFAULT 0,
  `barang_jadi_id` bigint UNSIGNED NULL DEFAULT NULL,
  `nama_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_from_id` bigint UNSIGNED NOT NULL,
  `status` enum('sales order','product design','manufacturing 1','manufacturing 2','manufacturing 3','manufacturing cutting','manufacturing infuse','finishing 1','finishing 2','finishing 3','rfs') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `sub_molding_id` bigint UNSIGNED NULL DEFAULT NULL,
  `cost_molding_pure` int NULL DEFAULT NULL,
  `panjang_skinning` decimal(10, 2) NULL DEFAULT 0.00,
  `lebar_skinning` decimal(10, 2) NULL DEFAULT 0.00,
  `harga_material_skinning` decimal(10, 2) NULL DEFAULT 0.00,
  `stock_monitor_id` bigint UNSIGNED NULL DEFAULT NULL,
  `photo_manufacturing_1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `revisi_manufacturing_1` int NOT NULL DEFAULT 0,
  `photo_manufacturing_2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `revisi_manufacturing_2` int NOT NULL DEFAULT 0,
  `photo_manufacturing_3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `revisi_manufacturing_3` int NOT NULL DEFAULT 0,
  `photo_manufacturing_cutting` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `revisi_manufacturing_cutting` int NOT NULL DEFAULT 0,
  `photo_manufacturing_infuse` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `revisi_manufacturing_infuse` int NOT NULL DEFAULT 0,
  `photo_finishing_1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `revisi_finishing_1` int NOT NULL DEFAULT 0,
  `photo_finishing_2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `revisi_finishing_2` int NOT NULL DEFAULT 0,
  `photo_finishing_3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `revisi_finishing_3` int NOT NULL DEFAULT 0,
  `is_lunas` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sales_orders_motif_id_foreign`(`motif_id` ASC) USING BTREE,
  INDEX `sales_orders_barang_jadi_id_foreign`(`barang_jadi_id` ASC) USING BTREE,
  INDEX `sales_orders_order_from_id_foreign`(`order_from_id` ASC) USING BTREE,
  INDEX `sales_orders_sub_molding_id_foreign`(`sub_molding_id` ASC) USING BTREE,
  INDEX `sales_orders_stock_monitor_id_foreign`(`stock_monitor_id` ASC) USING BTREE,
  CONSTRAINT `sales_orders_barang_jadi_id_foreign` FOREIGN KEY (`barang_jadi_id`) REFERENCES `barang_jadis` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `sales_orders_motif_id_foreign` FOREIGN KEY (`motif_id`) REFERENCES `motifs` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `sales_orders_order_from_id_foreign` FOREIGN KEY (`order_from_id`) REFERENCES `order_froms` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `sales_orders_stock_monitor_id_foreign` FOREIGN KEY (`stock_monitor_id`) REFERENCES `stock_monitors` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `sales_orders_sub_molding_id_foreign` FOREIGN KEY (`sub_molding_id`) REFERENCES `sub_moldings` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sales_orders
-- ----------------------------
INSERT INTO `sales_orders` VALUES (1, '202401290001', 'TEST ORDER PURE', 1, 'pure', 0, 1000000, NULL, 'TEST CUSTOMER 1', 'TEST', '082114578976', 2, 'rfs', 'test', 1, 100000, 0.00, 0.00, 0.00, NULL, NULL, 0, NULL, 0, NULL, 0, '1-manufacturing-cutting.jpg', 1, '1-manufacturing-infuse.jpg', 1, '1-finishing-1.jpg', 1, '1-finishing-2.jpg', 1, '1-finishing-3.jpg', 1, 0, '2024-01-29 17:57:26', '2024-01-29 18:10:17', NULL, 1, 1, NULL);
INSERT INTO `sales_orders` VALUES (2, '202401290002', 'TEST ORDER SKINNING', 3, 'skinning', 0, 1000000, NULL, 'TEST CUSTOMER 2', 'TEST', '082114578976', 1, 'sales order', NULL, NULL, NULL, 0.00, 0.00, 0.00, NULL, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0, 0, '2024-01-29 17:57:26', '2024-01-29 17:57:26', NULL, 1, 1, NULL);

-- ----------------------------
-- Table structure for stock_monitors
-- ----------------------------
DROP TABLE IF EXISTS `stock_monitors`;
CREATE TABLE `stock_monitors`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `master_barang_id` bigint UNSIGNED NOT NULL,
  `tipe_stock` enum('satuan','lembar') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `panjang` decimal(10, 2) NOT NULL DEFAULT 0.00,
  `lebar` decimal(10, 2) NOT NULL DEFAULT 0.00,
  `qty` decimal(8, 2) NOT NULL DEFAULT 0.00,
  `harga_jual` decimal(10, 2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `stock_monitors_master_barang_id_foreign`(`master_barang_id` ASC) USING BTREE,
  CONSTRAINT `stock_monitors_master_barang_id_foreign` FOREIGN KEY (`master_barang_id`) REFERENCES `master_barangs` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of stock_monitors
-- ----------------------------
INSERT INTO `stock_monitors` VALUES (1, 'CARB-20240129-1-0', 1, 'lembar', 0.00, 0.00, 0.00, 1000000.00, '2024-01-29 17:57:26', '2024-01-29 18:00:11', NULL, 1, 1, NULL);
INSERT INTO `stock_monitors` VALUES (2, 'KUAS-20240129', 2, 'satuan', 0.00, 0.00, 98.00, 1000.00, '2024-01-29 17:57:26', '2024-01-29 18:08:16', NULL, 1, 1, NULL);

-- ----------------------------
-- Table structure for stock_seqs
-- ----------------------------
DROP TABLE IF EXISTS `stock_seqs`;
CREATE TABLE `stock_seqs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `seq` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of stock_seqs
-- ----------------------------

-- ----------------------------
-- Table structure for stocks
-- ----------------------------
DROP TABLE IF EXISTS `stocks`;
CREATE TABLE `stocks`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock_monitor_id` bigint UNSIGNED NOT NULL,
  `tipe_stock` enum('satuan','lembar') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `panjang` decimal(8, 2) NOT NULL DEFAULT 0.00,
  `lebar` decimal(8, 2) NOT NULL DEFAULT 0.00,
  `qty` decimal(8, 2) NOT NULL DEFAULT 0.00,
  `harga_jual` decimal(10, 2) NOT NULL DEFAULT 0.00,
  `status` enum('in','out','repair') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sales_order_id` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `stocks_stock_monitor_id_foreign`(`stock_monitor_id` ASC) USING BTREE,
  CONSTRAINT `stocks_stock_monitor_id_foreign` FOREIGN KEY (`stock_monitor_id`) REFERENCES `stock_monitors` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of stocks
-- ----------------------------
INSERT INTO `stocks` VALUES (1, 'CARB-20240129-1-0', 1, 'lembar', 100.00, 50.00, 0.00, 1000000.00, 'in', NULL, '2024-01-29 17:57:26', '2024-01-29 17:57:26', NULL, 1, 1, NULL);
INSERT INTO `stocks` VALUES (2, 'KUAS-20240129', 2, 'satuan', 0.00, 0.00, 100.00, 1000.00, 'in', NULL, '2024-01-29 17:57:26', '2024-01-29 17:57:26', NULL, 1, 1, NULL);
INSERT INTO `stocks` VALUES (3, 'CARB-20240129-1-0', 1, 'lembar', 100.00, 50.00, 0.00, 1000000.00, 'out', 1, '2024-01-29 18:00:11', '2024-01-29 18:00:11', NULL, 1, 1, NULL);
INSERT INTO `stocks` VALUES (4, 'KUAS-20240129', 2, 'satuan', 0.00, 0.00, 1.00, 1000.00, 'out', NULL, '2024-01-29 18:03:41', '2024-01-29 18:03:41', NULL, 1, 1, NULL);
INSERT INTO `stocks` VALUES (5, 'KUAS-20240129', 2, 'satuan', 0.00, 0.00, 1.00, 1000.00, 'out', NULL, '2024-01-29 18:08:16', '2024-01-29 18:08:16', NULL, 1, 1, NULL);

-- ----------------------------
-- Table structure for sub_moldings
-- ----------------------------
DROP TABLE IF EXISTS `sub_moldings`;
CREATE TABLE `sub_moldings`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `metode_molding_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sub_moldings_metode_molding_id_foreign`(`metode_molding_id` ASC) USING BTREE,
  CONSTRAINT `sub_moldings_metode_molding_id_foreign` FOREIGN KEY (`metode_molding_id`) REFERENCES `metode_moldings` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sub_moldings
-- ----------------------------
INSERT INTO `sub_moldings` VALUES (1, 1, 'Sub A1', '2024-01-29 17:57:26', '2024-01-29 17:57:26', NULL);
INSERT INTO `sub_moldings` VALUES (2, 1, 'Sub A2', '2024-01-29 17:57:26', '2024-01-29 17:57:26', NULL);
INSERT INTO `sub_moldings` VALUES (3, 1, 'Sub A3', '2024-01-29 17:57:26', '2024-01-29 17:57:26', NULL);
INSERT INTO `sub_moldings` VALUES (4, 2, 'Sub B1', '2024-01-29 17:57:26', '2024-01-29 17:57:26', NULL);
INSERT INTO `sub_moldings` VALUES (5, 2, 'Sub B2', '2024-01-29 17:57:26', '2024-01-29 17:57:26', NULL);
INSERT INTO `sub_moldings` VALUES (6, 2, 'Sub B3', '2024-01-29 17:57:26', '2024-01-29 17:57:26', NULL);
INSERT INTO `sub_moldings` VALUES (7, 3, 'Sub C1', '2024-01-29 17:57:26', '2024-01-29 17:57:26', NULL);
INSERT INTO `sub_moldings` VALUES (8, 3, 'Sub C2', '2024-01-29 17:57:26', '2024-01-29 17:57:26', NULL);
INSERT INTO `sub_moldings` VALUES (9, 3, 'Sub C3', '2024-01-29 17:57:26', '2024-01-29 17:57:26', NULL);

-- ----------------------------
-- Table structure for tipe_barangs
-- ----------------------------
DROP TABLE IF EXISTS `tipe_barangs`;
CREATE TABLE `tipe_barangs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tipe_barangs
-- ----------------------------
INSERT INTO `tipe_barangs` VALUES (1, 'CARBON', '2024-01-29 17:57:26', '2024-01-29 17:57:26', NULL);
INSERT INTO `tipe_barangs` VALUES (2, 'UTILITY', '2024-01-29 17:57:26', '2024-01-29 17:57:26', NULL);

-- ----------------------------
-- Table structure for tracking_logs
-- ----------------------------
DROP TABLE IF EXISTS `tracking_logs`;
CREATE TABLE `tracking_logs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `sales_order_id` bigint UNSIGNED NOT NULL,
  `status` enum('sales order','product design','manufacturing 1','manufacturing 2','manufacturing 3','manufacturing cutting','manufacturing infuse','finishing 1','finishing 2','finishing 3','rfs') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `tracking_logs_sales_order_id_foreign`(`sales_order_id` ASC) USING BTREE,
  CONSTRAINT `tracking_logs_sales_order_id_foreign` FOREIGN KEY (`sales_order_id`) REFERENCES `sales_orders` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tracking_logs
-- ----------------------------
INSERT INTO `tracking_logs` VALUES (1, 1, 'sales order', '2024-01-29 17:57:26', '2024-01-29 17:57:26', NULL, 1, 1, NULL);
INSERT INTO `tracking_logs` VALUES (2, 2, 'sales order', '2024-01-29 17:57:26', '2024-01-29 17:57:26', NULL, 1, 1, NULL);
INSERT INTO `tracking_logs` VALUES (3, 1, 'product design', '2024-01-29 17:57:44', '2024-01-29 17:57:44', NULL, 1, 1, NULL);
INSERT INTO `tracking_logs` VALUES (4, 1, 'manufacturing cutting', '2024-01-29 17:58:07', '2024-01-29 17:58:07', NULL, 1, 1, NULL);
INSERT INTO `tracking_logs` VALUES (5, 1, 'manufacturing infuse', '2024-01-29 18:00:19', '2024-01-29 18:00:19', NULL, 1, 1, NULL);
INSERT INTO `tracking_logs` VALUES (6, 1, 'finishing 1', '2024-01-29 18:07:52', '2024-01-29 18:07:52', NULL, 1, 1, NULL);
INSERT INTO `tracking_logs` VALUES (7, 1, 'finishing 2', '2024-01-29 18:08:32', '2024-01-29 18:08:32', NULL, 1, 1, NULL);
INSERT INTO `tracking_logs` VALUES (8, 1, 'finishing 3', '2024-01-29 18:09:03', '2024-01-29 18:09:03', NULL, 1, 1, NULL);
INSERT INTO `tracking_logs` VALUES (9, 1, 'rfs', '2024-01-29 18:10:17', '2024-01-29 18:10:17', NULL, 1, 1, NULL);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_username_unique`(`username` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Admin', 'admin', '$2y$12$my70I1kKxnpOZJXGN0/rCePwPg4vPv/chW9QjKM5qgymgaNFGaRwa', NULL, '2024-01-29 17:57:26', '2024-01-29 17:57:26', NULL);

SET FOREIGN_KEY_CHECKS = 1;
