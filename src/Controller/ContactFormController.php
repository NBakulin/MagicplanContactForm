<?php
declare(strict_types=1);

namespace App\Controller;

use App\Form\ContactForm\ContactFormFactory;
use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;

class ContactFormController extends Controller
{

    public function getForm(string ...$path): ?Response
    {
//        $this->getEventManager()->off($this->Csrf);
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
            $formData = $this->request->getData();
            $isFormValid = $form->validate($formData);
            if ($isFormValid) {
                $form->execute($formData);
                return new Response();
            } else {
                throw new NotFoundException();
            }
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }
    }
}
