<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
  

<h1>Student Grades</h1>
@php
$average = ($prelim + $midterm + $final)/3;
@endphp

<h1>Average: {{ $average }}</h1>

<h1>Letter Grade: 
    @if ($average >= 90) A
    @elseif($average >= 80 && $average < 90 ) B
    @elseif($average >= 70 && $average < 80 ) C
    @elseif($average >= 60 && $average < 70 ) D
    @elseif($average < 60 ) F
@endif
</h1>

<h1>Remarks: 

@if ($average >= 75) Passed
@else Failed

@endif
</h1>

<h1>Award: 

@if ($average >= 98) With Highest Honors
@elseif ($average >= 95 && $average <=97) With High Honors
 @elseif ($average >= 90 && $average <=94) With Honors
 @else No Award

@endif
</h1>
</body>
</html>