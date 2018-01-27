<template>
    <div id="patients">
        <div style="clear: both">
            <span class="admin_head">
                Manage Patient {{ patientInfo }}
                -
                <select
                    v-model="routeParameters.selectedPatientType"
                    v-on:change="onChangePatientTypeSelect"
                    name="show"
                >
                    <option v-for="option in patientTypeSelect" v-bind:value="option.value">
                        {{ option.text }}
                    </option>
                </select>
            </span>
            <div class="letter_select">
                <router-link
                    v-for="letter in letters"
                    :key="letter.id"
                    :class="'letters ' + (letter === routeParameters.currentLetter ? 'selected_letter' : '')"
                    :to="{ name: $route.name, query: { letter: letter, sh: routeParameters.selectedPatientType }}"
                >{{ letter }}</router-link>

                <router-link
                    v-if="routeParameters.currentLetter"
                    :to="{ name: $route.name, query: { sh: routeParameters.selectedPatientType }}"
                >View All</router-link>
            </div>
            <br />
            <div v-if="message" align="center" class="red">
                <b>{{ message }}</b>
            </div>
        </div>
        <form name="sortfrm" style="clear: both">
            <table id="patients" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
                <tr v-if="patientsTotalNumber > patientsPerPage" bgColor="#ffffff">
                    <td  align="right" colspan="15" class="bp">
                        Pages:
                        <span v-for="index in totalPages" class="page_numbers">
                            <strong v-if="routeParameters.currentPageNumber === (index - 1)">{{ index }}</strong>
                            <router-link
                                v-else
                                :to="{
                                    name: $route.name,
                                    query: {
                                        page: index - 1,
                                        letter: routeParameters.currentLetter,
                                        sort: routeParameters.sortColumn,
                                        sortdir: routeParameters.sortDirection,
                                        sh: routeParameters.selectedPatientType
                                    }
                                }"
                                class="fp"
                            >{{ index }}</router-link>
                        </span>
                    </td>
                </tr>
                <tr class="tr_bg_h">
                    <td
                        v-for="(label, sort) in tableHeaders"
                        :class="'col_head ' + (routeParameters.sortColumn === sort ? 'arrow_' + routeParameters.sortDirection : '')"
                        valign="top"
                        width="10%"
                    >
                        <router-link
                            :to="{
                                name: $route.name,
                                query: {
                                    pid: routeParameters.patientId,
                                    letter: routeParameters.currentLetter,
                                    sh: routeParameters.selectedPatientType,
                                    sort: sort,
                                    sortdir: getCurrentDirection(sort)
                                }
                            }"
                        >{{ label }}</router-link>
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
                <tr v-if="patients.length === 0" class="tr_bg">
                    <td valign="top" class="col_head" colspan="10" align="center">
                        No Records
                    </td>
                </tr>
                <tr
                    v-else
                    v-for="patient in patients"
                    :class="(patient.status === 1 ? 'tr_active' : 'tr_inactive') + ' initial_list'"
                >
                    <td valign="top">
                        <router-link
                            :to="{
                                path: '/manage/edit-patient',
                                query: { pid: patient.patientid }
                            }"
                        >
                            {{ patient.lastname }},&nbsp;
                            {{ patient.firstname }}&nbsp;
                            {{ patient.middlename }}
                        </router-link>
                        <span v-if="patient.premedcheck === 1 || patient.allergenscheck === 1">
                            &nbsp;&nbsp;&nbsp;<span style="font-weight:bold; color:#ff0000;">*Med</span>
                        </span>
                    </td>
                    <template v-if="patient.patient_info !== 1">
                        <td colspan="9" align="center" class="pat_incomplete">-- Patient Incomplete --</td>
                    </template>
                    <template v-else>
                        <td valign="top">
                            <router-link
                                :to="{
                                    path: 'flowsheet3',
                                    query: {
                                        pid: patient.patientId
                                    }
                                }"
                            >
                                <span v-if="readyForTx(patient.insurance_no_error, patient.numsleepstudy)">Yes</span>
                                <span v-else class="red">No</span>
                            </router-link>
                        </td>
                        <td valign="top">
                            <router-link
                                :to="{
                                    path: 'flowsheet3',
                                    query: {
                                        pid: patient.patientId
                                    }
                                }"
                            >
                                <template
                                    v-if="!patient.date_scheduled || patient.date_scheduled === '0000-00-00'"
                                >
                                    <span>N/A</span>
                                </template>
                                <template v-else>
                                    <template v-if="isNegativeTime(patient.date_scheduled)">
                                        <span class="red">
                                            {{ patient.date_scheduled | moment("from") }}
                                        </span>
                                    </template>
                                    <template v-else>
                                        <span
                                            v-if="checkIfThisWeek(patient.date_scheduled)"
                                            class="green"
                                        >{{ patient.date_scheduled | moment("from") }}</span>
                                        <span v-else>{{ patient.date_scheduled | moment("from") }}</span>
                                    </template>
                                </template>
                            </router-link>
                        </td>
                        <td valign="top">
                            <router-link
                                :to="{
                                    path: 'flowsheet3',
                                    query: {
                                        pid: patient.patientId
                                    }
                                }"
                            >
                                <template
                                    v-if="!patient.date_completed || patient.date_completed === '0000-00-00'"
                                >
                                    <span>N/A</span>
                                </template>
                                <template v-else>
                                    <template
                                        v-if="checkIfThisWeek(patient.date_completed) &&
                                              !isNegativeTime(patient.date_completed)"
                                    >
                                        <span class="green">
                                            {{ patient.date_completed | moment("from") }}
                                        </span>
                                    </template>
                                    <template v-else>
                                        <span>{{ patient.date_completed | moment("from") }}</span>
                                    </template>
                                </template>
                            </router-link>
                        </td>
                        <td valign="top">
                            <router-link
                                :to="{
                                    path: 'flowsheet3',
                                    query: {
                                        pid: patient.patientId
                                    }
                                }"
                            >{{ !patient.segmentid ? 'N/A' : segments[patient.segmentid] }}</router-link>
                        </td>
                        <td valign="top">
                            <router-link
                                :to="{
                                    path: 'dss_summ',
                                    query: {
                                        pid: patient.patientId
                                    }
                                }"
                            >{{ patient.device }}</router-link>
                        </td>
                        <td valign="top">
                            <router-link
                                :to="{
                                    path: 'flowsheet3',
                                    query: {
                                        pid: patient.patientId
                                    }
                                }"
                            >
                                <template
                                    v-if="!patient.dentaldevice_date || patient.dentaldevice_date === '0000-00-00'"
                                >
                                    <span>N/A</span>
                                </template>
                                <template v-else>
                                    <template
                                        v-if="checkIfThisWeek(patient.dentaldevice_date) &&
                                              !isNegativeTime(patient.dentaldevice_date)"
                                    >
                                        <span class="green">
                                            {{ patient.dentaldevice_date | moment("from") }}
                                        </span>
                                    </template>
                                    <template v-else>
                                        <span>{{ patient.dentaldevice_date | moment("from") }}</span>
                                    </template>
                                </template>
                            </router-link>
                        </td>
                        <td valign="top">
                            <router-link
                                :to="{
                                    path: 'insurance',
                                    query: {
                                        pid: patient.patientId
                                    }
                                }"
                            >
                                <template v-if="patient.vob === null || patient.vob === ''">
                                    <span>No</span>
                                </template>
                                <template v-else>
                                    <span v-if="patient.vob === 1">Yes</span>
                                    <span v-else>{{ preauthLabels[patient.vob] }}</span>
                                </template>
                            </router-link>
                        </td>
                        <td valign="top">
                            <router-link
                                :to="{
                                    path: 'insurance',
                                    query: {
                                        pid: patient.patientId
                                    }
                                }"
                            >
                                {{ getRxLomn(patient.rx_lomn) }}
                            </router-link>
                        </td>
                        <td valign="top">
                            <router-link
                                :to="{
                                    path: 'ledger',
                                    query: {
                                        pid: patient.patientId
                                    }
                                }"
                            >
                                <span v-if="patient.ledger === null">N/A</span>
                                <template v-else>
                                    <span v-if="patient.total > 0" class="red">
                                        ({{ formatLedger(patient.total) }})
                                    </span>
                                    <span v-else class="green">{{ formatLedger(patient.total) }}</span>
                                </template>
                            </router-link>
                        </td>
                    </template>
                </tr>
            </table>
        </form>
    </div>
</template>

<script src="./patients.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/manage/manage_patient.scss";
    @import "../../../assets/css/manage/admin.scss";
</style>
