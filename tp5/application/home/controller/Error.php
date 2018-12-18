<?php
namespace app\home\controller;

class Error extends controller{
  public function index()
  {
    header("HTTP/1.0 404 Not Found");
    return $this->fetch('error_sys');
  }
}
?>