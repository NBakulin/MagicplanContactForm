<?php
declare(strict_types=1);

namespace App\Form\ContactForm;

use App\Enumeration\ContactForm\ContactFormEnum;
use App\Helper\LogHelper;
use Cake\Event\EventManager;
use Cake\Form\Schema;
use Cake\Validation\Validator;
use Cake\Http\Client;

final class SalesForm extends AbstractContactForm
{
    private ?string $requestUrl;

    private LogHelper $logger;

    public function __construct(?EventManager $eventManager = null)
    {
        parent::__construct($eventManager);

        $this->requestUrl = env('API_URL', null);
        if (!$this->requestUrl) {
            throw new \Exception('API URL to send a contact form data is not defined in config/.env');
        }
        $this->requestUrl .= '/sales';
        $this->logger = new LogHelper('contact_form_logs');
    }

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
        parent::_buildSchema($schema);
        $keys = [
            ContactFormEnum::COMPANY_NAME => 'string',
            ContactFormEnum::COMPANY_SIZE => 'string',
            ContactFormEnum::INDUSTRY => 'string',
            ContactFormEnum::REGION => 'string',
            ContactFormEnum::PHONE => 'string',
        ];
        foreach ($keys as $field => $type) {
            $schema->addField($field, ['type' => $type]);
        }

        return $schema;
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->equals(ContactFormEnum::QUESTION_TYPE, ContactFormEnum::SALES);
        $validator = parent::validationDefault($validator);
        $validator->notEmptyString(ContactFormEnum::COMPANY_NAME, 'Please provide a company name');
        $validator->inList(ContactFormEnum::COMPANY_SIZE, self::ALLOWED_COMPANY_SIZE, 'Please provide a company size');
        $validator->inList(ContactFormEnum::INDUSTRY, self::ALLOWED_INDUSTRY, 'Please provide a company industry');
        $validator->inList(ContactFormEnum::REGION, self::ALLOWED_REGION,'Please provide a region');
        $validator->add(ContactFormEnum::PHONE, 'custom', [
            'rule' => function ($value) {
                return $value === '' || (bool)preg_match('#^[+]?[\d]+$#', $value);
            },
            'message' => 'Please provide a valid phone number'
        ]);


        return $validator;
    }

    protected function _execute(array $data): bool
    {
        try {
            $client = new Client();
            $response = $client->post($this->requestUrl, json_encode($data), ['type' => 'text/html; charset=utf-8']);
            if ($response->getStatusCode() === 200 || $response->getStatusCode() === 204) {
                return true;
            }
            $this->logger->log(
                'notice',
                "POST \"{$this->requestUrl}\" responded with {$response->getStatusCode()} response code. Data: " . json_encode($data) . ' Response body: ' . $response->getStringBody()
            );
        } catch (\Exception $exception) {
            $this->logger->log(
                'error',
                "POST \"{$this->requestUrl}\" with request with data: " . json_encode($data) . '. Got message: ' . $exception->getMessage()
            );
        }
        return false;
    }
}
