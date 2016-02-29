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
                <h2>Your New Account</h2>
                <p>A new patient account has been created for you by {{mailing_practice}}.<br />
                    Your Patient Portal login information is:</p>
                <p><b>Email:</b> {{email}}</p>
            </td>
            <td>
                <img alt="Logo" src="{{baseUrl}}/{{logo}}" />
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <center>
                    <h2>Save Time - Complete Your Paperwork Online</h2>
                </center>
                <p>
                    Click the link below to log in and complete your patient forms online.
                    Paperless forms take only a few minutes to complete and let you avoid unnecessary waiting during your next visit.
                    Saving trees is good too!
                </p>
                <center>
                    <h3>
                        <a href="{-link-}">
                            Click Here to Complete Your Forms Online
                        </a>
                    </h3>
                </center>
            </td>
        </tr>
        <tr>
            <td>
                {-legend-}
                <p>
                    {{mailing_practice}}<br />
                    {{mailing_address}}<br />
                    {{mailing_city}} {{mailing_state}} {{mailing_zip}}<br />
                    {{mailing_phone}}
                </p>
                <h3>Need Assistance?</h3>
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
    This email was sent by Dental Sleep Solutions&reg; on behalf of {{mailing_practice}}.
    {-footer-}
</span>