CREATE TABLE signin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) COLLATE utf8mb4_general_ci NOT NULL,
    email VARCHAR(60) COLLATE utf8mb4_general_ci NOT NULL,
    password VARCHAR(255) COLLATE utf8mb4_general_ci NOT NULL
);