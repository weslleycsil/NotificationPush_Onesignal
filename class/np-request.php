<?php

/**
 * The Request class provides a simple HTTP request interface.
 *
 *
 * Quick Start:
 * https://twcreativs.com.br
 * @code
 *   include 'path/to/np-request.php';
 *   $request = new NP_Request('http://www.example.com/');
 *   $request->execute();
 * @endcode
 *
 * Minimum requirements: PHP 5.3.x, cURL.
 *
 * @version 1.0-beta1
 * @author Weslley Silva (weslleycsil).
 */

class NP_Request {

    private $address;

    // Variables used for the request.
    public $connectTimeout = 10;
    public $timeout = 15;

    // Request type.
    private $requestType;
    // If the $requestType is POST, you can also add post fields.
    private $postFields;

    // HTTP response body.
    private $responseBody;
    // HTTP response header.
    private $responseHeader;
    // HTTP response status code.
    private $httpCode;
    // cURL error.
    private $error;
    // HTTP Header
    private $httpHeaders;


    public function __construct($address) {
        if (!isset($address)) {
            throw new Exception("Error: Address not provided.");
        }
        $this->address = $address;
    }

    /**
     * Set the address for the request.
     *
     * @param string $address
     *   The URI or IP address to request.
     */
    public function setAddress($address) {
        $this->address = $address;
    }

    /**
     * Set a request type (by default, cURL will send a GET request).
     *
     * @param string $type
     *   GET, POST, DELETE, PUT, etc. Any standard request type will work.
     */
    public function setRequestType($type) {
        $this->requestType = $type;
    }

    /**
     * Set the POST fields (only used if $this->requestType is 'POST').
     *
     * @param array $fields
     *   An array of fields that will be sent with the POST request.
     */
    public function setPostFields($fields = array()) {
        $this->postFields = json_encode($fields);
        //echo $this->postFields;
        //echo '<br>';
    }

    /**
     * Get any cURL errors generated during the execution of the request.
     *
     * @return string
     *   An error message, if any error was given. Otherwise, empty.
     */
    public function getError() {
        return $this->error;
    }

    /**
     * Get the response body.
     *
     * @return string
     *   Response body.
     */
    public function getResponse() {
        return json_decode($this->responseBody);
    }

    /**
     * Get the response header.
     *
     * @return string
     *   Response header.
     */
    public function getHeader() {
        return $this->responseHeader;
    }

    /**
     * Get the HTTP status code for the response.
     *
     * @return int
     *   HTTP status code.
     *
     * @see http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
     */
    public function getHttpCode() {
        return $this->httpCode;
    }

    /**
     * Check for content in the HTTP response body.
     *
     * This method should not be called until after execute(), and will only check
     * for the content if the response code is 200 OK.
     *
     * @param string $content
     *   String for which the response will be checked.
     *
     * @return bool
     *   TRUE if $content was found in the response, FALSE otherwise.
     */
    public function checkResponseForContent($content = '') {
        if ($this->httpCode == 200 && !empty($this->responseBody)) {
            if (strpos($this->responseBody, $content) !== FALSE) {
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     *
     * @param array $headers
     */
    public function setHttpHeaders($headers = array()) {
        $this->httpHeaders = $headers;
        //print_r($this->httpHeaders);
        //echo '<br>';
    }


    public function execute() {
        
        // Set up cURL options.
        $ch = curl_init();


        // Send a custom request if set (instead of standard GET).
        if (isset($this->requestType)) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->requestType);
            // If POST fields are given, and this is a POST request, add fields.
            if ($this->requestType == 'POST' && isset($this->postFields)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $this->postFields);
            }
        }

        // Don't print the response; return it from curl_exec().
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $this->address);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->connectTimeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->httpHeaders);
        // Output the header in the response.
        curl_setopt($ch, CURLOPT_HEADER, TRUE);        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        
        $response = curl_exec($ch);
        $error = curl_error($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $time = curl_getinfo($ch, CURLINFO_TOTAL_TIME);
        curl_close($ch);

        // Set the header, response, error and http code.
        $this->responseHeader = substr($response, 0, $header_size);
        $this->responseBody = substr($response, $header_size);
        $this->error = $error;
        $this->httpCode = $http_code;

    }


}