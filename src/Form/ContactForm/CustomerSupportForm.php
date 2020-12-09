<?php
declare(strict_types=1);

namespace App\Form\ContactForm;

use App\Enumeration\ContactForm\ContactFormEnum;
use App\Helper\LogHelper;
use Cake\Event\EventManager;
use Cake\Mailer\Mailer;
use Cake\Validation\Validator;

final class CustomerSupportForm extends AbstractContactForm
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

    public function validationDefault(Validator $validator): Validator
    {
        parent::validationDefault($validator);
        $validator->equals(ContactFormEnum::QUESTION_TYPE, ContactFormEnum::CUSTOMER_SUPPORT);

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
        } catch (\Exception $exception) {
            $this->logger->log(
                'error',
                'Could not send an email with data: ' . json_encode($data) . ' and message: ' . $exception->getMessage()
            );

            return false;
        }

        return true;
    }
}
