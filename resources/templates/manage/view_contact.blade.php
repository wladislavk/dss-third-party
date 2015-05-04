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
                <span class="value">{{ $contactData['salutation'] or '' }} {{ $contactData['name'] or '' }}</span>
            </div>
            <div class="info">
                <label>Company:</label>
                <span class="value">{{ $contactData['company'] or '' }} </span>
            </div>
            <div class="info">
                <label>Contact Type:</label>
                <span class="value">{{ $contactData['contacttype'] or '' }} </span>
            </div>
            <div class="info">
                <label>Address:</label>
                <span class="value">{{ $contactData['add1'] or '' }}</span>
            </div>
            <div class="info">
                <label>&nbsp;</label>
                <span class="value">{{ $contactData['add2'] or '' }}</span>
            </div>
            <div class="info">
                <label>&nbsp;</label>
                <span class="value">{{ $contactData['city'] or '' }} {{ $contactData['state'] or '' }} {{ $contactData['zip'] or '' }}</span>
            </div>
            <div class="info">
                <label>Phone:</label>
                <span class="value">{{ $contactData['phone1'] or '' }}</span>
            </div>
            <div class="info">
                <label>Phone 2:</label>
                <span class="value">{{ $contactData['phone2'] or '' }}</span>
            </div>
            <div class="info">
                <label>Fax:</label>
                <span class="value">{{ $contactData['fax'] or '' }}</span>
            </div>
            <div class="info">
                <label>Email:</label>
                <span class="value">{{ $contactData['email'] or '' }}</span>
            </div>
            <div class="info">
                <label>Notes:</label>
                <span class="value">{{ $contactData['notes'] or '' }}</span>
            </div>

            @if (!empty($corporate))
                <a href="/manage/view_fcontact{{ !empty($ed) ? '/' . $ed : '' }}" style="margin-right:10px;float:right;">View Full</a>
            @else
                <a href="/manage/contact/add{{ !empty($ed) ? '/' . $ed : '' }}" style="margin-right:10px;float:right;">Edit</a>
            @endif
        </div>
    </body>
</html>
