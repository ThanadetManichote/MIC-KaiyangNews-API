<?php
namespace App\Library;

use Phalcon\DI;

class ApiKeyServices 
{
    private $hexKey    = "6b616979616e672d6d79616e6d61722d6170692d3030312d7075626c69632121";
    private $delimeter = ":";


    private $public_key = "-----BEGIN PUBLIC KEY-----\nMIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCYIxrithYnpjDVtuayChZC3doi\nldO32XtLriHan0zGEs1RaMkC2hVm/t6S3JcE9RgUCMLOJFtV+YGMXWFLdBVDpjhj\nVPgX8p2uVg+LG+k4zcLINEYetJpZ/nWzgU6IGt66nqbolcjieFasCDQur3UC4DYv\nIIT1jOdJc8Qg/92PQQIDAQAB\n-----END PUBLIC KEY-----";
    private $private_key = "-----BEGIN PRIVATE KEY-----\nMIICdQIBADANBgkqhkiG9w0BAQEFAASCAl8wggJbAgEAAoGBAJgjGuK2FiemMNW2\n5rIKFkLd2iKV07fZe0uuIdqfTMYSzVFoyQLaFWb+3pLclwT1GBQIws4kW1X5gYxd\nYUt0FUOmOGNU+Bfyna5WD4sb6TjNwsg0Rh60mln+dbOBToga3rqepuiVyOJ4VqwI\nNC6vdQLgNi8ghPWM50lzxCD/3Y9BAgMBAAECgYA1EvIbKyi5dknNFLyQWeKAO0MR\nE7HDjpRrx3i5+x7ebsq/3s1ZOFmFD9733wq0SQi4XIIRRi+y45MlM6JwnzOXV18v\n0hxIm1HvVvZwLlDzmIq5x2F6Ofglc/bx3Zv/8TnyViPFLU5ZvZ0ZlZ9In00PUy/I\nbgM+IqmgIMCP/GEmQQJBAMcBm2nYiZz8Ad2AuIccfsvPInlI+9+qyszfAOFRXyg2\n4koRd8gqdxHPGNBqqKJ0NILeWupHJTLc0p+bAtjgZSkCQQDDtTpcaieJv4STopKd\nYu0HBTwHP+XTJrkO/C3jUZo/xYLZvSRhxfp9McIPAjv/ZBhi1vRLQD3zRrq/DrfH\nD8RZAkAgAVYpU7XuFWmHYihLMn4B8TIuJ1q6whETmdneYuPW59zE5MJK4ul7Z78p\n5b1xQxce5PviKccFwxXsrVVr48rhAkAZOkNLpmNyXj24yjwcDaSAQyx5wsLddSBl\nzhwcMWiwz8UOTFNkRyEDAmcBiEgzo7OBCjRzftR9h6CLAFqwTlgBAkA0AFFAqD+I\nEdAwTLAfySDYjpkmn4dItCvMDxl11q79AwaQiDOenL3lRTBeBWlVJ114kKnV4EiP\nzu8mtFjomYWn\n-----END PRIVATE KEY-----";
    
    protected function getKey()
    {
        return pack('H*', $this->hexKey);
    }

    protected function getIvSize()
    {
        return mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
    }

    protected function encryptString($plaintext)
    {
        // --- ENCRYPTION ---
        $ciphertext = '';
        for($i=0; $i<strlen($plaintext); $i+=117){
            $src = substr($plaintext, $i, 117);
            $ret = openssl_public_encrypt($src, $out, $this->public_key);
            $ciphertext .= $out;
        }

        return base64_encode($ciphertext);
    }

    protected function decryptString($ciphertextBase64)
    {
        // //--- DECRYPTION ---
        $plaintext = '';
        //decode base64
        $crypted   = base64_decode($ciphertextBase64);
        
        for($i=0; $i<strlen($crypted); $i+=128){
            $src = substr($crypted, $i, 128);
            $ret = openssl_private_decrypt($src, $out, $this->private_key);
            $plaintext .= $out;
        }
        return $plaintext;
    }

    /*
    * Method for check api key
    */
    protected function checkApiKey($apiKey)
    {
        $dateTime = $this->decryptString($apiKey);

        //check date available
        if (date('Y-m') == $dateTime) {
            return true;
        }
        return false;
    }

    /**
    * Method for get api key from header
    */
    protected function getApiKeyFromHeader()
    {
        $request = DI::getDefault()->get('request');
        $headers = $request->getHeaders();

        if (isset($headers['Apikey'])) {
            return $headers['Apikey'];
        }
        return "";
    }

    /*
    * Method for get apikey
    */
    public function getApiKey()
    {
        $dateTime = date('Y-m');
        return $this->encryptString($dateTime);
    }


    /**
    * Method for validate api key
    */
    public function validateApiKey()
    {
        //get api key from header
        $apiKey = $this->getApiKeyFromHeader();

        if (empty($apiKey))
        {
            return false;
        }
        
        return $this->checkApiKey($apiKey);
    }
}
