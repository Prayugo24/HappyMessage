<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

#Load Component External
use Cache;
use Config;
use Carbon\Carbon;


class MainModel extends Model
{
    #================ getUser ==================================
        static function getUser($email=null, $id =null){
            ini_set('memory_limit','1024M');
            $query = DB::connection('mysql')
                ->table('users')
                ->where('email', $email)
                ->orWhere('id',$id);
            $query = $query->get();

            $result = [];
            if(count($query)) $result = collect($query)->map(function($x){ return (array) $x; })->toArray();
            return $result;
        }
    #================ End getUser ==================================

    #================  insertUser ==================================
        public static function insertUser($data_all = [], $justInsert = FALSE){
            $tabel_name = 'users';
            $query = DB::connection('mysql')
                ->table($tabel_name);
            if($justInsert){
                $query = $query->insert($data_all);
            }else{
                $query = $query->insertGetId($data_all);
            }
            $error = [];
            $data['status'] = 200;
            $data['message'] = 'success insert '.$tabel_name;
            if(!$query) {
                $data['status'] = 400;
                $data['message'] = 'failed insert '.$tabel_name;
                $error['msg'] = 'error insert '.$tabel_name;
                $error['num'] = 'error num insert '.$tabel_name;
            }

            $data['error'] 	= $error;
            if(!$justInsert) $data['id_result'] = $query;
            return $data;
        }
    #================ End insertUser ==================================

    #================  insertMessage ==================================
        public static function insertMessage($data_all = [], $justInsert = FALSE){
            $tabel_name = 'messages';
            $query = DB::connection('mysql')
                ->table($tabel_name);
            if($justInsert){
                $query = $query->insert($data_all);
            }else{
                $query = $query->insertGetId($data_all);
            }
            $error = [];
            $data['status'] = 200;
            $data['message'] = 'success insert '.$tabel_name;
            if(!$query) {
                $data['status'] = 400;
                $data['message'] = 'failed insert '.$tabel_name;
                $error['msg'] = 'error insert '.$tabel_name;
                $error['num'] = 'error num insert '.$tabel_name;
            }

            $data['error'] 	= $error;
            if(!$justInsert) $data['id_result'] = $query;
            return $data;
        }
    #================ End insertMessage ==================================

    #================ getMessage ==================================
        static function getMessage($from){
            ini_set('memory_limit','1024M');
            $query = DB::connection('mysql')
                ->table('messages')
                ->where('from', $from);
            $query = $query->latest()->first();

            $result = [];
            if(!empty($query)){
                $result = $query;
            }

            return $result;
        }
    #================ End getMessage ==================================

    #================ getReceiveMessage ==================================
        static function getReceiveMessage($from,$to){
            ini_set('memory_limit','1024M');
            $query = DB::connection('mysql')
                ->table('messages')
                ->where(function ($query) use ($from,$to){
                    $query->where('from',$from)
                        ->where('to',$to);
                })
                ->orWhere(function ($query) use ($from,$to){
                    $query->where('to',$from)
                        ->where('from',$to);
                });
            
            $query = $query->get();

            $result = [];
            if(count($query)) $result = collect($query)->map(function($x){ return (array) $x; })->toArray();
            return $result;
        }
    #================ End getReceiveMessage ==================================

    #================ getListMessage ==================================
        static function getListMessage($from){
            ini_set('memory_limit','1024M');
            $query = DB::connection('mysql')
                    ->table('messages')
                    ->where('from',$from);
            $query = $query->get();            

            $result = [];
            if(count($query)){
                $filter = [];
                $query = collect($query)->map(function($x){ return (array) $x; })->toArray();
                foreach($query as $valueQuery){
                    if(!empty($filter)){
                        foreach($filter as $key => $valueFilter){
                            if($valueFilter['to'] == $valueQuery['to']){
                                $filter[$key]=[
                                    'id' => $valueQuery['id'],
                                    'from' => $valueQuery['from'],
                                    'to' => $valueQuery['to'],
                                    'text' => $valueQuery['text'],
                                    'updated_at' => $valueQuery['updated_at'],
                                ];
                            }else{
                                $filter [] = [
                                    'id' => $valueQuery['id'],
                                    'from' => $valueQuery['from'],
                                    'to' => $valueQuery['to'],
                                    'text' => $valueQuery['text'],
                                    'updated_at' => $valueQuery['updated_at'],
                                ];
                            }
                        }
                    }else{
                        $filter [] = [
                            'id' => $valueQuery['id'],
                            'from' => $valueQuery['from'],
                            'to' => $valueQuery['to'],
                            'text' => $valueQuery['text'],
                            'updated_at' => $valueQuery['updated_at'],
                        ];
                    }
                }
                $result = $filter;
            } 
            
            return $result;
        }
    #================ End getListMessage ==================================

}