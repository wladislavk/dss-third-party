<template>
    <a
      v-bind:href="legacyUrl + 'manage_hst.php?status=' + constants.DSS_HST_COMPLETE + '&viewed=0'"
      :class="'count_' + headerInfo.hstNumber + ' notification ' + (headerInfo.hstNumber == 0 ? 'good_count' : 'great_count')"
    >
        <span class="count">{{ linkCount }}</span>
        <span class="label">{{ linkLabel }}</span>
    </a>
</template>
