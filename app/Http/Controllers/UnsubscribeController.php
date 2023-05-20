<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\GetResponseController;
use App\Http\Controllers\AweberController;

class UnsubscribeController extends Controller
{
    public function index()
    {
        return view('contents.unsubscribe');
    }

    public function unsubscribe(Request $request)
    {
        $id = $request->input('subscriber_id');

        $subscriber = new SubscriberController;
        $idList = $subscriber->get_data_by_subscriber_id($id);

        if (isset($idList['unsubscribe'])) {
        } elseif (isset($idList['aweber'])) {
            $aweber = new AweberController;
            $aweber->deleteAweberSubscriber($idList['aweber']);
        } elseif (isset($idList['getresponse'])) {
            $getResponse = new GetResponseController;
            $getResponse->deleteContact($idList['getresponse']);
        }
    }
}
