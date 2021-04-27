<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/app.css">
    <title>Currency Converter</title>
</head>
<body class="h-screen grid place-items-center">
<div>
    <div class="flex justify-center mb-20">
        @include('icon')
    </div>
    {{--    <h1 class="font-bold text-4xl text-center mt-4 mb-8">Converter</h1>--}}
    <div>
        <form action="/convert" method="post">
            <select name="currency" id="currency" class="form-select">
                @foreach($rates as $rate)
                    <option value="{{ $rate->name }}">
                        <div class="px-4">{{ currency($rate->name)->getSymbol() }}</div>
                        <div>{{ $rate->name }}</div>
                    </option>
                @endforeach
            </select>
            <input type="text" name="amount" id="amount">
            <input type="submit" value="Change" class="px-4 py-2">
        </form>
    </div>
    <div class="font-bold text-center mt-8">
        @if($result)
            @money($result, 'EUR')
        @endif
    </div>
</div>
</body>
</html>
