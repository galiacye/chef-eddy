USE chef_eddy;

CREATE TABLE IF NOT EXISTS recettes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    nom VARCHAR(50) NOT NULL,
    image_url VARCHAR(255),
    temps_preparation INT NOT NULL,
    temps_cuisson INT NOT NULL,
    contenu TEXT NOT NULL,
    nb_personnes INT NOT NULL DEFAULT 2,
    difficulte ENUM ('facile', 'moyen', 'difficile') NOT NULL,
    statut ENUM ('en attente', 'publiée', 'rejetée') DEFAULT 'en attente',
    nb_vues INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_recettes_user, 
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE, 
    INDEX (user_id),
    INDEX (statut),
    INDEX (nb_vues)
);

CREATE TABLE IF NOT EXISTS roles
(
	id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) UNIQUE NOT NULL
    
);

INSERT INTO roles(nom)
VALUES('guest'),
('author'),('admin');

CREATE TABLE IF NOT EXISTS comments
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    recette_id INT NOT NULL,
    user_id INT NOT NULL,
    contenu TEXT NOT NULL,
    rating TINYINT  NOT NULL CHECK (rating BETWEEN 1 AND 5),--ici je mettrai le script des étoiles
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_comments_recette
        FOREIGN KEY (recette_id) REFERENCES recettes(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_comments_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,

    UNIQUE KEY unique_user_recette (recette_id, user_id)--pour éviter plusieurs commentaires du même user

);

CREATE TABLE IF NOT EXISTS ingredients
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    image_url VARCHAR(255),
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_nom (nom)
);

CREATE TABLE recette_ingredients (
    recette_id INT NOT NULL,
    ingredient_id INT NOT NULL,
    quantite DECIMAL(6,2) NOT NULL,  
    unite VARCHAR(20) NOT NULL,      
    PRIMARY KEY (recette_id, ingredient_id),
    FOREIGN KEY (recette_id) REFERENCES recettes(id) ON DELETE CASCADE,
    FOREIGN KEY (ingredient_id) REFERENCES ingredients(id) ON DELETE CASCADE,

    INDEX idx_recette (recette_id),
    INDEX idx_ingredient (ingredient_id)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS recette_categories (
    recette_id INT NOT NULL,
    categorie_id INT NOT NULL,
    PRIMARY KEY (recette_id, categorie_id),  -- clé primaire composite déjà unique
    FOREIGN KEY (recette_id) REFERENCES recettes(id) ON DELETE CASCADE,
    FOREIGN KEY (categorie_id) REFERENCES categories(id) ON DELETE CASCADE,
    INDEX idx_recette (recette_id),
    INDEX idx_categorie (categorie_id),
    UNIQUE KEY u_r_c (recette_id, categorie_id)  -- clé unique explicite
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE tags (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE recette_tags (
    recette_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (recette_id, tag_id),
    FOREIGN KEY (recette_id) REFERENCES recettes(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
);

INSERT INTO users(username,email,password,nom,prenom,avatar_url,role_id)
VALUES('Eléonore','eleonore@exemple.com','scooby-doo','Pasquier','Vanina',null,3);
 



CREATE TABLE ingredient_categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL
  
);

ALTER TABLE ingredients ADD COLUMN category_id INT,
ADD FOREIGN KEY (category_id) REFERENCES ingredient_categories(id);

INSERT INTO ingredient_categorie(nom)
VALUES('Viandes'),('Épices'),('Légumes');

-- importer bdd
--fait jusqu'ici.



