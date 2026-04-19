UPDATE recettes
SET statut = 'En attente'
WHERE id IN (15, 16, 17, 18, 20);

ALTER TABLE recettes 
MODIFY COLUMN statut VARCHAR(50) DEFAULT 'En attente';