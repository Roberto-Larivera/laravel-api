<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel-Auth</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100vw;
            font-family: Arial, Helvetica, sans-serif;
            background-color: lightgrey
        }

        main {
            margin: 30px 0;
            width: 100%;
            color: white;

        }

        h1 {
            margin-bottom: 2rem;
        }

        h3 {
            margin-bottom: 2rem;

        }

        .box-principal {
            width: 50%;
            
        }

        .box-content {
            width: 100%;
            background-color: #09AAA2;
            box-shadow: 5px 5px 16px -2px rgba(0, 0, 0, 0.78);
            padding-top: 100px;
            padding-bottom: 20px;
        }

        .box-content a.github {
            text-decoration: none;
            font-weight: bold;

            color: white;
            padding: 15px;
            background-color: black;
            margin: 10px;

        }

        .box-content a.github:hover {
            background-color: rgba(0, 0, 0, 0.5);
        }

        .box-content a.github:active {
            color: black;
            background-color: transparent;
            border: 3px solid black;
        }

        .box-content a.button {
            text-decoration: none;
            font-weight: bold;
            color: black;
            padding: 15px;
            background-color: white;
            border-radius: 15px;
            margin: 10px;
        }

        .box-content .description {
            width: 75%;

        }

        .firma {
            color: #09AAA2;
            font-weight: bold;
        }

        /* ------  */
        .margin-3 {
            margin-top: 30px;
            margin-bottom: 30px;
        }

        .margin-5 {
            margin-top: 50px;
            margin-bottom: 50px;
        }
        .margin-5-t {
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <main>
        <center>


            <div class="box-principal">
                <div class="box-content">
                    <h1>
                        Nuovo Progetto Pubblicato!
                    </h1>
                    <h3>
                        Hai publicato con successo <span style="font-size: 23px ">' {{ $project->title }} '</span>
                    </h3>

                    <div class="margin-3">
                        <a class="github" href="{{ $project->link_repo }}">
                            {{ $project->name_repo }}
                        </a>
                    </div>

                    <div class="description margin-3">
                        <p>
                            {!! nl2br($project->description)!!}
                        </p>
                    </div>
                    {{-- img... --}}
                    <div class="margin-5">
                        <a class="button" href="{{ route('guest.projects') }}">
                            Vedi tutti i post!
                        </a>
                        {{-- <a href="{{ route('admin.projects.show',$project->id) }}">
                        Vedi tutti i post!
                    </a> --}}
                        <a class="button" href="{{ route('admin.projects.show',$project->id) }}">
                            Vedi il progetto!
                        </a>
                    </div>

                </div>
                <div class="firma margin-5-t">
                    <p>
                        Larivera Roberto | Bollfolio
                    </p>
                </div>
            </div>
        </center>
    </main>
</body>

</html>
