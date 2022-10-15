<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class ContactsSendmail extends Mailable
{
    use Queueable, SerializesModels;
    
    // プロパティを定義
    private $email;
    private $title;
    private $body;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($inputs)
    {
        // コンストラクタでプロパティに値を格納
        $this->email = $inputs['email'];
        $this->title = $inputs['title'];
        $this->body = $inputs['body'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $auth = Auth::user();
        return $this
                ->from('dspsblab@gmail.com')
                ->subject('自動送信メール')
                ->view('itineraries/contact/mail')
                ->with([
                    'email' => $this->email,
                    'title' => $this->title,
                    'body' => $this->body,
                    'auth' => $auth
                    ]);
    }
}
