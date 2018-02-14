<template>
    <form name="flowsheet_other_reason">
        <table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
            <tr>
                <td class="cat_head">Reason for {{ segmentType }}</td>
            </tr>
            <tr>
                <td valign="top" class="frmhead">
                    <textarea name="reason" id="reason" class="field text reason tbox" style="width:680px;" tabindex="1">{{ description }}</textarea>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <input type="submit" value="Submit Reason" class="button" v-on:click.prevent="submitForm()" />
                </td>
            </tr>
        </table>
    </form>
</template>

<script src="./FlowsheetReason.js"></script>
