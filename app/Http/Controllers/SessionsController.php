<?php

namespace App\Http\Controllers;

use App\PaymentDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function index()
    {
        $details = PaymentDetail::where('user_id', auth()->id())->get();
        return view('index', compact('details'));
    }

    public function show ()
    {
        return view('login');
    }

    public function store ()
    {
        $this->validate(request(), [
            'email'    => 'required|max:255|email',
            'password' => 'required|max:255'
        ]);

        if (!auth()->attempt(request(['email', 'password'])))
        {
            return back()->withErrors(['message' => 'Please check your credentials and try again']);
        }

        return redirect()->home();

    }
    public function destroy()
    {
        auth()->logout();
//        dd('destroy');

        return redirect()->home();
    }

}
