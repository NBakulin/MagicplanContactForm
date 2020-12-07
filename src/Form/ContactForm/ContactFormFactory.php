<?php
declare(strict_types=1);

namespace App\Form\ContactForm;

use App\Enumeration\Form\ContactFormEnum;
use Cake\Form\Form;

final class ContactFormFactory
{
    public static function createForm(array $formData): ?Form
    {
        if (isset($formData[ContactFormEnum::QUESTION_TYPE])) {
            $questionType = $formData[ContactFormEnum::QUESTION_TYPE];
            if ($questionType === ContactFormEnum::SALES) {
                return new SalesForm();
            }
            if ($questionType === ContactFormEnum::CUSTOMER_SUPPORT) {
                return new CustomerSupportForm();
            }
        }
        return null;
    }
}
