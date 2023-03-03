<?php
session_start();

// if (ini_get("session.use_cookies")) {
//     $params = session_get_cookie_params();
//     setcookie(
//         session_name(),
//         '',
//         time() - 42000,
//         $params["path"],
//         $params["domain"],
//         $params["secure"],
//         $params["httponly"]
//     );
// }
// unset($_SESSION);
session_destroy();
// echo json_encode($_SESSION);

header("location:login.php");
