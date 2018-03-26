<template>
    <div v-if="patientId" id="patient_nav">
        <ul>
            <patient-menu-element
                v-for="(menuElement, loopIndex) in menuElements"
                v-bind:element-link="menuElement.link"
                v-bind:element-name="menuElement.name"
                v-bind:element-active="menuElement.active"
                v-bind:element-active-like="menuElement.activeLike"
                v-bind:last-element="(loopIndex === menuElements.length - 1)"
                v-bind:key="loopIndex"
            ></patient-menu-element>
        </ul>
    </div>
</template>

<script src="./PatientMenu.js"></script>
