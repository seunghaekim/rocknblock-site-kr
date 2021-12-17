<?php namespace Amaryfilo\Feedbacks\Components;

use Cms\Classes\ComponentBase;
use Request;
use Mail;

use amaryfilo\Feedbacks\Models\Feedback as FeedbackModel;

use GuzzleHttp\Client;

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
        $data = [
            'name' => post('name'),
            'contact' => post('contact'),
            'type' => post('type'),
            'idea' => post('idea'),
            'from_url' => Request::url(),
            'created_at' => date("Ymdhis")
        ];

        if(post('id') === 'bridge') $data['idea'] = '<b>Blockchain</b>: '.post('blockchain').'.<br /><b>Token Contract</b>: '.post('tokenContract').'.';

        FeedbackModel::insert($data);

        $data['data'] = post();

        $mail_send = Mail::sendTo(trim(env('MAIL_REQUEST_TO')), 'amaryfilo.feedbacks::mail.feedback', $data);
        
        if(post('type') === 'email') Mail::sendTo(trim(post('contact')), 'amaryfilo.feedbacks::mail.request', ['name' => post('name')]);
        
        // if($mail_send)
        $this->page['success_form'] = "1";

        $this->toPipeDrive($data);
    }

    public function onFormDone()
    {
        $this->page['success_form'] = "0";
    }

    public function toPipeDrive(array $values = []) {
        $person = [];
        $person['name'] = $values['name'];
        $person['label'] = "7";
        $isTypeEmail = $values['type'] === 'email';
        $person[$isTypeEmail ? 'email' : 'phone'] = [['value' => $values['contact'],'label' => $isTypeEmail ? "Main" : $values['type']]];
        if(!$isTypeEmail) $person[$values['type'] === 'telegram' ? '92524324f9dc5f9b55a48c2b6a4d84aec6d16377' : 'e71670c7f11a9cb29aa333d6d1815cf7a18bb199'] = $values['contact'];

        $getPerson = $this->pipeDriveRequest(['url' => "v1/persons", 'data' => $person]);
        
        if($getPerson['success']) {
            $rqRef = Request::path() === '/' ? 'mainpage' : Request::path();
            $lead = [
                'title' => 'From website: '.$rqRef,
                'label_ids' => ['643dd95d-05b8-4108-82f2-c7996ea5c0d7'],
                'person_id' => $getPerson['data']['id'],
                'was_seen' => false,
                '6b570f722dc5a7fd375c2a247967cef21f7babdd' => "13",
                'e7f3337675a2627acd9d0f0aa87786de4ebbf7eb' => $values['from_url']
            ];

            $getLead = $this->pipeDriveRequest(['url' => "v1/leads", 'data' => $lead]);

            if($getLead['success']) {
                $note = [
                    'lead_id' => $getLead['data']['id'],
                    'content' => $values['idea']
                ];

                $addNote = $this->pipeDriveRequest(['url' => "v1/notes", 'data' => $note]);
            }
        }
    }

    public function pipeDriveRequest(array $values = []) {
        $apiKey = env('PIPEDRIVE_APIKEY');
        $apiCompany = env('PIPEDRIVE_COMPANY_DOMAIN');

        $apiUrl = "https://{$apiCompany}.pipedrive.com/{$values['url']}?api_token={$apiKey}";

        $client = new Client();
        $res = $client->request('POST', $apiUrl, ['json' => $values['data']]);
        
        return json_decode($res->getBody(), true);
    }
    
}
