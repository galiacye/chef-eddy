ALTER TABLE recipes MODIFY COLUMN difficulty ENUM('easy', 'medium', 'difficult') NULL DEFAULT NULL;
UPDATE recipes SET difficulty = 'easy'      WHERE difficulty = 'facile' AND id > 0;
UPDATE recipes SET difficulty = 'medium'    WHERE difficulty = 'moyen' AND id > 0;
UPDATE recipes SET difficulty = 'difficult' WHERE difficulty = 'difficile' AND id > 0;