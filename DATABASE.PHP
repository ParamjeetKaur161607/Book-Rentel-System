<?php

/**
 * class for database 
 */
class database
{
    use database_trait,user_view, admin_view,book_view,CRUD;
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



    /**
     * Function to get the password for the user who is loged in
     * 
     * @param string $email The email address of the user who is loged in
     * @return void
     */

     public function getLoginUserPassword($email)
     {
 
         $email = $this->conn->real_escape_string($email);
         $result = $this->conn->query("SELECT password FROM user_registration WHERE email='$email' or id='$email'");
         $this->login_password = $result->fetch_assoc();
 
         if ($this->login_password) {
             $this->hashedPassword = $this->login_password['password'];
         }
 
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


trait cart_deletion
{

    public function delete_cart($sku, $email)
    {
        $this->sql = "DELETE FROM cart where book_sku='$sku' and user_email='$email'";
        $this->run_query();
    }

    public function delete_from_cart($email)
    {
        $this->sql = "DELETE FROM cart where user_email='$email'";
        $this->run_query();
    }
}

trait cart_view
{
    public function user_cart()
    {
        $this->sql = "SELECT book_sku FROM cart where user_email='$_SESSION[login]'";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->all_sku[] = $row;
            }
        }
        return $this->all_sku;
    }
}

trait order_insertion
{
    public function insert_to_orders($tableName, $data)
    {
        $this->to_insert($data);
        $this->sql = "INSERT INTO $tableName($this->columns) VALUES($this->values)";
        $this->run_query();
    }

    public function insert_to_return_order($tableName, $data)
    {
        $this->to_insert($data);
        $this->sql = "INSERT INTO $tableName($this->columns) VALUES($this->values)";
        $this->run_query();
    }
}

trait order_deletion
{
    public function delete_from_returns($sku, $email)
    {
        $this->sql = "DELETE FROM return_order where book_sku='$sku' and customer_email='$email'";
        $this->run_query();
    }
}

trait order_view
{
    public function orders($id)
    {
        $this->sql = "SELECT * FROM orders where customer_email='$id'";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            $this->row1 = $result->fetch_assoc();
        }
    }



    public function returns($id)
    {
        $this->sql = "SELECT * FROM return_order where customer_email='$id'";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            $this->row1 = $result->fetch_assoc();
        }
    }

    public function user_returns()
    {
        $this->sql = "SELECT book_sku FROM return_order where customer_email='$_SESSION[login]'";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->all_sku[] = $row;
            }
        }
        return $this->all_sku;
    }

    public function all_returns()
    {
        $this->sql = "SELECT * FROM return_order";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->all_returns[] = $row;
            }
        }
        return $this->all_returns;
    }
    public function all_orders()
    {
        $this->sql = "SELECT * FROM orders";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->all_orders[] = $row;
            }
        }
        return $this->all_orders;
    }

}



/**
 * trait to handle the user view data from user_registration table
 */
trait user_view
{

    /**
     * Function to get the phone numbers stored in user_reg(user_registration) table
     * 
     * @return array
     */
    public function getUserPhone()
    {
        $this->sql = "SELECT phone FROM user_registration";
        $result = $this->conn->query($this->sql);
        $all_phone = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $all_phone[] = $row['phone'];
            }
        }
        return $all_phone;
    }


    /**
     * Function to get all the details of all users from user_reg(user_registration) and user_file(user_file) table
     * 
     * @return array
     */
    public function getAllUsers()
    {
        $this->sql = "SELECT * FROM user_registration";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->all_users[] = $row;
            }
        }
        return $this->all_users;
    }

    /**
     * Function to got all the information in user_reg(user_registration) for a particular user
     * 
     * @param string $id Value for field user_id
     * @return void
     */
    public function getUser($id)
    {
        $this->sql = "SELECT * FROM user_registration where id='$id'";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            $this->row = $result->fetch_assoc();
        }
    }

    /**
     * Function to get user status from user_reg(user_registration) for a particular user
     * 
     * @param string $email Value for field user_email
     * @return void
     */
    public function getUserStatus($id)
    {
        $this->sql = "SELECT status FROM user_registration where id='$id' or email='$id'";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            $this->status= $result->fetch_assoc();
            // var_dump($this->status);
        }
    }

    /**
     * Function to get user id from user_registration for a particular user
     * 
     * @param string $email Value for field user_email
     * @return void
     */
    public function getUserId($email)
    {
        $this->sql = "SELECT id FROM user_registration where email='$email'";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            $this->row = $result->fetch_assoc();
        }
    }

    /**
     * Function to get all user emails from user_reg(user_registration)
     * 
     * @return array Array contains all the emails
     */
    public function getUserEmails()
    {
        $this->sql = "SELECT email FROM user_registration";
        $result = $this->conn->query($this->sql);
        $all_email = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $all_email[] = $row['email'];
            }
        }
        return $all_email;
    }    

    /**
     * Function to count number of users registered
     * 
     * @return void
     */
    public function getTotalUsers()
    {
        $this->sql = "SELECT COUNT(email) FROM user_registration";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            $this->row = $result->fetch_assoc();
        }
    }
}


trait admin_view
{

    public function getTotalAdmins()
    {
        $this->sql = "SELECT COUNT(id) FROM admin";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            $this->row = $result->fetch_assoc();
        }
    }
    public function getAdminEmails()
    {
        $this->sql = "SELECT email FROM admin";
        $result = $this->conn->query($this->sql);
        $this->all_email = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->all_email[] = $row['email'];
            }
        }
        return $this->all_email;
    }
    public function getAdminPhones()
    {
        $this->sql = "SELECT phone FROM admin";
        $result = $this->conn->query($this->sql);
        $this->all_phones = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->all_phones[] = $row['phone'];
            }
        }
        return $this->all_phones;
    }
    public function getAllAdmins()
    {
        $this->sql = "SELECT * FROM admin";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->all_admins[] = $row;
            }
        }
        return $this->all_admins;
    }

    public function getAdmin($id)
    {
        $this->sql = "SELECT * FROM admin where id='$id' or email='$id'";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            $this->row = $result->fetch_assoc();
        }
    }

    /**
     * Function to get admin id from admin for a particular user
     * 
     * @param string $email Value for field user_email
     * @return void
     */
    public function getAdminId($email)
    {
        $this->sql = "SELECT id FROM admin where email='$email'";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            $this->id = $result->fetch_assoc();
        }
    }

    public function getSuperAdminEmails()
    {
        $this->sql = "SELECT email FROM super_admin";
        $result = $this->conn->query($this->sql);
        $all_email = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $all_email[] = $row['email'];
            }
        }
        return $all_email;
    }

    public function getAdminPassword($email)
    {      

        $email = $this->conn->real_escape_string($email);
         $result = $this->conn->query("SELECT password FROM admin where email='$email' or id='$email'");
         $this->login_password = $result->fetch_assoc();
 
         if ($this->login_password) {
             $this->hashedPassword = $this->login_password['password'];
         }
    }

    public function getSuperAdminPassword($email)
    {
        $this->sql = "SELECT password FROM super_admin where email='$email' or  id='$email'";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            $this->row = $result->fetch_assoc();
        }
    }
    public function getSuperAdmin($id)
    {
        $this->sql = "SELECT * FROM super_admin where id='$id' or email='$id'";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            $this->row = $result->fetch_assoc();
        }
    }

    public function getSuperAdminId($email)
    {
        $this->sql = "SELECT id FROM super_admin where email='$email'";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            $this->id = $result->fetch_assoc();
        }
    }

}


/**
 * trait to handle the view from table book
 */
trait book_view
{

    /**
     * Function to get all the categories from the book_category table
     * 
     * @return array 
     */
    public function getAllCategory()
    {
        $this->sql = "SELECT category FROM book_category";
        $result = $this->conn->query($this->sql);
        $all_category = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $all_category[] = $row['category'];
            }
        }
        return $all_category;
    }


    /**
     * Function to get all the sku from the book table
     * 
     * @return array 
     */
    public function getAllSku()
    {
        $this->sql = "SELECT sku FROM books";
        $result = $this->conn->query($this->sql);
        $all_sku = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $all_sku[] = $row['sku'];
            }
        }
        return $all_sku;    }



    public function getBook($sku)
    {
        $this->sql = "SELECT * FROM books LEFT JOIN books_price ON books.sku=books_price.sku WHERE books.sku='$sku'";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            $this->row = $result->fetch_assoc();
        }
    }

    public function getAllBooks()
    {
        $this->sql = "SELECT * FROM books LEFT JOIN books_price ON books.sku=books_price.sku";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->all_books[] = $row;
            }
        }
        return $this->all_books;
    }

    public function getBookByCategory($category)
    {
        $this->sql = "SELECT sku FROM books where category='$category'";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->all_books[] = $row;
                var_dump($this->$this->all_books);
            }
        }
        return $this->all_books;
    }

    public function getBooksku($id)
    {
        $this->sql = "SELECT sku FROM books where id='$id' or category='$id'";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            $this->row1 = $result->fetch_assoc();
            var_dump($this->row1);
        }
    }

    public function getTotalBooks()
    {
        $this->sql = "SELECT COUNT(sku) FROM books";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            $this->row = $result->fetch_assoc();
        }
    }

    /**
     * Function as a left join of 3 tables orders, book and return order
     * 
     * @param mixed $book_sku The common column in all the tables
     * @return void
     */
    public function books_orders($book_sku)
    {
        $this->sql = "SELECT * FROM books LEFT JOIN orders ON book.book_sku=orders.book_sku LEFT JOIN return_order ON book.book_sku=return_order.book_sku WHERE return_order.book_sku='$book_sku'";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            $this->row = $result->fetch_assoc();
        }
    }


}

trait CRUD{

    public function insertRecord($tableName, $data)
    {
        $this->to_insert($data);
        $this->sql = "INSERT INTO $tableName($this->fields) VALUES($this->values)";
        $this->run_query();
    }

    /**
     * Function to delete a record
     * 
     * @param $category Value for the coulmn book_category
     * @return void
     */
    public function deleteRecord($tableName,$field, $value)
    {
        $this->sql = "DELETE FROM $tableName where $field='$value'";
        $this->run_query();

    }

    public function deleteRow($tableName,$field1, $value1,$field2, $value2)
    {
        $this->sql = "DELETE FROM $tableName where $field1='$value1' and $field2='$value2'";
        $this->run_query();

    }

    function updateRecord($tableName, $data, $conditionField,$conditionValue) {
    
        $this->record = [];

        foreach ($data as $column => $value) {
            $this->record[] = "`$column` = '$value'";
        }

        $setData = implode(', ', $this->record);
    
        $this->sql = "UPDATE `$tableName` SET $setData WHERE $conditionField='$conditionValue'";
    
        $this->run_query();
    }

    public function getRecord($tableName, $selectColumns, $conditionField, $conditionValue) {
        $query = "SELECT $selectColumns FROM $tableName WHERE $conditionField = '$conditionValue'";
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

    public function getJoinbook($table1,$table2,$field,$sku)
    {
        $this->sql = "SELECT * FROM $table1 LEFT JOIN $table2 ON $table1.$field=$table2.$field WHERE $table1.$field='$sku'";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            $this->row = $result->fetch_assoc();
        }        
    }

    public function getAllFields($tableName, $conditionField, $conditionValue)
    {
        $this->sql = "SELECT * FROM $tableName where $conditionField='$conditionValue'";
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            $this->record = $result->fetch_assoc();
        }
    }


    /**
     * Function as a left join of 3 tables orders, book and return order
     * 
     * @param mixed $book_sku The common column in all the tables
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

    public function UpdateQuantity($symbol,$book_sku)
    {
        $this->sql = "UPDATE books SET quantity= quantity $symbol 1 where sku='$book_sku'";
        $this->run_query();
    }

    public function getPassword($tableName,$email)
     {
 
         $email = $this->conn->real_escape_string($email);
         $result = $this->conn->query("SELECT password FROM $tableName WHERE email='$email' or id='$email'");
         $this->login_password = $result->fetch_assoc();
 
         if ($this->login_password) {
             $this->hashedPassword = $this->login_password['password'];
         }
 
     } 

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
     * Function to count number of users registered
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