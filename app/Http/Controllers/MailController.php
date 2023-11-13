<?php

namespace App\Http\Controllers;

use App\Mail\Mail;
use Illuminate\Support\Facades\Mail as FacadesMail;

class MailController extends Controller
{
    public function index()
    {
        $mailData = [
            'title' => 'Não responda essa mensagem',
            'body' => 'Corpo da mensagem.',
            'link' => 'http://127.0.0.1:8000/forgot-password/SDFDSF096SDJ',
            'subject' => 'Sistema - Recuperação de senha',
        ];

        FacadesMail::to('giordanigomes@gmail.com')->send(new Mail($mailData));

        return response()->json([
            'message' => 'E-mail enviado com sucesso.'
        ], HTTP_CODE_OK);
    }
}
