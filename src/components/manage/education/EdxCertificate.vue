<template>
    <div>
        <br/>
        <span class="admin_head">EdX Certificates</span>
        <br/>
        <br/>

        <ul v-if="edxCertificates.length" class="fullwidth" style="list-style:none;">
            <li v-for="edxCertificate in edxCertificates">
                <a v-bind:href="edxCertificate.url" target="_blank">
                    {{ edxCertificate.course_name }} -
                    {{ edxCertificate.course_section }} -
                    {{ edxCertificate.course_subsection }} -
                    {{ edxCertificate.number_ce }}
                </a>
            </li>
        </ul>
    </div>
</template>

<script src="./EdxCertificate.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/old/admin.scss";
</style>
