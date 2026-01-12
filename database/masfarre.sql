-- --------------------------------------------------------
-- Host:                         /media/quileab/Shared3151/qb/innodesign/masfarre-backend/database/database.sqlite
-- Server version:               3.46.1
-- Server OS:                    
-- HeidiSQL Version:             12.14.1.1
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES  */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping data for table database.budget_product: 12 rows
/*!40000 ALTER TABLE "budget_product" DISABLE KEYS */;
INSERT INTO "budget_product" ("id", "budget_id", "product_id", "quantity", "price", "notes", "created_at", "updated_at") VALUES
	(2, 1, 8, 1, 45, '', '2025-07-01 00:00:38', '2025-07-01 00:00:38'),
	(3, 1, 10, 1, 180, '', '2025-07-01 00:06:41', '2025-07-01 00:06:41'),
	(4, 1, 13, 1, 120, '', '2025-07-01 00:07:05', '2025-07-01 00:07:05'),
	(5, 1, 5, 6, 70, '', '2025-07-01 00:07:13', '2025-07-01 00:07:13'),
	(6, 2, 3, 1, 25, '', '2025-07-01 00:23:18', '2025-07-01 00:23:18'),
	(7, 2, 9, 10, 200, '', '2025-07-01 00:23:32', '2025-07-01 00:23:32'),
	(8, 2, 15, 2, 130, '', '2025-07-01 00:23:50', '2025-07-01 00:23:50'),
	(9, 2, 7, 2, 30, '', '2025-07-01 00:24:04', '2025-07-01 00:24:04'),
	(10, 1, 4, 4, 100, '', '2025-07-01 00:32:23', '2025-07-01 00:32:23'),
	(11, 3, 7, 2, 30, '', '2025-07-01 12:40:35', '2025-07-01 12:40:35'),
	(12, 3, 5, 4, 70, '', '2025-07-01 12:40:40', '2025-07-01 12:40:40'),
	(13, 3, 8, 6, 45, '', '2025-07-01 12:41:37', '2025-07-01 12:41:37');
/*!40000 ALTER TABLE "budget_product" ENABLE KEYS */;

-- Dumping data for table database.budgets: 4 rows
/*!40000 ALTER TABLE "budgets" DISABLE KEYS */;
INSERT INTO "budgets" ("id", "admin_id", "client_id", "name", "date", "event_type_id", "notes", "total", "status", "created_at", "updated_at") VALUES
	(1, 1, 8, 'Just wanna have fun!', '2025-07-30', 3, 'Fiesta de prueba', 1165, 'draft', '2025-06-30 23:52:29', '2025-07-01 00:32:23'),
	(2, 1, 9, 'Señora de las 4 décadas', '2025-11-22', 3, 'Dijo Arjona', 2345, 'draft', '2025-07-01 00:22:52', '2025-07-01 00:24:04'),
	(3, 1, 12, 'Fifteen', '2025-08-02', 1, 'Ver por mas pantallas led, entelado', 610, 'approved', '2025-07-01 12:40:01', '2025-09-26 15:22:28'),
	(4, 1, 11, 'Fiesta Carioca', '2025-07-03', 5, 'Conseguir batucada', 0, 'draft', '2025-07-03 00:54:43', '2025-07-03 00:54:43');
/*!40000 ALTER TABLE "budgets" ENABLE KEYS */;

-- Dumping data for table database.cache: 0 rows
/*!40000 ALTER TABLE "cache" DISABLE KEYS */;
/*!40000 ALTER TABLE "cache" ENABLE KEYS */;

-- Dumping data for table database.cache_locks: 0 rows
/*!40000 ALTER TABLE "cache_locks" DISABLE KEYS */;
/*!40000 ALTER TABLE "cache_locks" ENABLE KEYS */;

-- Dumping data for table database.categories: 4 rows
/*!40000 ALTER TABLE "categories" DISABLE KEYS */;
INSERT INTO "categories" ("id", "name", "created_at", "updated_at") VALUES
	(1, 'Sonido', '2025-06-30 23:39:45', '2025-06-30 23:39:45'),
	(2, 'Iluminación', '2025-06-30 23:39:45', '2025-06-30 23:39:45'),
	(3, 'Pantallas LED', '2025-06-30 23:39:45', '2025-06-30 23:39:45'),
	(4, 'DJ/VJ', '2025-06-30 23:39:46', '2025-06-30 23:39:46');
/*!40000 ALTER TABLE "categories" ENABLE KEYS */;

-- Dumping data for table database.event_types: 5 rows
/*!40000 ALTER TABLE "event_types" DISABLE KEYS */;
INSERT INTO "event_types" ("id", "name", "color", "created_at", "updated_at") VALUES
	(1, 'Cumpleaños de 15', '#000000', '2025-06-30 23:39:45', '2025-06-30 23:39:45'),
	(2, 'Casamientos', '#000000', '2025-06-30 23:39:45', '2025-06-30 23:39:45'),
	(3, 'Fiestas', '#000000', '2025-06-30 23:39:45', '2025-06-30 23:39:45'),
	(4, 'Eventos', '#000000', '2025-06-30 23:39:45', '2025-06-30 23:39:45'),
	(5, 'Otros', '#000000', '2025-06-30 23:39:45', '2025-06-30 23:39:45');
/*!40000 ALTER TABLE "event_types" ENABLE KEYS */;

-- Dumping data for table database.failed_jobs: 0 rows
/*!40000 ALTER TABLE "failed_jobs" DISABLE KEYS */;
/*!40000 ALTER TABLE "failed_jobs" ENABLE KEYS */;

-- Dumping data for table database.job_batches: 0 rows
/*!40000 ALTER TABLE "job_batches" DISABLE KEYS */;
/*!40000 ALTER TABLE "job_batches" ENABLE KEYS */;

-- Dumping data for table database.jobs: 0 rows
/*!40000 ALTER TABLE "jobs" DISABLE KEYS */;
/*!40000 ALTER TABLE "jobs" ENABLE KEYS */;

-- Dumping data for table database.migrations: 10 rows
/*!40000 ALTER TABLE "migrations" DISABLE KEYS */;
INSERT INTO "migrations" ("id", "migration", "batch") VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2025_04_23_140758_create_posts_table', 1),
	(5, '2025_04_25_113829_create_personal_access_tokens_table', 1),
	(6, '2025_05_23_152223_create_categories_table', 1),
	(7, '2025_05_23_152242_create_products_table', 1),
	(8, '2025_06_25_140850_create_budgets_table', 1),
	(9, '2025_06_25_141036_create_budget_product_table', 1),
	(10, '2025_06_27_115721_create_event_types_table', 1);
/*!40000 ALTER TABLE "migrations" ENABLE KEYS */;

-- Dumping data for table database.password_reset_tokens: 0 rows
/*!40000 ALTER TABLE "password_reset_tokens" DISABLE KEYS */;
/*!40000 ALTER TABLE "password_reset_tokens" ENABLE KEYS */;

-- Dumping data for table database.personal_access_tokens: 0 rows
/*!40000 ALTER TABLE "personal_access_tokens" DISABLE KEYS */;
/*!40000 ALTER TABLE "personal_access_tokens" ENABLE KEYS */;

-- Dumping data for table database.posts: 0 rows
/*!40000 ALTER TABLE "posts" DISABLE KEYS */;
/*!40000 ALTER TABLE "posts" ENABLE KEYS */;

-- Dumping data for table database.products: 15 rows
/*!40000 ALTER TABLE "products" DISABLE KEYS */;
INSERT INTO "products" ("id", "category_id", "name", "description", "price", "quantity", "created_at", "updated_at") VALUES
	(1, 1, 'Sistema de Sonido Line Array JBL VRX932LA', NULL, 150, 0, '2025-06-30 23:39:46', '2025-06-30 23:39:46'),
	(2, 1, 'Mesa de Mezclas Digital Behringer X32', NULL, 80, 0, '2025-06-30 23:39:46', '2025-06-30 23:39:46'),
	(3, 1, 'Micrófono Inalámbrico Shure SM58', NULL, 25, 0, '2025-06-30 23:39:46', '2025-06-30 23:39:46'),
	(4, 1, 'Subwoofer Activo JBL PRX818XLFW', NULL, 100, 0, '2025-06-30 23:39:46', '2025-06-30 23:39:46'),
	(5, 2, 'Cabeza Móvil Beam 230W', NULL, 70, 0, '2025-06-30 23:39:46', '2025-06-30 23:39:46'),
	(6, 2, 'Foco Par LED RGBW', NULL, 15, 0, '2025-06-30 23:39:46', '2025-06-30 23:39:46'),
	(7, 2, 'Máquina de Humo Antari F-80Z', NULL, 30, 0, '2025-06-30 23:39:46', '2025-06-30 23:39:46'),
	(8, 2, 'Barra LED Pixel Bar', NULL, 45, 0, '2025-06-30 23:39:46', '2025-06-30 23:39:46'),
	(9, 3, 'Módulo Pantalla LED P3.9 Interior (m2)', NULL, 200, 0, '2025-06-30 23:39:46', '2025-06-30 23:39:46'),
	(10, 3, 'Proyector de Video 10.000 Lúmenes', NULL, 180, 0, '2025-06-30 23:39:46', '2025-06-30 23:39:46'),
	(11, 3, 'Pantalla de Proyección Fast Fold 3x2m', NULL, 60, 0, '2025-06-30 23:39:46', '2025-06-30 23:39:46'),
	(12, 4, 'Controlador DJ Pioneer DDJ-SZ2', NULL, 90, 0, '2025-06-30 23:39:46', '2025-06-30 23:39:46'),
	(13, 4, 'Reproductor CDJ Pioneer CDJ-2000NXS2', NULL, 120, 0, '2025-06-30 23:39:46', '2025-06-30 23:39:46'),
	(14, 4, 'Mesa de Mezclas DJ Pioneer DJM-900NXS2', NULL, 110, 0, '2025-06-30 23:39:46', '2025-06-30 23:39:46'),
	(15, 4, 'Sistema VJ Resolume Arena', NULL, 130, 0, '2025-06-30 23:39:46', '2025-06-30 23:39:46');
/*!40000 ALTER TABLE "products" ENABLE KEYS */;

-- Dumping data for table database.sessions: 7 rows
/*!40000 ALTER TABLE "sessions" DISABLE KEYS */;
INSERT INTO "sessions" ("id", "user_id", "ip_address", "user_agent", "payload", "last_activity") VALUES
	('6jOk0JxoWi1cSEhXbh0aKY7dA0PBFQO7GWeU7QuR', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Herd/1.22.3 Chrome/120.0.6099.291 Electron/28.2.5 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMDVkdGZFZVd2VUNDSTdKODlIM05JY3pZYmdaZ3ZZR29xaTlZQmg1UiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly9tYXNmYmFjay50ZXN0Lz9oZXJkPXByZXZpZXciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1760024204),
	('DZLtmK00bmc9NCCx2ryVaFljHIREwMvduO74MeJU', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 OPR/122.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV2VlOWhKTUpiMGJ6WFZTdnlJUlh3WnVYZTN5aTNzazEyVEpBaTlzMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly9tYXNmYmFjay50ZXN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1760024211),
	('MI4kTrT3c9KWjYcW9JU54y1xPapRTj4NBEQScw44', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 OPR/121.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiM2lLN1RLRWYzUmdTMzg0QWtyOTFuRzZpOFo4QjJXS0hVRTVqTUxrYSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNToiaHR0cHM6Ly9tYXNmYXJyZS1iYWNrZW5kLnRlc3QvdXNlcnMiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozNToiaHR0cHM6Ly9tYXNmYXJyZS1iYWNrZW5kLnRlc3QvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1758971050),
	('RSSok1NLMthD5T57v6Dfz9IwlCmtBR58OMs3B3qN', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 OPR/121.0.0.0', 'YTo3OntzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozNToiaHR0cHM6Ly9tYXNmYXJyZS1iYWNrZW5kLnRlc3QvdXNlcnMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoia0lmNU9sajkycm1SczBDazd2VnFzdEJFOXdNamlXRG5JTVgyTUdqcCI7czozOiJ1cmwiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo0OiJtYXJ5IjthOjE6e3M6NToidG9hc3QiO2E6MDp7fX1zOjQ6InVzZXIiO2E6NDp7czoyOiJpZCI7aTo4O3M6NDoibmFtZSI7czoxMzoiQXJpZWwgV2VpbWFubiI7czo1OiJwaG9uZSI7TjtzOjU6ImVtYWlsIjtzOjI5OiJrb25vcGVsc2tpLnBpZXJyZUBleGFtcGxlLmNvbSI7fX0=', 1758901963),
	('WM4t5HQf6Wan38zqG2szbBfEHe3buvcisSm4Yhzg', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 OPR/122.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYVplbEdTWXIyckRSYXhLTnNMZUF4dTdBZkJoOVQybll5eWt1RkVwcCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHBzOi8vbWFzZmFycmUtYmFja2VuZC50ZXN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1760027093),
	('mk0WezmPDiPtdoIoOohZE6K7U0moGgKITVw6Cp3n', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 OPR/122.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZW1ROW85blZTQlZoUTBsT1lGWHE2TzJ0dWNqZ3BoZm5keXAxQnhhNSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHBzOi8vbWFzZmFycmUtYmFja2VuZC50ZXN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1760183697),
	('u7HvxwnquXMQgqaFIGE2PEf5T7e8ae3mXEFMnebN', 1, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 OPR/126.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiT2ZuOUE1RG5yUFdsaEdRejc2MzA1dnJqUWU3M0J6ZmgxanlLcG1jeSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM4OiJodHRwOi8vbWFzZmFycmUtYmFja2VuZC50ZXN0L2J1ZGdldHMvMyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1768222183);
/*!40000 ALTER TABLE "sessions" ENABLE KEYS */;

-- Dumping data for table database.users: 12 rows
/*!40000 ALTER TABLE "users" DISABLE KEYS */;
INSERT INTO "users" ("id", "name", "role", "email", "phone", "address", "province", "email_verified_at", "password", "remember_token", "created_at", "updated_at") VALUES
	(1, 'admin', 'admin', 'admin@admin.com', NULL, NULL, NULL, '2025-06-30 23:39:45', '$2y$12$q/iLIT4.VA/VB6lU8TOEYORf2KTwbMVcpIm9M.WTO0J9oYiazlBUu', 'vPg8IjacPzCWYjdJDOIv4BSivUbynIx8gMK9zPRRf6IadA1zwLdZxFm4MdPu', '2025-06-30 23:39:45', '2025-06-30 23:39:45'),
	(2, 'Lavina Howell II', 'user', 'dayne83@example.org', NULL, NULL, NULL, '2025-06-30 23:39:45', '$2y$12$elx9FruTYpMEq0AjScSVuOjITElMy0iJqPAdtl8Sk6DELckywyocW', 'u4YO5N4WKc', '2025-06-30 23:39:45', '2025-06-30 23:39:45'),
	(3, 'Winnifred Rodriguez', 'user', 'hollie06@example.net', NULL, NULL, NULL, '2025-06-30 23:39:45', '$2y$12$elx9FruTYpMEq0AjScSVuOjITElMy0iJqPAdtl8Sk6DELckywyocW', 'HCLOTCMKiZ', '2025-06-30 23:39:45', '2025-06-30 23:39:45'),
	(4, 'Melissa Abernathy', 'user', 'ross.okon@example.org', NULL, NULL, NULL, '2025-06-30 23:39:45', '$2y$12$elx9FruTYpMEq0AjScSVuOjITElMy0iJqPAdtl8Sk6DELckywyocW', 'tQWlpYJyLH', '2025-06-30 23:39:45', '2025-06-30 23:39:45'),
	(5, 'Kody McLaughlin', 'user', 'katheryn.price@example.org', NULL, NULL, NULL, '2025-06-30 23:39:45', '$2y$12$elx9FruTYpMEq0AjScSVuOjITElMy0iJqPAdtl8Sk6DELckywyocW', 'QVTBVLg9Um', '2025-06-30 23:39:45', '2025-06-30 23:39:45'),
	(6, 'Emilie O''Keefe', 'user', 'savion.harris@example.net', NULL, NULL, NULL, '2025-06-30 23:39:45', '$2y$12$elx9FruTYpMEq0AjScSVuOjITElMy0iJqPAdtl8Sk6DELckywyocW', '8ODyVymZJV', '2025-06-30 23:39:45', '2025-06-30 23:39:45'),
	(7, 'Woodrow Pfannerstill', 'user', 'bradtke.jonathon@example.net', NULL, NULL, NULL, '2025-06-30 23:39:45', '$2y$12$elx9FruTYpMEq0AjScSVuOjITElMy0iJqPAdtl8Sk6DELckywyocW', 'r7LjWyCUC5', '2025-06-30 23:39:45', '2025-06-30 23:39:45'),
	(8, 'Ariel Weimann', 'user', 'konopelski.pierre@example.com', NULL, NULL, NULL, '2025-06-30 23:39:45', '$2y$12$elx9FruTYpMEq0AjScSVuOjITElMy0iJqPAdtl8Sk6DELckywyocW', '5x2lE6S4Z2', '2025-06-30 23:39:45', '2025-06-30 23:39:45'),
	(9, 'Dariana Jast', 'user', 'keeling.zoila@example.com', NULL, NULL, NULL, '2025-06-30 23:39:45', '$2y$12$elx9FruTYpMEq0AjScSVuOjITElMy0iJqPAdtl8Sk6DELckywyocW', 'NmPSLD8Bic', '2025-06-30 23:39:45', '2025-06-30 23:39:45'),
	(10, 'Leta Barton IV', 'user', 'vdavis@example.com', NULL, NULL, NULL, '2025-06-30 23:39:45', '$2y$12$elx9FruTYpMEq0AjScSVuOjITElMy0iJqPAdtl8Sk6DELckywyocW', '3QArn5nOz7', '2025-06-30 23:39:45', '2025-06-30 23:39:45'),
	(11, 'Quentin Koss', 'user', 'lysanne.kemmer@example.org', NULL, NULL, NULL, '2025-06-30 23:39:45', '$2y$12$elx9FruTYpMEq0AjScSVuOjITElMy0iJqPAdtl8Sk6DELckywyocW', 'BhLDEA3Nv6', '2025-06-30 23:39:45', '2025-06-30 23:39:45'),
	(12, 'Olivetti, Ana Paula', 'user', 'anapaulaolivetti@gmail.com', '3482111111', '25 de mayo 2282', 'Santa Fe', NULL, '$2y$12$llXOyqPS1tl8qHff5fhSt.nL4ccCu6hUDFWjuNJHJjWCq0j0Vfxui', NULL, '2025-07-01 12:39:21', '2025-07-01 13:36:33');
/*!40000 ALTER TABLE "users" ENABLE KEYS */;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
