<center>
    <table width="600">
        <colgroup>
            <col width="400" />
            <col width="200" />
        </colgroup>
        <tr>
            <td colspan="2">
                <img alt="A message from your healthcare provider"
                     src="{{baseUrl}}/reg/images/email/email_header_fo.png" />
            </td>
        </tr>
        <tr>
            <td>
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
                <center>
                    <img alt="{{mailing_practice}} Logo" src="{{baseUrl}}/{{logo}}" />
                </center>
            </td>
        </tr>
        <tr>
            <td colspan="2">
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
                <img alt="Powered by Dental Sleep Solutions&reg;"
                     src="{{baseUrl}}/reg/images/email/email_footer_fo.png" />
            </td>
        </tr>
    </table>
</center>
<span style="font-size:12px;">
    This email was sent by Dental Sleep Solutions&reg; on behalf of {{mailing_practice}}
    <i>Dental Sleep Solutions will never ask you for passwords or payment information via email.</i>
    The contents of this message, together with any attachments, are intended only for the use of the individual or entity to which they are addressed and may contain information that is legally privileged, confidential and exempt from disclosure.
    If you are not the intended recipient, you are hereby notified that any dissemination, distribution or copying of this message, or any attachment, is strictly prohibited.
    If you have received this message in error, please notify the original sender or contact Dental Sleep Solutions immediately by telephone (941-757-4642) or by responding to this email and delete this message, along with any attachments, from your computer.
</span>