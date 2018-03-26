@extends('layouts.login')


@section('body')
        <div class="form-box" id="login-box">

            

                <form action="/auth/sign-in" method="post">

                    <div class="header">Sign In</div>
                    
                    <div class="body bg-gray">

                    
                        @if($errors->has())
                            <div style="color:red">
                                <p>The following errors have occurred:</p>
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div><!-- end form-errors -->
                           @endif

                        

                        <div class="form-group">                            
                            <input type="text" id="email" name="email" value="" placeholder="Email" class="login username-field form-control" />
                        </div> <!-- /field -->

                        <div class="form-group">
                            
                            <input type="password" id="password" name="password" value="" placeholder="Password" class="login password-field form-control"/>
                        </div> <!-- /password -->

                    

                    <div class="form-group">

                        
                            <input id="rememberme" name="rememberme" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" />
                            Keep me signed in
                        
                        
                        </div> <!-- .actions -->
                        </div>
                        
                        
                        <div class="footer">

                        <button class="btn bg-olive btn-block">Sign In</button>

                    <p>
            <a href="#">Reset Password</a>
        </p>
             <a href="sign-up" class="text-center">Register a new membership</a>       
                 
                   

                  </div>

                </form>
                
                
                <div class="margin text-center">
<span>Sign in using social networks</span>
<br>
<button class="btn bg-light-blue btn-circle"><i class="fa fa-facebook"></i></button>
<button class="btn bg-aqua btn-circle"><i class="fa fa-twitter"></i></button>
<button class="btn bg-red btn-circle"><i class="fa fa-google-plus"></i></button>
</div>

        

        </div> <!-- /account-container -->

        
@stop

<!--@section('footer')
    <script src="/js/signin.js"></script>
@stop-->


