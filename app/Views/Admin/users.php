<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-users</title>
</head>
<body>
    <div class="users">
        <div class="usersIndex">
            <?php foreach($users as $user) :?>
                <p>Nom : <?= $user->lastname ?></p>
                <p>Prénom : <?= $user->firstname ?></p>
            <?php endforeach ;?>
        </div>
        <div class="userDetails">
            
        </div>
        <div class="modifierRole">

        </div>
        <div class="deleteUser">

        </div>
    </div>
   
</body>
</html>