<?php

class Personnage
{
    private $id;
    private $nom;
    private $degats;
    private $level;

    const CEST_MOI = 1;
    const PERSONNAGE_TUER = 2;
    const PERSONNAGE_FRAPPE = 3; 

    // Start constructeur

    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    //End constructeur


    // Start hydratation

    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set'.ucfirst($key);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // End Hydratation

    public function frapper(Personnage $perso)
    {
        if ($perso->id() == $this->id) {
            return  self::CEST_MOI;
        }
        else {
            return $perso->recevoirDegats();
        }
    }
    
    public function recevoirDegats()
    {
        $this->degats += 5;

        if ($this->degats >= 100) {

            return self::PERSONNAGE_TUER;
        }
        else {
            return self::PERSONNAGE_FRAPPE;
        }
    }

    // Start Getters

    public function degats()
    {
        return $this->degats;
    }

    public function id()
    {
        return $this->id;
    }

    public function nom()
    {
        return $this->nom;
    }
    public function level()
    {
        return $this->level;
    }
    // End getters

    //Start setters

    public function setDegats($degats)
    {
        $degats = (int) $degats;

        if ($degats >= 0 && $degats <= 100){
            $this->degats = $degats;
        }       
    }

    public function setId($id)
    {
        $id = (int) $id;

        if ($id > 0){
            $this->id = $id;
        }
    }

    public function setNom($nom)
    {
        if (is_string($nom)){
            $this->nom = $nom;
        }
    }

    public function nomValide()
        {
            return !empty($this->nom);
            
        }

        public function setLevel($level)
        {
            $level = (int) $level;
            $this->level = $level;
        }
    // End Setters

}