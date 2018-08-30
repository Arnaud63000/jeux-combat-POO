<?php

$manager = new personnageManager($db);


if(isset($_POST['nom'])) {

    $_SESSION["nom"] = $_POST["nom"];
} 


if (isset($_POST['creer']) && isset($_POST['nom'])) // Si on a voulu créer un personnage.
{
  
  $perso = new Personnage(['nom' => $_POST['nom']]); // On crée un nouveau personnage.
  
  if (!$perso->nomValide())
  {
    $message = 'Le nom choisi est invalide.';
    unset($perso);
  }
  elseif ($manager->exists($perso->nom()))
  {
    $message = 'Le nom du personnage est déjà pris.';
    unset($perso);
  }
  else
  {
    $manager->add($perso);
  }
}

elseif (isset($_POST['utiliser']) && isset($_SESSION['nom'])) // Si on a voulu utiliser un personnage.
{
  if ($manager->exists($_SESSION['nom'])) // Si celui-ci existe.
  {
    $perso = $manager->get($_SESSION['nom']);
  }
  else
  {
    $message = 'Ce personnage n\'existe pas !'; // S'il n'existe pas, on affichera ce message.
  }
}

    elseif (isset($_GET['frapper']))

    {
        $perso = $manager->get($_SESSION['nom']);
        if (!isset($perso))
        {
        $message = 'Merci de créer un personnage ou de vous identifier.';
        }
        if (!isset($perso))
        {
            $message = 'Merci de crée un personnage !';
        }
        else
        {
            if (!$manager->exists((int) $_GET['frapper']))
            {
                $message = 'Le personnage existe pas !';
            }
            else
            {
                $persoAFrapper = $manager->get((int) $_GET['frapper']);
                $retour = $perso->frapper($persoAFrapper);
            }
            switch($retour)
            {
                case Personnage::CEST_MOI :
                    $message = 'Pourquoi tu veut me mettre une mandale ?';
                break;

                case Personnage::PERSONNAGE_FRAPPE :
                    $message = 'Le personnage a manger un arret buffer';

                    $manager->update($perso);
                    $manager->update($persoAFrapper);

                break;


                case Personnage::PERSONNAGE_TUER :
                    $message = 'Vous avez tué le personnage !';
                    
                    $manager->update($perso);
                    $manager->delete($persoAFrapper);

                    break;
            
            }
        }
    }
?>