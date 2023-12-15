<?php 
  
  // Plaintext password entered by the user 
  $plaintext_password = "Sajal@12345"; 
  
  // The hashed password retrieved from database 
  $hash =  
"$2y$10$OJnk2o2YhYyQvBz2M/yfwObvNglpGs9IJGGGOeT51p9WYre4f8oWC"; 
  
  // Verify the hash against the password entered 
  $verify = password_verify($plaintext_password, $hash); 
  
  // Print the result depending if they match 
  if ($verify) { 
      echo 'Password Verified!'; 
  } else { 
      echo 'Incorrect Password!'; 
  } 
?> 