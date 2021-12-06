<?php namespace amaryfilo\Feedback\Components;

use Cms\Classes\ComponentBase;
use amaryfilo\Feedback\Models\Feedback;
use amaryfilo\Feedback\Models\Request as Requests;
use amaryfilo\Feedback\Models\Input;
use amaryfilo\Feedback\Models\Send;
// use Illuminate\Pagination\LengthAwarePaginator;
// use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use Mail;

class Feedbacks extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Feedback',
            'description' => 'Feedback component'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onViewForm()
    {
        $feedback_id = post('id');
        return Feedback::where('id','=', 1)->get();
        // $this->page['sfeedbacks'] = Feedback::where('id','=', 1)->get();
        // return [
        //         '#feedbackst' => $this->renderPartial('feedbackjs'),
        //     ];
    }

    public function onSendMail()
    {
        // Start initialization values

        $feedback_id = post('id_form');
        $text = '<table class="amaryfilo-table"><tbody>';
        $form_title = '';

        // Get form and info title

        $forms = Feedback::where('id','=', $feedback_id)->get();
        foreach ($forms as $form)
            $form_title = $form->title;

        // Get Inputs via form

        $results = Input::whereHas('feedback', function($filter) use ($feedback_id){
                    $filter->where('id', '=', $feedback_id);
                })->where('is_active', '=', 1)->get();

        foreach ($results as $result) $text = $text.'<tr><td><b>'.$result->title.'</b>:</td><td>'.post($result->name)."</td></tr>";

        $text = $text.'</tbody></table>';

        // Insert request into table Request and send mail

        $get_mails = Send::whereHas('feedback_mails', function($filter) use ($feedback_id){
            $filter->where('id', '=', $feedback_id);
        })->get();

        $insert_request = Requests::insertGetId(
            [
                'created_at' => date("Ymdhis"),
                'title' => $form_title,
                'description' => $text,
            ]
        );

        // $collection = [
        //     'info_header' => 'Заявка с лендинга Mebelbor',
        //     'ip_info' => $_SERVER['REMOTE_ADDR'],
        //     'datetime' => date("Ymdhis"),
        //     'title'    => $form->title,
        //     'description' => $text,
        // ];

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        $headers .= 'From: Rocknblock <no-reply@rocknblock.io>' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

        foreach ($get_mails as $get_mail){
            $mail_send = mail("$get_mail->title", "Сообщение от Rocknblock.io", "<html><head><title>Заявка с сайта rocknblock.io</title><style>table.amaryfilo-table{width: 100%;}table.amaryfilo-table tbody tr td{padding: 8px;}table.amaryfilo-table tbody tr:nth-child(2n){background: #f5f5f5;}</style></head><body>Новая Заявка<br><small><a href='rocknblock.io'>rocknblock.io</a></small><br><br><hr><br>".$text."<br><hr><br><small>Данное письмо было отправлено автоматически</small></body></html>", $headers);
        }

        $this->page['success_form'] = "1";
        return [
                '#feedbackst' => $this->renderPartial('feedbackjs')
            ];
    }

    // public function onSendMailViaForm()
    // {
    //     $feedback_form_id = post('id');
    //     $feedback_form_title = post('title');
    //     $feedback_type_form = post('type');
    //     $text = '<table class="amaryfilo-table"><tbody>';

    //     if($feedback_form_id == 1){
    //         $text = $text.'<tr><td>Имя</td><td>'.post('name')."</td></tr>";
    //         $text = $text.'<tr><td>Телефон</td><td>'.post('tel')."</td></tr>";
    //         $text = $text.'<tr><td>Размер кухни</td><td>'.post('size')."</td></tr>";
    //     }

    //     if($feedback_form_id == 2){
    //         $text = $text.'<tr><td>Имя</td><td>'.post('name')."</td></tr>";
    //         $text = $text.'<tr><td>Телефон</td><td>'.post('tel')."</td></tr>";
    //         $text = $text.'<tr><td>Заявка</td><td>'.post('zauavka')."</td></tr>";
    //     }

    //     $text = $text.'</tbody></table>';

    //     $insert_request = Requests::insertGetId(
    //         [
    //             'created_at' => date("Ymdhis"),
    //             'title' => $feedback_form_title,
    //             'description' => $text,
    //         ]
    //     );

    //     $get_mails = Send::whereHas('feedback_mails', function($filter) use ($feedback_type_form){
    //         $filter->where('id', '=', $feedback_type_form);
    //     })->get();

    //     $headers = "MIME-Version: 1.0" . "\r\n";
    //     $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    //     $headers .= 'From: Rocknblock.io <no-reply@rocknblock.io>' . "\r\n" .
    //     'X-Mailer: PHP/' . phpversion();

    //     foreach ($get_mails as $get_mail){

    //         $mail_send = mail("$get_mail->title", "Сообщение от Rocknblock.io", "<html><head><title>Заявка с сайта rocknblock.io</title><style>table.amaryfilo-table{width: 100%;}table.amaryfilo-table tbody tr td{padding: 8px;}table.amaryfilo-table tbody tr:nth-child(2n){background: #f5f5f5;}</style></head><body>Новая Заявка<br><small><a href='rocknblock.io'>rocknblock.io</a></small><br><br><hr><br>".$text."<br><hr><br><small>Данное письмо было отправлено автоматически</small></body></html>", $headers);
    //     }

    //     $this->page['success_form'] = "1";
    // }
}
