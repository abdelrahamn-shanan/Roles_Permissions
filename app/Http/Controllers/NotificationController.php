<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MailService;
use App\Facades\MailServiceFacade;



class NotificationController extends Controller
{
    // protected $mailService;

    // public function __construct(MailService $mailService)
    // {
    //     $this->mailService = $mailService;
    // }

    public function sendNotification(Request $request)
    {
        $to ='test@example.com';
        $subject = "Test Notification";
        $body = "This is a test notification email.";

        $result = $this->mailService->send($to, $subject, $body);

        return response()->json(['message' => $result]);
    }

    public function testFacade()
    {
       $to ='testt5555tt@example.com';
        $subject = "Test Notification";
        $body = "This is a test notification email.";

        $result = \MailService::send($to, $subject, $body);

        return response()->json(['message' => $result]);    
    }
}
