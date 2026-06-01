ALTER TABLE tags ADD COLUMN is_homepage TINYINT(1) DEFAULT 0;

ALTER TABLE users ADD CONSTRAINT `users_ibfk_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);