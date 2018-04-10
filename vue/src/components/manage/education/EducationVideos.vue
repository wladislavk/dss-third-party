<template>
    <div class="container">
        <h1>Education</h1>&nbsp;
        <div v-for="video in videos" class="video-div">
            <h2>{{ video.heading }}</h2>
            <div><span>{{ video.text }}</span> <em>Time: {{ video.time }} Minutes</em><br/></div>
            <iframe v-bind:src="video.video" allowFullScreen frameborder="0"></iframe>
        </div>
    </div>
</template>

<script src="./EducationVideos.js"></script>

<style lang="scss" scoped>
    @import "../../../assets/css/manage/education/videos.scss";
</style>
