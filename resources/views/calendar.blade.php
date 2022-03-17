<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Document</title>
    </head>
    <body>
        <button id="next">Next Month</button>
        <br>
        <button id="prev">Prev Month</button>
        <h3>DATE</h3>
        <p id="today"></p>
        <p id="prev-dates"></p>
        <p id="dates"></p>
        <p id="next-dates"></p>
        <p id="pr-dt"></p>
        <p id="dt"></p>
        <p id="nx-dt"></p>

    </body>
<script>
    var todayDate = new Date().toISOString().slice(0, 10);
    $( document ).ready(function() {
        var split = todayDate.split("-");
        var year = split[0];
        var month = split[1];
        var day = split[2];
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:'dates-j',
            data:{
                'year':year,
                'month':month,
                'day':day
            },
            type:'post',
            success:  function (response) {
                $('#today').html(response.today);
                $('#prev-dates').html(response.prevDates);
                $('#dates').html(response.dates);
                $('#next-dates').html(response.nextDates);
                var obj = JSON.parse(response.prevDates);
                $('#pr-dt').html("contoh 1 prev date: " + obj[27]);
                var obj = JSON.parse(response.dates);
                $('#dt').html("contoh 1 date: " + obj[1]);
                var obj = JSON.parse(response.nextDates);
                $('#nx-dt').html("contoh 1 next data: " + obj[1]);
            },
            statusCode: {
                404: function() {
                    alert('web not found');
                }
            },
            error:function(x,xs,xt){
                alert(JSON.stringify(x));
            }
        });
    });
    $('#next').click(function(){
        var order = "next";
        var split = todayDate.split("-");
        var year = split[0];
        var month = split[1];
        var day = split[2];
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:'/dates-j',
            data:{
                'order':order,
                'year':year,
                'month':month,
                'day':day
            },
            type:'post',
            success:  function (response) {
                $('#today').html(response.today);
                $('#prev-dates').html(response.prevDates);
                $('#dates').html(response.dates);
                $('#next-dates').html(response.nextDates);
                todayDate = response.today;
            },
            statusCode: {
                404: function() {
                    alert('web not found');
                }
            },
            error:function(x,xs,xt){
                alert(JSON.stringify(x));
            }
        });
    });
    $('#prev').click(function(){
        var order = "prev";
        var split = todayDate.split("-");
        var year = split[0];
        var month = split[1];
        var day = split[2];
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:'/dates-j',
            data:{
                'order':order,
                'year':year,
                'month':month,
                'day':day
            },
            type:'post',
            success:  function (response) {
                $('#today').html(response.today);
                $('#prev-dates').html(response.prevDates);
                $('#dates').html(response.dates);
                $('#next-dates').html(response.nextDates);
                todayDate = response.today;
            },
            statusCode: {
                404: function() {
                    alert('web not found');
                }
            },
            error:function(x,xs,xt){
                alert(JSON.stringify(x));
            }
        });
    });
</script>
</html>