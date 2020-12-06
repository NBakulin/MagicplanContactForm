<?php
declare(strict_types=1);

namespace App\Form\ContactForm;

use App\Enumeration\Form\ContactFormEnum;
use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

final class SalesForm extends Form
{
    // ToDo move in solo constants or leave as it is?
    private const ALLOWED_COMPANY_SIZE = [
        '1',
        '2-9',
        '10-19',
        '20+',
    ];

    private const ALLOWED_INDUSTRY = [
        'Renovation',
        'Inspection',
        'Other'
    ];

    private const ALLOWED_REGION = [
        'North-America',
        'Europe',
        'Asia',
        'Other',
    ];

    protected function _buildSchema(Schema $schema): Schema
    {
        $keys = [
            ContactFormEnum::QUESTION_CUSTOMER_SUPPORT => 'string',
            ContactFormEnum::FIRST_NAME => 'string',
            ContactFormEnum::LAST_NAME => 'string',
            ContactFormEnum::EMAIL => 'string',
            ContactFormEnum::MESSAGE => 'string',
            ContactFormEnum::COMPANY_NAME => 'string',
            ContactFormEnum::COMPANY_SIZE => 'string',
            ContactFormEnum::INDUSTRY => 'string',
            ContactFormEnum::REGION => 'string',
        ];
        foreach ($keys as $field => $type) {
            $schema->addField($field, ['type' => $type]);
        }
        //ToDo add phone validation
//        'phone' => 'string',
        return $schema;
    }

    //ToDo add invalid fields message
    public function validationDefault(Validator $validator): Validator
    {
        $validator->equals(ContactFormEnum::QUESTION_CUSTOMER_SUPPORT, ContactFormEnum::SALES);
        $validator->notEmptyString(ContactFormEnum::FIRST_NAME);
        $validator->notEmptyString(ContactFormEnum::LAST_NAME);
        $validator->email(ContactFormEnum::EMAIL);
        $validator->notEmptyString(ContactFormEnum::MESSAGE);

        $validator->notEmptyString(ContactFormEnum::COMPANY_NAME);
        $validator->inList(ContactFormEnum::COMPANY_SIZE, self::ALLOWED_COMPANY_SIZE);
        $validator->inList(ContactFormEnum::INDUSTRY, self::ALLOWED_INDUSTRY);
        $validator->inList(ContactFormEnum::REGION, self::ALLOWED_REGION);
        //ToDo add phone validation

        return $validator;
    }

    protected function _execute(array $data): bool
    {
        // Send an email.
        return true;
    }
}
