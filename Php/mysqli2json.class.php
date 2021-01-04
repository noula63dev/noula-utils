<?php


 /***********************
  * USAGE : 
  *   Define Your query 
  *   Instantiate OBJECT 
  *      $mysql =  Mysqli2json(string $user ,string $password,string $db , string $sql) 
  *      $mysql->selectData();  Return Json data ( set fields & data )
  *      $mysql->getDatas();    Return Json data only
  *      $mysql->getFields();   Return Json fields only
  *      $mysql->addData();     Return result added data
  *      $mysql->updateData();  Return result updated data 
  *      $mysql->delData();  Return result del data 
  *
  *      $selectSql ="SELECT * FROM sbkbs";
  *      $addSql = "INSERT INTO sbkbs (Created, Title , Description) VALUES (NOW(), 'T' , 'D' )";
  *      $updateSql = "UPDATE sbkbs SET Created = 'Valore', Title = 'Valore', Description = 'Valore' WHERE ID = 'Valore' )";
  *      $delSql = "DELETE FROM sbkbs  WHERE KB_Id = '4'  ";
  *
  *      $mysqlSelect = new Mysqli2Json('root', 'myl1nuxb0x','sbr', $sql);
  *      $mysqlSelect->selectData();
  *      $mysqlSelect->getDatas();
  *      $mysqlSelect->getFields();
  *      $mysqlAdd =  new Mysqli2Json('root', 'myl1nuxb0x','sbr', $addSql);
  *      $mysqlAdd->addData();
  *      $mysqlDel =  new Mysqli2Json('root', 'myl1nuxb0x','sbr', $delSql);
  *      $mysqlDel->delData();
  *      $mysqlUpdate =  new Mysqli2Json('root', 'myl1nuxb0x','sbr', $updateSql);
  *      $mysqlUpdate->updateData(); 
  */
class Mysqli2Json
{
    protected $conn = null;
    protected $row = 0; 
    protected $result = null;
    protected $dbData = [];
    public function __construct(string $user ,string $password,string $db , string $sql){
        $this->sql = $sql;
        $this->user = $user;
        $this->password = $password;
        $this->db = $db;
    }

    protected function connect() {
        $this->conn = mysqli_connect("localhost", $this->user, $this->password,$this->db);
        
        if(!$this->conn){
            echo "No connection made";
            exit;
        }

    }
    
    public function selectData() {
        $this->connect();
        $this->result = mysqli_query($this->conn, $this->sql);
        $this->rows = mysqli_num_rows($this->result);
        if ($this->rows > 0) {
            $fieldsResult = mysqli_fetch_fields($this->result);
            $i = 0;
            foreach ($fieldsResult as $val)
            {
            $fields[$i]= $val->name;
            $i++;
            }
            //Fetch into associative array
            while ( $row = $this->result->fetch_assoc())  {
                $data[]=$row;
            }
            $this->dbData[] = $fields;
            $this->dbData[] = $data;
    
            //Print array in JSON format
            return json_encode($this->dbData);
        } else {
            return "no results found";
        }
        mysqli_free_result($result);
        mysqli_close($conn); 
    }
    public function getRows(){
        return $this->rows;
    }

    public function getFields(){
        $this_fields = $this->dbData[0];
        return json_encode($this_fields);
    }

    public function getDatas(){
        $this_data = $this->dbData[1];
        return json_encode($this_data);
    }

    public function addData() {
        $this->connect();
        $this->result = mysqli_query($this->conn, $this->sql);
        $lastId = mysqli_insert_id($this->conn);
        if ($lastId > 0) {
            return "Record added succefully inserted ID : $lastId";
        } else {
            return "Encountered error !!!";
        }
        mysqli_free_result($this->result);
        mysqli_close($this->conn); 
    }

    public function updateData() {
        $this->connect();
        $this->result = mysqli_query($this->conn, $this->sql);
        if ($this->result > 0) {
            return "Record updateted succefully";
        } else {
            return "Encountered error !!!";
        }
        mysqli_free_result($result);
        mysqli_close($conn); 
    }

    public function delData() {
        $this->connect();
        $this->result = mysqli_query($this->conn, $this->sql);
        if ($this->result > 0) {
            return "Record updateted succefully";
        } else {
            return "Encountered error !!!";
        }
        mysqli_free_result($result);
        mysqli_close($conn); 
    }
}
?>