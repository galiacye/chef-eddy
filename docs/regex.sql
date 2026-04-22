<script>`^(\\d+[.,]?\\d*)\\s*(${unite.join('|')})?\\s*(.+)$`, 'i'</script>


la regex: 
 - ^ : début de la chaine
 - (\\d+[.,]?\\d*) : - \\dcapture un nombre sans ou avc séparateur [.,] 

  Match :

12
12.5
12,5

 Ne match pas :

.5 (pas de chiffre avant)
12. (match mais discutable selon usage)
3. \\s*

-> espaces optionnels

4. (${unite.join('|')})?

-> une unité optionnelle

Exemple si unite = ['kg', 'g', 'lb'] :

(kg|g|lb)?

Match :

kg
g
rien du tout (optionnel)

 Attention :

si une unité contient un caractère spécial (+, (…), ça casse la regex → il faut les échapper
5. \\s*

-> encore des espaces optionnels

6. (.+)

 capture le reste de la chaîne

 au moins un caractère obligatoire

7. $

-> fin de chaîne