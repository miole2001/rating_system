<?php 
    //to display errors
    error_reporting(E_ALL);
    ini_set('display_errors', 1);


   //DATABASE CONNECTION FOR ACCOUNTS
   $db_name = 'mysql:host=localhost;dbname=RJE_accounts';
   $db_user_name = 'root';
   $db_user_pass = '';

   $connForAccounts = new PDO($db_name, $db_user_name, $db_user_pass);

   function create_unique_id(){
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $characters_lenght = strlen($characters);
      $random_string = '';
      for($i = 0; $i < 20; $i++){
         $random_string .= $characters[mt_rand(0, $characters_lenght - 1)];
      }
      return $random_string;
   }

   if(isset($_COOKIE['user_id'])){
      $user_id = $_COOKIE['user_id'];
   }else{
      $user_id = '';
   }

   //DATABASE CONNECTION FOR POSTS
   $db_name = 'mysql:host=localhost;dbname=RJE_posts';
   $db_user_name = 'root';
   $db_user_pass = '';

   $connForPosts = new PDO($db_name, $db_user_name, $db_user_pass);


   //DATABASE CONNECTION FOR ADMIN & USER LOGS

   $db_name = 'mysql:host=localhost;dbname=RJE_logs';
   $db_user_name = 'root';
   $db_user_pass = '';

   $connForLogs = new PDO($db_name, $db_user_name, $db_user_pass);


?>