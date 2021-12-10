<?php namespace Amaryfilo\Feedbacks\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Http\Request;
use Mail;

use amaryfilo\Feedback\Models\Feedback as FeedbackModel;

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
        // Insert into database
        FeedbackModel::insertGetId(
            [
                'name' => post('name'),
                'contact' => post('contact'),
                'type' => post('type'),
                'idea' => post('idea'),
                'from_url' => Request::url(),
                'created_at' => date("Ymdhis")
            ]
        );

        // Table style
        $styleTable = 'table.amaryfilo-table{width: 300px;}table.amaryfilo-table tbody tr td{padding: 8px;}table.amaryfilo-table tbody tr:nth-child(2n){background: #f5f5f5;}';
        $styleTd = 'padding:10px;background:cornflowerblue;color:white;font-size:14px;';

        // Table wrap
        $text  = '<table class="amaryfilo-table"><tbody>';
        $text .= '<tr><td style="'.$styleTd.'">Name</td><td>'.post('name').'</td></tr>';
        $text .= '<tr><td style="'.$styleTd.'">Contact</td><td>'.post('contact').'</td></tr>';
        $text .= '<tr><td style="'.$styleTd.'">Type</td><td>'.post('type').'</td></tr>';
        $text .= '<tr><td style="'.$styleTd.'">Idea</td><td>'.post('idea').'</td></tr>';
        $text .= '<tr><td style="'.$styleTd.'">URL</td><td>'.Request::url().'</td></tr>';
        $text .= '</tbody></table>';

        $headers  = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: Rocknblock <no-reply@rocknblock.io>' . "\r\n" . 'X-Mailer: PHP/' . phpversion();

        $mail_send = mail(env('MAIL_REQUEST_TO'), "Application from the site rocknblock.io.", "<html><head><title>Application from the site rocknblock.io.</title><style>".$styleTable."</style></head><body>New Application from <a href='https://rocknblock.io/'>rocknblock.io</a> from <b>".post('name')."</b><br><hr><br>".$text."<br><hr><br><small>This email was sent automatically. Please do not reply to it.</small></body></html>", $headers);

        if(post('type') === 'email')
            Mail::sendTo(trim(post('contact')), 'amaryfilo.feedbacks::mail.request', $params);
            // mail(trim(post('contact')), "Your request to Rock'n'block Development.", "<html><head><title>Thank you for your request.</title></head><body>Hello, <b>".post('name')."</b>!<br><br>We have received your application. Our manager will contact you shortly.</body></html>", $headers);

        if($mail_send) $this->page['success_form'] = "1";
    }

    public function onFormDone()
    {
        $this->page['success_form'] = "0";
    }
    
}
