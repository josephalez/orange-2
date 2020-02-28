<?php
namespace App\Helpers\PHPClient;

class CurlHelper
{
  function __construct($url = null, $cookies = [])
  {
    $this->curl = curl_init($url);
    $this->result = null;
    $this->cookies = $cookies;
    $this->headers = null;
    $this->post = [];
    return $this;
  }
  function sGET(){
    $this->rqHeaders();
    $this->returnIn();
    $this->scookies();
    $this->exec();
    $this->gcookies();
    return $this;
  }
  function sPOST($post_params){
    $this->rqHeaders();
    $this->returnIn();
    $this->scookies();
    foreach ($post_params as $key => $value) {
      $this->setPost($key, $value);
    }
    $this->sendPost();
    $this->exec();
    $this->gcookies();
    return $this;
  }
  function rqHeaders($value = 1){
    curl_setopt($this->curl, CURLOPT_HEADER, $value);
    return $this;
  }
  function returnIn($value = 1){
    curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, $value);
    return $this;
  }
  function exec(){
    $result = curl_exec($this->curl);
    $result = explode('<!DOCTYPE html>', $result);

    $this->headers = $result[0];
    $this->result = $result[0];

    if (sizeof($result) > 1)
      $this->result = $result[1];

    curl_close($this->curl);
    return $this;
  }
  function arrStrCookies($cookies) {
    $str = '';$i = 0;
    foreach ($cookies as $key => $value) {
      $str .= $key.'='.$value.';';
    }
    return $str;
  }
  function scookies(){
    curl_setopt($this->curl, CURLOPT_COOKIE, $this->arrStrCookies($this->cookies));
    return $this;
  }
  function setPost($name, $value){
    $this->post[$name] = urlencode((string) $value);
    return $this;
  }

  /*$User_Agent = 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31';
  $headers = array(
    'Set-Cookie:'.$cookie_tr.';',
    'User-Agent:'.$User_Agent,
    'Content-Type:application/x-www-form-urlencoded',
  );*/
  function build_data_files($fields){
      $data = '';
      $eol = "\r\n";
      $delimiter = '-------------' . uniqid();
      foreach ($fields as $name => $content) {
          $data .= "--" . $delimiter . $eol
              . 'Content-Disposition: form-data; name="' . $name . "\"".$eol.$eol
              . $content . $eol;
      }
      $data .= "--" . $delimiter . "--".$eol;
      return $data;
  }
  function sendPost(){
    $fields_string = '';
    foreach($this->post as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
    $fields_string = rtrim($fields_string, '&');
    curl_setopt($this->curl, CURLOPT_POST, count($this->post));
    curl_setopt($this->curl, CURLOPT_POSTFIELDS, $fields_string);
    return $this;
  }

  function gcookies() {
    $matches = [];
    preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $this->headers, $matches);
    $cookies = array();
    foreach($matches[1] as $item) {
      parse_str($item, $cookie);
      $cookies = array_merge($cookies, $cookie);
    }
    $this->cookies = $cookies;
    return $this;
  }
}
