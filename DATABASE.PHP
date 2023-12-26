<?php

/**
 * class for database 
 */
class database
{
    use database_trait,CRUD;
    /**
     * Constructor to run default when object is created
     */
    public function __construct($host, $username, $password, $database)
    {
        $this->conn = new mysqli($host, $username, $password, $database);
        if ($this->conn->connect_error) {
            die('Connection failed: ' . $this->conn->connect_error);
        }
    }

    /**
     * Function to close the connection
     * 
     * @return void
     */
    public function closeConnection()
    {
        $this->conn->close();
    }     
}

/**
 * trait for the database connection
 * 
 */
trait database_trait
{
    public $conn, $all_sku, $fields, $values, $sql, $sql1, $current_user_id, $login_password, $row, $row1, $all_books, $all_users, $all_admins, $id, $all_orders, $all_returns, $hashedPassword, $login_user_data,$status,$all_phones,$all_email,$record;

    /**
     * Function to get current date
     *
     * @return string return the current date.
     */
    function current_date()
    {
        return date('Y-m-d');
    }

    /**
     * Function to get unique id
     * 
     * @return string return the unique id.
     */
    function unique_id()
    {
        return uniqid();
    }

    /**
     * Function to inert data in tables as array
     * 
     * @param mixed $data The oprend as a key and value
     * @return void
     */
    public function to_insert($data)
    {
        $this->fields = implode(", ", array_keys($data));
        $this->values = "'" . implode("', '", array_values($data)) . "'";
    }

    /**
     * Function to run a sql query
     * 
     * @return void
     */
    public function run_query()
    {
        if (!$this->conn->query($this->sql)) {
            echo "Error: " . $this->sql . "<br>" . $this->conn->error;
        }
    }

}
trait CRUD{

    /**
     * Function to insert a record into database
     * 
     * @param string $tableName name of the table where you want to insert the record
     * @param array $data An array which consist all fields and values to be inserted
     * @return void
     */

    public function insertRecord($tableName, $data)
    {
        $this->to_insert($data);
        $this->sql = "INSERT INTO $tableName($this->fields) VALUES($this->values)";
        $this->run_query();
    }

    /**
     * Function to delete a record from database
     * 
     * @param string $tableName name of the table where you want to delete the record
     * @param string $field name of the conditional field
     * @param string $value value of the field
     * 
     * @return void
     */
    public function deleteRecord($tableName,$field, $value)
    {
        $this->sql = "DELETE FROM $tableName where $field='$value'";
        $this->run_query();

    }

    /**
     * Function to delete a record from database with 2 conditions
     * 
     * @param string $tableName name of the table where you want to delete the record
     * @param string $field1 name of the first conditional field
     * @param string $value1 value for the first conditional field
     * @param string $field2 name of the second conditional field
     * @param string $value2 value for the second conditional field
     * 
     * @return void
     */
    public function deleteRow($tableName,$field1, $value1,$field2, $value2)
    {
        $this->sql = "DELETE FROM $tableName where $field1='$value1' and $field2='$value2'";
        $this->run_query();

    }


    /**
     * Function to update record with single condition
     * 
     * @param string $tableName name of the table where you want to update the record
     * @param array $data array of fields and values to be updated
     * @param string $conditionField name of the conditional field
     * @param mixed $conditionValue value for the conditional field
     * 
     * @return void     
     */
    function updateRecord($tableName, $data, $conditionField,$conditionValue) {
    
        $this->record = [];

        foreach ($data as $column => $value) {
            $this->record[] = "`$column` = '$value'";
        }

        $setData = implode(', ', $this->record);
    
        $this->sql = "UPDATE `$tableName` SET $setData WHERE $conditionField='$conditionValue'";
    
        $this->run_query();
    }

    /**
     * Function to update record with two condition
     * 
     * @param string $tableName name of the table where you want to update the record
     * @param array $data array of fields and values to be updated
     * @param string $conditionField name of the first conditional field
     * @param mixed $conditionValue value for the first conditional field
     * @param string $conditionField1 name of the second conditional field
     * @param mixed $conditionValue1 value for the second conditional field
     * 
     * @return void     
     */

    function updateRecordWithConditions($tableName, $data, $conditionField,$conditionValue, $conditionField1,$conditionValue1) {
    
        $this->record = [];

        foreach ($data as $column => $value) {
            $this->record[] = "`$column` = '$value'";
        }

        $setData = implode(', ', $this->record);
    
        $this->sql = "UPDATE `$tableName` SET $setData WHERE $conditionField='$conditionValue' and $conditionField1='$conditionValue1'";
    
        $this->run_query();
    }


    /**
     * Function to get record with single condition
     * 
     * @param string $tableName name of the table where you want to update the record
     * @param string $selectColumns name of the field to get the record
     * @param string $conditionField name of the first conditional field
     * @param mixed $conditionValue value for the first conditional field
     * 
     * @return mixed     
     */
    public function getRecord($tableName, $selectColumns, $conditionField, $conditionValue) {
        $query = "SELECT $selectColumns FROM $tableName WHERE TRIM($conditionField) = '$conditionValue'";
        $result = $this->conn->query($query);

        if ($result) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $result->free();
            return $data;
        } else {
            echo 'Error: ' .$this->conn->error;
            return [];
        }
    }


    /**
     * Function to get record with two conditions
     * 
     * @param string $tableName name of the table where you want to update the record
     * @param string $selectColumns name of the field to get the record
     * @param string $conditionField name of the first conditional field
     * @param mixed $conditionValue value for the first conditional field
     * @param string $conditionField name of the second conditional field
     * @param mixed $conditionValue value for the second conditional field
     * 
     * @return mixed     
     */
    public function getRecordWithConditions($tableName, $selectColumns, $conditionField, $conditionValue, $conditionField1,$conditionValue1) {
        $query = "SELECT $selectColumns FROM $tableName WHERE $conditionField = '$conditionValue' and $conditionField1 = '$conditionValue1'";
        $result = $this->conn->query($query);

        if ($result) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $result->free();
            return $data;
        } else {
            echo 'Error: ' .$this->conn->error;
            return [];
        }
    }


    /**
     * Function to get a feild's all records
     * 
     * @param string $tableName name of the table where you want to update the record
     * @param string $field name of the field to get the record
     * 
     * @return array     
     */
    public function getAllRecords($tableName,$field) {
        $this->sql = "SELECT * FROM $tableName";    
        $result = $this->conn->query($this->sql);
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row[$field];
            }
        }
        return $data;
    }

    /**
     * Function to get all the records from a table
     * @param string $tableName name of the table 
     * 
     * @return array
     */
    public function getRecords($tableName) {
        $this->sql = "SELECT * FROM $tableName";    
        $result = $this->conn->query($this->sql);
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }


    /**
     * Function to get joined data from two tables
     * @param string $table1 name of the first table
     * @param string $table2 name of the second table 
     * @param string $field name of the common field in both the fields
     * 
     * @return array
     */
    public function getJoinBooks($table1,$table2,$field)
    {
        $this->sql = "SELECT * FROM $table1 LEFT JOIN $table2 ON $table1.$field=$table2.$field";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    
    /**
     * Function to get joined data from two tables with a condition
     * @param string $table1 name of the first table
     * @param string $table2 name of the second table 
     * @param string $field name of the common field in both the fields
     * @param string $sku value of the conditional feild
     * 
     * @return void
     */

    public function getJoinbook($table1,$table2,$field,$sku)
    {
        $this->sql = "SELECT * FROM $table1 LEFT JOIN $table2 ON $table1.$field=$table2.$field WHERE $table1.$field='$sku'";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            $this->row = $result->fetch_assoc();
        }        
    }


    /**
     * Function to get all records from a table with single condition
     * 
     * @param string $tableName name of the table where you want to update the record
     * @param string $conditionField name of the first conditional field
     * @param mixed $conditionValue value for the first conditional field
     * 
     * @return void    
     */
    public function getAllFields($tableName, $conditionField, $conditionValue)
    {
        $this->sql = "SELECT * FROM $tableName where $conditionField='$conditionValue'";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            $this->record = $result->fetch_assoc();
        }
    }


    /**
     * Function to get joined data from three tables at once
     * 
     * @param string $table1 Name of the first table
     * @param string $table2 Name of the second table
     * @param string $table3 Name of the third table
     * @param string $field Name of the common field
     * @param string $conditionField Name of the conditional field
     * @param string $conditionValue value for the conditional field  
     * 
     * @return void
     */
    public function getJoinOrders($table1, $table2,$table3, $field, $conditionField, $conditionValue)
    {
        $this->sql = "SELECT * FROM $table1 LEFT JOIN $table2 ON $table1.$field=$table2.$field LEFT JOIN $table3 ON $table1.$field=$table3.$field WHERE $table1.$conditionField='$conditionValue'";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            $this->row = $result->fetch_assoc();
        }
    }


    /**
     * Function to update the quantity
     * @param string $symbol oprator symbol to perform the action
     * @param string $book_sku value for the sku to update the quantity
     * 
     * @return void 
     */
    public function UpdateQuantity($symbol,$book_sku)
    {
        $this->sql = "UPDATE books SET quantity= quantity $symbol 1 where sku='$book_sku'";
        $this->run_query();
    }


    /**
     * Function to get the password from the table
     * @param string $tableName name of table 
     * @param string $email value for the conditional feild
     * 
     * @return void 
     */
    public function getPassword($tableName,$email)
     {
 
         $email = $this->conn->real_escape_string($email);
         $result = $this->conn->query("SELECT password FROM $tableName WHERE email='$email' or id='$email'");
         $this->login_password = $result->fetch_assoc();
 
         if ($this->login_password) {
             $this->hashedPassword = $this->login_password['password'];
         }
 
     } 


     /**
      * Function to get the data from table which contain the digits entered by the user/admin 
      * @param string $tableName name of the table where to find the data
      * @param string $selectField name of the field to get result
      * @param string $field Name of the conditional field
      * @param string $value Value for the conditional field
      *
      * @return mixed
      */
     public function search($tableName,$selectField,$field,$value){
        $this->sql = "SELECT $selectField FROM $tableName WHERE $field LIKE '%$value%';";
        $result = $this->conn->query($this->sql);
        if ($result) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $result->free();
            return $data;
        } else {
            echo 'Error: ' .$this->conn->error;
            return [];
        }
     }  
     
     /**
     * Function to count the feild
     * @param string $field name of the field to count
     * @param string $tableName name of the table
     * 
     * @return void
     */
    public function getTotal($field,$tableName)
    {
        $this->sql = "SELECT COUNT($field) FROM $tableName";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            $this->row = $result->fetch_assoc();
        }
    }


    /**
     * Function to add the field 
     * 
     * @param string $field name of the field to add
     * @param string $tableName name of the table
     * 
     * @return void
     */
    public function getSum($field,$tableName)
    {
        $this->sql = "SELECT SUM($field) FROM $tableName";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            $this->row = $result->fetch_assoc();
        }
    }
}

?>