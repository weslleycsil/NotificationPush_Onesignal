<?php

class NP_Onesignal {

    private $linkApi = 'https://onesignal.com/api/v1/';
    private $KeyApp, $AppId, $KeyUser;

    public function __construct() {
        $this->KeyApp = get_option( 'np_app_key' );
        $this->AppId = get_option( 'np_app_id' );
        $this->KeyUser = get_option( 'np_user_key' );
    }

    public function sendNotALL(NP_Push $push){
        $headers = array('Content-Type: application/json; charset=utf-8','Authorization: Basic '.$this->KeyApp);

        $content = array(
			"en" => $push->getMsg()
        );
        $title = array(
            "en" => $push->getTitulo()
        );
		
		$fields = array(
			'app_id' => $this->AppId,
			'included_segments' => array('All'),
			'data' => array("foo" => "bar"),
            'contents' => $content,
            'headings' => $title
        );

        $req = new NP_Request($this->linkApi.'notifications');
        $req->setRequestType('POST');
        $req->setHttpHeaders($headers);
        $req->setPostFields($fields);

        //tratar a execução
        $req->execute();
        return $req->getResponse();

    }

    public function sendNot(NP_Push $push){
        $headers = array('Content-Type: application/json; charset=utf-8','Authorization: Basic '.$this->KeyApp);

        $content = array(
			"en" => $push->getMsg()
        );
        $title = array(
            "en" => $push->getTitulo()
        );
		
		$fields = array(
			'app_id' => $this->AppId,
			'include_player_ids' => array($push->getDeviceID()),
			'data' => array("foo" => "bar"),
			'contents' => $content,
            'headings' => $title
        );

        $req = new NP_Request($this->linkApi.'notifications');
        $req->setRequestType('POST');
        $req->setHttpHeaders($headers);
        $req->setPostFields($fields);

        //tratar a execução
        $req->execute();
        return $req->getResponse();
    }

    public function getInfoApp(){
        $headers = array('Content-Type: application/json; charset=utf-8','Authorization: Basic '.$this->KeyUser);


        $req = new NP_Request($this->linkApi.'apps/'.$this->AppId);
        $req->setHttpHeaders($headers);

        //tratar a execução
        $req->execute();
        return $req->getResponse();
    }

    public function listNotifications($limit){
        $headers = array('Content-Type: application/json; charset=utf-8','Authorization: Basic '.$this->KeyApp);

        $req = new NP_Request($this->linkApi.'notifications?app_id='.$this->AppId.'&limit='.$limit);
        $req->setHttpHeaders($headers);

        //tratar a execução
        $req->execute();
        return $req->getResponse();
    }

    public function getDeviceInfo($PushId){
        $headers = array('Content-Type: application/json; charset=utf-8','Authorization: Basic '.$this->KeyApp);

        $req = new NP_Request($this->linkApi.'players/'.$PushId.'?app_id='.$this->AppId);
        $req->setHttpHeaders($headers);

        //tratar a execução
        $req->execute();
        return $req->getResponse();
        
    }

    public function printVarsOptions(){
        echo '<br>';
        echo $this->KeyApp;
        echo '<br>';
        echo $this->AppId;
        echo '<br>';
        echo $this->KeyUser;
        echo '<br>';
    }

}