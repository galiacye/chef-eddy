USE chef_eddy;
CREATE TABLE `password_resets` (
    `id` int NOT NULL AUTO_INCREMENT,
    `email` varchar(100) NOT NULL,
    `token` varchar(64) NOT NULL,
    `expires_at` datetime NOT NULL,
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `email` (`email`),
    KEY `token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;