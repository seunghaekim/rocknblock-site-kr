<?php namespace amaryfilo\Site\Components;

use Cms\Classes\ComponentBase;

use Illuminate\Http\Request;
use Mail;

class Main extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Sections component',
            'description' => '!Important - use partials in plugin'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onForm()
    {

        $feedback_form_id = post('id');

        $text = '<table class="amaryfilo-table"><tbody>';

        $text = $text.'<tr><td style="padding:10px;background:cornflowerblue;color:white;font-size:14px;">Имя</td><td>'.post('name')."</td></tr>";
        $text = $text.'<tr><td style="padding:10px;background:cornflowerblue;color:white;font-size:14px;">Contact</td><td>'.post('contact')."</td></tr>";
        $text = $text.'<tr><td style="padding:10px;background:cornflowerblue;color:white;font-size:14px;">Type</td><td>'.post('type')."</td></tr>";
        $text = $text.'<tr><td style="padding:10px;background:cornflowerblue;color:white;font-size:14px;">Idea</td><td>'.post('idea')."</td></tr>";

        $text = $text.'</tbody></table>';

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        $headers .= 'From: Rocknblock <no-reply@rocknblock.io>' . "\r\n" . 'X-Mailer: PHP/' . phpversion();

        $mail_send = mail("laumiqv@gmail.com", "Заявка с сайта rocknblock.io", "<html><head><title>Заявка с сайта rocknblock.io</title><style>table.amaryfilo-table{width: 300px;}table.amaryfilo-table tbody tr td{padding: 8px;}table.amaryfilo-table tbody tr:nth-child(2n){background: #f5f5f5;}</style></head><body>Новая Заявка<br><small><a href='https://rocknblock.io/'>rocknblock.io</a></small><br><br><hr><br>".$text."<br><hr><br><small>Данное письмо было отправлено автоматически</small></body></html>", $headers);

        if($mail_send) $this->page['success_form'] = "1";
    }

    public function onFormDone()
    {
        $this->page['success_form'] = "0";
    }
}
