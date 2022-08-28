<?php

declare(strict_types = 1 );

namespace App\Services;

use App\App;
use App\Models\Database\PDOClient;
use App\Models\Entities\UserEntity;
use App\Models\Repositories\UserRepository;
use PDO;

use function PHPUnit\Framework\throwException;

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
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

       if (empty($user)) {
            return false;
       }
        if ($user['login'] === $login && password_verify($password, $user['password'] )) {
            $_SESSION['is_logged_in'] = "USER";
            return true;
        } else  {
            return false;
        }
       return false;
    } 
    
    public static function logOut()
    {
       SessionManager::sessionEnd();
       SessionManager::sessionStart();
    }

    public static function isUserLogged(): bool
    {
        return (
            isset($_SESSION['is_logged_in']) &&
            $_SESSION['is_logged_in'] === "USER") ? true : false;
    }
}