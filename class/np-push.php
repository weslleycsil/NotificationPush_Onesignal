<?php

class NP_Push {

    private $titulo, $msg, $pushID;

    public function __construct() {
        $a = func_get_args(); 
        $i = func_num_args(); 
        if (method_exists($this,$f='__construct'.$i)) { 
            call_user_func_array(array($this,$f),$a); 
        }
    }

    public function __construct3($tituloMsg, $mensagem, $idUsuario) {
        $this->titulo = $tituloMsg;
        $this->msg = $mensagem;
        $this->pushID = $this->getPushID($idUsuario);
    }

    public function __construct2($tituloMsg, $mensagem) {
        $this->titulo = $tituloMsg;
        $this->msg = $mensagem;
        $this->pushID = null;
    }

    private function getPushID($id){
        return get_field( "pushID", 'user_'.$id );
    }

    public function sendPush(){
        $req = new NP_Onesignal();
        $retorno;
        if($this->getDeviceID() == null){
            //se o destino for todos
            $retorno = $req->sendNotALL($this);
        } else {
            $retorno = $req->sendNot($this);
        }
        return $retorno;
    }

    public function print(){
        echo '<br>';
        echo $this->titulo;
        echo '<br>';
        echo $this->msg;
        echo '<br>';
        echo $this->pushID;
        echo '<br>';
    }

    public function getTitulo(){
        return $this->titulo;
    }
    public function getMsg(){
        return $this->msg;
    }
    public function getDeviceID(){
        return $this->pushID;
    }

}