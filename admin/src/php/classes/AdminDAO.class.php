<?php

class AdminDAO
{
    private $_bd;
    private $_array = array();

    public function __construct($cnx)
    {
        $this->_bd = $cnx;
    }

    public function getAdmin($login,$password)
    {
        $query = "select get_admin(:login,:password) as nom";
        try {
            $this->_bd->beginTransaction();
            $resultset = $this->_bd->prepare($query);
            $resultset->bindValue(':login',$login);
            $resultset->bindValue(':password',$password);
            $resultset->execute();
            //$data = $resultset->fetchAll();
            $nom = $resultset->fetchColumn(0);
            return $nom;


            $this->_bd->commit();
        } catch (PDOException $e) {
            $this->_bd->rollback();
            print "Echec de la requête " . $e->getMessage();
        }
    }

}
