<template>
    <div>
        <br/>
        <span class="admin_head">EdX Certificates</span>

        <br/>
        <br/>

        <ul class="fullwidth">
            <li v-for="edxCertificate in edxCertificates">
                <a v-bind:href="edxCertificate.url" target="_blank">
                    {{ edxCertificate.courseName }} -
                    {{ edxCertificate.courseSection }} -
                    {{ edxCertificate.courseSubsection }} -
                    {{ edxCertificate.numberCe }}
                </a>
            </li>
        </ul>
    </div>
</template>

<script src="./EdxCertificate.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/manage/education/edx_certificate.scss";
</style>
