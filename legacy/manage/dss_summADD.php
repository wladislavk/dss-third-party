<?php
namespace Ds3\Libraries\Legacy;
?>
<!--key reference table-->
<div style="float: left; width: 210px; margin-right: 10px; padding: 0; border: 0;">
    <table style="width: 100%;" class="followup-keytable" cellpadding="0">
        <tr style="background: #444;">
            <td colspan="4"><span style="color: #fff;">@Del / Follow Up ID / New</span></td>
        </tr>
        <tr>
            <td style="background: #F9FFDF;"><strong>Date</strong></td>
        </tr>
        <tr>
            <td style="background: #E4FFCF;"><strong>Dev</strong> - Device</td>
        </tr>
        <tr>
            <td style="background: #F9FFDF;"><strong>Set</strong> - Device Setting</td>
        </tr>
        <tr>
            <td style="background: #F9FFDF;"><strong>N/W</strong> - Nights Worn per Week</td>
        </tr>
        <tr>
            <td style="background: #E4FFCF;"><strong>ESS</strong> - Epworth Sleepiness Scale</td>
        </tr>
        <tr>
            <td style="background: #F9FFDF;"><strong>TSS</strong> - Thornton Snoring Scale</td>
        </tr>
        <tr>
            <td style="background: #E4FFCF;"><strong>S</strong> - Snoring Level (1-10)</td>
        </tr>
        <tr>
            <td style="background: #E4FFCF;"><strong>E</strong> - Energy Level</td>
        </tr>
        <tr>
            <td style="background: #F9FFDF;"><strong>SQ</strong> - Sleep Quality</td>
        </tr>
        <tr>
            <td style="background: #E4FFCF;"><strong>H/W</strong> - How often do you wake up with morning headaches?</td>
        </tr>
        <tr>
            <td style="background: #F9FFDF;"><strong>A/W</strong> - Awakenings per Night</td>
        </tr>
        <tr>
            <td style="background: #E4FFCF;"><strong>WA</strong> - Witnessed Apnea per Night</td>
        </tr>
        <tr>
            <td style="background: #F9FFDF;"><strong>H/N</strong> - Hours of Sleep per Night</td>
        </tr>
        <tr>
            <td style="background: #E4FFCF;"><strong>Other</strong></td>
        </tr>
        <tr>
            <td style="background: #F9FFDF;"><input id="new_followup_but" type="button" onclick="show_new_followup(); return false;" value="+Add New Followup" style="width:140px;"/></td>
        </tr>
    </table>
</div>

<div style=" width:577px;border: medium none;float: left;height: 570px;margin-bottom: 20px;margin-top: 2px; overflow-x:scroll;">
    <?php include 'dss_followups.php'; ?>
</div>
