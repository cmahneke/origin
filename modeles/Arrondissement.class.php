<?php

class Arrondissement {
	
    private static $database;
    
	function __construct() {
        
        if (!isset(self::$database)) {//Connection à la BDD si pas déjà connecté
            
            self::$database = BaseDeDonnees::getInstance();
        }
    }
		
	/**
	 * @access public
	 * @return Array
	 */
	public function getAllArrondissements() 
	{
				
        $infoArrondissements = array();
        
        self::$database->query('SELECT idArrondissement, nomArrondissement FROM Arrondissements');
        
        if ($arrondissements = self::$database->resultset()) {
            foreach ($arrondissements as $arrondissement) {
                $infoArrondissements[] = $arrondissement;
            }
        }
        return $infoArrondissements;
	}
    
    /**
    * @brief Méthode qui récupère l'ID en fonction du nom passé en paramètre, s'il existe.
    * @param string $nomArrondissement
    * @access private
    * @return string ou boolean
    */
    public function getArrondissementIdByName($nomArrondissement) {
        
        self::$database->query('SELECT idArrondissement FROM Arrondissements WHERE Arrondissements.nomArrondissement = :nomArrondissement');

        //Lie les paramètres aux valeurs
        self::$database->bind(':nomArrondissement', $nomArrondissement);

        if ($Arrondissement = self::$database->uneLigne()) {//Si trouvé dans la BDD
            return $Arrondissement["idArrondissement"];
        }
        else {
            return false;
        }
    }
    
    /**
    * @brief Méthode qui ajoute un arrondissement à la BDD.
    * @param string $nomArrondissement
    * @access private
    * @return void
    */
    public function ajouterArrondissement($nomArrondissement) {
        try {
            self::$database->query('INSERT INTO Arrondissements (nomArrondissement) VALUES (:nomArrondissement)');
            self::$database->bind(':nomArrondissement', $nomArrondissement);
            self::$database->execute();
        }
        catch(Exception $e) {
            echo "erreur lors de l'insertion : " . $e;
            exit;
        } 
    }
    
//    function chercheParArrondissement($keyword) {
//    
//    self::$database->query("SELECT nomArrondissement, idOeuvre FROM arrondissements, oeuvres Where oeuvres.idArrondissement = arrondissements.idArrondissement Group By nomArrondissement");
//                           
//    $keyword = $keyword.'%';
//
//    self::$database->bind(1, $keyword);
//    
//    $results = array();
//
//   if ($oeuvreBDD = self::$database->uneLigne()) {//Si trouvé dans la BDD
//            $results = array("idOeuvre"=>$oeuvreBDD['idOeuvre'],"titre"=>$oeuvreBDD['titre']);
//        }
//
//    return $results;
//    }
}
?>