<template>
    <div>
        <span class="admin_head">
            Today's Ledger Report
            <template v-if="patientId > 0">
                (<i>{{ name }}</i>)
            </template>
            <template v-if="true">
                (<i>{{ currentDate | moment("MM/DD/YYYY") }}</i>)
            </template>
        </span>
        <br>
        <div align="right" style="margin-right: 15px">
            <router-link
                :to="{ path: 'report-claim-aging' }"
                class="addButton"
                title="This report can take several minutes to generate"
            >Claim Aging</router-link>
            <router-link
                :to="{
                    path: 'print_ledger_reportfull',
                    query: {
                        dailysub: 0,
                        monthlysub: 0,
                        d_mm: '',
                        d_dd: '',
                        d_yy: '',
                        pid: 0
                    }
                }"
                target="_blank"
                class="addButton"
            >Print Ledger</router-link>
            <router-link
                :to="{ path: 'ledger' }"
                class="addButton"
            >Other Reports</router-link>
            <router-link
                :to="{ path: 'unpaid_patient' }"
                class="addButton"
            >Unpaid Pt.</router-link>
        </div>
        <br />
        <div v-if="message" align="center" class="red">
            <b>{{ message }}</b>
        </div>
        <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
            <tr
                v-if="ledgerRowsTotalNumber > ledgerRowsPerPage"
                bgColor="#ffffff"
                align="center"
                width="98%"
                cellpadding="5"
                cellspacing="1"
            >
                <td align="right" colspan="15" class="bp">
                    Pages:
                    <span v-for="index in totalPages" class="page_numbers">
                        <strong v-if="routeParameters.currentPageNumber == (index - 1)">{{ index }}</strong>
                        <router-link
                            v-else
                            :to="{
                                name: $route.name,
                                query: {
                                    page    : index - 1,
                                    sort    : routeParameters.sortColumn,
                                    sortdir : routeParameters.sortDirection
                                }
                            }"
                            class="fp"
                        >{{ index }}</router-link>
                    </span>
                </td>
            </tr>
            <tr class="tr_bg_h">
                <td
                    v-for="(settings, sort) in tableHeaders"
                    :class="'col_head ' + (routeParameters.sortColumn == sort ? 'arrow_' + routeParameters.sortDirection : '')"
                    valign="top"
                    :width="settings.width + '%'"
                >
                    <router-link
                        v-if="settings.with_link"
                        :to="{
                            name: $route.name,
                            query: {
                                sort: sort,
                                sortdir: getCurrentDirection(sort)
                            }
                        }"
                    >{{ settings.title }}</router-link>
                    <template v-else>{{ settings.title }}</template>
                </td>
            </tr>
            <tr v-if="ledgerRows.length == 0" class="tr_bg">
                <td valign="top" class="col_head" colspan="10" align="center">
                    No Records
                </td>
            </tr>
            <tr
                v-else
                v-for="row in ledgerRows"
                :class="/*row.status == 1 ? 'tr_active' : 'tr_inactive'*/'tr_active'"
            >
                <td valign="top" width="10%">
                    {{ row.service_date | moment("MM-DD-YYYY") }}
                </td>
                <td valign="top" width="10%">
                    {{ row.entry_date | moment("MM-DD-YYYY") }}
                </td>
                <td valign="top" width="10%">
                    <router-link
                        :to="{
                            path: 'manage_ledger',
                            query: {
                               pid: row.patientid
                            }
                        }"
                    >{{ getPatientFullName(row.patient_info) }}</router-link>
                </td>
                <td valign="top" width="10%">
                    {{ row.name }}
                </td>
                <td valign="top" width="25%" v-html="getDescription(row)"></td>
                <td valign="top" align="right" width="10%">
                    {{ row.ledger === 'ledger' && row.amount > 0 ? formatLedger(row.amount) : '' }}
                </td>
                <td valign="top" align="right" width="10%">
                    {{ row.paid_amount > 0 && isCredit(row) ? formatLedger(row.paid_amount) : '' }}
                </td>
                <td valign="top" align="right" width="10%">
                    {{ row.paid_amount > 0 && isAdjustment(row) ? formatLedger(row.paid_amount) : '' }}
                </td>
                <td valign="top" width="5%">
                    {{ row.status == 1 ? 'Sent' : (row.status == 2 ? 'Filed' : 'Pend') }}
                </td>
            </tr>
            <tr>
                <td valign="top" colspan="5" align="right">
                    <b>Page Totals</b>
                </td>
                <td valign="top" align="right">
                    <b>{{ formatLedger(totalPageCharges) }}</b>
                </td>
                <td valign="top" align="right">
                    <b>{{ formatLedger(totalPageCredits) }}</b>
                </td>
                <td valign="top" align="right">
                    <b>{{ formatLedger(totalPageAdjustments) }}</b>
                </td>
                <td valign="top"></td>
            </tr>
            <tr>
                <td valign="top" colspan="5" align="right">
                    <b>Page Balance</b>
                </td>
                <td align="right">
                    <b>
                        {{ formatLedger(totalPageCharges - totalPageCredits - totalPageAdjustments) }}
                    </b>
                </td>
                <td colspan="2">
                </td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td colspan="5"><hr style="border-top: thin dashed;"></td>
            </tr>
            <tr>
                <td valign="top" colspan="5" align="right">
                    <b>Totals</b>
                </td>
                <td valign="top" align="right">
                    <b>{{ formatLedger(totalCharges) }}</b>
                </td>
                <td valign="top" align="right">
                    <b>{{ formatLedger(totalCredits) }}</b>
                </td>
                <td valign="top" align="right">
                    <b>{{ formatLedger(totalAdjustments) }}</b>
                </td>
                <td valign="top"></td>
            </tr>
            <tr>
                <td valign="top" colspan="5" align="right">
                    <b>Balance</b>
                </td>
                <td align="right">
                    <b>{{ formatLedger(totalCharges - totalCredits - totalAdjustments) }}</b>
                </td>
                <td colspan="2"></td>
            </tr>
        </table>

        <ledger-summary-report-full
            :report-type="reportType"
        ></ledger-summary-report-full>
    </div>
</template>

<script src="./ledgerReportFull.js"></script>

<style src="../../../../assets/css/manage/admin.css" scoped></style>
<style lang="scss" scoped>
    @import "../../../../assets/css/manage/manage.scss";
</style>
