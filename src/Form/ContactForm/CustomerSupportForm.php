<?php
declare(strict_types=1);

namespace App\Form\ContactForm;

use App\Enumeration\Form\ContactFormEnum;
use Cake\Event\EventManager;
use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Log\Log;
use Cake\Mailer\Mailer;
use Cake\Validation\Validator;

final class CustomerSupportForm extends Form
{
    private  $receiver;

    private  $sender;

    public function __construct(?EventManager $eventManager = null)
    {
        parent::__construct($eventManager);
        $this->receiver = env('MAIL_ADDRESS_TO', null);
        $this->sender = env('MAIL_ADDRESS_FROM', null);
    }

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
        $validator->notEmptyString(ContactFormEnum::FIRST_NAME, 'Please provide your first name');
        $validator->notEmptyString(ContactFormEnum::LAST_NAME, 'Please provide your last name');
        // can check if email exists in MX-record with second argument but I think it is not necessary here
        $validator->email(ContactFormEnum::EMAIL, false, 'Please provide your email');
        $validator->notEmptyString(ContactFormEnum::MESSAGE, 'Please write a message');

        return $validator;
    }

    protected function _execute(array $data): bool
    {
        try {
            if (!$this->sender || !$this->receiver) {
                throw new \Exception('Sender or/and receiver is not defined in config/.env');
            }
            $mailer = new Mailer('default');
            $mailer->setFrom([$this->sender => 'Contact Form'])
                ->setTo($this->receiver)
                ->setSubject('Contact Form Email')
                ->deliver($data[ContactFormEnum::MESSAGE]);
        } catch (\Exception $error) {
            Log::write(
                'error',
                'Could not send an email with data: ' . json_encode($data) . ' and message: ' . $error->getMessage(),
                ['scope' => 'mailer_logs']
            );

            return false;
        }
        Log::write('info', 'Mail was sent', ['scope' => 'mailer_logs']);

        return true;
    }
}
