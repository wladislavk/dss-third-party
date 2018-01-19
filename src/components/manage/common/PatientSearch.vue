<template>
    <form>
        <div id="patient_search_div" class="patient_search_div">
            <input
                type="text"
                id="patient_search"
                class="patient_search"
                placeholder="Patient Search"
                v-bind:model="inputValue"
                name="q"
                autocomplete="off"
                v-on:keypress="patientNameKeyPress($event)"
                v-on:keyup="patientNameKeyUp($event)"
            />
            <br />
            <div id="search_hints" class="search_hints" v-show="showSearchHints">
                <ul
                    id="patient_list"
                    class="search_list"
                    v-show="patientList.length"
                >
                    <li
                        v-for="(patient, index) in patientList"
                        class="template"
                        v-on:mouseover="patientListMouseOver(index, patient.patientType)"
                        v-on:mouseout="patientListMouseOut(patient.patientType)"
                        v-on:click="patientListClick(patient)"
                        v-bind:style="{ 'cursor': cursor }"
                        v-bind:class="{
                           'no_matches': patient.patientType === 'no',
                           'create_new': patient.patientType === 'new',
                           'json_patient': patient.patientType === 'json',
                           'list_hover': index === searchListHover
                        }"
                    >{{ patient.name }}</li>
                </ul>
            </div>
        </div>
    </form>
</template>

<script src="./PatientSearch.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/manage/common/patient-search.scss";
</style>
