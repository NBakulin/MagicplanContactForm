<?php
declare(strict_types=1);

namespace App\Form\ContactForm;

use App\Enumeration\Form\ContactFormEnum;
use App\Helper\LogHelper;
use Cake\Event\EventManager;
use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Mailer\Mailer;
use Cake\Validation\Validator;

class CustomerSupportForm extends Form
{
    private ?string $receiver;

    private ?string $sender;

    private LogHelper $logger;

    public function __construct(?EventManager $eventManager = null)
    {
        parent::__construct($eventManager);

        $this->receiver = env('MAIL_ADDRESS_TO', null);

        if (!$this->receiver) {
            throw new \Exception('Receiver is not defined in config/.env');
        }
        $this->sender = env('MAIL_ADDRESS_FROM', null);
        if (!$this->sender) {
            throw new \Exception('Sender is not defined in config/.env');
        }
        $this->logger = new LogHelper('contact_form_logs');
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
            $mailer = new Mailer('default');
            $mailer->setFrom([$this->sender => 'Contact Form'])
                ->setTo($this->receiver)
                ->setSubject('Contact Form Email')
                ->deliver($data[ContactFormEnum::MESSAGE]);
        } catch (\Exception $error) {
            $this->logger->log(
                'error',
                'Could not send an email with data: ' . json_encode($data) . ' and message: ' . $error->getMessage()
            );

            return false;
        }

        return true;
    }
}
