<?php 
include_once ($_SERVER['DOCUMENT_ROOT'] ."/connect.php");

class User {
    
    private $email;
    private $nome;
    private $cognome;
    private $datanascita;
    private $password;
    private $tipologia;
    //protected $connect;
    private $prova;
    //costruttore
    public function __construct($username)
    {        
        $this->setEmail($username);
        $connect = startConnect();
        if($connect != null){
            $sqlQuery="SELECT * FROM utente WHERE email='".$username."'";
            $result=$connect->query($sqlQuery);
            if($result->num_rows > 0){
                if($row = $result->fetch_assoc()) {
                    $this->nome = $row['nome'];
                    $this->cognome = $row['cognome'];
                    $this->datanascita = $row['datanascita'];
                    $this->password = $row['password'];
                    $this->tipologia = $row['tipologia'];
                }
            }
        }
        closeConnect($connect);
    }   
    /*public function __destruct()
    {
        closeConnect($this->connect);     
    } */ 
            
    //metodi
    public function getEmail() {
        return $this->email;
    }       
    public function getNome() {
        return $this->nome;
    }       
    public function getCognome() {
        return $this->cognome;
    }       
    public function getDataNascita() {
        return $this->datanascita;
    }       
    public function getPassword() {
        return $this->password;
    }       
    public function getTipologia() {
        return $this->tipologia;
    }    
    
    
    public function setEmail($value) {
        //inserire controlli di tipo
        $this->email = $value;
    }       
    public function setNome($value) {
        $this->nome = $value;
    }       
    public function setCognome($value) {
        $this->cognome = $value;
    }       
    public function setDataNascita($value) {
        $this->datanascita = $value;
    }       
    public function setPassword($value) {
        $this->password = $value;
    }       
    public function setTipologia($value) {
        $this->tipologia = $value;
    }  

    public function addCommento($article, $value){

    }
    public function updateCommento($idCommento, $value){

    }

    public static function login($user, $pass, $tipologia){
        $connect = startConnect();
        $status = false;
        if($connect != null){
            $sqlQuery="SELECT * FROM utente WHERE email='".$user."' AND password='".$pass."' AND tipologia='".$tipologia."'";
            $result=$connect->query($sqlQuery);
            if($result->num_rows > 0){
                $status = true;
            }
        }
        $connect->close();
        return $status;
    }
        
}
?>