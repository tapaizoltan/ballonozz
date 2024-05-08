<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ config('app.name') }}</title>
        
    </head>
    <head>
        <style>
            body{
                background-color: #f4f4f5;
            }

            .btn {
                text-decoration: none;
                border-radius: 9999px;
                padding-top: 6px;
                padding-bottom: 6px;
                padding-left: 16px;
                padding-right: 16px;
            }
            
            .accent{
                background-color: #F4AC45;
                color: #FFFFFF;
                font-weight: 700;
            }
            .primary {
                background-color: #09C2EC;
                color: #FFFFFF
                font-weight: 700;
            }

            .card{
                border-radius: 10px;
                background-color: #FFFFFF; 
                padding: 16px;
            }

            .container {
                width: 100%;
                max-width: 768px;
                margin-left: auto;
                margin-right: auto;
            }
        </style>
    </head>
    <div class="container">
        <div class="card">
            {{ $slot }}
            <x-farewells.mail/>
        </div>
    </div>
</html>
