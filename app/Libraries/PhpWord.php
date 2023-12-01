<?php
namespace App\Libraries;

require_once ROOTPATH . 'vendor/autoload.php';

class PhpWord {
    private $phpWord;

    public function __construct() {
        $this->phpWord = new \PhpOffice\PhpWord\PhpWord();
    }

    public function getPhpWord() {
        return $this->phpWord;
    }
}
