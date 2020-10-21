<?php

namespace App\Http\Controllers;

use App\Ldcservice;
use Illuminate\Http\Request;
use \App\Mail\SendMail;
class MailSend extends Controller
{
    public function mailsend()
    {
        $all = Ldcservice::orderBy('id')->get();
        $idkey = array();
        foreach ($all as $key=>$value){
            $nextrenewdate = $value['nextrenew'];
            $now = time(); // or your date as well
            $your_date = strtotime($nextrenewdate);
            $datediff = ceil(($your_date-$now)/86400);
            if($value['renewalterms'] == 'Yearly'){
                if($datediff<= 30){
                    $idkey[] = $value;
                }
            }elseif ($value['renewalterms'] == 'Monthly'){
                if($datediff<= 7){
                    $idkey[] = $value;
                }
            }
        }
        foreach ($idkey as $item) {
            $details = [
                'title' => $item['renewalterms'] . ' Renewal',
                'body' => 'Service Type:'.$item['servicetype']. ' | Provider Name:'.$item['providername']. ' | Next Renewal Date:'.$item['nextrenew']
            ];

            \Mail::to('prosenjit.kundu@lizfashion.com')->send(new SendMail($details));
        }

        return view('emails.thanks');
    }
}
