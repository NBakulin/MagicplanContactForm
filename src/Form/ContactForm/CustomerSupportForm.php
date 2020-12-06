<?php
declare(strict_types=1);

namespace App\Form\ContactForm;

use App\Enumeration\Form\ContactFormEnum;
use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

final class CustomerSupportForm extends Form
{

    protected function _buildSchema(Schema $schema): Schema
    {
        $keys = [
            ContactFormEnum::QUESTION_CUSTOMER_SUPPORT => 'string',
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

    //ToDo add invalid fields message
    public function validationDefault(Validator $validator): Validator
    {
        $validator->equals(ContactFormEnum::QUESTION_CUSTOMER_SUPPORT, ContactFormEnum::CUSTOMER_SUPPORT);
        $validator->notEmptyString(ContactFormEnum::FIRST_NAME);
        $validator->notEmptyString(ContactFormEnum::LAST_NAME);
        $validator->email(ContactFormEnum::EMAIL);
        $validator->notEmptyString(ContactFormEnum::MESSAGE);

        return $validator;
    }

    protected function _execute(array $data): bool
    {
        // Send an email.
        return true;
    }
}
