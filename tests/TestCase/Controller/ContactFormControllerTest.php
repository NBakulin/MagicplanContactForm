<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * PagesControllerTest class
 *
 * @uses \App\Controller\PagesController
 */
class ContactFormControllerTest extends TestCase
{
    use IntegrationTestTrait;

    public function testGetForm()
    {
        $this->get('/contact_form');
        $this->assertTemplate('default');
        $this->assertResponseOk();
    }

    public function testPostCustomerSupportGetAndSubmitFormSuccess()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->get('/contact_form');
        $this->assertResponseOk();
        $this->post('/contact_form', [
            'question_type'=> 'customer_support',
            'first_name'=> 'Nikita',
            'last_name'=> 'Bakulin',
            'email'=> 'nk.bakulin@gmail.com',
            'message'=> 'Message to be sent',
            'company_name'=> '',
            'company_size'=> '',
            'industry'=> '',
            'region'=> '',
            'phone'=> ''
        ]);
        $this->assertResponseOk();
    }

    /**
     * This test asserts fail because API_URL="https://apiendpoint.app" (set in .env) does not exist.
     * To test if request making works just change $this->requestUrl in SalesForm __construct() to something valid
     * For example https://postman-echo.com/post
     **/
    public function testPostDomainNotFoundFail()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->get('/contact_form');
        $this->assertResponseOk();
        $this->post('/contact_form', [
            'question_type'=> 'sales',
            'first_name'=> 'Nikita',
            'last_name'=> 'Bakulin',
            'email'=> 'nk.bakulin@gmail.com',
            'message'=> 'Message to be sent',
            'company_name'=> 'Name',
            'company_size'=> '1',
            'industry'=> 'Renovation',
            'region'=> 'Europe',
            'phone'=> ''
        ]);
        $this->assertResponseCode(500);
    }

    public function testPostWithBadParametersFail()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->get('/contact_form');
        $this->assertResponseOk();
        $this->post('/contact_form', [
            'question_type'=> '',
            'first_name'=> '',
            'last_name'=> '',
            'email'=> '',
            'message'=> '',
            'company_name'=> '',
            'company_size'=> '',
            'industry'=> '',
            'region'=> '',
            'phone'=> ''
        ]);
        $this->assertTemplate('default');
        $this->assertResponseCode(500);
        $this->assertResponseEquals('{"message":"Something went wrong"}');
    }

    public function testPostCustomerSupportWithBadParametersFail()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->get('/contact_form');
        $this->assertResponseOk();
        $this->post('/contact_form', [
            'question_type'=> 'customer_support',
            'first_name'=> '',
            'last_name'=> '',
            'email'=> '',
            'message'=> '',
            'company_name'=> '',
            'company_size'=> '',
            'industry'=> '',
            'region'=> '',
            'phone'=> ''
        ]);
        $this->assertTemplate('default');
        $this->assertResponseCode(422);
        $this->assertResponseEquals('{"first_name":{"_empty":"Please provide your first name"},"last_name":{"_empty":"Please provide your last name"},"email":{"email":"Please provide your email"},"message":{"_empty":"Please write a message"}}');
    }


    public function testPostSalesFailedWithBadParameters()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->get('/contact_form');
        $this->assertResponseOk();
        $this->post('/contact_form', [
            'question_type'=> 'sales',
            'first_name'=> '',
            'last_name'=> '',
            'email'=> '',
            'message'=> '',
            'company_name'=> '',
            'company_size'=> '',
            'industry'=> '',
            'region'=> '',
            'phone'=> 'dawd'
        ]);
        $this->assertTemplate('default');
        $this->assertResponseCode(422);
        $this->assertResponseEquals('{"first_name":{"_empty":"Please provide your first name"},"last_name":{"_empty":"Please provide your last name"},"email":{"email":"Please provide your email"},"message":{"_empty":"Please write a message"},"company_name":{"_empty":"Please provide a company name"},"company_size":{"inList":"Please provide a company size"},"industry":{"inList":"Please provide a company industry"},"region":{"inList":"Please provide a region"},"phone":{"custom":"Please provide a valid phone number"}}');
    }

    public function testPostWithCsrfFail()
    {
        $this->get('/contact_form');
        $this->assertResponseOk();
        $this->post('/contact_form', [
            'question_type'=> 'sales',
            'first_name'=> '',
            'last_name'=> '',
            'email'=> '',
            'message'=> '',
            'company_name'=> '',
            'company_size'=> '',
            'industry'=> '',
            'region'=> '',
            'phone'=> 'dawd'
        ]);
        $this->assertResponseCode(403);
    }
}
