@extends('layouts.pdfBase')

@section('content')
    <p>Welcome {{ $content['firstname'] }} {{ $content['lastname'] }}! Your medical record access is just a few steps away.</p>
    <p>You'll receive an email with instructions for accessing your records online. The email was sent to:</p>
    <p>{{ $content['email'] }}</p>
    <br />
    <p>For your privacy, you'll need to enter the following temporary PIN when you login the first time:<p>
    <p><code>{{ $content['access_code'] }}</code></p>
    <p>We look forward to seeing you at your next visit!</p>
    <p>
        {{ $content['mailing_practice'] }}<br />
        {{ $content['mailing_address'] }}<br />
        {{ $content['mailing_city'] }} {{ $content['mailing_state'] }} {{ $content['mailing_zip'] }}<br />
        {{ $content['mailing_phone'] }}
    </p>
@endsection
