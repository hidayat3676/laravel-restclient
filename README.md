# laravel-restclient
This  provide  calling rest api from laravel

<code> composer require hidayat/restclient </code>

# usage 
<small>Include the facade provided by package in your class as belows</small>
 
<code> 
use hidayat\restclient\Facade\Client; 

$url = "http://some-site.com";

//simple GET request with no additional param

$response = Client::call($url);

dd($response)

// GET request with  query param and headers


$data = ['field1' => 'value1', 'field2' => 'value2'];

$headers = ['Authorization: Basic ' . $token, 'accept: application/json'];


$response = Client::setGetData($data)
->setHeaders($headers)
->call($url);
</code>

<b>Note: All methods are chainable except the call() method when setting any additional param call() method should be call at the end</b>

<code>
//example with post method and post data

$headers = ['content-type: application/x-www-form-urlencoded', Authorization: Basic ' . $token, 'accept: application/json'];

$postData = "field1=somevalue&field2=somefield2";
</code>

<b>Note: when sending post data then there is no need to explicitly set method to post as it will be automatically set.
 When sending post request without any data you must set method to post
</b>

<code>
$response = Client::setPostData($postData)
->setMethod(Client::METHOD_POST) // (Optional here) require only when not sending post data
->setHeaders($headers)
->call($url);

//PUT method example

$response = Client::setPostData($postData)
->setMethod(Client::METHOD_PUT) 
->setHeaders($headers)
->call($url);

//For url that require BasicHttpAuth you can use setHttpBasicAuthData method

$basicAuthCred = ['username' => 'abc', 'password' => 'bdjdjdjd']

$response = Client::setHeaders($headers)
->setHttpBasicAuthData($basicAuthCred)
->call($url);

Since this package is an interface over PHP cURL Api you can set any of the cURL Options by passing an array to setOptions method
You must provide Option key value pair format as below
 
 $response = Client::setOptions([
 CURLOPT_SSL_VERIFYPEER => false, 
 CURLOPT_TIMEOUT => 60
 ])
 ->call($url);
</code>
