<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body {
            background: lightblue;
            text-align: center;
            font-family: 'Segoe UI', Arial, Helvetica, sans-serif;
        }
    </style>
</head>
<body>
    <h1>È stato {{ $project->published ? 'pubblicato' : 'rimosso' }} un project</h1>
    <h2>{{ $project->title }}</h2>
</body>
</html>
