<?php

namespace App\Class;

use \Mailjet\Resources;
use \Mailjet\Client;
class Mail {

    public function send ($to_email, $to_name, $subject, $content) {
    $mj = new \Mailjet\Client($_ENV['MJ_APIKEY_PUBLIC'], $_ENV['MJ_APIKEY_PRIVATE'],true,['version' => 'v3.1']);

    // Define your request body

    $body = [
        'Messages' => [
            [
                'From' => [
                    'Email' => "$SENDER_EMAIL",
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
                        "content" => $content /*"<h3>Dear passenger 1, welcome to <a href=\"https://www.mailjet.com/\">Mailjet</a>!</h3>
                <br />May the delivery force be with you!"*/
                    ],
            ]
        ]
    ];

    $mj->post(Resources::$Email, ['body' => $body]);

    // Read the response

    /*$response->success() && var_dump($response->getData());*/

        }
}
