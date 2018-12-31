<?php

namespace App\Services;

use Mailjet\Resources;


/**
 * Class EmailMarketing
 * @package App\Services
 */
class EmailMarketing
{

    /**
     * @var MailjetService
     */
    private $mailService;

    /**
     * EmailMarketing constructor.
     * @param $mailjet MailJet
     */
    public function __construct(MailjetService $mailjetService)
    {
        $this->mailService = $mailjetService;
    }

    public function sendTest() {

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "contato@celmarbelem.com.br",
                        'Name' => "Mailjet Pilot"
                    ],
                    'To' => [
                        [
                            'Email' => "oscar.alencar@gmail.com",
                            'Name' => "passenger 1"
                        ]
                    ],
                    'Subject' => "Your email flight plan!",
                    'TextPart' => "Dear passenger 1, welcome to Mailjet! May the delivery force be with you!",
                    'HTMLPart' => "<h3>Dear passenger 1, welcome to Mailjet!</h3><br />May the delivery force be with you!"
                ]
            ]
        ];
        $response = $this->mailService->getClient()->post(Resources::$Email, ['body' => $body]);
        return $response->success();
    }


}
