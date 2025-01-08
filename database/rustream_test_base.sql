/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE TABLE `backend_users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `backend_users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `blog_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `preview_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `seo_title` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_categories_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `blog_posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `published_at` date DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `seo_title` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_posts_slug_unique` (`slug`),
  KEY `blog_posts_category_id_foreign` (`category_id`),
  CONSTRAINT `blog_posts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `blog_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `case_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `certificate_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `certificate_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `is_used` tinyint(1) NOT NULL DEFAULT '0',
  `options` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `certificate_user_certificate_id_foreign` (`certificate_id`),
  KEY `certificate_user_user_id_foreign` (`user_id`),
  CONSTRAINT `certificate_user_certificate_id_foreign` FOREIGN KEY (`certificate_id`) REFERENCES `certificates` (`id`),
  CONSTRAINT `certificate_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `certificates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `needed_points` decimal(10,2) NOT NULL,
  `promo_codes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `certificates_slug_index` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `instructions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `media` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint unsigned NOT NULL,
  `manipulations` json NOT NULL,
  `custom_properties` json NOT NULL,
  `generated_conversions` json NOT NULL,
  `responsive_images` json NOT NULL,
  `order_column` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `media_uuid_unique` (`uuid`),
  KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  KEY `media_order_column_index` (`order_column`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `notifications` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `pricing_plans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `monthly_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `yearly_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `max_accounts_count` int NOT NULL DEFAULT '0',
  `max_streams_count` int NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `most_popular` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `promo_code_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `promo_code_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `promo_code_user_promo_code_id_foreign` (`promo_code_id`),
  KEY `promo_code_user_user_id_foreign` (`user_id`),
  CONSTRAINT `promo_code_user_promo_code_id_foreign` FOREIGN KEY (`promo_code_id`) REFERENCES `promo_codes` (`id`),
  CONSTRAINT `promo_code_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `promo_codes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_usage` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `stories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stories_user_id_foreign` (`user_id`),
  CONSTRAINT `stories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `streams` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `video_id` bigint unsigned DEFAULT NULL,
  `story_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `streamable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `streamable_id` bigint unsigned NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `repeat_interval` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` json DEFAULT NULL,
  `options` json DEFAULT NULL,
  `stats` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_online` tinyint(1) NOT NULL DEFAULT '0',
  `pid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rtmp_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rtmp_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_at` timestamp NOT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `next_at` timestamp NULL DEFAULT NULL,
  `play_count` int NOT NULL DEFAULT '0',
  `view_count` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `streams_video_id_foreign` (`video_id`),
  KEY `streams_story_id_foreign` (`story_id`),
  KEY `streams_user_id_foreign` (`user_id`),
  KEY `streams_streamable_type_streamable_id_index` (`streamable_type`,`streamable_id`),
  CONSTRAINT `streams_story_id_foreign` FOREIGN KEY (`story_id`) REFERENCES `stories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `streams_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `streams_video_id_foreign` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `subscriptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pricing_plan_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `start_at` timestamp NULL DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auto_renew` tinyint(1) NOT NULL DEFAULT '1',
  `frequency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subscriptions_pricing_plan_id_foreign` (`pricing_plan_id`),
  KEY `subscriptions_user_id_foreign` (`user_id`),
  CONSTRAINT `subscriptions_pricing_plan_id_foreign` FOREIGN KEY (`pricing_plan_id`) REFERENCES `pricing_plans` (`id`),
  CONSTRAINT `subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `system_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `system_settings_code_index` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `tg_channels` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `tg_user_id` bigint unsigned NOT NULL,
  `tg_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` json DEFAULT NULL,
  `is_banned` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_in_channels` tinyint(1) NOT NULL DEFAULT '0',
  `is_in_stories` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tg_channels_user_id_foreign` (`user_id`),
  KEY `tg_channels_tg_user_id_foreign` (`tg_user_id`),
  CONSTRAINT `tg_channels_tg_user_id_foreign` FOREIGN KEY (`tg_user_id`) REFERENCES `tg_users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tg_channels_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `tg_users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `tg_id` int NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar_url` text COLLATE utf8mb4_unicode_ci,
  `token` text COLLATE utf8mb4_unicode_ci,
  `expires_at` timestamp NULL DEFAULT NULL,
  `payload` json DEFAULT NULL,
  `is_banned` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_in_page` tinyint(1) NOT NULL DEFAULT '0',
  `is_in_stories` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tg_users_user_id_foreign` (`user_id`),
  CONSTRAINT `tg_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `login` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint unsigned DEFAULT NULL,
  `profile_photo_path` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `partner_id` bigint unsigned DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sex` enum('male','female') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referral_link_count` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_login_unique` (`login`),
  KEY `users_partner_id_foreign` (`partner_id`),
  CONSTRAINT `users_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `videos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `duration` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `videos_user_id_foreign` (`user_id`),
  CONSTRAINT `videos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `vk_groups` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `vk_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `user_id` bigint unsigned NOT NULL,
  `vk_user_id` bigint unsigned NOT NULL,
  `in_dashboard` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vk_groups_user_id_foreign` (`user_id`),
  KEY `vk_groups_vk_user_id_foreign` (`vk_user_id`),
  CONSTRAINT `vk_groups_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `vk_groups_vk_user_id_foreign` FOREIGN KEY (`vk_user_id`) REFERENCES `vk_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `vk_users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `vk_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `full_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sex` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `refresh_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `access_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `device_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `id_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `expires_at` timestamp NULL DEFAULT NULL,
  `payload` json DEFAULT NULL,
  `is_banned` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_in_page` tinyint(1) NOT NULL DEFAULT '0',
  `is_in_stories` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vk_users_user_id_foreign` (`user_id`),
  CONSTRAINT `vk_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `backend_users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'info@albus-it.ru', NULL, '$2y$12$1kZRGdoddlQ/IQE0qqvRuurd9RUQzSVvXvZwqEGXcSxSD4.uL3Tau', 'sStBKAcJD3H14wFujHqLacXP7A11ERTbxX8TgrpoqzxVfL6KX6uNzF9RVXaC', '2024-11-23 20:24:05', '2024-11-23 20:24:05', NULL);
INSERT INTO `backend_users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'Евгений', 'jorikjada@gmail.com', NULL, '$2y$12$OhUgrhnGPNIpNl6pJDxAnuL.pmV6djWWZWtkrWFusPRVemuWbJLXm', NULL, '2024-12-08 11:40:52', '2024-12-08 11:40:52', NULL);




INSERT INTO `blog_posts` (`id`, `category_id`, `title`, `slug`, `content`, `published_at`, `active`, `seo_title`, `seo_description`, `created_at`, `updated_at`) VALUES
(1, NULL, 'СРЕДНИЙ И МАЛЫЙ БИЗНЕС', 'srednii-i-malyi-biznes', '<h2>RU:STREAM БЛОГ: СРЕДНИЙ И МАЛЫЙ БИЗНЕС</h2><p>Чем же автотрансляции и сервис RU:STREAM<br>могут быть полезны представителям малого и среднего бизнеса?<br><br>Для начала давайте разложим весь малый и средний бизнес на основные его проявления.<br>Есть 3 ключевые направления бизнесов, которые делят 90% рынка, а именно: производство, продажи (торговля) и услуги.<br>Разберём каждое направление отдельно.<br><br>ПРОИЗВОДСТВО<br>Если рассматривать производство в рамках малого или даже среднего бизнеса, то, как правило, это узкоспециализированное направление, заточенное на производство одного конкретного продукта в больших объёмах, в редких случаях производства нескольких позиций продукта.<br><br>Как в этом случае вам могут быть полезны автотрансляции и сервис RU:STREAM?<br><br>1. Вы можете снять развёрнутую презентацию произведённого вами товара (продукта) и запускать её в автотрансляции через RU:STREAM на вашу постоянно растущую аудиторию в соцсетях.<br><br>2. Вы можете снять весь цикл производства вашего товара.<br>Так вы покажете возможные сложности производства, чем повысите его ценность для потребителя и аргументируете цену.<br><br>3. Также с помощью автотрансляций вы сможете информировать вашу аудиторию о новинках, акциях, сможете проводить всякого рода розыгрыши и т. д…<br><br>ПРОДАЖИ (ТОРГОВЛЯ)<br>Не важно, что именно вы продаёте, адаптировать автотрансляции и сервис RU:STREAM возможно под любые товары.<br>Для примера возьмём пару совершенно полярных видов торговли, такие как магазин строительного и садового инструмента и отдел с разливной бытовой химией в торговом центре.<br><br>«Магазин инструментов»<br><br>Вы можете относительно каждого инструмента, имеющегося у вас в наличии или под заказ, снять или взять готовый от производителя презентационный ролик, или использовать обзор от какого-нибудь блогера и запустить его в автотрансляции через RU:STREAM на вашу постоянно растущую аудиторию в соцсетях.<br>Тем самым вы расскажите потенциальным клиентам о возможностях и преимуществах каждого инструмента, имеющегося у вас, и побудите их к покупке.<br><br>«Отдел бытовой химии»<br><br>Вы можете снять или взять готовый видео ролик о каждом виде вашей бытовой химии, в котором подробно разберете состав, аргументируете, почему именно ваша химия эффективна и безопасна для здоровья и т. п…<br><br>Вы можете информировать вашу аудиторию о новых поступлениях товара, возможных скидках, акциях, устраивать различные розыгрыши и т. д.<br><br>УСЛУГИ<br>Давайте для примера в этом разделе разберем представителей бьюти-сферы.<br>Пусть это будет владелец(а) небольшой парикмахерской, где он(она), собственно, и оказывает свои услуги.<br><br>Вы можете снять видео или собрать его в любом видеоредакторе из фотографий своих работ, в котором покажете своё мастерство и профессионализм, которые объяснят без слов, почему нужно постригаться именно у вас, и запустите его в автотрансляции через RU:STREAM на вашу постоянно растущую аудиторию в соцсетях.<br><br>Также вы можете допродавать вашим клиентам какую-нибудь уходовую косметику для волос и кожи головы (шампуни, бальзамы и т. п.), разумеется, со своей наценкой.<br>Для этого вы можете снять или взять готовый от производителя видео ролик, или обзор от какого-нибудь блогера, в котором дадите понять вашим клиентам, почему нужно использовать именно эти средства, и также запустите его в автотрансляции через RU:STREAM.<br><br>Почему это будет работать?<br>В отличие от того, если вы просто выложите видео у себя на страничке, алгоритм проведения автоэфира работает совершенно иначе.<br>Благодаря автоповторам всем вашим друзьям и подписчикам каждый раз будет приходить оповещение о том, что вы начали трансляцию и сейчас в прямом эфире.<br><br>По завершению автотрансляции её запись будет оставаться у вас на странице, а соответственно, в ленте у вашей аудитории.<br>Этот алгоритм будет повторятся каждый раз, предварительно удаляя прошлую трансляцию, тем самым позволит вам всегда оставаться в топе ленты и кратно увеличит просмотры вашего видео.<br><br>https://ru-stream.pro</p>', '2024-09-14', 1, NULL, NULL, '2024-06-15 07:18:42', '2024-09-14 11:45:43');
INSERT INTO `blog_posts` (`id`, `category_id`, `title`, `slug`, `content`, `published_at`, `active`, `seo_title`, `seo_description`, `created_at`, `updated_at`) VALUES
(2, NULL, 'МАРКЕТОЛОГИ И SMM СПЕЦИАЛИСТЫ', 'marketologi-i-smm-specialisty', '<h2>RU:STREAM БЛОГ: МАРКЕТОЛОГИ И SMM СПЕЦИАЛИСТЫ</h2><p>SMM-менеджер — специалист по продвижению товаров, услуг и бренда в социальных сетях.<br>Это человек, который отвечает за ведение аккаунтов компании в социальных сетях.<br><br>Маркетолог — это лицо, ответственное за маркетинг продукта или услуги. Его сфера деятельности охватывает маркетинг, рекламу и продажи, а также такие задачи, как стратегическое размещение продукта на рынке, стратегии продаж, логотипные этикетки, спонсорство и маркетинговые модели. Маркетологи в основном работают в отделах маркетинга крупных промышленных и коммерческих компаний или в маркетинговых и рекламных агентствах и работают в качестве интернет-маркетологов, аффилированных маркетологов или реферальных маркетологов.<br><br>Что объединяет маркетолога и SMM-менеджера?<br>Ответ прост — реклама и её разновидности!<br><br>Задача у SMM-менеджера и маркетолога одна.<br>Представлять своего заказчика — свою компанию в сети.<br>Делать это эффективно и искать новые креативные подходы!<br><br>Именно здесь на сцену выходит сервис RU:STREAM.<br>RU:STREAM — это идеальная возможность автоматизированно представлять свой бренд или свою компанию на рынке.<br>RU:STREAM — это безграничные возможности креативного подхода к ведению бизнес-аккаунтов.<br>RU:STREAM — лучший способ продвижения бренда в массы.<br><br><a href=\"https://vk.com/away.php?to=https%3A%2F%2Fru-stream.pro&amp;post=-215374743_266&amp;cc_key=&amp;track_code=\"><span style=\"text-decoration: underline;\">https://ru-stream.pro</span></a></p>', '2024-09-14', 1, NULL, NULL, '2024-09-14 10:24:22', '2024-09-14 11:46:16');
INSERT INTO `blog_posts` (`id`, `category_id`, `title`, `slug`, `content`, `published_at`, `active`, `seo_title`, `seo_description`, `created_at`, `updated_at`) VALUES
(3, NULL, 'КОУЧИ И ИНФОБИЗНЕСМЕНЫ', 'kouci-i-infobiznesmeny', '<h2>RU:STREAM БЛОГ: КОУЧИ И ИНФОБИЗНЕСМЕНЫ</h2><p>Что такое инфобизнес? Кто такие инфобизнесмены?<br><br>Инфобизнес – это получение прибыли от продажи информации.<br>Чем ярче упаковка, агрессивнее реклама, громче имя продавца и больше база подписчиков, тем успешнее продается продукт.<br>Эксперты зарабатывают на реализации любых обучающих продуктов, главное – правильно их упаковать и найти свою аудиторию.<br><br>Всю суть инфобизнеса можно свести к простой схеме на три пункта!<br>Пусть это будет утрированно, зато понятно для простого обывателя.<br><br>1. Есть Я – успешный предприниматель.<br>2. У меня есть секретные знания, основанные на моём личном опыте – как тебе стать успешным.<br>3. Я готов этими знаниями поделиться за небольшое вознаграждение.<br><br>Таким образом, мы понимаем, что основная часть продаж любого инфобизнесмена ложится именно на прокачку и рекламу своего личного бренда! Имя! Вот что самое главное!<br><br>Сергей из шиномонтажки за углом вряд ли может рассказать секретный секрет вашего успеха.<br>А вот Аяз Шабутдинов – основатель холдинга Like.<br>В группу компаний которого входят 22 бренда – он МОЖЕТ и он ДЕЛАЕТ.<br><br>Отсюда мы понимаем, что инфобизнесмену важно.<br>Как он выглядит в социальных сетях, что говорит и как говорит.<br>Ну и самое главное – чем активней инфобизнесмен предлагает свои продукты, чем активней он взаимодействует со своей аудиторией, даёт фидбэк, снимает возражения, закидывает инсайды, тем больше продаж и больше доход!<br><br>Зачем в этой системе взаимодействия нужен RU:STREAM?<br>Всё просто! Поскольку для инфобизнесмена важна работа с его аудиторией, желательно автоматизированная и круглосуточная.<br>То сервис RU:STREAM подойдёт идеально!<br><br>Вам, как инфобизнесмену, будет достаточно сделать небольшой тизер или короткую презентацию своего нового продукта в формате видео.<br>И запустить эту презентацию в прямой эфир, на автоповторы в своей группе ВКОНТАКТЕ, например. Или в вашем телеграм-канале.<br>Не лишним будет запустить автоэфиры на личной странице ВК – не важно!<br>Важно другое – экономия времени!<br>Вам больше не нужно часами готовиться к выступлениям.<br>Вам больше не нужно планировать эфиры на месяц вперёд!<br>Вам больше не страшны форс-мажоры!<br><br>Вы один раз настроили автоэфир, и он будет продавать ваши продукты вместо вас! На полном автомате! <br><br><a href=\"https://vk.com/away.php?to=https%3A%2F%2Fru-stream.pro&amp;post=-215374743_262&amp;cc_key=&amp;track_code=\"><span style=\"text-decoration: underline;\">https://ru-stream.pro</span></a></p>', '2024-09-14', 1, NULL, NULL, '2024-09-14 10:27:24', '2024-09-14 11:46:38');
INSERT INTO `blog_posts` (`id`, `category_id`, `title`, `slug`, `content`, `published_at`, `active`, `seo_title`, `seo_description`, `created_at`, `updated_at`) VALUES
(4, NULL, 'СЕТЕВОЙ МАРКЕТИНГ', 'setevoi-marketing', '<h2>RU:STREAM БЛОГ: СЕТЕВОЙ МАРКЕТИНГ</h2><p>Что такое сетевой маркетинг?<br><br>Это концепция реализации товаров и услуг, основанная на создании сети независимых дистрибьюторов, каждый из которых, помимо сбыта продукции, также обладает правом на привлечение партнёров, имеющих аналогичные права.<br>При этом доход каждого участника сети состоит из комиссионных за реализацию продукции и дополнительных вознаграждений, зависящих от объёма продаж, совершённых привлечёнными ими сбытовыми агентами.<br><br>Если простыми словами, то основная цель дистрибьютера сетевой компании — это привлечение в свою структуру новых дистрибьютеров.<br>Создание своей собственной сети сбыта продукции.<br>Создание своей команды, которая приносит доход на постоянной основе.<br>Чем больше ваша команда, чем больше вы привлекли дистрибьютеров, тем больше ваш пассивный доход.<br><br>Беря во внимание тот факт, что не каждый «сетевик», особенно начинающий, может приглашать, умеет правильно и интересно рассказать про свою компанию.<br>Мы получаем самую главную проблему всех сетевиков: «Я НЕ УМЕЮ ПРИГЛАШАТЬ».<br>Или другая интерпретация этой проблемы: «КО МНЕ НЕ ИДУТ ЛЮДИ».<br>Именно эту проблему решает сервис RU:STREAM.<br><br>Что конкретно мы предлагаем?<br><br>Для того чтобы приглашать новых дистрибьютеров в свою команду на полном автомате:<br>- Вам не нужно быть спикером.<br>- Вам не нужно иметь большого опыта в приглашениях.<br>- Вам не нужно быть профессиональным копирайтером.<br>И так далее...<br><br>Всё, что вам нужно, — это просто взять готовый ролик-презентацию вашей компании.<br>Запустить его в прямой эфир на автоповторы, допустим, в ВК.<br>Указать в описании свою реферальную ссылку или ссылку на командный чат, и дело в шляпе!<br><br>Сервис RU:STREAM будет в автоматическом режиме проводить прямые трансляции с презентацией вашей компании на вашей стене ВКОНТАКТЕ.<br>Тем самым создавая бешеную активность в вашем профиле и привлекая заинтересованных людей в вашу команду.<br><br>Сервис не устаёт, у сервиса нет выходных, ему не нужно спать!<br>Эта машина работает круглосуточно 7 дней в неделю!<br>Ни один человек не способен работать на таких скоростях!<br>А если такой метод будете использовать не только вы, а вся ваша команда?<br>У вас будет результат? <br><br><a href=\"https://vk.com/away.php?to=https%3A%2F%2Fru-stream.pro&amp;post=-215374743_261&amp;cc_key=&amp;track_code=\"><span style=\"text-decoration: underline;\">https://ru-stream.pro</span></a></p>', '2024-09-14', 1, NULL, NULL, '2024-09-14 10:28:27', '2024-09-14 11:46:57'),
(5, NULL, 'ФРИЛАНСЕРЫ', 'frilansery', '<h2>RU:STREAM БЛОГ: ФРИЛАНСЕРЫ</h2><p>Фрилансер — это человек, который сам организует свой труд, ищет клиентов, получает прибыль и платит налоги. Выполняет разовые проекты или периодически решает задачи одного заказчика.<br><br>Простыми словами, фрилансер — это человек, который продаёт свои навыки. Условный Максим умеет обрабатывать фото с помощью нейросетей, а условный Андрей хочет поставить на аватарку фото, обработанное с помощью нейросетей.<br>Андрей заказывает у Максима фото и оплачивает его работу.<br>Всё просто.<br><br>Под определение «фриланс» попадают тысячи видов деятельности.<br>От копирайтинга до программирования.<br>От обработки видео до создания уникального продающего дизайна.<br>От перевода до озвучки.<br>Всё, что можно сделать удалённо, можно делать за деньги.<br><br>Зачем фрилансеру RU:STREAM?<br><br>Поскольку видов деятельности у фрилансеров слишком много,<br>То выведем одну общую формулу успешного взаимодействия с сервисом.<br><br>1. Фрилансеру необходимо собрать портфолио из своих работ и представить его в формате видео.<br>2. Готовое видео портфолио загрузить на сайт RU:STREAM.<br>3. Запустить автоэфиры и получать заинтересованных клиентов на полном автомате.<br><br>Человек, который занимается фрилансом, как никто другой знает, что каждый клиент на вес золота.<br>А если есть возможность получать клиентов, не прилагая усилий!<br>Этой возможностью необходимо пользоваться уже сейчас.<br><br><a href=\"https://vk.com/away.php?to=https%3A%2F%2Fru-stream.pro&amp;post=-215374743_265&amp;cc_key=&amp;track_code=\"><span style=\"text-decoration: underline;\">https://ru-stream.pro</span></a></p>', '2024-09-14', 1, NULL, NULL, '2024-09-14 10:29:50', '2024-09-14 11:47:18'),
(6, NULL, 'КОНТАКТЫ', 'kontakty', '<h2>RU:STREAM БЛОГ: КОНТАКТЫ ДЛЯ СВЯЗИ</h2><p>По вопросам сотрудничества: <a href=\"https://t.me/rustream_admin\"><span style=\"text-decoration: underline;\">https://t.me/rustream_admin</span></a><br>Наш телеграм канал: <a href=\"https://t.me/+S6qQvXprClE1NTZi\">https://t.me/+S6qQvXprClE1NTZi</a><br>Группа ВКонтакте: <a href=\"https://vk.com/public215374743\"><span style=\"text-decoration: underline;\">https://vk.com/public215374743</span></a><br>Поддержать проект: <a href=\"https://vk.cc/cAKGaT\"><span style=\"text-decoration: underline;\">https://vk.cc/cAKGaT</span></a></p><p><br></p>', '2024-09-14', 1, NULL, NULL, '2024-09-14 10:45:48', '2024-09-14 13:41:10');





INSERT INTO `case_items` (`id`, `title`, `description`, `video_url`, `active`, `sort_order`, `created_at`, `updated_at`) VALUES
(2, 'Роман Сухов', 'RU:STREAM - Отличное решение для выстраивания воронок продаж. Что такое “Эра проявления”\nТелеграм для связи: @romajustin', 'https://vk.com/video-215374743_456239208', 1, 2, '2024-09-16 11:52:33', '2024-09-16 12:07:06');
INSERT INTO `case_items` (`id`, `title`, `description`, `video_url`, `active`, `sort_order`, `created_at`, `updated_at`) VALUES
(3, 'Николай Котин', 'RU:STREAM - Это самый простой и удобный сервис для автоматизации. Советы по использованию. Телеграм для связи: @Nikolay_Kotin', 'https://vk.com/video-215374743_456239207', 1, 3, '2024-09-16 11:56:41', '2024-09-16 12:03:05');
INSERT INTO `case_items` (`id`, `title`, `description`, `video_url`, `active`, `sort_order`, `created_at`, `updated_at`) VALUES
(4, 'Евгений Ванин', 'RU:STREAM - Автоматизирует поток целевого трафика. Личный опыт использования сервиса. Телеграм для связи: @evgenyvanin', 'https://vk.com/video-215374743_456239206', 1, 4, '2024-09-16 11:59:48', '2024-09-16 12:03:11');







INSERT INTO `instructions` (`id`, `title`, `description`, `video_url`, `active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'КАК ПОЛУЧИТЬ ПОЛУЧИТЬ МАКСИМАЛЬНЫЙ РЕЗУЛЬТАТ', 'Каменный век закончился не потому, что закончились камни, а потому что появились новые технологии».', 'https://vk.com/public215374743?z=video-215374743_456239037%2Fpl_-215374743_-2', 1, 1, '2024-06-25 03:58:38', '2024-06-25 03:59:20');






INSERT INTO `media` (`id`, `model_type`, `model_id`, `uuid`, `collection_name`, `name`, `file_name`, `mime_type`, `disk`, `conversions_disk`, `size`, `manipulations`, `custom_properties`, `generated_conversions`, `responsive_images`, `order_column`, `created_at`, `updated_at`) VALUES
(21, 'App\\Models\\Video', 5, '50a21460-d58b-465b-885c-e03527342108', 'videos', 'TestVideo', 'TestVideo.mp4', 'video/mp4', 'public', 'public', 122130614, '[]', '[]', '[]', '[]', 1, '2024-12-14 10:03:15', '2024-12-14 10:03:15');
INSERT INTO `media` (`id`, `model_type`, `model_id`, `uuid`, `collection_name`, `name`, `file_name`, `mime_type`, `disk`, `conversions_disk`, `size`, `manipulations`, `custom_properties`, `generated_conversions`, `responsive_images`, `order_column`, `created_at`, `updated_at`) VALUES
(22, 'App\\Models\\Video', 5, '1726612b-9a5f-44cc-8f8d-23288fc1a19e', 'posters', 'video_poster_5', 'video_poster_5.jpg', 'image/jpeg', 'public', 'public', 115534, '[]', '[]', '[]', '[]', 2, '2024-12-14 10:03:16', '2024-12-14 10:03:16');
INSERT INTO `media` (`id`, `model_type`, `model_id`, `uuid`, `collection_name`, `name`, `file_name`, `mime_type`, `disk`, `conversions_disk`, `size`, `manipulations`, `custom_properties`, `generated_conversions`, `responsive_images`, `order_column`, `created_at`, `updated_at`) VALUES
(25, 'App\\Models\\Story', 7, 'bb5b1ae4-d69c-478a-9cf1-1bac88bc0031', 'stories', 'Евгений Жебанов - Клип @idi.t.suzun', 'Евгений-Жебанов---Клип-@idi.t.suzun.mp4', 'video/mp4', 'public', 'public', 2396415, '[]', '[]', '[]', '[]', 1, '2024-12-14 10:11:23', '2024-12-14 10:11:23');
INSERT INTO `media` (`id`, `model_type`, `model_id`, `uuid`, `collection_name`, `name`, `file_name`, `mime_type`, `disk`, `conversions_disk`, `size`, `manipulations`, `custom_properties`, `generated_conversions`, `responsive_images`, `order_column`, `created_at`, `updated_at`) VALUES
(26, 'App\\Models\\Story', 7, '4856617f-8d22-40f8-aa95-881249f2f0f0', 'posters', 'story_poster7', 'story_poster7.jpg', 'image/jpeg', 'public', 'public', 23494, '[]', '[]', '[]', '[]', 2, '2024-12-14 10:11:23', '2024-12-14 10:11:23'),
(27, 'App\\Models\\Video', 6, '776584da-d472-4455-b6c7-e72c071bca1a', 'videos', 'Запись 2024-12-13 180015', 'Запись-2024-12-13-180015.mp4', 'video/mp4', 'public', 'public', 666781904, '[]', '[]', '[]', '[]', 1, '2024-12-20 20:44:04', '2024-12-20 20:44:04'),
(28, 'App\\Models\\Video', 6, 'bf56f3ef-60eb-4e56-9e29-9281e2e5d851', 'posters', 'video_poster_6', 'video_poster_6.jpg', 'image/jpeg', 'public', 'public', 95556, '[]', '[]', '[]', '[]', 2, '2024-12-20 20:44:05', '2024-12-20 20:44:05'),
(29, 'App\\Models\\Video', 7, '04f48b0a-c711-4b49-9b41-aa2582863131', 'videos', 'Y2mate_mx_Король_и_Шут_&_Хатсуне_Мику_Кукла_колдуна_Фулл_клип_фан', 'Y2mate_mx_Король_и_Шут_&_Хатсуне_Мику_Кукла_колдуна_Фулл_клип_фан.mp4', 'video/mp4', 'public', 'public', 11727783, '[]', '[]', '[]', '[]', 1, '2024-12-25 13:48:54', '2024-12-25 13:48:54'),
(30, 'App\\Models\\Video', 7, 'dfef52a7-6a3d-4590-b016-0376025b0211', 'posters', 'video_poster_7', 'video_poster_7.jpg', 'image/jpeg', 'public', 'public', 37961, '[]', '[]', '[]', '[]', 2, '2024-12-25 13:48:55', '2024-12-25 13:48:55'),
(31, 'App\\Models\\Social\\TgUser', 1, 'a6b528a6-01f7-4e31-8d70-9811c35b6326', 'tg_avatars', 'avatar', 'avatar.jpg', 'image/jpeg', 'public', 'public', 86857, '[]', '[]', '[]', '[]', 1, '2024-12-25 19:44:08', '2024-12-25 19:44:08');

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(3, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(4, '2023_05_05_010101_create_backend_users_table', 1),
(5, '2023_05_05_020101_create_setting_models_table', 1),
(6, '2024_03_27_105001_create_blog_categories_table', 1),
(7, '2024_03_27_105019_create_blog_posts_table', 1),
(8, '2024_11_11_091630_add_two_factor_columns_to_users_table', 1),
(9, '2024_11_11_091640_create_personal_access_tokens_table', 1),
(10, '2024_11_11_235903_create_media_table', 1),
(11, '2024_11_12_010001_create_instructions_table', 1),
(12, '2024_11_12_010004_create_case_items_table', 1),
(13, '2024_11_12_010101_extend_users_table', 1),
(14, '2024_11_12_010102_create_promo_codes_table', 1),
(15, '2024_11_12_010103_create_certificates_table', 1),
(16, '2024_11_12_010201_create_videos_table', 1),
(17, '2024_11_12_010202_create_stories_table', 1),
(18, '2024_11_12_010301_create_streams_table', 1),
(19, '2024_11_12_010401_create_vk_users_table', 1),
(20, '2024_11_15_025947_create_pricing_plans_table', 1),
(22, '2024_11_25_074118_create_vk_groups_table', 2),
(23, '2024_11_26_141212_create_notifications_table', 2),
(24, '2024_11_15_205714_create_subscriptions_table', 3),
(26, '2024_12_23_173840_create_tg_users_table', 4),
(27, '2024_12_29_143128_create_tg_channels_table', 5);

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('04597c48-0ca3-4c28-948c-e29e8f546c81', 'App\\Notifications\\Subscription\\SubscriptionTimeRemaining', 'App\\Models\\User', 1, '{\"title\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u0438\\u0441\\u0442\\u0435\\u043a\\u0430\\u0435\\u0442\",\"message\":\"\\u0421\\u0440\\u043e\\u043a \\u043f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0438 \\u043d\\u0430 \\u043f\\u043b\\u0430\\u043d \\u0418\\u0441\\u0442\\u043e\\u0440\\u0438\\u0438 \\\"PRO\\\" \\u0438\\u0441\\u0442\\u0435\\u043a\\u0430\\u0435\\u0442. \\u041e\\u0441\\u0442\\u0430\\u043b\\u043e\\u0441\\u044c \\u0434\\u043d\\u0435\\u0438\\u0306: 3.\",\"category\":\"subscription\"}', NULL, '2024-12-22 12:24:14', '2024-12-22 12:24:14');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('17af29d4-55b1-4919-91c6-fc65150896e3', 'App\\Notifications\\Subscription\\SubscriptionTimeRemaining', 'App\\Models\\User', 1, '{\"title\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u0438\\u0441\\u0442\\u0435\\u043a\\u0430\\u0435\\u0442\",\"message\":\"\\u0421\\u0440\\u043e\\u043a \\u043f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0438 \\u043d\\u0430 \\u043f\\u043b\\u0430\\u043d \\u0418\\u0441\\u0442\\u043e\\u0440\\u0438\\u0438 \\\"PRO\\\" \\u0438\\u0441\\u0442\\u0435\\u043a\\u0430\\u0435\\u0442. \\u041e\\u0441\\u0442\\u0430\\u043b\\u043e\\u0441\\u044c \\u0434\\u043d\\u0435\\u0438\\u0306: 3.\",\"category\":\"subscription\"}', NULL, '2024-12-22 12:21:55', '2024-12-22 12:21:55');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('23b4bc65-539f-48d2-b582-efcbdccda118', 'App\\Notifications\\Subscription\\SubscriptionAdded', 'App\\Models\\User', 1, '{\"title\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u043e\\u0444\\u043e\\u0440\\u043c\\u043b\\u0435\\u043d\\u0430\",\"message\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u043d\\u0430 \\u043f\\u043b\\u0430\\u043d Tg+ \\u0431\\u044b\\u043b\\u0430 \\u0443\\u0441\\u043f\\u0435\\u0448\\u043d\\u043e \\u043e\\u0444\\u043e\\u0440\\u043c\\u043b\\u0435\\u043d\\u0430.\",\"category\":\"subscription\"}', NULL, '2024-12-24 10:50:08', '2024-12-24 10:50:08');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('23d474d9-7053-4d59-bc9d-03cfe9dabe46', 'App\\Notifications\\Subscription\\SubscriptionTimeRemaining', 'App\\Models\\User', 1, '{\"title\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u0438\\u0441\\u0442\\u0435\\u043a\\u0430\\u0435\\u0442\",\"message\":\"\\u0421\\u0440\\u043e\\u043a \\u043f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0438 \\u043d\\u0430 \\u043f\\u043b\\u0430\\u043d \\u0418\\u0441\\u0442\\u043e\\u0440\\u0438\\u0438 \\\"PRO\\\" \\u0438\\u0441\\u0442\\u0435\\u043a\\u0430\\u0435\\u0442. \\u041e\\u0441\\u0442\\u0430\\u043b\\u043e\\u0441\\u044c \\u0434\\u043d\\u0435\\u0438\\u0306: 3.\",\"category\":\"subscription\"}', NULL, '2024-12-22 12:24:33', '2024-12-22 12:24:33'),
('36edbea5-ceb5-42ca-a0b5-f28d583aefe6', 'App\\Notifications\\Subscription\\SubscriptionTimeRemaining', 'App\\Models\\User', 1, '{\"title\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u0438\\u0441\\u0442\\u0435\\u043a\\u0430\\u0435\\u0442\",\"message\":\"\\u0421\\u0440\\u043e\\u043a \\u043f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0438 \\u043d\\u0430 \\u043f\\u043b\\u0430\\u043d \\u0418\\u0441\\u0442\\u043e\\u0440\\u0438\\u0438 \\\"PRO\\\" \\u0438\\u0441\\u0442\\u0435\\u043a\\u0430\\u0435\\u0442. \\u041e\\u0441\\u0442\\u0430\\u043b\\u043e\\u0441\\u044c \\u0434\\u043d\\u0435\\u0438\\u0306: 3.\",\"category\":\"subscription\"}', NULL, '2024-12-22 12:31:37', '2024-12-22 12:31:37'),
('3ff9f295-87e6-4e9e-b7f2-c7ade13e549a', 'App\\Notifications\\Subscription\\SubscriptionTimeRemaining', 'App\\Models\\User', 1, '{\"title\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u0438\\u0441\\u0442\\u0435\\u043a\\u0430\\u0435\\u0442\",\"message\":\"\\u0421\\u0440\\u043e\\u043a \\u043f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0438 \\u043d\\u0430 \\u043f\\u043b\\u0430\\u043d \\u0413\\u0440\\u0443\\u043f\\u043f\\u0430 \\\"PRO\\\" \\u0438\\u0441\\u0442\\u0435\\u043a\\u0430\\u0435\\u0442. \\u041e\\u0441\\u0442\\u0430\\u043b\\u043e\\u0441\\u044c \\u0434\\u043d\\u0435\\u0438\\u0306: 5.\",\"category\":\"subscription\"}', NULL, '2024-12-22 12:31:38', '2024-12-22 12:31:38'),
('4517f111-6109-4701-bdda-43ebba5a2e52', 'App\\Notifications\\Subscription\\SubscriptionChanged', 'App\\Models\\User', 2, '{\"title\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u0431\\u044b\\u043b\\u0430 \\u0438\\u0437\\u043c\\u0435\\u043d\\u0435\\u043d\\u0430\",\"message\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u043d\\u0430 \\u043f\\u043b\\u0430\\u043d \\u0418\\u0441\\u0442\\u043e\\u0440\\u0438\\u0438 \\\"VIP\\\" \\u0431\\u044b\\u043b\\u0430 \\u0443\\u0441\\u043f\\u0435\\u0448\\u043d\\u043e \\u0438\\u0437\\u043c\\u0435\\u043d\\u0435\\u043d\\u0430 \\u043d\\u0430 \\u0418\\u0441\\u0442\\u043e\\u0440\\u0438\\u0438 \\\"PRO\\\".\",\"category\":\"subscription\"}', NULL, '2024-11-27 15:19:33', '2024-11-27 15:19:33'),
('52ef4177-a4e2-4c7d-8a55-6ca5ca4dfd63', 'App\\Notifications\\Subscription\\SubscriptionTimeRemaining', 'App\\Models\\User', 1, '{\"title\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u0438\\u0441\\u0442\\u0435\\u043a\\u0430\\u0435\\u0442\",\"message\":\"\\u0421\\u0440\\u043e\\u043a \\u043f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0438 \\u043d\\u0430 \\u043f\\u043b\\u0430\\u043d \\u0413\\u0440\\u0443\\u043f\\u043f\\u0430 \\\"PRO\\\" \\u0438\\u0441\\u0442\\u0435\\u043a\\u0430\\u0435\\u0442. \\u041e\\u0441\\u0442\\u0430\\u043b\\u043e\\u0441\\u044c \\u0434\\u043d\\u0435\\u0438\\u0306: 5.\",\"category\":\"subscription\"}', NULL, '2024-12-22 12:24:34', '2024-12-22 12:24:34'),
('6f4fc721-7be3-4dff-adc4-ffa62bfc66a0', 'App\\Notifications\\Subscription\\SubscriptionAdded', 'App\\Models\\User', 1, '{\"title\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u043e\\u0444\\u043e\\u0440\\u043c\\u043b\\u0435\\u043d\\u0430\",\"message\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u043d\\u0430 \\u043f\\u043b\\u0430\\u043d \\u0412\\u043a\\u043e\\u043d\\u0442\\u0430\\u043a\\u0442\\u0435 \\\"PRO\\\" \\u0431\\u044b\\u043b\\u0430 \\u0443\\u0441\\u043f\\u0435\\u0448\\u043d\\u043e \\u043e\\u0444\\u043e\\u0440\\u043c\\u043b\\u0435\\u043d\\u0430.\",\"category\":\"subscription\"}', NULL, '2024-12-22 14:04:53', '2024-12-22 14:04:53'),
('76e0863d-843b-43f7-b4cc-a5ece8d9a98c', 'App\\Notifications\\Subscription\\SubscriptionAdded', 'App\\Models\\User', 1, '{\"title\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u043e\\u0444\\u043e\\u0440\\u043c\\u043b\\u0435\\u043d\\u0430\",\"message\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u043d\\u0430 \\u043f\\u043b\\u0430\\u043d \\u0413\\u0440\\u0443\\u043f\\u043f\\u0430 \\\"START\\\" \\u0431\\u044b\\u043b\\u0430 \\u0443\\u0441\\u043f\\u0435\\u0448\\u043d\\u043e \\u043e\\u0444\\u043e\\u0440\\u043c\\u043b\\u0435\\u043d\\u0430.\",\"category\":\"subscription\"}', NULL, '2024-12-24 10:23:18', '2024-12-24 10:23:18'),
('80ecd328-85a8-4447-9fce-52e33e10a727', 'App\\Notifications\\Subscription\\SubscriptionChanged', 'App\\Models\\User', 1, '{\"title\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u0431\\u044b\\u043b\\u0430 \\u0438\\u0437\\u043c\\u0435\\u043d\\u0435\\u043d\\u0430\",\"message\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u043d\\u0430 \\u043f\\u043b\\u0430\\u043d \\u0412\\u043a\\u043e\\u043d\\u0442\\u0430\\u043a\\u0442\\u0435 \\\"VIP\\\" \\u0431\\u044b\\u043b\\u0430 \\u0443\\u0441\\u043f\\u0435\\u0448\\u043d\\u043e \\u0438\\u0437\\u043c\\u0435\\u043d\\u0435\\u043d\\u0430 \\u043d\\u0430 \\u0412\\u043a\\u043e\\u043d\\u0442\\u0430\\u043a\\u0442\\u0435 \\\"START\\\".\",\"category\":\"subscription\"}', NULL, '2024-11-28 11:22:16', '2024-11-28 11:22:16'),
('93582b37-354b-48c2-a492-102784d50e9a', 'App\\Notifications\\Subscription\\SubscriptionChanged', 'App\\Models\\User', 1, '{\"title\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u0431\\u044b\\u043b\\u0430 \\u0438\\u0437\\u043c\\u0435\\u043d\\u0435\\u043d\\u0430\",\"message\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u043d\\u0430 \\u043f\\u043b\\u0430\\u043d \\u0412\\u043a\\u043e\\u043d\\u0442\\u0430\\u043a\\u0442\\u0435 \\\"PRO\\\" \\u0431\\u044b\\u043b\\u0430 \\u0443\\u0441\\u043f\\u0435\\u0448\\u043d\\u043e \\u0438\\u0437\\u043c\\u0435\\u043d\\u0435\\u043d\\u0430 \\u043d\\u0430 \\u0412\\u043a\\u043e\\u043d\\u0442\\u0430\\u043a\\u0442\\u0435 \\\"VIP\\\".\",\"category\":\"subscription\"}', '2024-11-28 11:22:09', '2024-11-27 03:12:39', '2024-11-28 11:22:09'),
('a74a894e-2ed4-4f99-902b-62f1dbdfa2ee', 'App\\Notifications\\Subscription\\SubscriptionAdded', 'App\\Models\\User', 1, '{\"title\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u043e\\u0444\\u043e\\u0440\\u043c\\u043b\\u0435\\u043d\\u0430\",\"message\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u043d\\u0430 \\u043f\\u043b\\u0430\\u043d \\u0413\\u0440\\u0443\\u043f\\u043f\\u0430 \\\"PRO\\\" \\u0431\\u044b\\u043b\\u0430 \\u0443\\u0441\\u043f\\u0435\\u0448\\u043d\\u043e \\u043e\\u0444\\u043e\\u0440\\u043c\\u043b\\u0435\\u043d\\u0430.\",\"category\":\"subscription\"}', '2024-11-28 11:22:07', '2024-11-27 03:10:03', '2024-11-28 11:22:07'),
('ad08cb57-5f52-4145-bad8-3180611c0d82', 'App\\Notifications\\Subscription\\SubscriptionRemoved', 'App\\Models\\User', 1, '{\"title\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u043e\\u0442\\u043c\\u0435\\u043d\\u0435\\u043d\\u0430\",\"message\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u043d\\u0430 \\u043f\\u043b\\u0430\\u043d \\u0412\\u043a\\u043e\\u043d\\u0442\\u0430\\u043a\\u0442\\u0435 \\\"PRO\\\" \\u0431\\u044b\\u043b\\u0430 \\u043e\\u0442\\u043c\\u0435\\u043d\\u0435\\u043d\\u0430.\",\"category\":\"subscription\"}', NULL, '2024-12-22 14:08:31', '2024-12-22 14:08:31'),
('b275b8a8-2ce6-4399-b736-1a9ab4c74fa6', 'App\\Notifications\\Subscription\\SubscriptionChanged', 'App\\Models\\User', 1, '{\"title\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u0431\\u044b\\u043b\\u0430 \\u0438\\u0437\\u043c\\u0435\\u043d\\u0435\\u043d\\u0430\",\"message\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u043d\\u0430 \\u043f\\u043b\\u0430\\u043d \\u0412\\u043a\\u043e\\u043d\\u0442\\u0430\\u043a\\u0442\\u0435 \\\"START\\\" \\u0431\\u044b\\u043b\\u0430 \\u0443\\u0441\\u043f\\u0435\\u0448\\u043d\\u043e \\u0438\\u0437\\u043c\\u0435\\u043d\\u0435\\u043d\\u0430 \\u043d\\u0430 \\u0412\\u043a\\u043e\\u043d\\u0442\\u0430\\u043a\\u0442\\u0435 \\\"VIP\\\".\",\"category\":\"subscription\"}', NULL, '2024-11-28 11:22:24', '2024-11-28 11:22:24'),
('b491e5fa-f997-48bf-955c-badfd7aeb97e', 'App\\Notifications\\Subscription\\SubscriptionTimeRemaining', 'App\\Models\\User', 1, '{\"title\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u0438\\u0441\\u0442\\u0435\\u043a\\u0430\\u0435\\u0442\",\"message\":\"\\u0421\\u0440\\u043e\\u043a \\u043f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0438 \\u043d\\u0430 \\u043f\\u043b\\u0430\\u043d \\u0413\\u0440\\u0443\\u043f\\u043f\\u0430 \\\"PRO\\\" \\u0438\\u0441\\u0442\\u0435\\u043a\\u0430\\u0435\\u0442. \\u041e\\u0441\\u0442\\u0430\\u043b\\u043e\\u0441\\u044c \\u0434\\u043d\\u0435\\u0438\\u0306: 5.\",\"category\":\"subscription\"}', NULL, '2024-12-22 12:21:55', '2024-12-22 12:21:55'),
('d1c2386c-677d-4f9d-95bd-90cf9c8bd347', 'App\\Notifications\\Subscription\\SubscriptionTimeRemaining', 'App\\Models\\User', 1, '{\"title\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u0438\\u0441\\u0442\\u0435\\u043a\\u0430\\u0435\\u0442\",\"message\":\"\\u0421\\u0440\\u043e\\u043a \\u043f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0438 \\u043d\\u0430 \\u043f\\u043b\\u0430\\u043d \\u0418\\u0441\\u0442\\u043e\\u0440\\u0438\\u0438 \\\"PRO\\\" \\u0438\\u0441\\u0442\\u0435\\u043a\\u0430\\u0435\\u0442.\\\\n\\u041e\\u0441\\u0442\\u0430\\u043b\\u043e\\u0441\\u044c \\u0434\\u043d\\u0435\\u0438\\u0306: 3.\",\"category\":\"subscription\"}', NULL, '2024-12-22 12:30:49', '2024-12-22 12:30:49'),
('d7a33729-7922-480c-99f8-c8543dbb3286', 'App\\Notifications\\Subscription\\SubscriptionChanged', 'App\\Models\\User', 1, '{\"title\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u0431\\u044b\\u043b\\u0430 \\u0438\\u0437\\u043c\\u0435\\u043d\\u0435\\u043d\\u0430\",\"message\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u043d\\u0430 \\u043f\\u043b\\u0430\\u043d \\u0412\\u043a\\u043e\\u043d\\u0442\\u0430\\u043a\\u0442\\u0435 \\\"VIP\\\" \\u0431\\u044b\\u043b\\u0430 \\u0443\\u0441\\u043f\\u0435\\u0448\\u043d\\u043e \\u0438\\u0437\\u043c\\u0435\\u043d\\u0435\\u043d\\u0430 \\u043d\\u0430 \\u0412\\u043a\\u043e\\u043d\\u0442\\u0430\\u043a\\u0442\\u0435 \\\"PRO\\\".\",\"category\":\"subscription\"}', NULL, '2024-11-29 09:02:52', '2024-11-29 09:02:52'),
('ddb2e540-e92c-4f96-a987-a5497b549b30', 'App\\Notifications\\Subscription\\SubscriptionTimeRemaining', 'App\\Models\\User', 1, '{\"title\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u0438\\u0441\\u0442\\u0435\\u043a\\u0430\\u0435\\u0442\",\"message\":\"\\u0421\\u0440\\u043e\\u043a \\u043f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0438 \\u043d\\u0430 \\u043f\\u043b\\u0430\\u043d \\u0413\\u0440\\u0443\\u043f\\u043f\\u0430 \\\"PRO\\\" \\u0438\\u0441\\u0442\\u0435\\u043a\\u0430\\u0435\\u0442.\\\\n\\u041e\\u0441\\u0442\\u0430\\u043b\\u043e\\u0441\\u044c \\u0434\\u043d\\u0435\\u0438\\u0306: 5.\",\"category\":\"subscription\"}', NULL, '2024-12-22 12:30:50', '2024-12-22 12:30:50'),
('e83bb35b-512a-4446-9cc5-495f80306ce9', 'App\\Notifications\\Subscription\\SubscriptionAdded', 'App\\Models\\User', 2, '{\"title\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u043e\\u0444\\u043e\\u0440\\u043c\\u043b\\u0435\\u043d\\u0430\",\"message\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u043d\\u0430 \\u043f\\u043b\\u0430\\u043d \\u0413\\u0440\\u0443\\u043f\\u043f\\u0430 \\\"VIP\\\" \\u0431\\u044b\\u043b\\u0430 \\u0443\\u0441\\u043f\\u0435\\u0448\\u043d\\u043e \\u043e\\u0444\\u043e\\u0440\\u043c\\u043b\\u0435\\u043d\\u0430.\",\"category\":\"subscription\"}', '2024-11-27 15:19:05', '2024-11-27 15:16:26', '2024-11-27 15:19:05'),
('ed02d98a-1436-41a2-badd-2921659924ee', 'App\\Notifications\\Subscription\\SubscriptionAdded', 'App\\Models\\User', 1, '{\"title\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u043e\\u0444\\u043e\\u0440\\u043c\\u043b\\u0435\\u043d\\u0430\",\"message\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u043d\\u0430 \\u043f\\u043b\\u0430\\u043d \\u0412\\u043a\\u043e\\u043d\\u0442\\u0430\\u043a\\u0442\\u0435 \\\"PRO\\\" \\u0431\\u044b\\u043b\\u0430 \\u0443\\u0441\\u043f\\u0435\\u0448\\u043d\\u043e \\u043e\\u0444\\u043e\\u0440\\u043c\\u043b\\u0435\\u043d\\u0430.\",\"category\":\"subscription\"}', NULL, '2024-12-22 14:09:19', '2024-12-22 14:09:19'),
('f60e57be-83e8-44ca-9c34-d1e37dd3d963', 'App\\Notifications\\Subscription\\SubscriptionUpdated', 'App\\Models\\User', 1, '{\"title\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u043f\\u0440\\u043e\\u0434\\u043b\\u0435\\u043d\\u0430\",\"message\":\"\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430 \\u043d\\u0430 \\u043f\\u043b\\u0430\\u043d \\u0412\\u043a\\u043e\\u043d\\u0442\\u0430\\u043a\\u0442\\u0435 \\\"PRO\\\" \\u0431\\u044b\\u043b\\u0430 \\u0443\\u0441\\u043f\\u0435\\u0448\\u043d\\u043e \\u043f\\u0440\\u043e\\u0434\\u043b\\u0435\\u043d\\u0430.\",\"category\":\"subscription\"}', NULL, '2024-12-22 14:12:35', '2024-12-22 14:12:35');





INSERT INTO `pricing_plans` (`id`, `name`, `slug`, `type`, `description`, `monthly_price`, `yearly_price`, `max_accounts_count`, `max_streams_count`, `active`, `most_popular`, `created_at`, `updated_at`) VALUES
(1, 'Вконтакте \"START\"', 'vk-start', 'vk-page', '<p>• Автотрансляция видео на вашу личную страницу.<br>• Мгновенный запуск повтора трансляций.<br>• Отложенный запуск цикла.<br>• Гибкая настройка.</p>', '350.00', '4200.00', 1, 1, 1, 0, '2024-04-23 11:25:05', '2024-11-23 22:51:57');
INSERT INTO `pricing_plans` (`id`, `name`, `slug`, `type`, `description`, `monthly_price`, `yearly_price`, `max_accounts_count`, `max_streams_count`, `active`, `most_popular`, `created_at`, `updated_at`) VALUES
(2, 'Вконтакте \"PRO\"', 'vk-pro', 'vk-page', '<p>• Автотрансляция видео на вашу личную страницу.<br>• Мгновенный запуск повтора трансляций.<br>• Отложенный запуск цикла.<br>• Гибкая настройка.</p>', '550.00', '6600.00', 1, 3, 1, 1, '2024-04-23 11:25:05', '2024-11-23 23:00:31');
INSERT INTO `pricing_plans` (`id`, `name`, `slug`, `type`, `description`, `monthly_price`, `yearly_price`, `max_accounts_count`, `max_streams_count`, `active`, `most_popular`, `created_at`, `updated_at`) VALUES
(3, 'Вконтакте \"VIP\"', 'vk-vip', 'vk-page', '<p>• Автотрансляция видео на вашу личную страницу.<br>• Мгновенный запуск повтора трансляций.<br>• Отложенный запуск цикла.<br>• Гибкая настройка.</p>', '850.00', '10200.00', 3, 9, 1, 0, '2024-04-23 11:25:05', '2024-11-23 22:51:57');
INSERT INTO `pricing_plans` (`id`, `name`, `slug`, `type`, `description`, `monthly_price`, `yearly_price`, `max_accounts_count`, `max_streams_count`, `active`, `most_popular`, `created_at`, `updated_at`) VALUES
(4, 'Истории \"START\"', 'istorii-start', 'vk-stories', '<p>• Автоповтор историй на вашу личную страницу.<br>• Мгновенный запуск повтора.<br>• Отложенный запуск цикла.<br>• Гибкая настройка.</p>', '250.00', '3000.00', 1, 1, 0, 0, '2024-05-08 05:37:52', '2024-11-23 23:31:57'),
(5, 'Истории \"PRO\"', 'istorii-pro', 'vk-stories', '<p>• Автоповтор историй на вашу личную страницу.<br>• Мгновенный запуск повтора.<br>• Отложенный запуск цикла.<br>• Гибкая настройка.</p>', '450.00', '5400.00', 1, 3, 0, 1, '2024-05-08 05:38:34', '2024-11-23 23:00:48'),
(6, 'Истории \"VIP\"', 'istorii-vip', 'vk-stories', '<p>• Автоповтор историй на вашу личную страницу.<br>• Мгновенный запуск повтора.<br>• Отложенный запуск цикла.<br>• Гибкая настройка.</p>', '750.00', '9000.00', 3, 9, 0, 0, '2024-05-08 05:39:11', '2024-11-23 22:51:57'),
(7, 'Группа \"START\"', 'gruppa-start', 'vk-group', '<p>• Автотрансляции в ваших группах ВКОНТАКТЕ.<br>• Мгновенный запуск повтора трансляций.<br>• Отложенный запуск цикла.<br>• Гибкая настройка.</p>', '450.00', '5400.00', 1, 1, 0, 0, '2024-05-08 05:47:00', '2024-11-23 22:51:57'),
(8, 'Telegram \"START\"', 'telegram-start', 'telegram', '<p>• Автотрансляции в ваших группах TELEGRAM<br>• Мгновенный запуск повтора трансляций.<br>• Отложенный запуск цикла.<br>• Гибкая настройка.</p>', '450.00', '5400.00', 1, 1, 0, 0, '2024-08-22 12:32:23', '2024-11-23 22:51:57'),
(10, 'Группа \"PRO\"', 'gruppa-pro', 'vk-group', '<p>• Автотрансляции в ваших группах ВКОНТАКТЕ.<br>• Мгновенный запуск повтора трансляций.<br>• Отложенный запуск цикла.<br>• Гибкая настройка.</p>', '650.00', '7800.00', 1, 3, 0, 1, '2024-09-22 12:15:49', '2024-11-23 23:00:30'),
(11, 'Группа \"VIP\"', 'gruppa-vip', 'vk-group', '<p>• Автотрансляции в ваших группах ВКОНТАКТЕ.<br>• Мгновенный запуск повтора трансляций.<br>• Отложенный запуск цикла.<br>• Гибкая настройка.</p>', '950.00', '11400.00', 3, 9, 0, 0, '2024-09-22 12:17:24', '2024-11-23 22:51:57'),
(12, 'Telegram \"PRO\"', 'telegram-pro', 'telegram', '<p>• Автотрансляции в ваших группах TELEGRAM<br>• Мгновенный запуск повтора трансляций.<br>• Отложенный запуск цикла.<br>• Гибкая настройка.</p>', '750.00', '9000.00', 1, 3, 0, 1, '2024-09-22 12:35:10', '2024-11-23 23:00:18'),
(13, 'Telegram \"VIP\"', 'telegram-vip', 'telegram', '<p>• Автотрансляции в ваших группах TELEGRAM<br>• Мгновенный запуск повтора трансляций.<br>• Отложенный запуск цикла.<br>• Гибкая настройка.</p>', '1050.00', '12600.00', 3, 9, 0, 0, '2024-09-22 12:35:47', '2024-11-23 22:51:57'),
(16, 'Tg+', 'tg', 'telegram', NULL, '100.00', '500.00', 3, 3, 0, 0, '2024-12-24 10:49:55', '2024-12-24 10:49:55');





INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('cMzuDEHX9EiqJwtJJ0ebiNehEByFINYukQuxmkt2', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiQWczRUhIZExuTUxucTBUNWNSWGZUUHJYS1hCOWdNakpZYTBtbW1zUSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjIxOiJwYXNzd29yZF9oYXNoX3NhbmN0dW0iO3M6NjA6IiQyeSQxMiRuMjR4anV6TmhBUVc1LjN4cTIvYVJlQVlZWlhkZVpyVk43a2FQeno3VWF2WjEzY1VvNlRsQyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHBzOi8vcnVzdHJlYW0udGVzdC9zdHJlYW1zL3RnLWNoYW5uZWwiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1735515041);


INSERT INTO `stories` (`id`, `user_id`, `title`, `duration`, `created_at`, `updated_at`) VALUES
(1, 2, '99988', 46, '2024-11-25 14:04:06', '2024-11-26 04:54:24');
INSERT INTO `stories` (`id`, `user_id`, `title`, `duration`, `created_at`, `updated_at`) VALUES
(5, 2, 'IMG_7096', 25, '2024-12-07 10:23:12', '2024-12-07 10:23:12');
INSERT INTO `stories` (`id`, `user_id`, `title`, `duration`, `created_at`, `updated_at`) VALUES
(7, 1, 'Евгений Жебанов - Клип @idi.t.suzun', 15, '2024-12-14 10:11:23', '2024-12-14 10:11:23');

INSERT INTO `streams` (`id`, `video_id`, `story_id`, `user_id`, `streamable_type`, `streamable_id`, `title`, `description`, `type`, `repeat_interval`, `payload`, `options`, `stats`, `is_active`, `is_online`, `pid`, `rtmp_url`, `rtmp_key`, `start_at`, `expires_at`, `next_at`, `play_count`, `view_count`, `created_at`, `updated_at`) VALUES
(16, NULL, 1, 2, 'App\\Models\\Social\\VkUser', 4, '99988', '', 'vk-stories', '30', '{\"id\": 456239094, \"date\": 1733891565, \"type\": \"video\", \"video\": {\"id\": 456239911, \"date\": 1733891564, \"type\": \"story\", \"files\": {\"src\": \"https://vkvd409.okcdn.ru/?expires=1734150765784&srcIp=5.35.82.91&pr=48&srcAg=UNKNOWN&ms=45.136.20.169&type=4&sig=UIUbt7kQgsk&ct=27&urls=185.226.53.139&clientType=13&appId=512000384397&id=7256584424004\", \"mp4_144\": \"https://vkvd409.okcdn.ru/?expires=1734150765784&srcIp=5.35.82.91&pr=48&srcAg=UNKNOWN&ms=45.136.20.169&type=4&sig=UIUbt7kQgsk&ct=27&urls=185.226.53.139&clientType=13&appId=512000384397&id=7256584424004\", \"failover_host\": \"vkvd302.okcdn.ru\"}, \"image\": [{\"url\": \"https://i.mycdn.me/videoPreview?ct=-30&id=7256584424004&idx=0&od=1&type=32&tkn=z_0VY6haMIstz2NVhpEvyzpOu-M&fn=vid_s\", \"width\": 130, \"height\": 96, \"with_padding\": 1}, {\"url\": \"https://i.mycdn.me/videoPreview?ct=-30&id=7256584424004&idx=0&od=1&type=32&tkn=z_0VY6haMIstz2NVhpEvyzpOu-M&fn=vid_m\", \"width\": 160, \"height\": 120, \"with_padding\": 1}, {\"url\": \"https://i.mycdn.me/videoPreview?ct=-30&id=7256584424004&idx=0&od=1&type=32&tkn=z_0VY6haMIstz2NVhpEvyzpOu-M&fn=vid_l\", \"width\": 320, \"height\": 240, \"with_padding\": 1}, {\"url\": \"https://i.mycdn.me/videoPreview?ct=-30&id=7256584424004&idx=0&od=1&type=32&tkn=z_0VY6haMIstz2NVhpEvyzpOu-M&fn=vid_x\", \"width\": 800, \"height\": 450, \"with_padding\": 1}, {\"url\": \"https://i.mycdn.me/videoPreview?ct=-30&id=7256584424004&idx=0&od=1&type=32&tkn=z_0VY6haMIstz2NVhpEvyzpOu-M&fn=vid_w\", \"width\": 405, \"height\": 720}, {\"url\": \"https://i.mycdn.me/videoPreview?ct=-30&id=7256584424004&idx=0&od=1&type=32&tkn=z_0VY6haMIstz2NVhpEvyzpOu-M&fn=vid_t\", \"width\": 320, \"height\": 569}, {\"url\": \"https://i.mycdn.me/videoPreview?ct=-30&id=7256584424004&idx=0&od=1&type=32&tkn=z_0VY6haMIstz2NVhpEvyzpOu-M&fn=vid_u\", \"width\": 720, \"height\": 1280}], \"ov_id\": \"8437074178116\", \"title\": \"\", \"views\": 0, \"width\": 1080, \"height\": 1920, \"can_add\": 0, \"duration\": 46, \"owner_id\": 194783300, \"is_author\": true, \"access_key\": \"804fe92bce210e3d17\", \"can_dislike\": 1, \"description\": \"\", \"first_frame\": [{\"url\": \"https://i.mycdn.me/getVideoPreview?id=7256584424004&idx=0&type=39&tkn=5Vd_ty4i307SqP3NPRgC5ClE4Nc&fn=vid_f\", \"width\": 227, \"height\": 405}, {\"url\": \"https://i.mycdn.me/getVideoPreview?id=7256584424004&idx=0&type=39&tkn=5Vd_ty4i307SqP3NPRgC5ClE4Nc&fn=vid_md\", \"width\": 151, \"height\": 270}, {\"url\": \"https://i.mycdn.me/getVideoPreview?id=7256584424004&idx=0&type=39&tkn=5Vd_ty4i307SqP3NPRgC5ClE4Nc&fn=vid_d\", \"width\": 75, \"height\": 135}, {\"url\": \"https://i.mycdn.me/getVideoPreview?id=7256584424004&idx=0&type=39&tkn=5Vd_ty4i307SqP3NPRgC5ClE4Nc&fn=vid_sm\", \"width\": 40, \"height\": 72}, {\"url\": \"https://i.mycdn.me/getVideoPreview?id=7256584424004&idx=0&type=39&tkn=5Vd_ty4i307SqP3NPRgC5ClE4Nc&fn=vid_w\", \"width\": 405, \"height\": 720}, {\"url\": \"https://i.mycdn.me/getVideoPreview?id=7256584424004&idx=0&type=39&tkn=5Vd_ty4i307SqP3NPRgC5ClE4Nc&fn=vid_h\", \"width\": 303, \"height\": 540}, {\"url\": \"https://i.mycdn.me/getVideoPreview?id=7256584424004&idx=0&type=39&tkn=5Vd_ty4i307SqP3NPRgC5ClE4Nc\", \"width\": 405, \"height\": 720}, {\"url\": \"https://i.mycdn.me/getVideoPreview?id=7256584424004&idx=0&type=39&tkn=5Vd_ty4i307SqP3NPRgC5ClE4Nc\", \"width\": 1080, \"height\": 1920}], \"can_download\": 0, \"response_type\": \"full\", \"can_play_in_background\": 1}, \"views\": 0, \"can_ask\": 0, \"can_see\": 1, \"privacy\": \"all\", \"replies\": {\"new\": 0, \"count\": 0}, \"can_hide\": 1, \"can_like\": false, \"no_sound\": false, \"owner_id\": 194783300, \"can_reply\": 0, \"can_share\": 1, \"access_key\": \"story\", \"expires_at\": 1733977965, \"track_code\": \"story/3AAQAc4LnChEAs4bMaf2A84LnChEBAAFoAagB6AIAA==\", \"can_comment\": 0, \"likes_count\": 0, \"reaction_set_id\": \"reactions\", \"narratives_count\": 0, \"can_ask_anonymous\": 0, \"can_use_in_narrative\": true}', '[]', NULL, 1, 1, NULL, NULL, NULL, '2024-12-11 04:32:44', '2024-12-11 04:33:31', '2024-12-11 05:03:31', 1, 0, '2024-12-11 04:32:44', '2024-12-11 04:32:45');


INSERT INTO `subscriptions` (`id`, `pricing_plan_id`, `user_id`, `start_at`, `trial_ends_at`, `ends_at`, `type`, `auto_renew`, `frequency`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 2, 1, '2024-12-22 14:12:35', NULL, '2025-01-22 14:12:35', 'vk-page', 1, 'monthly', NULL, '2024-12-22 14:09:19', '2024-12-22 14:12:36');
INSERT INTO `subscriptions` (`id`, `pricing_plan_id`, `user_id`, `start_at`, `trial_ends_at`, `ends_at`, `type`, `auto_renew`, `frequency`, `deleted_at`, `created_at`, `updated_at`) VALUES
(3, 7, 1, '2024-12-24 10:23:18', NULL, '2025-01-24 10:23:18', 'vk-group', 1, 'monthly', NULL, '2024-12-24 10:23:18', '2024-12-24 10:23:18');
INSERT INTO `subscriptions` (`id`, `pricing_plan_id`, `user_id`, `start_at`, `trial_ends_at`, `ends_at`, `type`, `auto_renew`, `frequency`, `deleted_at`, `created_at`, `updated_at`) VALUES
(4, 16, 1, '2024-12-24 10:50:08', NULL, '2025-01-24 10:50:08', 'tg-channel', 1, 'monthly', NULL, '2024-12-24 10:50:08', '2024-12-24 10:50:08');





INSERT INTO `tg_users` (`id`, `user_id`, `tg_id`, `phone`, `name`, `avatar_url`, `token`, `expires_at`, `payload`, `is_banned`, `is_active`, `is_in_page`, `is_in_stories`, `created_at`, `updated_at`) VALUES
(1, 1, 1045032580, '79895123444', 'lexter_wayne', NULL, NULL, NULL, NULL, 0, 1, 1, 0, '2024-12-25 19:23:27', '2024-12-25 19:23:27');


INSERT INTO `users` (`id`, `name`, `email`, `login`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`, `balance`, `partner_id`, `phone`, `sex`, `referral_link_count`) VALUES
(1, 'Alex', 'info@albus-it.ru', 'info', NULL, '$2y$12$n24xjuzNhAQW5.3xq2/aReAYYZXdeZrVN7kaPzz7UavZ13cUo6TlC', NULL, NULL, NULL, 'Uv5gylMTcUcEtmP3Vrtrg4Eptw2gtVrVJBqzY0hke8CiAttdY9N5LQ1bYb0T', NULL, NULL, '2024-11-23 22:50:01', '2024-12-24 10:50:08', '0.00', NULL, NULL, NULL, 2);
INSERT INTO `users` (`id`, `name`, `email`, `login`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`, `balance`, `partner_id`, `phone`, `sex`, `referral_link_count`) VALUES
(2, 'Евгений Жебанов', 'jorikjada@gmail.com', 'jorikjada', NULL, '$2y$12$/726d4d3ZAEC0MPqJZjkhurWq/FcoqN3XDXxINJvvt3ezbWMsddku', NULL, NULL, NULL, 't2od1bW5ZqZ6Rep5D1fYazSr9wFo38ybfXBjVMAGqheDtksmC1l2xUGMcL25', NULL, 'profile-photos/4Gpjvb9dg1VzMh4qmHGTFtNzQ1vcl3SiVdod0cIZ.jpg', '2024-11-25 00:18:46', '2024-11-27 15:19:33', '7300.00', NULL, NULL, NULL, 0);


INSERT INTO `videos` (`id`, `user_id`, `title`, `description`, `duration`, `created_at`, `updated_at`) VALUES
(5, 1, 'TestVideo', '', 269, '2024-12-14 10:03:15', '2024-12-14 10:03:16');
INSERT INTO `videos` (`id`, `user_id`, `title`, `description`, `duration`, `created_at`, `updated_at`) VALUES
(6, 1, 'WSL СЕРВЕР', 'Работа WEB сервера на WSL', 301, '2024-12-20 20:44:04', '2024-12-20 20:44:23');
INSERT INTO `videos` (`id`, `user_id`, `title`, `description`, `duration`, `created_at`, `updated_at`) VALUES
(7, 1, 'Y2mate_mx_Король_и_Шут_&_Хатсуне_Мику_Кукла_колдун', '', 228, '2024-12-25 13:48:54', '2024-12-25 13:48:55');

INSERT INTO `vk_groups` (`id`, `vk_id`, `name`, `avatar_url`, `user_id`, `vk_user_id`, `in_dashboard`, `created_at`, `updated_at`) VALUES
(1, '226343814', 'Waynelogic', 'https://sun7-19.userapi.com/impf/XflwIQpiW7eTSf95MQ-Nver647DeVm2WJTC3rw/H-QugqVUlkA.jpg?quality=96&as=32x32,48x48,72x72,108x108,160x160,240x240,360x360&sign=61027d210ccb0a59d7af739beb9110ba&u=aNilTjpajNGXznoAFiBsCyhWBvZZx5t-H0ovp9gVz-s&cs=200x200', 1, 5, 1, '2024-11-27 03:27:47', '2024-12-25 13:49:03');
INSERT INTO `vk_groups` (`id`, `vk_id`, `name`, `avatar_url`, `user_id`, `vk_user_id`, `in_dashboard`, `created_at`, `updated_at`) VALUES
(2, '224246563', 'НА КАРТУ', 'https://sun1-91.userapi.com/s/v1/ig2/he5V39ETlIQyAt4Yd3ImEOck2DTVOxMrv7OaKQcvZ6i4PJr8LqW5_lXVhxxpJxHvPIS_Dsa2aQ-aljdH8YD9R8k5.jpg?quality=95&crop=126,0,1013,1013&as=32x32,48x48,72x72,108x108,160x160,240x240,360x360,480x480,540x540,640x640,720x720&ava=1&cs=200x200', 2, 3, 1, '2024-11-27 15:16:51', '2024-11-27 15:16:51');
INSERT INTO `vk_groups` (`id`, `vk_id`, `name`, `avatar_url`, `user_id`, `vk_user_id`, `in_dashboard`, `created_at`, `updated_at`) VALUES
(3, '199798589', 'SENLER РАССЫЛКИ', 'https://sun1-88.userapi.com/s/v1/ig2/MUqI8okXlIgQrS4ILdgkH2zqBMwi_2P-WZInj0h8vzmc56is8K-BleJqlYI1xLscEHLs72BkETOryEka71VmjUxe.jpg?quality=95&crop=47,11,573,573&as=32x32,48x48,72x72,108x108,160x160,240x240,360x360,480x480,540x540&ava=1&cs=200x200', 2, 3, 1, '2024-12-02 06:36:44', '2024-12-02 06:36:44');

INSERT INTO `vk_users` (`id`, `user_id`, `vk_id`, `full_name`, `first_name`, `last_name`, `avatar_url`, `email`, `phone`, `sex`, `refresh_token`, `access_token`, `device_id`, `id_token`, `expires_at`, `payload`, `is_banned`, `is_active`, `is_in_page`, `is_in_stories`, `created_at`, `updated_at`) VALUES
(1, 1, '26139415', 'Александр Пригода', 'Александр', 'Пригода', 'https://sun7-20.userapi.com/s/v1/ig1/TOZWc-0sKtBlIM8B9ct4s5RICSXhyBrsYME0QT1KJbB-TyFDeOgx5DPe9lFlEi91BHdQb5t3.jpg?quality=96&crop=0,320,828,828&as=32x32,48x48,72x72,108x108,160x160,240x240,360x360,480x480,540x540,640x640,720x720&ava=1&cs=50x50', 'prigoda.ad@gmail.com', '79895123444', NULL, 'vk2.a.EcipOP_Xi76nQR8G5FhYl_jnwgtHdTuhpd3GaLDwoGbAunvQZKt4gFmWz0CT3o6krRvky0LyARRRObEV1OkoCc0ht-GUzMXyTRTtRoV2yPVNfbTjBSi93ysGfNRQHZ-x5ZQWbe4V2uRUFB3CTlkO9BoShMotgBFksvPqAw-YpcdbSIXqyQxjLP2beKO1bDGYPvda7RIaTaXhLgUbyy0ULSkhoIfFWDcVkWGGHoNP7yBd4adiJ2u5WYPG9wtSx6Tz', 'vk2.a.gpwn0Po_z7Ym88V0uHWYKXWps8oXG1m-a17BPk4-ek416ElZYQpJaMFT4Q7WqbWPNBp4Vm2DlacLQ69_ME80PElbTtMsacjRumypDYDkp348QcXY_3LZ3iB5STy84_Mb7loNNH1TZBiy4slCaiUmWm50tJSuom75K302U0Ybw99rVzimVY0Z2wiSa8bV5FJvi3axEJKPqTyvoHohoz3q0ITfSHm3w7w11HPeCddzPcAf1xz9xZRM4jMwy8g9oyjl', 'TD-c4ShFFO9TJj1_I-YwIlCCyAsH9oVy4UXFFzyNaXGddJVQPViGZNgj_oJZZTf0yEjAyc46XcnUcgokc54VOA', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpaXMiOiJWSyIsInN1YiI6MjYxMzk0MTUsImFwcCI6NTE4NzAxNjIsImV4cCI6MTc2NTk3MDEyNSwiaWF0IjoxNzM0ODY2MTI1LCJqdGkiOjIxfQ.ADhWNRg83vMfrBKcl_m5ubmDEohkDoiC-HBUa7r5rj1x64Fcm6KWIfau-aASYW3tFzUjCaw2qxwktkvFu87wMaVADAko75CbOV9nIzFDhlojmSjqydMjFlBict21SReJFSXI3PsVy4TX4xt4SuofVKa9hnQnP2iN4BN3oiBgi-sehCRxoLjwqXKycuymuE67JCFA5gxIxK2fe6RMVpN6M6erJWSBe7jG3y5UKfF_jvWiKwP6wAGfI9cWRmVsUMkkp3OzMuqm_ubloAdN3z9zgo8ZOIaae2j22g5dRuUR8ch7PG9ro0acbSjBrMS3llmLa3Q9QaC412MpXmw4bsEKQfBCTMP7VECHdub8OJJhKQSb6x3F9XxcndwrJ64o5wCI6bY-qc6F2MudqMK265uUHDqZBBWSmqRybpYsyr9YxK_gsW6mFMOsrl7wXDlFQizjfs-lYB3siar5GC5NoX9g1YJ_tiB8UEk6ITMdfxrcAitfPI-VFB-I-bHYkgJW2BXUYFxBF1OKYuoOTg00WQa9UzNnnPjL48JT8kUhJGgatu9x2XTfjCR_LJfJkiOnlwjfwZAX8CAwx9RW2in9iOr2l_CpLluT9vx-k3DDrUSGspx91HXjuWrN6BvdsJTU9Xk8IkxReE7ECsnvdt8LeU3Bw0wSJ35YY0sOUraGdQQXnBs', '2024-12-22 12:15:28', NULL, 0, 1, 1, 0, '2024-11-25 03:38:27', '2024-12-22 11:15:28');
INSERT INTO `vk_users` (`id`, `user_id`, `vk_id`, `full_name`, `first_name`, `last_name`, `avatar_url`, `email`, `phone`, `sex`, `refresh_token`, `access_token`, `device_id`, `id_token`, `expires_at`, `payload`, `is_banned`, `is_active`, `is_in_page`, `is_in_stories`, `created_at`, `updated_at`) VALUES
(2, 2, '629525359', 'Egor Anatolevish', 'Egor', 'Anatolevish', 'https://sun1-90.userapi.com/s/v1/ig2/9ZLq87T6nYIg9PI6Yyb0cJck_N1bvpPAJlKqWwxvbzD73hF5GyjP2acRkQIIk1mDMqhO5_UN8JGsF_j5JL_eq7NC.jpg?quality=95&crop=0,0,1080,1080&as=32x32,48x48,72x72,108x108,160x160,240x240,360x360,480x480,540x540,640x640,720x720,1080x1080&ava=1&cs=50x50', 'eabond1993@mail.ru', '79513901386', NULL, 'vk2.a.Sg4i5GqTtEn-zjLS3i2PkHMfl9-6bJNyR0IR1XuNRI9YyKcAjT6kMRukakmqhrMlr0C-OxB58DsodyB-pebFLsmf4v1QBE_xm0dK_WPZvL65tOF4aNwJD1dBspO3yMc7iU8hq3Yn1MiPIvRar_S3LfP5U_xIiOmECnNqHDphI3OyDPUY-zU-2eXHMlQeyV3--2LLZ2HAhVHHtCZNJTX5pnhmlQiBpA8eO462b02tVZIPG4--a0TlVt15nkTmg5Ym', 'vk2.a.P1qwNJNZSZ-LK5UOAyZ3IlvTDk7bZgpbl28i7hc2rSMHEQLcT5Oh4pXxFkipJucIJFWZwxfvGNo_G6qq-MVZh1Edu-H11pP0D_deDkaBQheWReDHbe1X_4ZwEO3PvJQsLMbbf94zpIK0gqJ3VoFabppv2mbpYhp9NIhMx2-2jsSokxWBa0v8GVW5a9G8qTX8DPy2Z6Ql95vGt5T6A9_xUzPyGpYWFDiuiJ_kiqRzdvyRE5gm5GtxBAgHhafr0MtC', 'UvlCJAR-htLm-oKThLvjORcp9VZvgKnjgVWp6jc64zk4GxsQinUJk3ue8gXFKybGGFLzqq4s5oyZqSNGW8YQUw', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpaXMiOiJWSyIsInN1YiI6NjI5NTI1MzU5LCJhcHAiOjUxODcwMTYyLCJleHAiOjE3NjM2MTI5NTMsImlhdCI6MTczMjUwODk1MywianRpIjoyMX0.IdY7SWeMexlDd80cxqScp-7WO7y-b9Arb1NbRHg5gZ0o8ki12duH-uEp_cfWfJoy9P1K2AysKlxG1gPdwh3gTRk-PRVNfqUQUxK9W37VWdlObABt9pfnghyDcS7YHb3xyyko65-4uYCmt77jciGfDwr1gXup4Oh-wxsbsFn2r_K3p9nnNf7nbqx9TQD-xVjs1ycr1eTHvSKviGpLUmIzLzKTGRK4hk6rrhWPlEJSMdVpegnLZZ-NqxJTHSH6AsCLCU9cDnzTFDwwhTDWDYMFxopEGrUGB-le7P0cUmiT53QIH99CFmmRv9wfT6LRpL0A-AFLAAVEaMcS3uf4OyPC7fnhTKlU9SE216PTFNFXVsCYgvUkFcHNUkGSIK5vmvrO8gRn_m1jpmN2eIyxBmM_5cSwexEztfiyTD6EdnPv_a1E-W0Bq35PBHNADJ0lv9rBBgKL3QifyramiF2kWDnA956voQJljznCV_vz1yDwCEdq90EnbcJDKJovEiwl7ADC4jOxulIci_OZygGp29-_CzO54S1KiQRq_FlRYN7fnv0fPy0dehOZxASR4_fCw3gcc8AckOhR6EjNwinLBvMPQhUHqZvD2ZvN4uHbeh3vYgW426LWxnlNg5u_YAc8mEzZWV0YPgUb1C7rRzM2kBtvW5HjN3ruuMDEWkhZiuSSzII', '2024-12-02 07:34:20', NULL, 0, 1, 1, 0, '2024-11-25 04:29:13', '2024-12-02 06:34:20');
INSERT INTO `vk_users` (`id`, `user_id`, `vk_id`, `full_name`, `first_name`, `last_name`, `avatar_url`, `email`, `phone`, `sex`, `refresh_token`, `access_token`, `device_id`, `id_token`, `expires_at`, `payload`, `is_banned`, `is_active`, `is_in_page`, `is_in_stories`, `created_at`, `updated_at`) VALUES
(3, 2, '316657931', 'Евгений Жебанов', 'Евгений', 'Жебанов', 'https://sun1-23.userapi.com/s/v1/ig2/fA6LszbVHZEXcXlIbA3IuTT0jzYDuJck1tfbyEXpBEPV5Dwo2AplTGLjZyrubZXS7j0Y-TqKwWaYvrvcAkTh2w67.jpg?quality=95&crop=3,0,2169,2169&as=32x32,48x48,72x72,108x108,160x160,240x240,360x360,480x480,540x540,640x640,720x720,1080x1080,1280x1280,1440x1440&ava=1&cs=50x50', 'zhebanov_yevgeniy@vk.com', '79133612825', NULL, 'vk2.a.SeJ7zndrhvSoajxJP6jwX16AczFCj6NOLPtn1PqUX_3J27Jx1ddI2DqyjpSRxw9UEWcsyoEY1RUBxb9ix47E0XJ2Yd0FxBvE3h9QquGs4hc8esWtjoqEQ262VRW-ARoInS_P_vFZoNj7wr35l-1DoGzYhPVD71dZtD9XTk3C68RvC5QprReZzKENBctRhqg0cFdLzvGPpuvZQY_rggQ_yPCKuQbDmYKF0tDHRE2kVPi1nGYiR4isD2UvXA6wOEyd', 'vk2.a.W_zGct5UYGQjW8VwxcoLfH1IfrHv-3lq8cs_ecLe5UKSjKiG4FqD7DsuTSmywYvgRLtKF3FuG3EUQMQbjY33_UJdWkx_9wvPfKyHc8A_95K0cs8T-jF1NK8neqwxN3FFwwvNiavDW0lxfx5WmXKsf3chJgHA5oIDZZpWxaoBhjYbfTX48mEro2YHcAd8LECFbJHka5_gCtx0Ljby9inpPUxtINIrdEorFumUO_b3qm2ja7AQyc_DNDNaWqf52kXf', '-TRs1Bndukf6k7xKC8LhBEfh45wBvisC2SGj_e0akqAgVsgUtXHEpOVEcIsdofEVdiMqeWP37d_0qa3EO19nrg', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpaXMiOiJWSyIsInN1YiI6MzE2NjU3OTMxLCJhcHAiOjUxODcwMTYyLCJleHAiOjE3NjM2MzQ5MDQsImlhdCI6MTczMjUzMDkwNCwianRpIjoyMX0.MhROD0n3O5Zwyj_jdm9jTkqPOXSWBBXhO1g7TKdgzbZI4uxzIabGbaesKFqJN1Fg4l9VkYgPkih2NNTQ5jI2PcXVFo1QL2l1X2tngnsJGmyy8A8JlQCbawYCp8AGWL3Nec_JBF7o3W-0BcSFo188ga-InUK4HG0JMYBJU5UGMSERKkzzg3j5JrztO6_v0tNwggOFtBSLYBCy-NPZ-Ih09tGpZKzLsEuAEM-4Lt8wonvK3xlDzlGCgFGtDHmiItPK-1B-vAYTE5OIuuNrsLJMw4yiOWdItRVdapTxV-XUTITsdcqO4wApQL-YDovO687LEJnI7ce_aR03442Ia3ImaOYgP-HEn1-8mKqD6_HgkCxWM179hYF0nN5cj5BiNtBMU0r-Kn9rBL7o4BdFlEoijf9QHHtUHOrHaGe6w7HGfGKLebTd32m2x_d6lYSB6Ny7qUK6fmKxpyHPuzm-BoTY1rnFoans7JGDGnOwY_Zh28XDpLZQoMA7P3w-IjzcKdylsv-vo7uZ0Z4AlChJKiAujH5Ue8e1BWO_yggthPzg7GD9K8A5t38Ax69D4QheO2Pl7FkQ9kHzX6bveZzgJdnMhVQ8C6k8pAgR-44-zeZNqyudXySFSiyzaOf6t9fvF4rnaDUER520OPmcSH4IMH7H4tc0Zc9Awb3HYxsWW852ezM', '2024-12-02 07:34:21', NULL, 0, 1, 1, 0, '2024-11-25 10:35:04', '2024-12-02 06:36:13');
INSERT INTO `vk_users` (`id`, `user_id`, `vk_id`, `full_name`, `first_name`, `last_name`, `avatar_url`, `email`, `phone`, `sex`, `refresh_token`, `access_token`, `device_id`, `id_token`, `expires_at`, `payload`, `is_banned`, `is_active`, `is_in_page`, `is_in_stories`, `created_at`, `updated_at`) VALUES
(4, 2, '194783300', 'Ирина Жебанова', 'Ирина', 'Жебанова', 'https://sun1-87.userapi.com/s/v1/ig2/e3zXiexgJLH-RTIEK2zSuz0Hbr1f2ZE6qyJYFHNaY0HS25nIxaIGdLmjcYP4IAq-rCFIk_ZnofQvC9mhcLg6ff5P.jpg?quality=95&crop=0,0,2160,2160&as=32x32,48x48,72x72,108x108,160x160,240x240,360x360,480x480,540x540,640x640,720x720,1080x1080,1280x1280,1440x1440&ava=1&cs=50x50', '', '79969519457', NULL, 'vk2.a.IFcL9wNm2sQjGtowmMs6pH-m_e3c3UAE-Wao3toldl-O6ADJzodUdXRr534iPRWAqY_mRr_F2XQqJcQE8h92ERnJ7R8jO0JmReg8-BIjwp-067TBOo8qdFKzaZJfoWWvMbBiCA9goWgvjs6ollozLxRT_HlCZ9aRVAesPvTc-wpumbaHiul9DDZloP9gbPry2zcZpw0TgDy9lyuEy_gImwjV6DEKKZiPF8szkT2Zy1KbWHwAZ1mF54c4JJVNBmWo', 'vk2.a.3JDi7_uhrq0Ggf56XbPhA07Y6p2HkyRc5SJBfn9w4f5aN0nhc9iyv1GGQU1eW-7Q-DESIo8uq9kkFwB7Yuf6o_LB-mYT5RY-jW6y5CxUZnKwOfGyeYkMVrX8C52EnczmcOVjLbQFwlWj7deB-6fHX0LWbCCRmtOMerns1lJP8Xe3-SVy4yVlDncFMWg5OvJ-6jbodWyl1kkRwYAofi3-1JTbw3HjOwsi2EB3hwEqe34uBfGJFml3cxaIwhuWBWtN', '9oLePAw8Ztpv-EZ3K6oNs0a8EJb8IFvcBACtPfH7P8RYJhEGe2OYvpvETwf5ACAUUGt2JSbzPswnhzICc7uKow', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpaXMiOiJWSyIsInN1YiI6MTk0NzgzMzAwLCJhcHAiOjUxODcwMTYyLCJleHAiOjE3NjM2NDY1ODIsImlhdCI6MTczMjU0MjU4MiwianRpIjoyMX0.kDN9vosKamNxIE20eaTVVAawFf1QFL4d8vjsRyTF1qHOYKJcbxZ3ooyqcw1LMapze4o8Fu9NTBJ_dEqiQ6baNy69H2TzGWHXqXPbix6Z4Lo_86HIgxDuf-4qxXQuGX39IJizBRSk732WzLsQkEb14E1FJO28Tkj1sXBKVVZ25Ajdo1IG-1fI92EX51ZNbO4Zgf5sbuRyzHGQBoV9FFTWhUTNGOodmmIEH9oyRUAYY3WfAzTmfx1ySVc4O2YhHbCfkUURgtC5536jSAgRNbQ4j_cuArT85hk7cjAcGjSMCJHMTwT1gAFplWAiFkcnTtLT8mDG-YicSQSCZ01aiG-drpVfXcCl69k1Oau0C0kXrM2xU54TGnpOzxkwEGM22qC7wVCKxit5Ps6GxCcqEUhDgRCwEgMfyMRGIkCZDO0dnrzLzgFX6NgQvT9iMUJkF9417Bm73veMAvTKOxCwo9v-sMgAFZ9EFExSLk6jw_WYALZV3Hs-Y_Yn4iCeuY3eTfzBP_YAmFDQuL30fXdaQFthU9W-ze26U668kOPS22-y45bRnPr6TL3EfSgwEK4FNI0GmtTZM1t9sSsqJzSmxmj0HsbVzylDk8M5KoeeqFDJI15clLix7vd1_tP7yFs9zfbZ6T9q2m7AWtQQKgefubhP-Vz-KfsZ4yF58gVp38KH8qY', '2024-12-11 05:32:44', NULL, 0, 1, 1, 1, '2024-11-25 13:49:42', '2024-12-11 04:32:44'),
(5, 1, '853060809', 'Bruce Wayne', 'Bruce', 'Wayne', 'https://sun7-22.userapi.com/impf/DW4IDqvukChyc-WPXmzIot46En40R00idiUAXw/l5w5aIHioYc.jpg?quality=96&as=32x32,48x48,72x72,108x108,160x160,240x240,360x360&sign=10ad7d7953daabb7b0e707fdfb7ebefd&cs=50x50', '', '79897090215', NULL, 'vk2.a.v3BOF4zchWa7VtmPiBBwTlFqL2KiE_nJchxjBdPbgUvodRMqIQcxXpCRssAwazGIzp2LOLPywJf8bzU_pIChCe33nCDIbI4EjTj_HLc91qMDxMmLG9eoj5PbeyKrzXboJBKgQoj3yzVkgUbQHJHLiW0z4pelAASNqgSpVBiAvZ3WgyvICMVc9fwQwAVcS1jYZmPygv23eazTDDH9VxfiZqU89cf3ENTUT1GtfYbDspSOmrClHkBd_tkCFJ7KGMnt', 'vk2.a.RkupaxzikePH1gvc7o0XY1nIPhbXqSqOAe63tr5kIPs2AR0hk1EsS1i-XSTm9C9Z2f08Bw4VkFrvZPKpUwtUxZE9Q5dMEuFzIGy-osEuaA7wiCRMsHJjApbHi7PJu2a09HZ1iV-zD37nKuJufu01ReTD4WbcxuWvWFxcyGpMWMmVfGT0dvBbNdu0ihvpTUaC13OOvpJvtr3M1VurvF_5anr0mzEczUN2nYiyrTIXe-3gjVKmtAo6g2UQFiYyZRRF', 'RvFHtVn-cTHjWyChsHbZVzQr7TmxdCiSRECZWoG4SNLN-61oc6nlUq9nuEAP37U9MLii3Vtb9egG_KivpxtibA', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpaXMiOiJWSyIsInN1YiI6ODUzMDYwODA5LCJhcHAiOjUxODcwMTYyLCJleHAiOjE3NjU5NzAwMjQsImlhdCI6MTczNDg2NjAyNCwianRpIjoyMX0.sEOizkJf1yJocO-FHoh821lYNNJ_49C2XSXqg_ZYahE_FeiVF4hpSR1gCjurrdoGkwftJNzJaSLxRjMkE46rF851D3fbJjEmw412dqCWDFSP-9joPrHhJZ6wDYf23hoGlc_HGwtUid9voFIj7STgMVkl-U5oYZah2WOGyCYJZr9krSira-46WQkCO3UeV68TnkpIZVdAvcyt1LE_sts43CqJxs6xKdTdwWiW9SOyuHKh-MAnQOfY3obMQ-INLOeF702yDpK0l8ONIGVQ74KShnDetyv9U1IQ7kYSKlMZY3yG11LLUWXmt2EQ8PCPE7sT4UYO_WAv2FbxQipFS4ZWq4BXLmcDToOtgw7jEb_moH-grtznVlL-L94w-KAD_0VVe_gZctz-zSI4fQmIXr6t7mMp7MQavmzT2ZMyuzt5NBFraMpMP3_hNxaomG311NaEj34gTcVFI4SyszAEJFSqr8_ahLJ7SeiA2OZkPIAI6iu60O4ZQQulWs4pIHdCyQwZLbWghHVNwji2dZeriHu5Xd-H8hnc_OQLQVj1k1eWliWfU4pkjuMe23-_tMfPN8Q57vRBdfltkWejHEtQ32uKixaDP306jvTeeVUAX_dar7zB6iaGUUGO4RfdzaS7asU_SLUi4Dx4YHQLduNh9JuKybQfLUoMFGH8_NDA0UpwuwU', '2024-12-25 14:49:10', NULL, 0, 1, 0, 1, '2024-11-27 03:17:58', '2024-12-25 13:49:10');


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;