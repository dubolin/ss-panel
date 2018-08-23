<?php


namespace Ss\User;


class Invite {

    public $uid;
    private $db;

    private $table = "invite_code";


    function  __construct($uid=0){

        global $db;
        $this->db   = $db;
        $this->uid = $uid;
    }

    function CodeArray(){
        $datas = $this->db->select("user","invite_key",[
            "ORDER" => "last_check_in_time DESC",
            "LIMIT" => "10"
        ]);
        return $datas;
    }

    function AddAllCode(){
        $u = new UserInfo($this->uid);
        $num = $u->InviteNum();
        $sub = $this->uid;
        for($a=0;$a<$num;$a++) {
            $x = rand(10, 1000);
            $z = rand(10, 1000);
            $x = md5($x).md5($z);
            $x = base64_encode($x);
            $code = $sub.substr($x, rand(1, 13), 24);
            $this->db->insert("invite_code",[
                "code" => $code,
                "user" => $this->uid
            ]);
        }
    }

}