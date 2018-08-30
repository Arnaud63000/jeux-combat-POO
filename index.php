<?php
session_start();

if (isset($_GET['deconnexion']))
{
    session_destroy();
    header('location: .');
    exit();
}
    include 'connect.php';
    include 'personnage.php';
    include 'personnageManager.php';
    include 'combat.php';

    
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Street Fighter V1</title>
    
    <meta charset="utf-8" />
  </head>
  <body>
  <h1>Street Fighter V1</h1>
  <p>Nombre de personnages créés :<?= $manager->count()?> </p>

<?php

    if (isset($message)) 
    {
    echo '<p>', $message, '</p>'; 
    }

    if (isset($perso))
    {
?>

<p><a href="?deconnexion=1">Déconnexion</a></p>

<fieldset>
    <legend>Mes informations</legend>
    <p>
        Nom : <?= htmlspecialchars($perso->nom()) ?><br>
        Degats : <?= $perso->degats()?><br>
        Level : <?= $perso->level()?>
    </p>
</fieldset>

<fieldset>
    <legend>Sur qui envoyé une mandale ?</legend>
    <p>
<?php 

        $persos = $manager->getList($perso->nom());

        if (empty($persos))
        {
            echo 'Personne à taper !';
        }
        else
        {
            foreach ($persos as $unPerso)
      echo '<a href="?frapper='. $unPerso->id(). '">', htmlspecialchars($unPerso->nom()). '</a> (dégâts : '. $unPerso->degats(). ')<br />';
  }
?>
        </p>
        </fieldset>
<?php
    }
    else
    {
    ?>
    
 
    <form action="" method="post">

      <p>

        Nom : <input type="text" name="nom" maxlength="50" />

        <input type="submit" value="Créer ce personnage" name="creer" />

        <input type="submit" value="Utiliser ce personnage" name="utiliser" />

      </p>

    </form>
<?php
    }
    ?>    
  </body>
</html>
