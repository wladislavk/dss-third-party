<template>
    <div class="fullwidth">
        <h3>Charges</h3>
        <ul>
            <li v-for="charge in charges">
                <label v-html="charge.description"></label> {{ formatLedger(charge.amount) }}
            </li>
            <li>
                <label>Charges Total</label> {{ formatLedger(totals.charges) }}
            </li>
        </ul>
        <h3>Credit</h3>
        <ul>
            <li v-for="credit in credits">
                <label v-html="credit.description"></label> {{ formatLedger(credit.amount) }}
            </li>
            <li>
                <label>Credits Total</label> {{ formatLedger(totals.credits) }}
            </li>
        </ul>
        <h3>Adjustments</h3>
        <ul>
            <li v-for="adjustment in adjustments">
                <label v-html="adjustment.description"></label> {{ formatLedger(adjustment.amount) }}
            </li>
            <li>
                <label>Adjust. Total</label> {{ formatLedger(totals.adjustments) }}
            </li>
        </ul>
    </div>
</template>

<script src="./ledgerSummaryReportFull.js"></script>
