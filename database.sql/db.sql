-- Base de données : chef_eddy
USE chef_eddy;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    avatar_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    role_id int 
);

-- 1. Créer la table roles
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL UNIQUE
);

-- 2. Insérer les rôles
INSERT INTO roles (nom) VALUES ('guest'), ('author'), ('admin');

-- 3. Ajouter la colonne role_id à users
ALTER TABLE users ADD COLUMN role_id INT;


-- 5. Rendre role_id obligatoire avec valeur par défaut
ALTER TABLE users MODIFY role_id INT NOT NULL DEFAULT 1;

-- 6. Ajouter la clé étrangère
ALTER TABLE users ADD CONSTRAINT fk_users_roles 
    FOREIGN KEY (role_id) REFERENCES roles(id);

-- 7. Supprimer l'ancienne colonne role
ALTER TABLE users DROP COLUMN role;



CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);---fait

CREATE TABLE tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);--on laisse de côté tags et recettes_tags pour l'instant

CREATE TABLE ingredients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE,
    image_url VARCHAR(255),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);--fait

CREATE TABLE recettes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    nom VARCHAR(100) NOT NULL,
    image_url VARCHAR(255),
    temps_preparation INT,
    temps_cuisson INT,
    contenu TEXT,
    nb_personnes INT DEFAULT 4,
    difficulte ENUM('facile', 'moyen', 'difficile') DEFAULT 'moyen',
    statut ENUM('brouillon', 'publie') DEFAULT 'brouillon',
    nb_vues INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);--fait

CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recette_id INT NOT NULL,
    user_id INT NOT NULL,
    contenu TEXT NOT NULL,
    rating TINYINT CHECK (rating BETWEEN 1 AND 5),
    statut ENUM('en_attente', 'approuve', 'rejete') DEFAULT 'en_attente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (recette_id) REFERENCES recettes(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);--fait

CREATE TABLE recette_ingredients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recette_id INT NOT NULL,
    ingredient_id INT NOT NULL,
    quantite DECIMAL(10,2),
    unite VARCHAR(50),
    FOREIGN KEY (recette_id) REFERENCES recettes(id) ON DELETE CASCADE,
    FOREIGN KEY (ingredient_id) REFERENCES ingredients(id) ON DELETE CASCADE,
    UNIQUE KEY unique_recette_ingredient (recette_id, ingredient_id)--pour éviter les doublons et s'assurer qu'un ingrédient n'apparait qu'une fois par recette
);--fait

CREATE TABLE recette_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recette_id INT NOT NULL,
    categorie_id INT NOT NULL,
    FOREIGN KEY (recette_id) REFERENCES recettes(id) ON DELETE CASCADE,
    FOREIGN KEY (categorie_id) REFERENCES categories(id) ON DELETE CASCADE,
    UNIQUE KEY unique_recette_categorie (recette_id, categorie_id)
);

CREATE TABLE recettes_tags (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    recette_id INT NOT NULL,
    tag_id INT NOT NULL,
    FOREIGN KEY (recette_id) REFERENCES recettes(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE,
    UNIQUE KEY unique_recette_tag (recette_id, tag_id)
);
CREATE TABLE tags (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL
);

CREATE INDEX idx_recettes_user ON recettes(user_id);
CREATE INDEX idx_recettes_statut ON recettes(statut);
CREATE INDEX idx_comments_recette ON comments(recette_id);
CREATE INDEX idx_comments_user ON comments(user_id);

INSERT INTO categories (nom) VALUES
('Apéritifs'),
('Entrées'),
('Plats principaux'),
('Desserts');

INSERT INTO tags (nom) VALUES 
    ('Végétarien'),
    ('Vegan'),
    ('Rapide'),
    ('Cuisine du monde'),
    ('Sans gluten'),
    ('Gastronomique'),
    ('Économique'),
    ('Au chocolat');
    --fait

--pour les tests:

INSERT INTO users(username,email,password,nom,prenom,avatar_url,role)
VALUES
(
    'Chef Eddy','morat.eddy@laposte.net','SW1987','Morat','Eddy','./img/eddy-bd.jpeg','admin'
);

INSERT INTO recettes(user_id,nom,image_url,temps_preparation,temps_cuisson,contenu,nb_personnes,difficulte,statut,nb_vues)
VALUES(
    1,'Fraisier','img/desserts/fraisier.jpeg',60,null,null,6,'moyen','publié',null
),
(
    1,'Cheesecake à la pistache','./img/desserts/cheesecake-pistache.jpg',60,null,null,8,'moyen','publié',null
);


ALTER TABLE recipes 
MODIFY COLUMN statut ENUM('pending', 'approved', 'rejected') DEFAULT 'pending';

CREATE TABLE ingredients_categories (
    id  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL
);

INSERT INTO ingredients_categories (nom) VALUES
    ('Viandes'),
    ('Poissons'),
    ('Oeufs'),
    ('Légumes'),
    ('Fruits'),
    ('Féculents'),
    ('Farines et céréales'),
    ('Produits laitiers'),
    ('Épices & herbes'),
    ('Sucre et édulcorants'),
    ('Matières grasses'),
    ('Liquides'),
    ('Autres');

 ALTER TABLE ingredients ADD COLUMN categorie VARCHAR(50) DEFAULT NULL;   

 INSERT INTO roles (nom) VALUES ('banned');

 ALTER TABLE recettes 
MODIFY statut VARCHAR(50) DEFAULT 'pending';

UPDATE recettes 
SET statut = 'pending' 
WHERE statut IS NULL OR statut = '';





