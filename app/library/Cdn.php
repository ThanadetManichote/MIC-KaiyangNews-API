<?php
namespace App\Library;

use Phalcon\DI;

class Cdn {

    public function __construct() 
    {
    	$this->baseConfig = DI::getDefault()->get('config');

        $this->private_key = $this->baseConfig['cdn']['cdn_private_key'];
    	$this->service_id = $this->baseConfig['cdn']['cdn_service_id'];
    	$this->alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    }

    //method manage for upLoadFile
    public function upLoadFileCdn($file)
    {
    	if(!empty($file)){
    		//Get api key from curl cdn
    		$apikey = $this->ApiKey();
    		//Check have value
    		if(!empty($apikey)){
    			//Post file to cdn
    			$result = $this->postApiFileCreate($file,$apikey);
    			//debug error by dd($result)
    			if(isset($result['messages']['data']['short_url'])){
    				return $result['messages']['data']['short_url'];
    			}else{
    				return false;
    			}
    		}else{
    			return false;
    		}			
    	}else{
    		return false;
    	}
    }

    //method manage for apikey
    private function ApiKey()
	{
		//default value
		$apikey = false;
		//create service in cms cdn
		$private_key = $this->private_key;
		$service_id = 4;
		//curl server_encode
		$server_encode = $this->getApiKeyCdn($private_key,$service_id);
		//check data
		if($server_encode['status'] == 'success' && isset($server_encode['messages']['data']['key'])){
			$server_encode = $server_encode['messages']['data']['key'];
			//create apikey
			$apikey = $this->encode($server_encode . $private_key, 8);
		}
		return $apikey;
	}

	//method get apikey from cdn
	private function getApiKeyCdn($private_key,$service_id)
	{
		try {
			$action = "getkey?private_key=".$private_key."&service_id=".$service_id;
			$url = $this->CI->config->config['cdn_url'].$action;
			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL,$url); 
			curl_setopt($ch, CURLOPT_HTTPGET, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			$response = curl_exec($ch); 
			$data = json_decode($response,true);

			if (curl_errno($ch)) { 
			   $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			   print_r($httpcode);
			   print_r(curl_error($ch));
			   exit();
			} 
			curl_close($ch);

			if(isset($data['status']) && $data['status']["code"] == 200){
				$result['status'] = "success";
				$result['messages'] = $data;
			}else{
				$result['status'] = "warnning";
				$result['messages'] = 'No Data';
			}

		} catch (Exception $e) {
			$result['status'] = "error";
			$result['messages'] = $e;
		}
		return $result;
	}


	//method copy from cdn
    private function encode($input, $length = 8)
    {
        $key      = '';
        $input    = md5($input).$length;
        $input    = substr($input, 0, $length);
        $alphabet = $this->alphabet . $this->alphabet;

        foreach (str_split($input) as $s) {
            $alphabet  .= $this->alphabet;
            $int_alpha  = ord($s);
            $alphabet   = substr($alphabet, $int_alpha);
            $key       .= substr($alphabet, 0, 1);
        }
        return $key;
    }

    //method post file to cdn
	private function postApiFileCreate($file,$apikey)
	{
		try {
			$action = "upload";
			$url = $this->CI->config->config['cdn_url'].$action;
			$ch = curl_init($url);

			if ((version_compare(PHP_VERSION, '5.5') >= 0)) {
			    $cfile = new CURLFILE($file['tmp_name'], $file['type'], $file['name']);
			} else {
			    $cfile = "@".$file['tmp_name'].";filename=".$file['name'].";type=".$file['type'];
			}
			
			$data = array();
			$data['file'] = $cfile;
			$data['service_id'] = $this->service_id;
			$data['apikey'] = $apikey;

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$data);

			$response = curl_exec($ch);
			$data = json_decode($response,true);

			if(isset($data['status']) && $data['status']["code"] == 200){
				$result['status'] = "success";
				$result['messages'] = $data;
			}else{
				$result['status'] = "warnning";
				$result['messages'] = 'No Data';
			}
		} catch (Exception $e) {
			$result['status'] = "error";
			$result['messages'] = $e;
		}
		return $result;
	}

}