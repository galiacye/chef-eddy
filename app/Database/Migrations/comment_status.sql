ALTER TABLE comments

UPDATE comments SET statut = 'pending' WHERE statut = 'en_attente';
UPDATE comments SET statut = 'approved' WHERE statut = 'approuve';
UPDATE comments SET statut = 'rejected' WHERE statut = 'rejete';

si pas de données:
ALTER TABLE comments
MODIFY statut ENUM('pending', 'approved', 'rejected') DEFAULT 'pending';