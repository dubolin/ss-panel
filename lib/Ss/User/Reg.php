<?php


namespace Ss\User;


class Reg {

    private $db;

    private $table = "user";

    function __construct(){
        global $db;
        $this->db = $db;
    }

    function Reg($email,$pass,$plan,$transfer,$ref_by){
        global $port_min,$port_max;
        $sspass = \Ss\Etc\Comm::get_random_char(8);
        return $this->db->insert($this->table,[
           "user_name" => $email,
            "email" => $email,
            "pass" => $pass,
            "passwd" =>  $sspass,
            "t" => '0',
            "u" => '0',
            "d" => '0',
            "plan" => $plan,
            "transfer_enable" => $transfer,
            "port" => rand($port_min,$port_max),
            "invite_num" => 0,
            "invite_key" => \Ss\Etc\Comm::get_random_invie_key(6),
            "money" => '0',
            "#reg_date" =>  'NOW()',
            "ref_by" => $ref_by
        ]);
    }

}