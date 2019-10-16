/*
 Navicat Premium Data Transfer

 Source Server         : lokal root
 Source Server Type    : MySQL
 Source Server Version : 50529
 Source Host           : localhost:3306
 Source Schema         : db_lpjbos

 Target Server Type    : MySQL
 Target Server Version : 50529
 File Encoding         : 65001

 Date: 17/10/2019 07:58:22
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tb_kecamatan
-- ----------------------------
DROP TABLE IF EXISTS `tb_kecamatan`;
CREATE TABLE `tb_kecamatan`  (
  `id` char(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `wilayah` enum('1','2','3') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tb_kelurahan
-- ----------------------------
DROP TABLE IF EXISTS `tb_kelurahan`;
CREATE TABLE `tb_kelurahan`  (
  `id` char(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `district_id` char(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `villages_district_id_index`(`district_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tb_lampiran
-- ----------------------------
DROP TABLE IF EXISTS `tb_lampiran`;
CREATE TABLE `tb_lampiran`  (
  `id` tinyint(3) NOT NULL,
  `nama` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `jenis` enum('LAMPIRAN BOS','LAMPIRAN KEUANGAN') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tb_lpj
-- ----------------------------
DROP TABLE IF EXISTS `tb_lpj`;
CREATE TABLE `tb_lpj`  (
  `npsn` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `tahun` char(9) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `tahap` enum('Tahap I','Tahap II') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Tahap II',
  `id_lampiran` tinyint(3) NOT NULL,
  `status` enum('Belum Diajukan','Pending','Proses','Diterima','Upload Ulang') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `keterangan` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `path_file` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `bulan` tinyint(2) UNSIGNED NOT NULL,
  `tanggal` date NULL DEFAULT NULL,
  PRIMARY KEY (`npsn`, `tahun`, `tahap`, `id_lampiran`, `bulan`) USING BTREE,
  CONSTRAINT `fk_npsn` FOREIGN KEY (`npsn`) REFERENCES `tb_madrasah` (`npsn`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tb_madrasah
-- ----------------------------
DROP TABLE IF EXISTS `tb_madrasah`;
CREATE TABLE `tb_madrasah`  (
  `npsn` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `nsm` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `jenjang` enum('Madrasah Ibtidaiyah','Madrasah Tsanawiyah','Madrasah Aliyah') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `nama` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `alamat` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `nama_kepsek` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `nama_bendahara` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `no_telp` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `id_kel` char(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `id_kec` char(7) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`npsn`) USING BTREE,
  INDEX `fk_username`(`username`) USING BTREE,
  CONSTRAINT `fk_username` FOREIGN KEY (`username`) REFERENCES `tb_user` (`username`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tb_penilaian
-- ----------------------------
DROP TABLE IF EXISTS `tb_penilaian`;
CREATE TABLE `tb_penilaian`  (
  `npsn` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `tahun` char(9) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `tahap` enum('Tahap I','Tahap II') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` enum('Pending','Proses','Upload Ulang','Diterima','Ditolak') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `keterangan` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`npsn`, `tahun`, `tahap`) USING BTREE,
  CONSTRAINT `fk_npsn_penilaian` FOREIGN KEY (`npsn`) REFERENCES `tb_madrasah` (`npsn`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tb_tahun_tahap
-- ----------------------------
DROP TABLE IF EXISTS `tb_tahun_tahap`;
CREATE TABLE `tb_tahun_tahap`  (
  `tahun` char(9) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `tahap` enum('Tahap I','Tahap II') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`tahun`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tb_user
-- ----------------------------
DROP TABLE IF EXISTS `tb_user`;
CREATE TABLE `tb_user`  (
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` char(41) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `level` enum('pemeriksa','operator') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `nama` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` enum('aktif','belum aktif') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'belum aktif',
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `wilayah` enum('0','1','2','3') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`username`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
