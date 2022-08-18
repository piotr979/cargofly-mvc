<?php

declare(strict_types = 1 );

namespace App\Services;

use App\App;
use App\Models\Database\PDOClient;
use App\Models\Entities\UserEntity;
use App\Models\Repositories\UserRepository;
use PDO;
class Authorisation
{
    public function __construct()
    {
    }
    public static function login(string $login, string $password): bool
    {
        $conn = App::$app->conn;
        // $user = new UserEntity($conn);
        // $userRepo = new UserRepository($conn);
        // dump($userRepo->getById(1, 'user'));
        
        $stmt = $conn->prepare('SELECT * FROM user WHERE
                                    login = :login');
        $stmt->bindValue(':login', $login);
        $stmt->execute();
        $user = $stmt->fetchAll(PDO::FETCH_OBJ);
        if ($user['login' === $login && $user['password'] === $password ]) {
            $_SESSION['is_logged_in'] = "USER";
            return true;
        } else {
        }
       return false;
    } 
    public static function logOut()
    {
         // Unset all of the session variables.
         $_SESSION = array();

         // If it's desired to kill the session, also delete the session cookie.
         // Note: This will destroy the session, and not just the session data!
         if (ini_get("session.use_cookies")) {
             $params = session_get_cookie_params();
             setcookie(
                 session_name(),
                 '',
                 time() - 42000,
                 $params["path"],
                 $params["domain"],
                 $params["secure"],
                 $params["httponly"]
             );
         }
         session_destroy(); 

    }
    public static function isUserLogged(): bool
    {
        return (
            isset($_SESSION['is_logged_in']) &&
            $_SESSION['is_logged_in'] === "USER") ? true : false;
    }
}