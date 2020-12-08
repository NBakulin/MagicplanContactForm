<?php
declare(strict_types=1);

namespace App\Controller;

use App\Form\ContactForm\ContactFormFactory;
use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\Log\Log;
use Cake\View\Exception\MissingTemplateException;

class ContactFormController extends Controller
{

    public function getForm(string ...$path): ?Response
    {
        if (!$path) {
            return $this->redirect('/contact_form');
        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        $this->set(compact('page', 'subpage'));

        try {
            return $this->render(implode('/', $path));
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }
    }

    public function postForm(string ...$path): ?Response
    {
        try {
            $form = ContactFormFactory::createForm($this->request->getData());
            if (!$form) {
                throw new \Exception();
            }
            $formData = $this->request->getData();
            $isFormValid = $form->validate($formData);
            if ($isFormValid) {
                if ($form->execute($formData)) {
                    return $this->render('success');
                }
            } else {
                return $this->createResponse(422, json_encode($form->getErrors()));
            }
        } catch (\Exception $exception) {
            $encodedMessage = json_encode($exception);
            Log::write('error', "Could not handle an error with message: {$encodedMessage}" );
        }
        return $this->createResponse(500, json_encode(['message' => 'Something went wrong']));
    }

    private function createResponse(int $status, string $body): Response
    {
        return new Response(
            [
                'status' => $status,
                'body' => $body,
            ]
        );
    }
}
