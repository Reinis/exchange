<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index()
    {
        $rates = Currency::all();
        $result = session('result', 0);

        return view('converter', compact('rates', 'result'));
    }

    public function convert(Request $request)
    {
        $currency = $request->get('currency');
        $amount = $request->get('amount');

        $result = $amount * Currency::where('name', $currency)->first()->rate / 1000;

        session(compact('result'));

        return redirect('/');
    }
}
