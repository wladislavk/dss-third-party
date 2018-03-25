<template>
    <li v-bind:class="{ 'last': lastElement }">
        <a v-bind:class="{ 'nav_active': isActive }" v-bind:href="parsedLink">{{ elementName }}</a>
    </li>
</template>

<script src="./PatientMenuElement.js"></script>
