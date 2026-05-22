CREATE TABLE favorites (
    user_id    INT NOT NULL,
    recipe_id  INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, recipe_id),
    FOREIGN KEY (user_id)   REFERENCES users(id)    ON DELETE CASCADE,
    FOREIGN KEY (recipe_id) REFERENCES recettes(id) ON DELETE CASCADE
);