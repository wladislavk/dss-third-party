@extends('layouts.admin.login')
@section('content')
<div class="logo">
		<h1  style="color:#ffffff;font-size:30px; margin:9px;">Dental Sleep <span style="color:#187eb7;">Solutions</span></h1>
	</div>
	<!-- END LOGO -->

	<div class="content">
		<!-- BEGIN LOGIN FORM -->

                          {{--@if(Session::has('errors'))--}}
                            {{--{{ dd(Session::has('errors')) }}--}}
                                    {{--<div style="color:red">--}}
                                        {{--<p>The following errors have occurred:</p>--}}

                                        {{--<ul >--}}
                                            {{--@foreach($errors->all() as $error)--}}
                                                {{--<li>{{ $error }}</li>--}}
                                            {{--@endforeach--}}
                                        {{--</ul>--}}
                                    {{--</div><!-- end form-errors -->--}}
                            {{--@endif--}}

		<form name="loginfrm" method="post" action="/manage/admin/login" onsubmit="return loginabc(this)" class="login-form form-horizontal">

			<h3 class="form-title">Login to your DS3 account</h3>
			<div class="form-group">
				<div class="input-icon">
					<i class="fa fa-user"></i>
					<input type="text" name="username" placeholder="Username" autocomplete="off" id="username" class="form-control placeholder-no-fix">
				</div>
			</div>
			<div class="form-group">
				<div class="input-icon">
					<i class="fa fa-lock"></i>
					<input type="password" name="password" placeholder="Password" id="password" autocomplete="off" class="form-control placeholder-no-fix">
				</div>
			</div>
			{{--<div class="form-group">--}}
				{{--<div class="input-icon">--}}
					{{--<img src="../CaptchaSecurityImages.php?width=100&amp;height=40&amp;characters=5" style="margin-bottom:5px;" width="100" height="40" alt="If you cannot see the captcha, reload the page please">--}}
				{{--</div>--}}
			{{--</div>--}}
			{{--<div class="form-group">--}}
				{{--<div class="input-icon">--}}
					{{--<i class="fa fa-user"></i>--}}
					{{--<input type="text" class="form-control" name="security_code" id="captcha"  placeholder="write the characters in the image">--}}
				{{--</div>--}}
			{{--</div>--}}
			<div class="form-actions" style="margin-left:-35px;">
				<input type="hidden" name="loginsub" value="1" />
				<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
				<button type="submit" class="btn blue pull-right" name="loginbut" >Login
				<i class="m-icon-swapright m-icon-white"></i>
			</div>
			<div class="forget-password">
				<h4>Forgot your password ?</h4>
				<p>no worries, click <a id="forget-password" href="javascript:;">here</a>
				 to reset your password.
				</p>
			</div>
		</form>
		<form class="forget-form" action="index.php" method="post">
			<h3>Forget Password ?</h3>
			<p>Enter your e-mail address below to reset your password.</p>
			<div class="form-group">
				<div class="input-icon">
					<i class="fa fa-envelope"></i>
					<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email"/>
					<input type="hidden" name="emailsub" value="1" />
				</div>
			</div>
			<div class="form-actions">
				<button type="button" id="back-btn" class="btn">
				<i class="m-icon-swapleft"></i> Back </button>
				<button type="submit" class="btn blue pull-right">
				Submit <i class="m-icon-swapright m-icon-white"></i>
				</button>
			</div>
		</form>
	</div>

	<!-- END LOGIN FORM -->

@stop
@stop