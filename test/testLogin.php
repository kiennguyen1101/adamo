<?php
//include_once('../includes/config.php');
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
require('../includes/global.php');
//require_once(BASE_DIR . 'vendor/autoload.php');
PHPUnit_Framework_Error_Notice::$enabled = FALSE;
define('TEST_URL', 'http://localhost/adamo/');

class TestLogin extends PHPUnit_Extensions_Selenium2TestCase
{

    private $db;

    public function setUp()
    {
        $this->setHost('localhost');
        $this->setPort(4444);
        $this->setBrowser('chrome');
        $this->setBrowserUrl(TEST_URL);
    }

    public function testLoginFormAttributes()
    {
        $this->url('login.php');
        $form = $this->byId('form_login');
        $username = $this->byId('username');
        $password = $this->byId('password');


        //test initiate value
        $this->assertEquals('', $username->value());
        $this->assertEquals('', $password->value());

        //test form submit to login.php
        $this->assertContains('login.php', $form->attribute('action'));

    }

    public function testLoginError() {
        $this->url('login.php');
        $form = $this->byId('form_login');
        $username = $this->byId('username');
        $password = $this->byId('password');

        
    }
}