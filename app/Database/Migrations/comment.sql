ALTER TABLE comments DROP INDEX unic_user_recette;

suppression de la condition un seul comment par user/recette 
pour créer parent_id ds la table et pouvoir à terme établir une boucle sociale avec le chef
