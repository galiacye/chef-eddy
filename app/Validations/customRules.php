<?php

namespace App\Validation;

class CustomRules
{
    /**
     * required_if_role_author
     * Règle custom : champ obligatoire si role = author
     *
     * @param string $str Valeur du champ à valider
     * @param string $fields Nom du champ (non utilisé ici)
     * @param array $data Tout le POST
     * @return bool
     */
    public function required_if_role_author(string $str, string $fields, array $data): bool
    {
        // Vérifie si le rôle envoyé est 'author'
        if (isset($data['role']) && $data['role_id'] === 2) {
            // Si rôle = author, le champ doit être non vide
            return !empty(trim($str));
        }

        // Sinon, la validation passe
        return true;
    }
}

