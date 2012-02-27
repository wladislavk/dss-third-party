



  <div class="login_content" id="first2_sect" style="display:none;">
     <h3>Enter your access code</h3>
     <p>We sent a text message to your phone number ending in -<span id="access_phone"></span>.  Please enter the code we sent you.</p>
     <p id="first2_error" class="error"></p>
     <div class="field">
       <label>Email Address</label>
       <input type="text" readonly="readonly" id="code_email" />
     </div>
     <div class="field">
       <label>Access Code</label>
       <input type="text" id="code" name="code" />
     </div>
     <div class="field">
       <label>New Password <span style="font-size:12px">(minimum 8 characters)</span></label>
       <input type="password" onkeyup="checkPass()" id="password1" name="password1" />
     </div>
     <div class="field">
       <label>Re-type Password</label>
       <input type="password" onkeyup="checkPass()" id="password2" name="password2" />
     </div>
     <div class="field">
       <button onclick="createPassword()">Create</button>
     </div>
     <a href="javascript:showSect('login');">&laquo; Return to Login Screen</a>
  </div>

