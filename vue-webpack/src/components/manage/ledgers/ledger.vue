<template>
    <div>
        <span class="admin_head">
            Ledger Card
        </span>
        <div>
            <span>{{ patient.name }}</span>
            <span>{{ patient.add1 }}</span>
            <span>{{ patient.add2 }}</span>
            <span>{{ patient.city }} {{ patient.state }} {{ patient.zip }}</span>
            <span>D: {{ patient.work_phone }} H: {{ patient.home_phone }}</span>
            <span>W1: {{ patient.cell_phone }}</span>
        </div>
        <div align="right">
            <button
                v-if="routeParameters.openclaims == 1"
                onclick="Javascript: window.location='manage_ledger.php?<?php echo 'pid='.$_GET['pid'];?>';"
                class="addButton"
            >View All</button>
            <button
                v-else
                onclick="Javascript: window.location='manage_ledger.php?openclaims=1&<?php echo 'pid='.$_GET['pid'];?>';"
                class="addButton"
            >Claims Outstanding</button>
            <button
                onclick="Javascript: window.open('print_ledger_report.php?<?php echo (isset($_GET['pid']))?'pid='.$_GET['pid']:'';?>')"
                class="addButton"
            >Print Ledger</button>
            <button
                onclick="Javascript: loadPopup('add_ledger_entry.php?pid=<?php echo $_GET['pid'];?>');"
                class="addButton"
            >Add New Transaction</button>
            <button
                onclick="Javascript: window.location='manage_ledger.php?pid=<?php echo $_GET['pid'];?>&inspay=1'"
                class="addButton"
            >Add Ins. Payment</button>
            <button
                onclick="Javascript: loadPopup('add_ledger_note.php?pid=<?php echo $_GET['pid'];?>');"
                class="addButton"
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
                    <td valign="top" class="col_head" colspan="10" align="center">
                        No Records
                    </td>
                </tr>
                <tr
                    v-else
                    v-for="row in ledgerRows"
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
                    <td>
                        
                    </td>
                    <td valign="top" align="right">
                    </td>
                    <td></td>
                    <td valign="top" align="right">
                    </td>
                    <td valign="top">
                    </td>
                    <td valign="top">
                    </td>
                    <td valign="top">
                    </td>
                </tr>
                <tr class="history_<?php echo $myarray['ledgerid']; ?>" style="display:none;">
                    <td>Updated At</td>
                    <td>Service Date</td>
                    <td>Producer</td>
                    <td>Description</td>
                    <td>Charges</td>
                    <td>Credits</td>
                    <td>Update By</td>
                </tr>  
                <tr class="history_<?php echo $myarray['ledgerid']; ?>" style="display:none;">
                    <td><?php echo $h_r['updated_at']; ?></td>
                    <td><?php echo $h_r['service_date']; ?></td>
                    <td><?php echo $h_r['name']; ?></td>
                    <td><?php echo $h_r['description']; ?></td>
                    <td><?php echo $h_r['amount']; ?></td>
                    <td><?php echo $h_r['paid_amount']; ?></td>
                    <td><?php if($h_r['updated_admin']!=''){
                            echo $h_r['updated_admin'];
                            }elseif($h_r['updated_user']!=''){
                            echo $h_r['updated_user'];
                            } ?>
                    </td>
                </tr>
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
                    <td style="color:#fff;"><?php echo (!empty($cur_cha) ? $cur_cha : '') ? number_format(st($cur_cha),2) : '0'; ?></td>
                    <td style="color:#fff;"><?php echo (!empty($cur_pay) ? $cur_pay : '') ? number_format(st($cur_pay),2) : '0'; ?></td>
                    <td style="color:#fff;"><?php echo (!empty($cur_adj) ? $cur_adj : '') ? number_format(st($cur_adj),2) : '0'; ?></td>
                    <td style="color:#fff;"><?php echo (!empty($orig_bal) ? $orig_bal : '') ? number_format(st($orig_bal),2) : '0'; ?></td>
                    <td style="color:#fff;"><?php echo (!empty($cur_bal) ? $cur_bal : '') ? number_format(st($cur_bal),2) : '0'; ?></td>
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
