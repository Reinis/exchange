<?php

namespace App\Console\Commands;

use App\Models\Currency;
use Illuminate\Console\Command;

class CurrencyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $xml = simplexml_load_string(file_get_contents('https://www.bank.lv/vk/ecb.xml'));

        $json = json_encode($xml->Currencies, JSON_THROW_ON_ERROR);
        $rates = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        foreach ($rates['Currency'] as $rate) {
            $currency = Currency::where('name', $rate['ID'])->first();
            if (empty($currency)) {
                $currency = new Currency(['name' => $rate['ID']]);
            }
            $currency->rate = (float)$rate['Rate'] * 100_000;
            $currency->save();
        }

        return 0;
    }
}
