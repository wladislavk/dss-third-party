<template>
    <li v-bind:class="{ 'last': lastElement }">
        <a v-bind:class="{ 'nav_active': isActive }" v-bind:href="parsedLink" v-if="elementLegacy">{{ elementName }}</a>
        <router-link
            v-bind:class="{ 'nav_active': isActive }"
            v-bind:to="{ name: elementLink }"
            v-else
        >{{ elementName }}</router-link>
    </li>
</template>

<script src="./PatientMenuElement.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/manage/patients/patient-menu-element.scss";
</style>
