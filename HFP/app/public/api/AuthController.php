<?php
require_once(__DIR__ . '/../models/UserModel.php');
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');

class AuthController{
    private $UserModel;
    public function __construct()
    {
        $this->UserModel = new UserModel();

    }

    public function registerUser($username, $email, $password){
        try{
            if($username === null || $password === null || $email === null){
                ResponseHelper::sendError("Username, Email or Password missing", 400);
            }
            $this->UserModel->registerUser($username, $email, $password);
        }catch(Exception $e){
            ResponseHelper::sendError("Database connection error", 500);
        }
    }

    public function loginUser($username, $email, $password){
        try{
            if($username === null || $password === null || $email === null){
                ResponseHelper::sendError("Username, Email or Password missing", 400);
            }
            $this->UserModel->loginUser($username, $email, $password);
        }catch(Exception $e){
            ResponseHelper::sendError("Could not retrieve user", 500);
        }
    }

    public function logoutUser(){
        try{
            $this->UserModel->logoutUser();
        }catch(Exception $e){
            ResponseHelper::sendError("General error", 400);
        }
    }

    public function getUser($username, $password){
        try{
            if($username === null || $password === null){
                ResponseHelper::sendError("Username or Password missing", 400);
            }
            $user = $this->UserModel->getUser($username, $password);
            if($user){
                ResponseHelper::sendJson($user);
            }
            else{
                ResponseHelper::sendError("User not found", 404);
            }
        }catch(Exception $e){
            ResponseHelper::sendError("Could not retrieve user", 500);
        }
    }
    public function getUserByUsername($username){
        try{
            if($username === null){
                ResponseHelper::sendError("Username missing", 400);
            }
            $user = $this->UserModel->getUserByUsername($username);
            if($user){
                ResponseHelper::sendJson($user);
            }
            else{
                ResponseHelper::sendError("User not found", 404);
            }
        }catch(Exception $e){
            ResponseHelper::sendError("Could not retrieve user", 500);
        }
    }
}

?>