<?php

class NP_Push {

    private $titulo, $msg, $pushID, $dataHora;

    public function __construct() {
        $a = func_get_args(); 
        $i = func_num_args(); 
        if (method_exists($this,$f='__construct'.$i)) { 
            call_user_func_array(array($this,$f),$a); 
        }
    }

    public function __construct4($tituloMsg, $mensagem, $idUsuario, $dateHour) {
        $this->titulo = $tituloMsg;
        $this->msg = $mensagem;
        $this->pushID = $this->getPushID($idUsuario);
        $this->dataHora = $this->formateDate($dateHour); 
    }

    public function __construct3($tituloMsg, $mensagem, $dateHour) {
        $this->titulo = $tituloMsg;
        $this->msg = $mensagem;
        $this->pushID = null;
        $this->dataHora = $this->formateDate($dateHour); 
    }

    private function getPushID($id){
        return get_field( "pushID", 'user_'.$id );
    }

    private function formateDate($date){
        if ($date == null) {
            return null;
        } else {
        return str_replace ('T', ' ', $date).':00 UTC-0300';
        }
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
        echo $this->dataHora;
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
    public function getDate(){
        return $this->dataHora;
    }
}