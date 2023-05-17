<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Subscriber;

class SubscriberController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function add_new()
    {
        return view('contents.add-new');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function manage_list(Request $request)
    {
        $subscribers = Subscriber::all();
        return view('contents.manage-list', ['subscribers' => $subscribers]);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($id)
    {
        $subscriber = Subscriber::find($id);
        return view('contents.edit', $subscriber);
    }

    public function store(Request $request)
    {
        $subscriber = new Subscriber;
        $subscriber->subscriber_list = $request->subscriber_list;
        $subscriber->unsubscriber_list = $request->unsubscriber_list;
        $subscriber->aweber_unsubscribe_list = $request->aweber_unsubscribe_list;
        $subscriber->getresponse_list = $request->getresponse_list;
        $subscriber->save();
        return redirect('/manage-list');
    }
    public function update(Request $request)
    {
        $subscriber = Subscriber::find($request->id);
        $subscriber->subscriber_list = $request->subscriber_list;
        $subscriber->unsubscriber_list = $request->unsubscriber_list;
        $subscriber->aweber_unsubscribe_list = $request->aweber_unsubscribe_list;
        $subscriber->getresponse_list = $request->getresponse_list;
        $subscriber->save();
        return redirect('/manage-list');
    }
    public function delete($id)
    {
        Subscriber::destroy($id);
        return redirect('/manage-list');
    }

    function get_data_by_subscriber_id($id)
    {
        $subscribers = Subscriber::where('subscriber_list', $id)->get();
        printf('<ul>');
        foreach ($subscribers as $key => $subscriber) {
            $subscriber_id = $subscriber->subscriber_list;

            $unsubscriber_list = explode(',', $subscriber->unsubscriber_list);
            if (in_array($subscriber_id, $unsubscriber_list)) {
                printf('<li>/api/unsubscribe/%d</li>', $subscriber_id);
            }

            $aweber_unsubscribe_list = explode(',', $subscriber->aweber_unsubscribe_list);
            if (in_array($subscriber_id, $aweber_unsubscribe_list)) {
                printf('<li>/api/aweber/%d</li>', $subscriber_id);
            }

            $getresponse_list = explode(',', $subscriber->getresponse_list);
            if (in_array($subscriber_id, $getresponse_list)) {
                printf('<li>/api/getresponse/%d</li>', $subscriber_id);
            }
        }
        printf('<ul>');
        // return $subscriber;
    }
}
