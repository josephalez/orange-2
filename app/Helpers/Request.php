<?php namespace  App\Helpers;
  /**
   *
   */
  class Request
  {
    public static function Request($key = null){
      $response = null;
      if (isset($_REQUEST[$key])) $response = $_REQUEST[$key];
      return $response;
    }
    public static function Get($key = null,$response = null){
      if (isset($_GET[$key])) $response = $_GET[$key];
      return $response;
    }
    public static function Post($key = null){
      $response = null;
      if (isset($_POST[$key])) $response = $_POST[$key];
      return $response;
    }
  }