<?php

// function register($username, $password) {
//   $hash = ;
//   save($username, $hash);
// }

// function login($username, $password) {
//   $hash = loadHashByUsername($username);
//   if (password_verify($password, $hash)) {
//       //login
//   } else {
//       // failure
//   }
// }

// function getRandomString($length = 16) {
//   $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
//   $string = '';

//   for ($i = 0; $i < $length; $i++) {
//       $string .= $characters[mt_rand(0, strlen($characters) - 1)];
//   }

//   return $string;
// }

// $user_id = '2019390018';
// $email = 'madina.chumaera@my.sampoernauniversity.ac.id';
// $full_name = 'Madina Malahayati Chumaera';
// $given_password = '1234';
// $password_salt = getRandomString();
// $password_pepper = getRandomString();
// $password_hash = password_hash("$password_salt$given_password$password_pepper", PASSWORD_BCRYPT);
// $program_id = 8;

// echo "('$user_id', '$email', '$full_name', '$password_salt', '$password_pepper', '$password_hash', $program_id),";
