<?php
namespace Ds3\Libraries\Legacy;
?>
<table width="100%" align="center">
    <tr>
        <td style="background:#333; color:#FFFFFF; font-size: 14px; font-weight:bold; height:30px;" colspan="15">
            Subjective Tests:
        </td>
    </tr>
</table>

<style>
    #hideshow2section2 input {
        width:20px;
    }
    .followup-datatable {
        margin: 0;
        padding: 0;
        border: 0;
    }
    .followup-datatable tr {
        height: 25px;
    }
    .followup-datatable tr td {
        padding: 0 4px;
    }
    .followup-keytable {
        margin: 0;
        padding: 0;
        border: 0;
    }
    .followup-keytable tr {
        height: 25px;
    }
    .followup-keytable tr td {
        text-align: right;
        padding-right: 4px;
        font-weight: normal;
    }
</style>
<div id="hideshow2section2" style="width: 100%; margin: 0 auto; display: table;">
    <!--The sumadd script generates divs and tabular data from a db-->
    <?php include("../dss_summADD.php"); ?>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#hideshow2section2 input').change(function(){
            $(this).parents('form:first').find('td').css('background', 'rgb(173, 216, 230)');
            window.onbeforeunload = function(){
                return 'You have made changes to a Test and have not saved your changes. Click OK to leave the page, or Cancel to return and save your changes.';
            };
        });
    });
</script>
