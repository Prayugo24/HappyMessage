<?php

namespace App\Http\Controllers\V1;
use \Illuminate\Http\Request;
use \Illuminate\Http\Response;
use \App\Http\Controllers\Controller;
use \Carbon\Carbon;
use \App\User;

#Load Helper V1
use App\Helpers\ResponseConnected as ResponseConnected;

#Load Models V1
use App\Models\V1\MainModel as MainModel;

class UsersController extends Controller
{
    public function UserRegister(Request $request = NULL, $params = NULL){
        $speed = microtime(true);
        $param = $params; 
        if(is_null($params)) $param = $request->all();
        $email = (isset($param['params']['email']) ? $param['params']['email'] : NULL);
        $name = (isset($param['params']['name']) ? $param['params']['name'] : NULL);
        $password_1 = (isset($param['params']['password_1']) ? $param['params']['password_1'] : NULL);
        $password_2 = (isset($param['params']['password_2']) ? $param['params']['password_2'] : NULL);
        $Users = MainModel::getUser($email);
        if(empty($Users)){
            if($password_1 == $password_2 ){
                $Input = array(
                    'email' => $email,
                    'name' => $name,
                    'password' => md5($password_1),
                    'profile_image' => 'http://via.placeholder.com/150x150',
                    'remember_token' => str_random(20),
                );
                $save = MainModel::insertUser($Input);
                $Users = MainModel::getUser($email);
                $LogSave = [
                    'email' =>$Users[0]['email'],
                    'name' =>$Users[0]['name'],
                    'profile_image' => $Users[0]['profile_image'],
                    'remember_token' => $Users[0]['remember_token'],
                ];
                return ResponseConnected::SuccessResponse("Register", $LogSave, $speed,"Success Register");
            }else{
                return ResponseConnected::ErrorResponse("Register", [], $speed, "passwords must be the same");
            }
        }else{
            return ResponseConnected::ErrorResponse("Register", [], $speed, "Email already registered");
        }
    }

    public function UserLogin(Request $request = NULL, $params = NULL){
        $speed = microtime(true);
        $param = $params; 
        if(is_null($params)) $param = $request->all();
        $email = (isset($param['params']['email']) ? $param['params']['email'] : NULL);
        $password = (isset($param['params']['password']) ? md5($param['params']['password']) : NULL);
        $Users = MainModel::getUser($email);
        if(!empty($Users) && $Users[0]['password'] == $password ){
            $LogSave = [
                'email' =>$Users[0]['email'],
                'name' =>$Users[0]['name'],
                'profile_image' => $Users[0]['profile_image'],
                'remember_token' => $Users[0]['remember_token'],
            ];
            return ResponseConnected::SuccessResponse("Login", $LogSave, $speed,"Success Login");
        }else{
            return ResponseConnected::ErrorResponse("Login", [], $speed, "Email or password is wrong");
        }
    }
    
}
