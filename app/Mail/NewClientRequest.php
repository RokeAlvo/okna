<?php

namespace App\Mail;

use App\Layout;
use App\Request as ClientRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewClientRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $clientRequest;
    public $layout;

    public function __construct(ClientRequest $clientRequest)
    {
        $this->clientRequest = $clientRequest;
        if (!empty($this->clientRequest->layout_id)) {
            $this->layout = Layout::select('id', 'residential_complex_id', 'rooms', 'area', 'main_image_original')
                ->with([
                    'residentialComplex' => function ($q) {
                        $q->select('id', 'title', 'developer_id', 'completion_decade', 'completion_year')
                            ->with([
                                'developer' => function ($q) {
                                    $q->select('id', 'name');
                                }
                            ]);
                    },
                    'apartments' => function ($q) {
                        $q->select('id', 'floor', 'layout_id', 'rooms', 'house_id', 'price', 'price_meter')->take(1)->with([
                            'house' => function ($q) {
                                $q->select('id', 'completion_decade', 'completion_year');
                            },
                        ]);
                    },
                ])
                ->findOrFail($this->clientRequest->layout_id);
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(MAIL_FROM[getUrlPathFirstPart()]['email'], MAIL_FROM[getUrlPathFirstPart()]['mailName'])
            ->subject(REQUEST_TYPES[$this->clientRequest->type])->view('emails.newRequest');
    }
}
