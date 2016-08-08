<style src="../../../../assets/css/manage/admin.css" scoped></style>
<style src="../../../../assets/css/manage/manage_patient.css" scoped></style>

<template>
    <div id="patients">
        <div style="clear: both">
            <span class="admin_head">
                Manage Patient {{ patientInfo }}
                -
                <select
                    v-model="selectedPatientType"
                    v-on:change="onChangePatientTypeSelect"
                    name="show"
                >
                    <option v-for="option in patientTypeSelect" v-bind:value="option.value">
                        {{ option.text }}
                    </option>
                </select>
            </span>
            <div class="letter_select">
                <a
                    v-for="letter in letters"
                    v-bind:class="{ 'selected_letter': letter == $route.query.letter }"
                    v-link="{ name: $route.name, query: { letter: letter, sh: $route.query.sh }}"
                    class="letters"
                >{{ letter }}</a>

                <a
                    v-if="$route.query.letter"
                    v-link="{ name: $route.name, query: { sh: $route.query.sh }}"
                >View All</a>
            </div>
            </br>
            <div v-if="message" align="center" class="red">
                <b>{{ message }}</b>
            </div>
        </div>
        <form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post" style="clear: both">
            <table id="patients" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
                <tr v-if="patientsTotalCount > patientsPerPage" bgColor="#ffffff">
                    <td  align="right" colspan="15" class="bp">
                        Pages:
                        <span v-for="index in totalPages">
                            <strong v-if="currentPageNumber == index"></strong>
                            <a
                                v-else
                                v-link="{
                                    name: $route.name,
                                    query: {
                                        page    : index,
                                        letter  : $route.query.letter,
                                        sort    : sortColumn,
                                        sortdir : sortDirection,
                                        sh      : $route.query.sh
                                    }
                                }"
                                class="fp"
                            >{{ index + 1 }}</a>
                        </span>
                    </td>
                </tr>
                <tr class="tr_bg_h">
                    <td
                        v-for="(sort, label) in tableHeaders"
                        class="col_head  {{ sortColumn == sort ? arrow_ + sortDirection : '' }}"
                        valign="top"
                        width="10%"
                    >
                        <a
                            v-link="{
                                name: $route.name,
                                query: {
                                    pid: patientId,
                                    letter: $route.query.letter,
                                    sh: $route.query.sh,
                                    sort: sort,
                                    sortDir: currentDirection
                                }
                            }"
                        >{{ label }}</a>
                    </td>
                </tr>
                <tr class="template" style="display:none;">
                    <td class="patient_name">John Smith</td>
                    <td class="flowsheet">No</td>
                    <td class="next_visit">(4 days)</td>
                    <td class="last_visit">1 yr 2 mo</td>
                    <td class="last_treatment">Consult</td>
                    <td class="appliance">TAP 3</td>
                    <td class="appliance_since">63 days</td>
                    <td class="vob">Complete</td>
                    <td class="rxlomn">N/A</td>
                    <td class="ledger">($435.75)</td>
                </tr>
                <tr v-if="!patients.length" class="tr_bg">
                    <td valign="top" class="col_head" colspan="10" align="center">
                        No Records
                    </td>
                </tr>
                <tr
                    v-else
                    v-for="patient in patients"
                    class="{{ patient.status == 1 ? 'tr_active' : 'tr_inactive' }} initial_list"
                >
                    <td valign="top">
                        <a
                            v-link="{
                                path: '/manage/add-patient',
                                query: {
                                    pid: patient.patientid,
                                    ed: patient.patientid
                                }
                            }"
                        >
                            {{ patient.lastname }},&nbsp;
                            {{ patient.firstname }},&nbsp;
                            {{ patient.middlename }}
                        </a>
                        <span v-if="patient.premedcheck == 1 || patient.allergenscheck == 1">
                            &nbsp;&nbsp;&nbsp;<span style="font-weight:bold; color:#ff0000;">*Med</span>
                        </span>
                    </td>
                    <td v-if="patient.patient_info != 1" colspan="9" align="center" class="pat_incomplete">-- Patient Incomplete --</td>
                    <td v-else valign="top">
                                $ins_error = !$myarray['insurance_no_error'];
                                $study_error = $myarray['numsleepstudy'] == 0;
                        <a
                            v-link="{
                                path: 'flowsheet3',
                                query: {
                                    pid: patient.patientId
                                }
                            }"
                        >
                            <span v-if="!!patient.insurance_no_error && !(patient.numsleepstudy == 0)">Yes</span>
                            <span v-else class="red">No</span>
                        </a>
                    </td>
                    <td valign="top">
                        <a
                            v-link="{
                                path: 'flowsheet3',
                                query: {
                                    pid: patient.patientId
                                }
                            }"
                        >{{ patient.date_scheduled }}</a>
                    </td>
                    <td valign="top">
                        <a
                            v-link="{
                                path: 'flowsheet3',
                                query: {
                                    pid: patient.patientId
                                }
                            }"
                        >{{ patient.date_completed }}</a>
                    </td>
                    <td valign="top">
                        <a
                            v-link="{
                                path: 'flowsheet3',
                                query: {
                                    pid: patient.patientId
                                }
                            }"
                        >{{ !patient.segmentid ? 'N/A' : segments[patient.segmentid] }}</a>
                    </td>
                    <td valign="top">
                        <a
                            v-link="{
                                path: 'dss_summ',
                                query: {
                                    pid: patient.patientId
                                }
                            }"
                        >{{ patient.device }}</a>
                    </td>
                    <td valign="top">
                        <a
                            v-link="{
                                path: 'flowsheet3',
                                query: {
                                    pid: patient.patientId
                                }
                            }"
                        >{{ patient.dentaldevice_date }}</a>
                    </td>
                    <td valign="top">
                        <a
                            v-link="{
                                path: 'insurance',
                                query: {
                                    pid: patient.patientId
                                }
                            }"
                        >
                            <span v-if="patient.vob == null">No</span>
                            <span v-if="patient.vob == 1">Yes</span>
                            <span v-else="">{{ window.constants.dssPreauthStatusLabels[patient.vob] }}</span>
                        </a>
                    </td>
                    <td valign="top">
                        <a
                            v-link="{
                                path: 'insurance',
                                query: {
                                    pid: patient.patientId
                                }
                            }"
                        >
                            {{
                                switch (patient.rx_lomn) {
                                    case 3:
                                        'Yes';
                                        break;
                                    case 2:
                                        'Yes/No';
                                        break;
                                    case 1:
                                        'No/Yes';
                                        break;
                                    default:
                                        'No';
                                        break;
                                }
                            }}
                        </a>
                    </td>
                    <td valign="top">
                        <a
                            v-link="{
                                path: 'ledger',
                                query: {
                                    pid: patient.patientId
                                }
                            }"
                        >
                            <span v-if="patient.ledger == null">'N/A'</span>
                            <span v-else>format_ledger(number_format(patient.total, 2))</span>
                        </a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</template>

<script>
    module.exports = require('./patients.js');
</script>