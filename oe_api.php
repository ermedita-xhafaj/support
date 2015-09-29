<?php
include('xmlrpc.inc');

class OpenerpApi{

private $host = 'improdemo.commprog.com';
	private $db = 'impro_demo';
	private $user = 'admin';
	private $pass = 'i_demo123@@';
	private $server_url = 'http://improdemo.commprog.com/xmlrpc/';
	private $client = null;
	private $uid = -1;

	function __construct() {
		$this->connect();
	}

	function __destroy() {
		$this->connect();
	}

	/**
	 * Ndihmes per zhveshjen rekursive te nje array nga xmlrpc ne vlerat perkatese skalare, per qartesimin e vlerave ne prezantim
	 */
	private function zhvish_rpc(&$rpc_arr) {
		# zhvish argumentin aktual
		$rpc_arr = $rpc_arr->scalarval();
		# kontrollo a lejohet iterimi i metejshem
		$arg_type = gettype($rpc_arr);
		if(!in_array($arg_type, array('array', 'object'))) return;
		# rekursion tek femijet
		foreach($rpc_arr as &$nen_arr) {
			$this->zhvish_rpc($nen_arr);
		}
	}

	/**
	 * Lidhu me serverin
	 */
	public function connect() {
		$this->client = new xmlrpc_client($this->server_url.'common');
		#$this->client->setSSLVerifyPeer(0);
		$msg = new xmlrpcmsg('login');
		$msg->addParam(new xmlrpcval($this->db, "string"));
		$msg->addParam(new xmlrpcval($this->user, "string"));
		$msg->addParam(new xmlrpcval($this->pass, "string"));
		$resp = $this->client->send($msg);
		$val = $resp->value();
		$id = $val->scalarval();
		$this->uid = $id;
	}

	public function create_record($values, $model_name) {
        $this->client = new xmlrpc_client($this->server_url.'object');
        //$this->$client->return_type = 'phpvals';
        //   ['execute','userid','password','module.name',{values....}]
        $nval = array();
        foreach($values as $k=>$v){
				$nval[$k] = new xmlrpcval( $v, xmlrpc_get_type($v) );
        }
         
        $msg = new xmlrpcmsg('execute');
        $msg->addParam(new xmlrpcval($this->db, "string"));  //* database name */
        $msg->addParam(new xmlrpcval($this->uid, "int")); /* useid */
        $msg->addParam(new xmlrpcval($this->pass, "string"));/** password */
        $msg->addParam(new xmlrpcval($model_name, "string"));/** model name where operation will held * */
        $msg->addParam(new xmlrpcval("create", "string"));/** method which u like to execute */
        $msg->addParam(new xmlrpcval($nval, "struct"));/** parameters of the methods with values....  */
        
        $resp = $this->client->send($msg);
        return $resp;
        if ($resp->faultCode())
            return -1; /* if the record is not created  */
        else
            return $resp->value();  /* return new generated id of record */
    }
	
	
	/* Funksioni i leximit te nje sherbimi
	* @args: $service => servisi i deshiruar
	* @args: $objectid => kodi i kerkimit
	* @args: $uid => Numri Personal i Kerkuesit
	* @return: $status => statusi i porosise
	*/
	public function search_helpdeskID($service = "project.issue", $objectid = 0, $uid = '') {
		$this->client = new xmlrpc_client($this->server_url.'object');
		$keys = array(new xmlrpcval(array(new xmlrpcval("helpdesk_id" , "string"),
						new xmlrpcval("=","string"),
						new xmlrpcval($objectid,"string")),"array")
						
			);

		$msg = new xmlrpcmsg('execute');
		$msg->addParam(new xmlrpcval($this->db, "string"));
		$msg->addParam(new xmlrpcval($this->uid, "int"));
		$msg->addParam(new xmlrpcval($this->pass, "string"));
		$msg->addParam(new xmlrpcval($service, "string"));
		$msg->addParam(new xmlrpcval("search", "string"));
		$msg->addParam(new xmlrpcval($keys, "array"));
		$resp = $this->client->send($msg);
		$ids = $resp->value();
		if(empty($ids)){
				return array(array("state" => "Nuk ekziston helpdesk_id!"));
		} else {
			$this->zhvish_rpc($ids);
			
		}
		
		return $ids;
	}
	//kerkojme per korrelance projektesh
	public function search_projectID($service = "project.issue", $objectid = 0, $uid = '') {
		$this->client = new xmlrpc_client($this->server_url.'object');
		$keys = array(new xmlrpcval(array(new xmlrpcval("code" , "string"),
						new xmlrpcval("=","string"),
						new xmlrpcval($objectid,"string")),"array")
						
			);

		$msg = new xmlrpcmsg('execute');
		$msg->addParam(new xmlrpcval($this->db, "string"));
		$msg->addParam(new xmlrpcval($this->uid, "int"));
		$msg->addParam(new xmlrpcval($this->pass, "string"));
		$msg->addParam(new xmlrpcval($service, "string"));
		$msg->addParam(new xmlrpcval("search", "string"));
		$msg->addParam(new xmlrpcval($keys, "array"));
		$resp = $this->client->send($msg);
		$ids = $resp->value();
		if(empty($ids)){
				return array(array("state" => "Error ne kerkimin e nje project code ne erp!"));
		} else {
			//return $ids;
			$this->zhvish_rpc($ids);
			
		}
		
		return $ids;
	}

}

?>
