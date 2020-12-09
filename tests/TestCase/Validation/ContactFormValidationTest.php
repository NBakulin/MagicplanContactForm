<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Form\ContactForm\ContactFormFactory;
use Cake\TestSuite\TestCase;

/**
 * PagesControllerTest class
 *
 * @uses \App\Controller\PagesController
 */
class ContactFormValidationTest extends TestCase
{
    private const CUSTOMER_SUPPORT_FORM_DATA = [
        'first_name'=> 'Nikita',
        'last_name'=> 'Bakulin',
        'email'=> 'nk.bakulin@gmail.com',
        'message'=> 'Message to be sent',
    ];

    private const SALES_FORM_DATA = [
        'first_name'=> 'Nikita',
        'last_name'=> 'Bakulin',
        'email'=> 'nk.bakulin@gmail.com',
        'message'=> 'Message to be sent',
        'company_name'=> 'Name',
        'company_size'=> '1',
        'industry'=> 'Renovation',
        'region'=> 'Europe',
    ];

    public function testSalesValidation()
    {
        foreach (self::SALES_FORM_DATA as $key => $value) {
            $formData = self::SALES_FORM_DATA;
            $formData['question_type'] = 'sales';
            $formData[$key] = '';
            $formValidator = ContactFormFactory::createForm($formData);
            $this->assertFalse($formValidator->validate($formData));
        }

        $formData = self::CUSTOMER_SUPPORT_FORM_DATA;
        $formData['question_type'] = 'sales';
        $formData['phone'] = '+1231dw23';
        $formValidator = ContactFormFactory::createForm($formData);
        $this->assertFalse($formValidator->validate($formData));

        $formData = self::CUSTOMER_SUPPORT_FORM_DATA;
        $formData['question_type'] = 'sales';
        $formData['phone'] = '+123123';
        $formValidator = ContactFormFactory::createForm($formData);
        $this->assertTrue($formValidator->validate($formData));

        $formData = self::SALES_FORM_DATA;
        $formData['question_type'] = 'sales';
        $formValidator = ContactFormFactory::createForm($formData);
        $this->assertTrue($formValidator->validate($formData));
    }


    public function testCustomerSupportValidation()
    {
        foreach (self::CUSTOMER_SUPPORT_FORM_DATA as $key => $value) {
            $formData = self::CUSTOMER_SUPPORT_FORM_DATA;
            $formData['question_type'] = 'customer_support';
            $formData[$key] = '';
            $formValidator = ContactFormFactory::createForm($formData);
            $this->assertFalse($formValidator->validate($formData));
        }

        $formData = self::CUSTOMER_SUPPORT_FORM_DATA;
        $formData['question_type'] = 'customer_support';
        $formValidator = ContactFormFactory::createForm($formData);
        $this->assertTrue($formValidator->validate($formData));
    }
}
