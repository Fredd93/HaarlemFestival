<?php
require_once(__DIR__ . '/../models/LoginModel.php');
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');

class LoginApiCOntroller{
    private $loginModel;
    public function __construct()
    {
        $this->loginModel = new LoginModel();

    }

    public function loginUser($username, $password){
        try{
            if($username === null || $password === null){
                ResponseHelper::sendError("Username or Password missing", 400);
            }
            $this->loginModel->loginUser($username, $password);
        }catch(Exception $e){
            ResponseHelper::sendError("Could not retrieve user", 500);
        }
    }

    public function addUser(){
        ResponseHelper::sendError("Not yet implemented", 404);
    }
    public function deleteUser(){
        ResponseHelper::sendError("Not yet implemented", 404);
    }
    public function getUser($username, $password){
        try{
            if($username === null || $password === null){
                ResponseHelper::sendError("Username or Password missing", 400);
            }
            $user = $this->loginModel->getUser($username, $password);
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
            $user = $this->loginModel->getUserByUsername($username);
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