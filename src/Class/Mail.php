<?php

namespace App\Class;

use \Mailjet\Resources;
use \Mailjet\Client;
class Mail {

    public function send($to_email, $to_name, $subject, $template, $vars = null) {

        $content = file_get_contents(dirname(__DIR__).'/Mail/'.$template);

        if($vars) {
            foreach($vars as $key => $var) {
                $content = str_replace('{'.$key.'}', $var, $content);
            }
        }

    $mj = new \Mailjet\Client($_ENV['MJ_APIKEY_PUBLIC'], $_ENV['MJ_APIKEY_PRIVATE'],true,['version' => 'v3.1']);
    $senderEmail = $_ENV['SENDER_EMAIL'];

    $body = [
        'Messages' => [
            [
                'From' => [
                    'Email' => $senderEmail,
                    'Name' => "Gamestore"
                ],
                'To' => [
                    [
                        'Email' => $to_email,
                        'Name' => $to_name,
                    ]
                ],
                'TemplateID' => 6478373,
                'TemplateLanguage' => true,
                'Subject' => $subject /*"My first Mailjet Email!"*/,
                    "Variables" => [
                        "content" => $content
                    ]
            ]
        ]
    ];

    $mj->post(Resources::$Email, ['body' => $body]);

    // Read the response

    /*$response->success() && var_dump($response->getData());*/

        }
}
