<?php

    function chargerClasse($classname)
    {
        require $classname.'.php';
    }

    spl_autoload_register('chargerClasse');

    $req = new PDO('mysql:host=localhost;dbname=TP', 'root', '');
    $req->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);



    $manager = new personnageManager();

    if (isset($_POST['creer']) && isset($_POST['nom']))
    {
        $perso = new Personnage(['nom' => $_POST['nom']]);
        
        if (!$perso->nomValide())
        {
            $message = 'Nom invalide !';
            unset($perso);
        }
        else if ($manager->exists($perso->nom()))
        {
            $message = 'Ce nom est déjà utilisé !';
            unset($perso);
        }
        else
        {
            $manager->add($perso);
        }
    }

        else if (isset($_POST['utiliser']) && isset($_POST['nom']))
        {
            if ($manager->exists($_POST['nom']))
            {
                $perso = $manager->get($_POST['nom']);
            }
            else
            {
                $message = 'Ce personnage est inconnu au bataillon !';

            }
        }

    