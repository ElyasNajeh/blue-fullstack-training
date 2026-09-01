<?php

namespace Elyas\Services\Components;

use Cms\Classes\ComponentBase;
use Elyas\Services\Models\ContactMessage;
use Elyas\Services\Models\Settings;
use October\Rain\Exception\ValidationException;
use Validator;

class ContactForm extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Contact Form',
            'description' => 'Displays and processes the public contact form.'
        ];
    }

    public function onRun()
    {
        $this->page['contactSettings'] = Settings::instance();
    }

    public function onSubmit()
    {
        $data = post();

        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|max:255',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $contactMessage = new ContactMessage();
        $contactMessage->name = $data['name'];
        $contactMessage->email = $data['email'];
        $contactMessage->subject = $data['subject'];
        $contactMessage->message = $data['message'];
        $contactMessage->status = 'new';
        $contactMessage->save();

        return [
            '#contact-result' => '<div class="contact-success">Message sent successfully.</div>'
        ];
    }
}
