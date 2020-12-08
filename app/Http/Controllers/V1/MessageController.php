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

class MessageController extends Controller
{
    public function SendMessage(Request $request = NULL, $params = NULL){
        $speed = microtime(true);
        $param = $params;
        if(is_null($params)) $param = $request->all();
        $token = !empty($request->header("X-Token")) ? $request->header("X-Token"): '';
        $from = (isset($param['params']['from']) ? $param['params']['from'] : NULL);
        $to = (isset($param['params']['to']) ? $param['params']['to'] : NULL);
        $message = (isset($param['params']['message']) ? $param['params']['message'] : NULL);
        $getFrom = MainModel::getUser($from);
        $getTo = MainModel::getUser($to);
        if(!empty($getFrom) && !empty($getTo)){
            if($getFrom[0]['remember_token'] == $token){
                $Input = array(
                    'from' => $getFrom[0]['id'],
                    'to' => $getTo[0]['id'],
                    'text' => $message,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                );
                $save = MainModel::insertMessage($Input);
                $getMessage = MainModel::getMessage($getFrom[0]['id']);
                return ResponseConnected::SuccessResponse("Send Message", $getMessage, $speed,"Success Send Message");
            }else{
                return ResponseConnected::ErrorResponse("Send Message", [], $speed, "Auth Token is Wrong, message could not be sent");    
            }
        }else{
            return ResponseConnected::ErrorResponse("Send Message", [], $speed, "message could not be sent");
        }
    }

    public function listMessage(Request $request = NULL, $params = NULL){
        $speed = microtime(true);
        $param = $params;
        if(is_null($params)) $param = $request->all();
        $token = !empty($request->header("X-Token")) ? $request->header("X-Token"): '';
        $email = (isset($param['params']['email']) ? $param['params']['email'] : NULL);
        $getUser = MainModel::getUser($email);
        if(!empty($getUser)){
            if($getUser[0]['remember_token'] == $token){
                $getListMessage =  MainModel::getListMessage($getUser[0]['id']);
                if(!empty($getListMessage)){
                    $listMessage =[];
                    foreach($getListMessage as $valueMessage){
                        $getUser = MainModel::getUser(null,$valueMessage['to']);
                        $listMessage[] = [
                            'id'   => $valueMessage['id'],
                            'Name' => $getUser[0]['name'],
                            'email' => $getUser[0]['email'],
                            'Text' => $valueMessage['text'],
                            'Time' => $valueMessage['updated_at']
                        ];
                    }
                    return ResponseConnected::SuccessResponse("List Message", $listMessage, $speed,"Success Get List Message");
                }else{
                    return ResponseConnected::ErrorResponse("List Message", [], $speed, "List Message Not Found");    
                }
            }else{
                return ResponseConnected::ErrorResponse("List Message", [], $speed, "Auth Token is Wrong, list message could not be get");    
            }
        }else{
            return ResponseConnected::ErrorResponse("List Message", [], $speed, "list message could not be get");
        }
        
    }

    public function listReceiveMessage(Request $request = NULL, $params = NULL){
        $speed = microtime(true);
        $param = $params;
        if(is_null($params)) $param = $request->all();
        $token = !empty($request->header("X-Token")) ? $request->header("X-Token"): '';
        $from = (isset($param['params']['from']) ? $param['params']['from'] : NULL);
        $to = (isset($param['params']['to']) ? $param['params']['to'] : NULL);
        $getFrom = MainModel::getUser($from);
        $getTo = MainModel::getUser($to);
        if(!empty($getFrom) && !empty($getTo)){
            if($getFrom[0]['remember_token'] == $token){
                $getReceiveMessage = MainModel::getReceiveMessage($getFrom[0]['id'], $getTo[0]['id']);
                if(!empty($getReceiveMessage)){
                    $dataReceive = [];
                    foreach($getReceiveMessage as $value){
                        $getFrom = MainModel::getUser(null,$value['from']);
                        $getTo = MainModel::getUser(null,$value['to']);
                        $dataReceive []= [
                            'id' => $value['id'],
                            'FromName' => $getFrom[0]['name'],
                            'ToName' => $getTo[0]['name'],
                            'Text' => $value['text'],
                            'Time' => $value['updated_at'],
                        ];
                    }
                    return ResponseConnected::SuccessResponse("Receive Message", $dataReceive, $speed,"Success Get Message");
                }else{
                    return ResponseConnected::ErrorResponse("Receive Message", [], $speed, "Message Not Found");    
                }
            }else{
                return ResponseConnected::ErrorResponse("Receive Message", [], $speed, "Auth Token is Wrong, message could not be get");    
            }
        }else{
            return ResponseConnected::ErrorResponse("Receive Message", [], $speed, "message could not be get");
        }
    }
}