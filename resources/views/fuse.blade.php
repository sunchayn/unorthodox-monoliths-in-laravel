<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Example</title>
</head>
<body>

@if($results->isNotEmpty())
    Found the following:
    <ul>
        @foreach($results as $result)
            <li>Migration: {{$result->migration}}</li>
        @endforeach
    </ul>
@else
    <p>Cannot find anything at the moment.</p>
    <small>Check the logs for `A table was not readable`.</small>
@endif
</body>
</html>
