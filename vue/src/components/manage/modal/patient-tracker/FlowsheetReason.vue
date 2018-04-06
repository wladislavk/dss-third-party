<template>
    <form name="flowsheet_other_reason">
        <br />
        <br />
        <table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
            <tr>
                <td class="cat_head">Reason for {{ segmentType }}</td>
            </tr>
            <tr>
                <td valign="top" class="frmhead">
                    <textarea
                        name="reason"
                        id="reason"
                        class="field text reason tbox"
                        tabindex="1"
                        v-bind:value="description"
                        v-on:change="changeDescription($event)"
                    ></textarea>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <input type="submit" value="Submit Reason" class="button addButton" v-on:click.prevent="submitForm()" />
                </td>
            </tr>
        </table>
    </form>
</template>

<script src="./FlowsheetReason.js"></script>

<style lang="scss" scoped>
    @import "../../../../assets/css/manage/modal/patient-tracker/reason.scss";
</style>
