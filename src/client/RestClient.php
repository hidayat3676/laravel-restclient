<?php


namespace hidayat\restclient\src\client;


class RestClient
{
    /**
     *curl options to set
     * @var array
     */
    private $curlOptions = [];
    /**
     * HTTP method used for the request
     * @var string
     */
    private $method;
    /**
     * HTTP headers to send along with request
     * @var array
     */
    private $header = [];
    /**
     * whether the request require @BasicHttpAuth or not
     * @var bool
     */
    private $httpBasicAuth = false;
    /**
     * HttpBasicAuth Credentials if require
     * @var array
     */
    private $httpBasicAuthData = [];
    /**
     * Form post fields if sending data to server
     * @var string
     */
    private $postData;
    /**
     * Query param to send along with get request
     * @var string
     */
    private $getData = [];
    /**
     * The method used for the request default is GET
     */
    const METHOD_POST = 'POST';
    const METHOD_DELETE = 'DELETE';
    const METHOD_PUT = 'PUT';


    public function call($url){

        if (!is_null($this->getData)){
            $url = sprintf('%s?%s',$url,http_build_query($this->getData));
        }
        $ch = curl_init($url);
        if ($this->curlOptions){
            curl_setopt_array($ch, $this->curlOptions);
        }else{
            /**
             * Set Some default OPTIONS if user not set custom options
             */
            curl_setopt_array($ch, array(
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_MAXREDIRS      => 1,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_TIMEOUT        => 60,
            ));
        }

        if ($this->method){
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->method);
        }
        if ($this->postData || $this->method == static::METHOD_POST){

            curl_setopt($ch, CURLOPT_POST, 1);
        }
        if($this->postData){
            curl_setopt($ch, CURLOPT_POSTFIELDS,$this->postData);
        }
        if ($this->httpBasicAuthData){
            curl_setopt($ch, CURLOPT_USERPWD, "$this->httpBasicAuthData[username]:$this->httpBasicAuthData[password]");
        }
        if ($this->header){
            curl_setopt($ch,CURLOPT_HTTPHEADER,$this->header);
        }
        $res = curl_exec($ch);
        if (!$res){
            return  curl_getinfo($ch, CURLINFO_HTTP_CODE) . curl_error($ch) . curl_errno($ch) ;
        }
        curl_close($ch);

        return $res;

    }
    public function setOptions(array $options)  {
        $this->curlOptions = $options;

        return $this;
    }

    public function setPostData($postData)  {
        $this->postData = $postData;

        return $this;
    }

    public function setGetData(array $getData)  {
        $this->getData = $getData;

        return $this;
    }

    public function setHeaders(array $headers){
        $this->header = $headers;

        return $this;
    }

    public function setHttpBasicAuthData(array $credential){
        $this->httpBasicAuthData = $credential;
        $this->httpBasicAuth = true;
        return $this;
    }

    public function setMethod($method){
        $this->method = $method;

        return $this;
    }
}
