<template>
    <div class="tracker-div">
        <template v-if="isHSTCompany">
            <a
                href="#"
                class="button"
                v-on:click.prevent="orderHst()"
                v-if="incompleteHSTs.length"
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
        >View Calendar Appts</a>
    </div>
</template>

<script src="./ChartButtons.js"></script>
