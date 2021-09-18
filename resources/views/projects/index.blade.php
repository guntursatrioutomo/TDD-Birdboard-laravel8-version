<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GunBoard</title>
</head>
<body>
    @foreach ($projects as $project)
    <a href="{{ $project->path() }}"><li>{{ $project->title }}</li></a> 
    <li>{{ $project->descriptions }}</li>   
    
    @endforeach
</body>
</html>