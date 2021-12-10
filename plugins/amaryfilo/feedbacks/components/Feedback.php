<?php namespace Amaryfilo\Feedbacks\Components;

use Cms\Classes\ComponentBase;
use Request;
use Mail;

use amaryfilo\Feedbacks\Models\Feedback as FeedbackModel;

class Feedback extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Feedback MAIN',
            'description' => 'Put this component into pages or template where you use simple form vith request onForm.'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onForm()
    {
        $feedbackData = [
            'name' => post('name'),
            'contact' => post('contact'),
            'type' => post('type'),
            'idea' => post('idea'),
            'from_url' => Request::path(),
            'created_at' => date("Ymdhis")
        ];

        // Insert into database
        FeedbackModel::insert($feedbackData);

        $mail_send = Mail::sendTo(trim(env('MAIL_REQUEST_TO')), 'amaryfilo.feedbacks::mail.feedback', $feedbackData);
        
        if(post('type') === 'email')
            Mail::sendTo(trim(post('contact')), 'amaryfilo.feedbacks::mail.request', ['name' => post('name')]);
        
        if($mail_send) $this->page['success_form'] = "1";
    }

    public function onFormDone()
    {
        $this->page['success_form'] = "0";
    }
    
}
