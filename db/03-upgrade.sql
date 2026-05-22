-- ============================================================
-- UPGRADE DATABASE: MODUL PRESENSI & PPDB ENHANCEMENTS
-- ============================================================

-- ------------------------------------------------------------
-- 1. BUILDINGS (Master Gedung)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `buildings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `building_name` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `restored_at` datetime DEFAULT NULL,
  `created_by` bigint DEFAULT '0',
  `updated_by` bigint DEFAULT '0',
  `deleted_by` bigint DEFAULT '0',
  `restored_by` bigint DEFAULT '0',
  `is_deleted` enum('true','false') DEFAULT 'false',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ------------------------------------------------------------
-- 2. EXAM ROOMS (Master Ruang Ujian)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `exam_rooms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `building_id` bigint DEFAULT '0',
  `room_name` varchar(255) NOT NULL,
  `room_capacity` int NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `restored_at` datetime DEFAULT NULL,
  `created_by` bigint DEFAULT '0',
  `updated_by` bigint DEFAULT '0',
  `deleted_by` bigint DEFAULT '0',
  `restored_by` bigint DEFAULT '0',
  `is_deleted` enum('true','false') DEFAULT 'false',
  PRIMARY KEY (`id`),
  KEY `exam_rooms_building_id__idx` (`building_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ------------------------------------------------------------
-- 3. EXAM SUBJECTS (Mata Pelajaran Ujian Tes Tulis)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `exam_subjects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `academic_year_id` bigint DEFAULT '0',
  `subject_name` varchar(255) NOT NULL,
  `subject_order` int NOT NULL DEFAULT '0',
  `is_active` enum('true','false') DEFAULT 'true',
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `restored_at` datetime DEFAULT NULL,
  `created_by` bigint DEFAULT '0',
  `updated_by` bigint DEFAULT '0',
  `deleted_by` bigint DEFAULT '0',
  `restored_by` bigint DEFAULT '0',
  `is_deleted` enum('true','false') DEFAULT 'false',
  PRIMARY KEY (`id`),
  KEY `exam_subjects_academic_year_id__idx` (`academic_year_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ------------------------------------------------------------
-- 4. EXAM SCHEDULES (Jadwal Ujian Tes Tulis)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `exam_schedules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `academic_year_id` bigint DEFAULT '0',
  `admission_phase_id` bigint DEFAULT '0',
  `exam_subject_id` bigint DEFAULT '0',
  `exam_date` date DEFAULT NULL,
  `exam_start_time` time DEFAULT NULL,
  `exam_end_time` time DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `restored_at` datetime DEFAULT NULL,
  `created_by` bigint DEFAULT '0',
  `updated_by` bigint DEFAULT '0',
  `deleted_by` bigint DEFAULT '0',
  `restored_by` bigint DEFAULT '0',
  `is_deleted` enum('true','false') DEFAULT 'false',
  PRIMARY KEY (`id`),
  KEY `exam_schedules_academic_year_id__idx` (`academic_year_id`) USING BTREE,
  KEY `exam_schedules_admission_phase_id__idx` (`admission_phase_id`) USING BTREE,
  KEY `exam_schedules_exam_subject_id__idx` (`exam_subject_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ------------------------------------------------------------
-- 5. EXAM PARTICIPANTS (Ruang Peserta Ujian Tes Tulis)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `exam_participants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `academic_year_id` bigint DEFAULT '0',
  `admission_phase_id` bigint DEFAULT '0',
  `exam_schedule_id` bigint DEFAULT '0',
  `exam_room_id` bigint DEFAULT '0',
  `registrant_id` bigint DEFAULT '0',
  `seat_number` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `restored_at` datetime DEFAULT NULL,
  `created_by` bigint DEFAULT '0',
  `updated_by` bigint DEFAULT '0',
  `deleted_by` bigint DEFAULT '0',
  `restored_by` bigint DEFAULT '0',
  `is_deleted` enum('true','false') DEFAULT 'false',
  PRIMARY KEY (`id`),
  KEY `exam_participants_academic_year_id__idx` (`academic_year_id`) USING BTREE,
  KEY `exam_participants_admission_phase_id__idx` (`admission_phase_id`) USING BTREE,
  KEY `exam_participants_exam_schedule_id__idx` (`exam_schedule_id`) USING BTREE,
  KEY `exam_participants_exam_room_id__idx` (`exam_room_id`) USING BTREE,
  KEY `exam_participants_registrant_id__idx` (`registrant_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ------------------------------------------------------------
-- 6. STUDENT GRADE SUBJECTS (Master Nilai Rapor - PPDB)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `student_grade_subjects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `academic_year_id` bigint DEFAULT '0',
  `subject_name` varchar(255) NOT NULL,
  `is_active` enum('true','false') DEFAULT 'true',
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `restored_at` datetime DEFAULT NULL,
  `created_by` bigint DEFAULT '0',
  `updated_by` bigint DEFAULT '0',
  `deleted_by` bigint DEFAULT '0',
  `restored_by` bigint DEFAULT '0',
  `is_deleted` enum('true','false') DEFAULT 'false',
  PRIMARY KEY (`id`),
  KEY `student_grade_subjects_academic_year_id__idx` (`academic_year_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ------------------------------------------------------------
-- 7. STUDENT GRADES (Nilai Rapor Calon Pendaftar PPDB)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `student_grades` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `academic_year_id` bigint DEFAULT '0',
  `registrant_id` bigint DEFAULT '0',
  `student_grade_subject_id` bigint DEFAULT '0',
  `grade` decimal(5,2) DEFAULT '0.00',
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `restored_at` datetime DEFAULT NULL,
  `created_by` bigint DEFAULT '0',
  `updated_by` bigint DEFAULT '0',
  `deleted_by` bigint DEFAULT '0',
  `restored_by` bigint DEFAULT '0',
  `is_deleted` enum('true','false') DEFAULT 'false',
  PRIMARY KEY (`id`),
  KEY `student_grades_academic_year_id__idx` (`academic_year_id`) USING BTREE,
  KEY `student_grades_registrant_id__idx` (`registrant_id`) USING BTREE,
  KEY `student_grades_student_grade_subject_id__idx` (`student_grade_subject_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ------------------------------------------------------------
-- 8. ATTENDANCES (Presensi Siswa)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `attendances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `academic_year_id` bigint DEFAULT '0',
  `class_group_setting_id` bigint DEFAULT '0',
  `schedule_id` bigint DEFAULT '0' COMMENT 'FK ke jadwal (bila ada)',
  `student_id` bigint DEFAULT '0',
  `attendance_date` date DEFAULT NULL,
  `attendance_status` enum('present','absent','sick','permit') NOT NULL DEFAULT 'present',
  `notes` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `restored_at` datetime DEFAULT NULL,
  `created_by` bigint DEFAULT '0',
  `updated_by` bigint DEFAULT '0',
  `deleted_by` bigint DEFAULT '0',
  `restored_by` bigint DEFAULT '0',
  `is_deleted` enum('true','false') DEFAULT 'false',
  PRIMARY KEY (`id`),
  KEY `attendances_academic_year_id__idx` (`academic_year_id`) USING BTREE,
  KEY `attendances_class_group_setting_id__idx` (`class_group_setting_id`) USING BTREE,
  KEY `attendances_student_id__idx` (`student_id`) USING BTREE,
  KEY `attendances_date__idx` (`attendance_date`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ------------------------------------------------------------
-- 9. TEACHING AGENDAS (Agenda Mengajar Guru)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `teaching_agendas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `academic_year_id` bigint DEFAULT '0',
  `employee_id` bigint DEFAULT '0',
  `class_group_setting_id` bigint DEFAULT '0',
  `schedule_id` bigint DEFAULT '0' COMMENT 'FK ke jadwal (bila ada)',
  `meeting_date` date DEFAULT NULL,
  `meeting_time` time DEFAULT NULL,
  `material_discussed` text,
  `notes` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `restored_at` datetime DEFAULT NULL,
  `created_by` bigint DEFAULT '0',
  `updated_by` bigint DEFAULT '0',
  `deleted_by` bigint DEFAULT '0',
  `restored_by` bigint DEFAULT '0',
  `is_deleted` enum('true','false') DEFAULT 'false',
  PRIMARY KEY (`id`),
  KEY `teaching_agendas_academic_year_id__idx` (`academic_year_id`) USING BTREE,
  KEY `teaching_agendas_employee_id__idx` (`employee_id`) USING BTREE,
  KEY `teaching_agendas_class_group_setting_id__idx` (`class_group_setting_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
