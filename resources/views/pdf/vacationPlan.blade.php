<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Your Vacation Plan</title>

        @vite('resources/css/app.css')
    </head>
<body>
    <div class="container p-5">
        <div>
            <h1 class="text-3xl font-bold text-center p-4">
                Your Vacation Plan
            </h1>
        </div>
        <div class="my-40 pl-3">
            <p class="pb-3"><span class="font-bold">Title:</span> {{$vacationPlan->title}}</p>
            <p class="pb-3"><span class="font-bold">Description:</span> {{$vacationPlan->description}}</p>
            <p class="pb-3"><span class="font-bold">Date:</span> {{$vacationPlan->date->format('F d, Y')}}</p>
            <p class="pb-3"><span class="font-bold">Location:</span> {{$vacationPlan->location}}</p>
            @if ($vacationPlan->participants)
                <p class="pb-3"><span class="font-bold">Participants:</span> {{$vacationPlan->participants}}</p>
            @endif
        </div>
    </div>
</body>
</html>