<?php
if( !defined('BASEPATH') ) exit('No direct script access allowed');

class Htmltoword_lib{
    public function __construct(){
        require_once APPPATH.'third_party/htmltoword/htmltoword.php';
    }
}