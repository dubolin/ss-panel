<?php

namespace Ss\User;


class EmailCheck {

    private $db;
    private $table = "ss_email";
    private $email;

    function __construct($email = 0){
        global $db;
        $this->db  = $db;
        $this->email = $email;
    }

    function NewLog(){
        $init_time = time();
        $expire_time = $init_time+3600*24;
        $char = md5($init_time).md5($this->email);
        $char = base64_encode($char);
        $uni_char = substr($char,rand(1,30),32);
        $this->db->insert($this->table,[
            "init_time" => $init_time,
            "expire_time" => $expire_time,
            "email" => $this->email,
            "uni_char" => $uni_char
        ]);
        return $uni_char;
    }

    function IsCharOK($char,$email){
        if(empty($char) || empty($email)) return false;
        if($this->db->has($this->table,[
            "AND" => [
                "email" => $email,
                "uni_char" => $char
            ]
        ])){
            //
            $datas = $this->db->select($this->table,"*",[
                "AND" => [
                    "email" => $email,
                    "uni_char" => $char

                ],
                "LIMIT"   => '1'
            ]);
            if($datas['0']['expire_time'] < time() ){
                return false;
            }else{
                return true;
            }

        }else{
            //Null
            return false;
        }
    }

    function Del($char,$email)
    {
        $this->db->delete($this->table, [
            "AND" => [
                "email" => $email
            ]
        ]);
    }

    function LogCount(){
        $sum = $this->db->count($this->table,[
            "AND" => [
                "email" => $this->email,
                "expire_time[>]" => time()
            ]
        ]);
        return $sum;
    }

    function IsAbleToRegister(){
        if($this->LogCount()>3){
            return false;
        }else{
            return true;
        }
    }
}