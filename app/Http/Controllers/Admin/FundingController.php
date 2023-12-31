<?php

namespace App\Http\Controllers\Admin;

use App\Funding;
use App\Http\Controllers\Controller;
use App\Mail\FundingMail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FundingController extends Controller
{
    public function fund()
    {
        $users = User::where('admin', 0)->get();
        $funds = Funding::latest()->get();
        return view('admin.user.add-fund', compact('users', 'funds'));
    }
    public function sendFund(Request $request)
    {
        $data = $this->getData($request);
        $data['user_id'] = $request->user_id;
        $data['status'] = 1;
        $data = Funding::create($data);
        if ($data['type'] == 'Bonus'){
            $user = User::findOrFail($data->user_id);
            $user->ref_bonus += $request->amount;
            $user->save();
            Mail::to($data->user->email)->send(new FundingMail($data));
            return redirect()->back()->with('success', "Fund sent successfully");
        }elseif ($data['type'] == 'Profit')
        {
            $user = User::findOrFail($data->user_id);
            $user->profit += $request->amount;
            $user->save();
            Mail::to($data->user->email)->send(new FundingMail($data));
            return redirect()->back()->with('success', "Fund sent successfully");
        }elseif ($data['type'] == 'Balance')
        {
            $user = User::findOrFail($data->user_id);
            $user->balance += $request->amount;
            $user->save();
            Mail::to($data->user->email)->send(new FundingMail($data));
            return redirect()->back()->with('success', "Fund sent successfully");
        }elseif ($data['type'] == "Invested")
        {
            $user = User::findOrFail($data->user_id);
            $user->invested += $request->amount;
            $user->save();
            Mail::to($data->user->email)->send(new FundingMail($data));
            return redirect()->back()->with('success', "Fund sent successfully");
        }
        return redirect()->back()->with('error', "Fund Not Sent");
    }

    protected function getData(Request $request)
    {
        $rules = [
            'type' => 'required',
            'amount' => 'required',
        ];
        return $request->validate($rules);
    }


    public function deleteFund($id)
    {
        $fund = Funding::findOrFail($id);
        $fund->delete();
        return redirect()->back()->with('success', 'deleted successfully');
    }

}
