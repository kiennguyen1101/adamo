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
//        $this->setRunTestInSeparateProcess(false);
        $this->setPreserveGlobalState(true);
    }

    public function testLoginError()
    {

        //login using user1
        $this->url('login.php');
        $form = $this->byId('form_login');
        $username = $this->byId('username');
        $password = $this->byId('password');
        $username->value('user1');
        $password->value('123456');
        $form->submit();

        //sell new item, multiple steps
        //step: choose category
        $this->url('sell_item.php?option=new_item');
        $category = $this->select($this->byId('selector_0'));
        $category->selectOptionByValue('2320');

        $subcat = $this->select($this->byId('selector_1'));
        $subcat->selectOptionByValue('2321');
        //category
        $this->assertContains('Điện thoại & Phụ kiện', $category->selectedLabel());
        $this->assertContains('Điện thoại phổ thông', $subcat->selectedLabel());
        $this->byId('form_next_step')->click();

        //step: name and description
        $this->byId('name')->value(uniqid('Phone_'));
//        $this->frame('idContentoEdit1');
//        $description = $this->byCssSelector('body');

        //fill in iframe description with text
        $script = "jQuery('#idContentoEdit1').contents().find('body').text('New description')";
        $this->execute(array(
            'script' => $script,
            'args' => array()
        ));

        $this->byId('form_next_step')->click();

        //step: pricing
        $parent = $this->byCssSelector('.sell_table');
        $start_price = $parent->element($this->using('name')->value('start_price'));
        $start_price->value((string)rand(250, 400) * 1000);


        $this->byName('is_buy_out')->click();

        $buyout_price = $parent->element($this->using('name')->value('buyout_price'));
        $buyout_price->value((string)rand(350, 450) * 1000);

        $this->byName('hpfeat')->click();

        $this->byName('catfeat')->click();

        $this->byId('form_next_step')->click();

        //step: payment and shipping
        $parent = $this->byCssSelector('.sell_table');
        $postage_amount = $parent->element($this->using('name')->value('postage_amount'));
        $postage_amount->value('0');
        $this->byId('paypal')->click();
        $this->byId('nganluong')->click();
        $this->byId('form_next_step')->click();

        //step: preview
        $this->byId('form_next_step')->click();

        //step: finish

    }
}