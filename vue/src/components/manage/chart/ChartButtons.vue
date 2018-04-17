<template>
    <div class="tracker-div">
        <template v-if="isHstCompany">
            <a
                href="#"
                class="button"
                v-on:click.prevent="orderHst()"
                v-if="incompleteHsts.length"
            >Order HST</a>
            <a
                href="#"
                class="button"
                v-on:click.prevent="requestHst()"
                v-else
            >Request HST</a>
        </template>
        <a
            v-legacy-href="'manage/calendar_pat.php?pid=' + patientId"
            class="button"
            id="calendar-appts-button"
        >View Calendar Appts</a>
    </div>
</template>

<script src="./ChartButtons.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/manage/chart/chart-buttons.scss";
</style>
