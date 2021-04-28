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
        $amount = session('amount', 0);
        $currency = session('currency', 'EUR');

        return view('converter', compact('rates', 'result', 'amount', 'currency'));
    }

    public function convert(Request $request)
    {
        $currency = $request->get('currency');
        $amount = $request->get('amount');

        $amount *= \currency($currency)->getSubunit();
        $result = money($amount, $currency)
            ->convert(
                \Akaunting\Money\Currency::EUR(),
                100_000 / Currency::where('name', $currency)->first()->rate
            )
            ->getAmount(true);

        session(compact('currency', 'amount', 'result'));

        return redirect('/');
    }
}
