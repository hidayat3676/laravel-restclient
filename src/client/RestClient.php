<?php


namespace hidayat\restclient\client;


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
     * Send the request to the url
     *
     * @param $url
     * @return bool|string
     */
    /**
     * Request post method
     */
    const METHOD_POST = 'POST';

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
            return 'Code ' . curl_getinfo($ch, CURLINFO_RESPONSE_CODE) .' ' .  curl_error($ch) . curl_errno($ch) ;
        }
        curl_close($ch);

        return $res;

    }

    /**
     * Set PHP cURL Options
     *
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)  {
        $this->curlOptions = $options;

        return $this;
    }

    /**
     * Form data to be sent to the server with request
     *
     * @param $postData
     * @return $this
     */
    public function setPostData($postData)  {
        $this->postData = $postData;

        return $this;
    }

    /**
     * Any Query param to be sent to server with the request
     *
     * @param array $getData
     * @return $this
     */
    public function setGetData(array $getData)  {
        $this->getData = $getData;

        return $this;
    }

    /**
     * Set Any header to be sent to the server with request
     *
     * @param array $headers
     * @return $this
     */
    public function setHeaders(array $headers){
        $this->header = $headers;

        return $this;
    }

    /**
     * The HttpBasicAuth credentials
     *
     * @param array $credential
     * @return $this
     */
    public function setHttpBasicAuthData(array $credential){
        $this->httpBasicAuthData = $credential;
        $this->httpBasicAuth = true;
        return $this;
    }

    /**
     * Set the request method
     *
     * @param $method
     * @return $this
     */
    public function setMethod($method){
        $this->method = $method;

        return $this;
    }
}
