<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('bootstrap-pdf/bootstrap.min.css') }}">

        <title>Generando en formato PFD Padrón de placas....</title>

    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    @yield('content')
                </div>
            </div>
        </div>
    </body>
</html>