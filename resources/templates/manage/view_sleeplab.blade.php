<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>

        {!! HTML::style('/css/manage/admin.css') !!}
        {!! HTML::style('/css/manage/form.css') !!}
        {!! HTML::style('/css/manage/quick_view.css') !!}

        {!! HTML::script('/js/jquery-1.6.2.min.js') !!}
        {!! HTML::script('/js/3rdParty/jquery.maskedinput-1.3.min.js') !!}
        {!! HTML::script('/js/manage/validation.js') !!}
        {!! HTML::script('/js/manage/masks.js') !!}
        {!! HTML::script('/js/manage/wufoo.js') !!}
        {!! HTML::script('/js/manage/preferred_contact.js') !!}
    </head>

    <body>
        <div style="padding-top:10px;background: #fff; width: 98%; height:380px; margin-left: 1%;">
            <div class="info">
                <label>Name:</label>
                <span class="value">{!! $sleeplabData['name'] !!}</span>
            </div>
            <div class="info">
                <label>Company:</label>
                <span class="value">{!! $sleepLabs['0']->company !!} </span>
            </div>
            <div class="info">
                <label>Address:</label>
                <span class="value">{!! $sleepLabs['0']->add1 !!}</span>
            </div>
            <div class="info">
                <label>&nbsp;</label>
                <span class="value">{!! $sleepLabs['0']->add2 !!}</span>
            </div>
            <div class="info">
                <label>&nbsp;</label>
                <span class="value">{!! $sleepLabs['0']->city or '' !!} {!! $sleepLabs['0']->state or '' !!} {!! $sleepLabs['0']->zip or '' !!}</span>
            </div>
            <div class="info">
                <label>Phone:</label>
                <span class="value">{!! $sleepLabs['0']->phone1 !!}</span>
            </div>
            <div class="info">
                <label>Phone 2:</label>
                <span class="value">{!! $sleepLabs['0']->phone2 !!}</span>
            </div>
            <div class="info">
                <label>Fax:</label>
                <span class="value">{!! $sleepLabs['0']->fax !!}</span>
            </div>
            <div class="info">
                <label>Email:</label>
                <span class="value">{!! $sleepLabs['0']->email !!}</span>
            </div>
            <div class="info">
                <label>Notes:</label>
                <span class="value">{!! $sleepLabs['0']->notes !!}</span>
            </div>
            <a href="/manage/add_sleeplab/{!! $ed !!}" style="margin-right:10px; float:right;">Edit</a>
        </div>
    </body>


</html>
