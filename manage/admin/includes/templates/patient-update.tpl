<center>
    <table width="600">
        <tr>
            <td colspan="2">
                <img alt="A message from your healthcare provider"
                     src="{{baseUrl}}/reg/images/email/email_header_fo.png" />
            </td>
        </tr>
        <tr>
            <td width="400">
                <h2>Your Updated Account</h2>
                <p>
                    An update has been made to your account.<br />
                    Please use the updated email address below to login:
                </p>
                <h3>New Email: {{new_email}}</h3>
                <p>
                    <b>Old Email:</b> {{old_email}}
                </p>
            </td>
            <td>
                <img alt="Logo" src="{{baseUrl}}/{{logo}}" />
            </td>
        </tr>
        <tr>
            <td>
                <p>
                    Click the link below to login with your new email address:<br />
                    <a href="{{baseUrl}}/reg/login.php">{{baseUrl}}/reg/login.php</a>
                </p>
                <p>
                    {{mailing_practice}}<br />
                    {{mailing_address}}<br />
                    {{mailing_city}} {{mailing_state}} {{mailing_zip}}<br />
                    {{mailing_phone}}
                </p>
                <h3>Need assistance?</h3>
                <p>
                    <b>Contact us at {{mailing_phone}}</b>
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <img alt="A message from your healthcare provider"
                     src="{{baseUrl}}/reg/images/email/email_footer_fo.png" />
            </td>
        </tr>
    </table>
</center>
<span style="font-size:12px;">
    This email was sent by Dental Sleep Solutions&reg; on behalf of {{mailing_practice}}
    {-footer-}
</span>