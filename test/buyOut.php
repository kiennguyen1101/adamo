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
        parent::setUp();
        $this->setHost('localhost');
        $this->setPort(4444);
        $this->setBrowser('chrome');
        $this->setBrowserUrl(TEST_URL);
//        $this->setRunTestInSeparateProcess(false);
//        $this->setPreserveGlobalState(true);
        $this->db = new database();
        $this->db->connect('localhost', 'root', '');
        $this->db->select_db('adamo_store');
        $this->db->beginTransaction();

    }

    public function testLoginError()
    {

        //login page with form
        $this->url('login.php');
        $form = $this->byId('form_login');

        //fill login form with values
        $username = $this->byId('username');
        $password = $this->byId('password');
        $username->value('buyer_test');
        $password->value('123456');
        $form->submit();
        $this->url('auction_details.php?auction_id=100598');

        //auction details page
        $buyOut = $this->byId('product_buy_out');
        $this->assertContains('buy_out.php', $buyOut->attribute('href'));
        $buyOut->click();

    }

    public function tearDown()
    {
        $this->db->rollBack();
    }
}