<?php
declare(strict_types=1);

namespace App\Form\ContactForm;

use App\Enumeration\Form\ContactFormEnum;
use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

abstract class AbstractContactForm extends Form
{
    protected function _buildSchema(Schema $schema): Schema
    {
        $keys = [
            ContactFormEnum::QUESTION_TYPE => 'string',
            ContactFormEnum::FIRST_NAME => 'string',
            ContactFormEnum::LAST_NAME => 'string',
            ContactFormEnum::EMAIL => 'string',
            ContactFormEnum::MESSAGE => 'string',
        ];

        foreach ($keys as $field => $type) {
            $schema->addField($field, ['type' => $type]);
        }
        return $schema;
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString(ContactFormEnum::FIRST_NAME, 'Please provide your first name');
        $validator->notEmptyString(ContactFormEnum::LAST_NAME, 'Please provide your last name');
        // can check if email exists in MX-record with second argument but I think it is not necessary here
        $validator->email(ContactFormEnum::EMAIL, false, 'Please provide your email');
        $validator->notEmptyString(ContactFormEnum::MESSAGE, 'Please write a message');

        return $validator;
    }

    protected function _execute(array $data): bool
    {
        return false;
    }
}
