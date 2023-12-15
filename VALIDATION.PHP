<?php
session_start();
include_once("DATABASE.PHP");
// trait for validation checking
trait validation_trait
{
    public $name, $email, $address, $phone, $gender, $dob, $security_question, $password, $card_number, $name_on_card, $cvv, $card_expiry_month, $card_expiry_year, $profile_picture, $extra, $profile_picture_name, $profile_picture_path, $date, $category, $duration, $payment, $start_date, $max_duration, $return_date, $sale_price, $daysDifference, $book_image_path, $book_image_name;

    public $error_name, $error_email, $error_address, $error_phone, $error_gender, $error_dob, $error_security_question, $error_password, $error_card_number, $error_name_on_card, $error_cvv, $error_card_expiry_month, $error_card_expiry_year, $error_profile_picture, $error_category, $error_duration, $error_payment;

    public $book_sku, $book_title, $book_author, $book_category, $book_discription, $book_quantity, $book_price, $book_sale_price, $book_image;

    public $error_book_sku, $error_book_title, $error_book_author, $error_book_category, $error_book_discription, $error_book_quantity, $error_book_price, $error_book_sale_price, $error_book_image;


    public $admins, $currunt_date;



/**
 * Check whether a value is empty or not
 * 
 * @param mixed $data The oprend to check empty or not.
 * @return bool return true if not empty, false otherwise
 */
    function is_not_empty($data)
    {
        return !empty($data);
    }

/**
 * Check whether pattren of a $data is correct or not
 * 
 * @param mixed $data It validate that only capital letter, small letters and space allowd.
 * @return bool return true if $data dosen't belongs to the pattren, false otherwise
 */
    function is_name_pattren_valid($data)
    {
        return !preg_match("/^[a-zA-z' ]*$/", $data);
    }

/**
 * Check whether the email entered by user is in correct format or not
 * 
 * @param mixed $data The oprend to check the format of a email
 * @return bool return true if $data format is wrong, false otherwise
 */
    function is_email_pattren_valid($data)
    {
        return !filter_var($data, FILTER_VALIDATE_EMAIL);
    }

/**
 * Check whether the length of the phone is 10 or not
 * 
 * @param mixed $data The oprend to check the length
 * @return bool return eturn true if $data is less then equal $length, otherwise false
 */
    function is_phone_length_valid($data)
    {
        return strlen((string) $data) != 10;
    }

/**
 * Check length of the password
 * 
 * @param mixed $data The oprend to check the length
 * @return bool return true if $data is less then equal $length, otherwise false
 */
    function is_password_length_valid($data)
    {
        return strlen($data) <= 8;
    }

/**
 * Check length of any data
 * 
 * @param mixed $data The oprend to check the length
 * @return bool return true if $data is less then equal $length, otherwise false
 */
    function is_length_valid($data, $lenth)
    {
        return strlen($data) <= $lenth;
    }


/**
 * Change the format of any date 
 * 
 * @param mixed $data The oprend to change the date format
 * @return string return date into correct format (i.e 2023-10-10)
 */
    function is_date_format_valid($data)
    {
        $dateTime = new DateTime($data);
        return $dateTime->format('Y-m-d');
    }

/**
 * Check  whether the input contains number or not
 * 
 * @param mixed $data The oprend to check its data type
 * @return bool return true if input contains numbers, false otherwise
 */
    function is_number($data)
    {
        return !preg_match("#[0-9]+#", $data);
    }

/**
 * Check  whether the input contains Capital Letter or not
 * 
 * @param mixed $data The oprend to check its data type
 * @return bool return true if input contains capital letter, false otherwise
 */
    function is_capital($data)
    {
        return !preg_match("#[A-Z]+#", $data);
    }


/**
 * Check  whether the input contains small letter or not
 * 
 * @param mixed $data The oprend to check its data type
 * @return bool return true if input contains small letter, false otherwise
 */
    function is_small($data)
    {
        return !preg_match("#[a-z]+#", $data);
    }


/**
 * Check  whether the input contains any special character character/symbol or not
 * 
 * @param mixed $data The oprend to check its data type
 * @return bool return true if input contains special character or any symbol, false otherwise
 */
    function is_contail_special_char($data)
    {
        return !preg_match("#[^a-zA-Z0-9]+#", $data);
    }

/**
 * Check  whether the input contains Capital Letter or not
 * 
 * @param mixed $data The oprend to check its data type
 * @return bool return true if input contains capital letter, false otherwise
 */
    function is_contain_numbers($data)
    {
        return !preg_match("#[0-9]+#", $data);
    }


/**
 * Check  whether an array is empty or not
 * 
 * @param mixed $array An array oprend to check its empty or not
 * @return bool return true array is not empty, false otherwise
 */
    function is_array_empty($array)
    {
        $filteredArray = array_filter($array, function ($value) {
            return !empty($value);
        });

        return empty($filteredArray);
    }

}


/**
 * trait to check validation related to a book
*/
trait validate_book
{

    use validation_trait;

    
/**
 * Function to check wheter category is empty or not and whether category is already existed or not
 * 
 * @return void 
 */
    public function category()
    {
        $this->category = $_POST['category'];

        $this->error_category=empty($this->category) ? "Category can't be empty!" : null;

        $category = $this->get_all_category();
        if (in_array($this->category, $category)) {
            $this->error_category = "This category is already existed, Please try again!";
            return;
        }
        
    }


/**
 * Function to check wheter book_sku is empty or not 
 * whether book_sku is already existed or not 
 * whether the length of the sku is 20 or not
 * 
 * @return void 
 */
    public function is_book_sku_valid()
    {
        $this->book_sku = $_POST['book_sku'];

        $this->error_book_sku=empty(trim($this->book_sku)) ? "Please enter SKU for this listing!" : null;

        if (!$this->is_length_valid($this->book_sku, 20)) {
            $this->error_book_sku = "The maximum length of SKU can be 20 only!";
            return;
        } 

        if (in_array($this->book_sku, $this->get_all_sku())) {
            $this->error_book_sku = "This SKU is already existed in the database!";
            return;
        }
      
    }

/**
 *Function to check whether the book_title is empty or not. 
 *whether the length of the book_title is 50 or not.
 *whether the pattren of the the entred title is valid or not(i.e only can contain Capital Letters, Small letters and white space).
 * 
 * @return void 
 */
    public function is_book_title_valid()
    {
        $this->book_title = $_POST['book_title'];

        $this->error_book_title=empty(trim($this->book_title)) ? "Please enter title of the listing!" : null;

        if (!$this->is_length_valid($this->book_title, 50)) {
            $this->error_book_title = "The maximum length of the title can be 50 only!";
            return;
        }

        if ($this->is_name_pattren_valid($this->book_title)) {
            $this->error_book_title = "Only alphabets and whitespace are allowed!";
            return;
        }

    }

/**
 *Function to check whether the name of the author is empty or not 
 *whether the length of the book author is 50 or not
 * whether the pattren of the entred name is valid or not(i.e only can contain Capital Letters, Small letters and white space)
 * 
 * @return void 
 */
    public function is_book_author_valid()
    {
        $this->book_author = $_POST['book_author'];

        $this->error_book_author=empty(trim($this->book_author)) ? "Please enter name of the author!" : null;

        if (!$this->is_length_valid($this->book_author, 20)) {
            $this->error_book_author = "The maximum length of Author Name can be 20 only!";
            return;
        } 

        if ($this->is_name_pattren_valid($this->book_title)) {
            $this->error_book_author = "Only alphabets and whitespace are allowed!";
            return;
        }

    }

/**
 *Function to check if admin select any category from the drop down or not 
 * 
 * @return void 
 */
    public function is_book_category_valid()
    {
        if (isset($_POST['book_category'])) {
            $this->book_category = $_POST['book_category'];
        } else {
            $this->error_book_category = "Please select the category for this book!";
        }
    }

/**
 *Function to check whether the book description is empty or not
 * 
 * @return void 
 */
    public function is_book_discription_valid()
    {
        $this->book_discription = $_POST['book_discription'];
        if (empty(trim($this->book_discription))) {
            $this->error_book_discription = "Please enter little bit description about book!";
            return;
        }
    }

/**
 *Function to check whether the book quantity is empty or not
 * 
 * @return void 
 */
    public function is_book_quantity_valid()
    {
        $this->book_quantity = $_POST['book_quantity'];
        if (empty(trim($this->book_quantity))) {
            $this->error_book_quantity = "Please enter quantity of the book!";
            return;
        }
    }

/**
*Function to check whether the book price is empty or not
* 
* @return void 
*/
    public function is_book_price_valid()
    {
        $this->book_price = $_POST['book_price'];
        if (empty(trim($this->book_price))) {
            $this->error_book_price = "Please enter price of the book!";
            return;
        }
       
        if (!ctype_digit($this->book_price)) {
            $this->error_book_price = "Please enter the valid book price!";
            return;
        }
    }

/**
*Function to check whether the file extension of the book cover image is valid or not
* 
* @return void 
*/
    public function is_book_image_valid()
    {
        $this->book_image = $_FILES['book_file'];
        $this->book_image_name = $this->book_image["name"];

        $allowed_extensions = array("jpg", "jpeg", "png");
        $file_extension = pathinfo($this->book_image_name, PATHINFO_EXTENSION);
        
        if (in_array($file_extension, $allowed_extensions)) {
            $this->book_image_path = "BOOKS_IMAGES/" . $this->book_image_name;
        } else {
            $this->error_book_image = "Invalid file type. Allowed file types: " . implode(", ", $allowed_extensions);
        }
        
    }
}


/**
* Trait to validate the login details for the admin and user
*/
trait validate_login
{

/**
*Function to check whether the email is existed in the databse or not. 
*If yes then check the password is valid or not.
*Check status of the user. If its active user can login otherwise unable to login.
*Store the login user information into session and redirect to another page.
*
* @return void 
*/
    function user_login()
    {
        $this->email = $_POST['user_email_login'];
        $this->password = $_POST['user_password_login'];
        $allEmails = $this->get_user_emails();

        if (!in_array($this->email, $allEmails)) {
            $this->error_password = 'Please register yourself first!';
            return;
        }

        $this->login_user_password($this->email);

        if (!password_verify($this->password, $this->hashedPassword)) {
            $this->error_password = 'Password is incorrect!';
            return;
        }

        $this->check_users_status($this->email);

        if ($this->row['user_status'] !== 'ACTIVE' && $this->row['user_status'] !== 'active') {
            $this->error_email = 'Please register yourself first!';
            return;
        }

        $_SESSION['login'] = $_POST['user_email_login'];
        header("location: INDEX.PHP");
    }

/**
*Function to check whether the admin email is existed in the admin database or super admin database. 
*If yes then varify the password is valid or not.
*if varified password, store the login admin information into session and redirect to another page.
*
* @return void 
*/

    public function admin_login()
    {
        $this->email = $_POST['admin_email_login'];
        $this->password = $_POST['admin_password_login'];

        $this->all_admins();

        $all_emails = $this->get_admin_emails();
        $super_admin_email = $this->get_super_admin_emails();

        $this->login_admin($this->email);

        if (in_array($this->email, $all_emails) && password_verify($this->password, $this->hashedPassword)) {
            $_SESSION['admin_login'] = $_POST['admin_email_login'];
            header("location:ADMIN_DASHBOARD.PHP");
        } else {
            $this->error_password = 'Wrong Password or email!';
        }

        $this->get_super_admin_password($this->email);
        if (in_array($this->email, $super_admin_email) && ($this->password == $this->row1['s_admin_password'])) {
            $_SESSION['admin_login'] = $_POST['admin_email_login'];
            header("location:ADMIN_DASHBOARD.PHP");
        } else {
            $this->error_password = 'Wrong Password or email!';
        }

    }
}


/**
*trait to validate the order related details 
*
*/
trait validate_order_details
{
    use validation_trait;

/**
*Function to check whether the selected duretion date of rent is valid or not.
*Validate that user can't select the past date as return date of the book.
*As per our company policy we can't give the book more than 2 months on rent) 
*
* @return void 
*/
    public function is_duration_valid()
    {
        $this->duration = $_POST['duration'];
        $this->start_date = $this->current_date();

        $date1 = new DateTime($this->start_date);
        $date2 = new DateTime($this->duration);

        $interval = $date1->diff($date2);
        $this->daysDifference = $interval->days;
        if ($this->is_not_empty($this->duration) || !isset($this->duration)) {

            if ($this->daysDifference > 70) {
                $this->error_duration = "You can not buy this book more then 2 months on rent!";
                return;
            }

            if ($date2 < $date1) {
                $this->error_duration = "Please select valid date!";
                return;
            }

        } else {
            $this->error_duration = "This feild can't be empty!";
        }
    }


/**
*Function to check that user allow to automatic payment from his credit/debit card. 
*
* @return void 
*/
    public function is_payment_valid()
    {
        if (!isset($_POST['payment'])) {
            $this->error_payment = "Please check the payment option.";
        }
    }
}


/**
*class for overall validation(user,admin..) 
*
*/
class validation extends database
{
    use validation_trait, validate_book, validate_login, validate_order_details;

/**
*Function to check whether the name is empty or  not.
*To validate name that it can contain only Small letters, Capital letters or white spaces 
*
* @return void 
*/
    public function is_name_valid()
    {
        $this->name = $_POST['name'];
        if (empty(trim($this->name))) {
            $this->error_name = "Please enter valid name!";
            return;
        }
        if ($this->is_name_pattren_valid($this->name)) {
            $this->error_name = "Only alphabets and whitespace are allowed!";
            return;
        }
    }

/**
*Function to check whether the DOB is empty or not.
*validate if input date is a future date or past. 
*
* @return void 
*/
    public function is_dob_valid()
    {
        $this->dob = $_POST['dob'];
        $this->dob = $this->is_date_format_valid($this->dob);

        if ($this->is_not_empty($this->dob) || !isset($this->dob)) {
            if ($this->dob > date("Y-m-d")) {
                $this->error_dob = "Please select valid DOB!";
                return;
            }
        } else {
            $this->error_dob = "This field can't be empty!";
        }
    }

/**
*Function to check that any gender is selected or not. 
*
* @return void 
*/
    public function is_gender_valid()
    {        
        $this->error_gender = isset($_POST['gender']) ? null : "Please select your gender!";
    }

/**
*Function to check whether the email is empty or not.
*Check if the pattren is not correct as email must contain (@) and (.).
*Check if email is already existed in the database or not. 
*
* @return void 
*/    
    public function is_email_valid()
    {
        $this->email = $_POST['email'];
        $this->error_email = empty($this->email) ? "Please enter your email address!" : null;

        if ($this->is_email_pattren_valid($this->email)) {
            $this->error_email = "Email must contain (@) and (.)!";
            return;
        }

        $all_emails = $this->get_user_emails();
        if (in_array($this->email, $all_emails)) {
            $this->error_email = "This email is already associated with an account.!";
            return;
        }

    }

/**
*Function to check whether the phone number is empty or not.
*Check only nmerical data is entred.
*check the length of the phone number.
*Check if phone is already existed in the database or not. 
*
* @return void 
*/
    public function is_phone_valid()
    {
        $this->phone = $_POST['phone'];

        $this->error_phone = empty($this->phone) ? "Please enter your phone number!" : null;

        if (!ctype_digit($this->phone)) {
            $this->error_phone = "You can enter only numeric digits";
            return;
        }

        if ($this->is_phone_length_valid($this->phone)) {
            $this->error_phone = "Phone Number must contain 10 digits!";
            return;
        }

        $all_phones = $this->get_user_phone();
        if (in_array($this->phone, $all_phones)) {
            $this->error_phone = "This phone number is already associated with an account.!";
            return;
        }
    }

/**
*Function to check whether the address is empty or not.
*
* @return void 
*/
    public function is_address_valid()
    {
        $this->address = $_POST['address'];
        if (empty(trim($this->address))) {
            $this->error_address = "Please enter valid address!";
            return;
        }
    }
/**
*Function to check whether the sequrity question is empty or not.
*
* @return void 
*/
    public function is_security_question_valid()
    {
        $this->security_question = $_POST['user_security'];
        if (empty(trim($this->security_question))) {
            $this->error_security_question = "Please answer this question for your future security!";
            return;
        }
    }

/**
*Function to check whether the password is empty or not.
*Validate password that one capital lettle, one small letter, one numeric value and one special character is entred or not.
*Validate the length of the password.
*
* @return void
*/
    public function is_password_valid()
    {
        $this->password = $_POST['password'];

        $this->error_password = empty($this->password) ? "Please enter your password!" : null;

        if ($this->is_password_length_valid($this->password)) {
            $this->error_password = "Password must contain atleast 8 characters!";
            return;
        }

        if ($this->is_number($this->password)) {
            $this->error_password = "Password must contain atleast one numeric value!";
            return;
        }

        if ($this->is_capital($this->password)) {
            $this->error_password = "Password must contain atleast one capital letter!";
            return;
        }

        if ($this->is_small($this->password)) {
            $this->error_password = "Password must contain atleast one small letter!";
            return;
        }

    }

/**
* Function to validate password that one capital lettle, one small letter, one numeric value and one special character is entred or not.
*Validate the length of the password.
*
* @return void
*/
    public function is_new_password_valid()
    {
        $this->password = $_POST['password'];
        if ($this->is_password_length_valid($this->password)) {
            $this->error_password = "Password must contain atleast 8 characters!";
            return;
        }

        if ($this->is_number($this->password)) {
            $this->error_password = "Password must contain atleast one numeric value!";
            return;
        }

        if ($this->is_capital($this->password)) {
            $this->error_password = "Password must contain atleast one capital letter!";
            return;
        }

        if ($this->is_small($this->password)) {
            $this->error_password = "Password must contain atleast one small letter!";
            return;
        }

    }

/**
*Function to check whether the card number is empty or not.
*Validate card number that only numerical data can be entred.
*Validate the length of the card number.
*
* @return void
*/
    public function is_card_number_valid()
    {
        $this->card_number = $_POST['card_number'];
        $this->error_card_number = empty(trim($this->card_number)) ? "Please enter your debit/credit card number! " : null;

        if (!ctype_digit($this->card_number)) {
            $this->error_card_number = "Please enter valid debit/credit card number!";
            return;
        }

        if (strlen((string) $this->card_number) !== 16) {
            $this->error_card_number = "Please enter valid debit/credit card number!";
            return;
        }

    }

/**
*Function to check whether the name on the card is empty or not.
*Validate name that only capital letters, small letters and white space can be entred.
*
* @return void
*/
    public function is_name_on_card_valid()
    {
        $this->name_on_card = $_POST['name_on_card'];
        $this->error_name_on_card = empty(trim($this->name_on_card)) ? "Please enter valid card number!" : null;

        if ($this->is_name_pattren_valid($this->name_on_card)) {
            $this->error_name_on_card = "Only alphabets and whitespace are allowed!";
            return;
        }
    }

/**
*Function to check whether the cvv is empty or not.
*Validate cvv that only numerical digits can be entred.
*Validate the length of the cvv.
*
* @return void
*/
    public function is_cvv_valid()
    {
        $this->cvv = $_POST['cvv'];
        if (empty(trim($this->cvv))) {
            $this->error_cvv = "Please enter cvv of credit/debit card!";
            return;
        }

        if (strlen((string) $this->cvv) !== 3) {
            $this->error_cvv = "Please enter 3 digits of cvv!";
            return;
        }

        if (!ctype_digit($this->cvv)) {
            $this->error_cvv = "Please enter valid cvv!";
            return;
        }
    }


/**
*Function to check whether the card expiry year and month is empty or not.
*Validate the range of the month.
*validate the year of expiry.
*
* @return void
*/
    public function is_expiry_date_valid()
    {
        $this->card_expiry_month = $_POST['month'];
        $this->card_expiry_year = $_POST['year'];

        $this->error_card_expiry_month = empty(trim($this->card_expiry_month)) ? "Please enter expiry month!" : null;
        $this->error_card_expiry_year = empty(trim($this->card_expiry_year)) ? "Please enter expiry year!" : null;

        if ($this->card_expiry_year < date("y")) {
            $this->error_year = "Please select valid year!";
            return;
        }

        if ($this->card_expiry_month < 0 || $this->card_expiry_month > 12) {
            $this->error_month = "Please enter valid month!";
            return;
        }
    }


/**
*Function to check whether the extension of the picture is valid or not.
*
* @return void
*/
    public function is_profile_picture_valid()
    {
        $this->profile_picture = $_FILES['profile_picture'];
        $this->profile_picture_name = $this->profile_picture["name"];

        $allowed_extensions = array("jpg", "jpeg", "png");
        $file_extension = pathinfo($this->profile_picture["name"], PATHINFO_EXTENSION);

        if (in_array($file_extension, $allowed_extensions)) {
            $this->profile_picture_path = "USER_IMAGES/" . $this->profile_picture_name;
        } else {
            $this->error_profile_picture = "Invalid file type. Allowed file types: " . implode(", ", $allowed_extensions);
        }
    }

/**
*Function to check whether the extension of the admin profile is valid or not.
*
* @return void
*/
    public function is_admin_file_valid()
    {
        $this->profile_picture = $_FILES['profile_picture'];
        if ($this->is_not_empty($this->profile_picture)) {
            $this->profile_picture_name = $this->profile_picture["name"];

            $allowed_extensions = array("jpg", "jpeg", "png");
            $file_extension = pathinfo($this->profile_picture_name, PATHINFO_EXTENSION);

            if (in_array($file_extension, $allowed_extensions)) {
                $this->profile_picture_path = "ADMINS_PROFILE_PICS/" . $this->profile_picture_name;
            } else {
                $this->error_profile_picture = "Invalid file type. Allowed file types: " . implode(", ", $allowed_extensions);
            }
        }
    }
}

$object_validation = new validation("localhost", "param", "161607", "BookRentelSystem");
$object_database = new database("localhost", "param", "161607", "BookRentelSystem");

if (isset($_SESSION['login'])) {
    $object_database->users_data($_SESSION['login']);
}

if (isset($_POST['delete_user'])) {
    $object_database->delete_from_user($_SESSION['login']);
    unset($_SESSION['login']);
    header('location:LOGIN.PHP');
}


if (isset($_POST['logut_user'])) {
    unset($_SESSION['login']);
}




if (isset($_POST['delete_category'])) {
    $category = $_POST['book_category'];
    $object_database->delete_book_category($category);
    header('location: ALL_BOOKS.PHP');
}



if (isset($_POST['admin_login'])) {
    $object_validation->admin_login();
}

if (isset($_POST['log_out_admin'])) {
    // session_destroy();
    unset($_SESSION['admin_login']);
}







?>