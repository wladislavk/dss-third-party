<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>{!! env('APP_NAME') !!}</title>
        {!! HTML::style('css/manage/login.css') !!}
    </head>

    <body>
        <div id="login_container">
            {!! Form::open(array('url' => 'manage/login', 'method' => 'post')) !!}
                <table border="0" cellpadding="3" cellspacing="1" width="40%">
                    <tr class="row">
                        <td colspan="2" class="t_head">
                           Please Enter Your Login Information 
                        </td>
                    </tr>

                    @if (!empty($msg))
                        <tr class="row">
                            <td colspan="2" >
                                <span class="red">
                                    {{ $msg }}
                                </span>
                            </td>
                        </tr>
                    @endif

                    @if (!empty($errors->has()))
                        <tr class="row">
                            <td colspan="2" >
                                <span class="red">
                                    Wrong username or password
                                </span>
                            </td>
                        </tr>
                    @endif

                    <tr class="row">
                        <td class="t_data">
                            User name
                        </td>
                        <td class="t_data">
                            @if (empty($username))
                                {!! Form::text('username', null, array('autofocus')) !!}
                            @else
                                {!! Form::text('username', $username, array('autofocus')) !!}
                            @endif
                        </td>
                    </tr>
                    <tr class="row">
                        <td class="t_data">
                            Password
                        </td>
                        <td class="t_data">
                            {!! Form::password('password') !!}
                        </td>
                    </tr>
                    <tr class="row">
                        <td colspan="2" align="center" >
                            {!! Form::submit(' Login ', array('name' => 'btnsubmit', 'class' => 'addButton')) !!}
                        <span style="float:right;">
                            {!! HTML::link('register/new.php', 'Register') !!}
                        |
                            {!! HTML::link('forgot_password.php', 'Forgot Password') !!}
                        </span>
                        </td>
                    </tr>
                </table>
                <span style="float:right; margin-top:4px;" class="screener">Looking for the screener? {!! HTML::link('../screener', 'Click Here') !!}</span>
            {!! Form::close() !!}
        </div>
        <span style="clear:both;" id="siteseal">
            {!! HTML::script('https://seal.godaddy.com/getSeal?sealID=3b7qIyHRrOjVQ3mCq2GohOZtQjzgc1JF4ccCXdR6VzEhui2863QRhf') !!}<br />
            {!! HTML::link('http://www.godaddy.com/ssl/ssl-certificates.aspx', 'secure website', array('id' => 'link_secure')) !!}
        </span>
        <div style="clear:both;"></div>
    </body>
</html>