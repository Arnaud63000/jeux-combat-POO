<?php
    

    class PersonnageManager
    {
        private $db;


        public function __construct($db)
        {
            $this->setdb($db);
        }

        public function add(Personnage $perso)
        {
            $req = $this->db->prepare('INSERT INTO personnages(nom) VALUES(:nom)');

            $req->bindValue(':nom', $perso->nom());
            $req->execute();
            
            $perso->hydrate(['id' => $this->db->lastInsertId(), 'degats' => 0]);
        }

        public function count()
        {
            return $this->db->query('SELECT COUNT(*) FROM personnages')->fetchColumn();
        }

        public function delete(Personnage $perso)
        {
            $this->db->query('DELETE FROM personnages WHERE id = '.$perso->id());
        }

        public function exists($info)
        {
            if (is_int($info)) {
                return (bool) $this->db->query('SELECT COUNT(*) FROM personnages WHERE id = '.$info)->fetchColumn();
            }
            else {

                $req = $this->db->prepare('SELECT COUNT(*) FROM personnages WHERE nom = :nom');
                $req->execute([':nom' => $info]);

                return (bool) $req->fetchColumn();
            }
        }

        public function get($info)
        {
            if (is_int($info)) {
                $req = $this->db->query('SELECT id, nom, degats FROM personnages WHERE id = '.$info);
                $data = $req->fetch(PDO::FETCH_ASSOC);

                return new Personnage($data);
            }
            else {
                $req = $this->db->prepare('SELECT id, nom, degats FROM personnages WHERE nom = :nom');
                $req->execute([':nom' =>$info]);

                return new Personnage($req->fetch(PDO::FETCH_ASSOC));

            }
        }

        public function getlist($nom)
        {
            $persos = [];

            $req = $this->db->prepare('SELECT id, nom, degats FROM personnages WHERE nom <> :nom ORDER BY nom');
            $req->execute([':nom' => $nom]);

            while ($data = $req->fetch(PDO::FETCH_ASSOC))
            {
                $persos[] = new Personnage($data);
            }

            return $persos;
        }

        public function update(Personnage $perso)
        {
            $req = $this->db->prepare('UPDATE personnages SET degats = :degats WHERE id = :id');
            

            
            $req->bindValue(':degats', $perso->degats(), PDO::PARAM_INT);
            $req->bindValue(':id', $perso->id(), PDO::PARAM_INT);

            $req->execute();
            
        }

        public function setdb(PDO $db)
        {
            $this->db = $db;
        }
    }