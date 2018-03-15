<template>
    <div class="container">
        <h1>Education</h1>
        &nbsp;
        <div v-for="video in videos">
            <h2>{{ video.heading }}</h2>
            {{ video.text }}
            <em>Time: {{ video.time }} Minutes</em><br/>
            <iframe :src="video.video" allowFullScreen frameborder="0"></iframe>
        </div>
    </div>
</template>

<script src="./Videos.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/manage/education/videos";
</style>
