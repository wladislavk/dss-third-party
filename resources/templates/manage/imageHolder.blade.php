<!DOCTYPE html>
<html>
    <head>
        {!! HTML::style('/css/cloud-zoom.css') !!}

        {!! HTML::style('/js/jquery-1.6.2.min.js') !!}
        {!! HTML::style('/js/cloud-zoom.1.0.2.min.js') !!}
    </head>
    <body>
        <a href="{!! $folder !!}/{!! $image !!}" class='cloud-zoom'>
            <img height='250' src="{!! $folder !!}/{!! $image !!}" />
        </a><br />
        <img height='500' src="{!! $folder !!}/{!! $image !!}" />
    </body>
</html>