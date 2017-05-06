<template>
    <div>
        <span class="admin_head">
            Ledger Card
        </span><br><br>
        <template v-if="patient.hasOwnProperty('patientid') && patient.patientid > 0">
            <span
                v-if=""
                style="clear:both; margin-left: 10px"
            >
                <a
                    v-if="!showPatientSummary"
                    v-on:click.prevent="showPatientSummary = true"
                    href="#"
                >Show Patient Summary</a>
                <a
                    v-else
                    v-on:click.prevent="showPatientSummary = false"
                    href="#"
                >Hide Patient Summary</a>
            </span>
            <br>
            <div
                v-show="showPatientSummary"
                style="margin: 10px"
            >
                <span>{{ patient.name }}</span><br>
                <span>{{ patient.add1 }}</span><br>
                <span>{{ patient.add2 }}</span><br>
                <span>{{ patient.city }} {{ patient.state }} {{ patient.zip }}</span><br>
                <span>D: {{ patient.work_phone }} H: {{ patient.home_phone }}</span><br>
                <span>W1: {{ patient.cell_phone }}</span>
            </div>
        </template>
        <div align="right" style="margin-right: 10px">
            <button
                v-if="routeParameters.openclaims == 1"
                onclick="Javascript: window.location='manage_ledger.php?<?php echo 'pid='.$_GET['pid'];?>';"
                class="addButton control-buttons"
            >View All</button>
            <button
                v-else
                onclick="Javascript: window.location='manage_ledger.php?openclaims=1&<?php echo 'pid='.$_GET['pid'];?>';"
                class="addButton control-buttons"
            >Claims Outstanding</button>
            <button
                onclick="Javascript: window.open('print_ledger_report.php?<?php echo (isset($_GET['pid']))?'pid='.$_GET['pid']:'';?>')"
                class="addButton control-buttons"
            >Print Ledger</button>
            <button
                onclick="Javascript: loadPopup('add_ledger_entry.php?pid=<?php echo $_GET['pid'];?>');"
                class="addButton control-buttons"
            >Add New Transaction</button>
            <button
                onclick="Javascript: window.location='manage_ledger.php?pid=<?php echo $_GET['pid'];?>&inspay=1'"
                class="addButton control-buttons"
            >Add Ins. Payment</button>
            <button
                onclick="Javascript: loadPopup('add_ledger_note.php?pid=<?php echo $_GET['pid'];?>');"
                class="addButton control-buttons"
            >Add Note</button>
            <button
                onclick="Javascript: window.open('ledger_statement.php?pid=<?php echo $_GET['pid'];?>')"
                class="addButton"
            >Create Statement</button>
        </div>
        <br />
        <div v-if="message" align="center" class="red">
            <b>{{ message }}</b>
        </div>
        <form name="edit_mult_form" id="edit_mult_form">
            <table  class="ledger" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
                <tr
                    v-if="ledgerRowsTotalNumber > ledgerRowsPerPage"
                    bgColor="#ffffff"
                    align="center"
                    width="98%"
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
                    <td valign="top" class="col_head" colspan="11" align="center">
                        No Records
                    </td>
                </tr>
                <template
                    v-else
                    v-for="row in ledgerRows"
                >
                    <tr
                        :class="'tr_active ' + getLedgerRowStatus(row)"
                    >
                        <td valign="top">
                            {{ row.service_date | moment("MM-DD-YYYY") }}
                        </td>
                        <td valign="top">
                            {{ row.entry_date | moment("MM-DD-YYYY") }}
                        </td>
                        <td valign="top">
                            {{ row.name }}
                        </td>
                        <td valign="top">
                            {{ getDescription(row) }}
                        </td>
                        <td valign="top" align="right">
                            {{ row.ledger != 'claim' && row.amount != 0 ? formatLedger(row.amount) : '' }}
                        </td>
                        <td valign="top" align="right">
                            {{ row.ledger != 'claim' && row.paid_amount != 0 ? formatLedger(row.paid_amount) : '' }}
                        </td>
                        <td></td>
                        <td valign="top" align="right">
                            {{ formatLedger(row.balance) }}
                        </td>
                        <td valign="top">
                            {{ getStatus(row) }}
                        </td>
                        <td valign="top">
                            <a
                                v-if="row.ledger === 'ledger' || row.ledger === 'ledger_payment'"
                                v-on:click="showHistory(row)"
                                href="#"
                            >View</a>
                        </td>
                        <td valign="top">
                            <a
                                href="#"
                            >Edit</a>
                            <a
                                v-if="true"
                                href="#"
                            >Pay</a>
                        </td>
                    </tr>
                    <template
                        v-if="ledgerHistories.hasOwnProperty(row.ledgerid) && ledgerHistories[row.ledgerid].length"
                        v-show="row.show_history"
                    >
                        <tr>
                            <td>Updated At</td>
                            <td>Service Date</td>
                            <td>Producer</td>
                            <td>Description</td>
                            <td>Charges</td>
                            <td>Credits</td>
                            <td>Update By</td>
                        </tr>
                        <tr v-for="history in ledgerHistories[row.ledgerid]">
                            <td>{{ history.updated_at }}</td>
                            <td>{{ history.service_date }}</td>
                            <td>{{ history.name }}</td>
                            <td>{{ history.description }}</td>
                            <td>{{ history.amount }}</td>
                            <td>{{ history.paid_amount }}</td>
                            <td>
                                {{ history.updated_admin
                                    ? history.updated_admin
                                    : (history.updated_user
                                        ? history.updated_user
                                        : ''
                                    ) }}
                            </td>
                        </tr>
                    </template>
                </template>
                <tr class="tr_bg_h" style="color:#fff; font-weight: bold">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="color:#fff;" >Totals</td>
                    <td style="color:#fff;">Charges</td>
                    <td style="color:#fff;">Credits</td>
                    <td style="color:#fff;">Adjustments</td>
                    <td style="color:#fff;">Balance</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="tr_bg_h" style="color:#fff; font-weight: bold">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="color:#fff;">{{ formatLedger(totalCharges) }}</td>
                    <td style="color:#fff;">{{ formatLedger(totalCredits) }}</td>
                    <td style="color:#fff;">{{ formatLedger(totalAdjustments) }}</td>
                    <td
                        v-if="true"
                        style="color:#fff;"
                    >{{ formatLedger(originalBalance) }}</td>
                    <td
                        v-else
                        style="color:#fff;"
                    >{{ formatLedger(currentBalance) }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="8">
                        <center>
                            <button
                                class="addButton"
                                onclick="Javascript: loadPopup('view_ledger_record.php?pid=<?php echo $_GET['pid']; ?>');return false;"
                            >View Ledger Records</button>
                        </center>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</template>

<script src="./ledger.js"></script>

<style src="../../../assets/css/manage/admin.css" scoped></style>
<style src="../../../assets/css/manage/manage.css" scoped></style>
<style src="../../../assets/css/manage/ledger.css" scoped></style>
