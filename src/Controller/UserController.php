<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    public function login()
    {
        $errorsLogin = [];


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $credentialsLogin = array_map('trim', $_POST);

            if (!isset($credentialsLogin['identifiant']) || empty($credentialsLogin['identifiant'])) {
                $errorsLogin['identifiant'] = 'Veuillez entrer votre pseudonyme ou votre email';
            }

            if (!isset($credentialsLogin['password']) || empty($credentialsLogin['password'])) {
                $errorsLogin['password'] = 'Veuillez entrer votre mot de passe';
            }

            if($errorsLogin) {
                return json_encode(['errorsLogin' => $errorsLogin]);
            }
            
            if (!$errorsLogin) {
                $userManager = new UserManager();
                $user = $userManager->selectOneByIdentifiant($credentialsLogin['identifiant']);
                if ($user && password_verify($credentialsLogin['password'], $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    return json_encode(['status_login' => 'success', 'message_success' => 'connexion réussie']);                    
                } else {
                    return json_encode(['status_login' => 'errors', 'message_error' => 'erreur connexion']);
                }
            }
            
        }
    }

}