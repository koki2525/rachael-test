<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="css/styles.css">

         <!-- Bootstrap CSS -->
         <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    </head>
    <body>
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
        <div id="form-main">
            <h2 class="heading">Enter your message here</h2>
            <div id="form-div">
                <form class="form" id="form1">
                
                <p class="text">
                    <textarea name="text" class="validate[required,length[6,300]] feedback-input" id="comment"></textarea>
                </p>
                
                
                <div class="submit">
                    <input type="submit" value="SEND" id="button-blue"/>
                    <div class="ease"></div>
                </div>
                </form>
        </div>
    </body>
</html>
