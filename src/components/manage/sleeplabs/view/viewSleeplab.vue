<template>
    <div style="margin-top:3px;padding-top:10px;background: #fff; width: 98%; height:380px; margin-left: 1%;">
        <div class="info">
            <label>Name:</label>
            <span class="value">{{ sleeplab.name }}</span>
        </div>
        <div class="info">
            <label>Company:</label>
            <span class="value">{{ sleeplab.company }}</span>
        </div>
        <div class="info">
            <label>Address:</label>
            <span class="value">{{ sleeplab.add1 }}</span>
        </div>
        <div class="info">
            <label>&nbsp;</label>
            <span class="value">{{ sleeplab.add2 }}</span>
        </div>
        <div class="info">
            <label>&nbsp;</label>
            <span class="value">{{ sleeplab.city  }} {{ sleeplab.state }} {{ sleeplab.zip }}</span>
        </div>
        <div class="info">
            <label>Phone:</label>
            <span class="value">{{ sleeplab.phone1 }}</span>
        </div>
        <div class="info">
            <label>Phone 2:</label>
            <span class="value">{{ sleeplab.phone2 }}</span>
        </div>
        <div class="info">
            <label>Fax:</label>
            <span class="value">{{ sleeplab.fax }}</span>
        </div>
        <div class="info">
            <label>Email:</label>
            <span class="value">{{ sleeplab.email }}</span>
        </div>
        <div class="info">
            <label>Notes:</label>
            <span class="value">{{ sleeplab.notes }}</span>
        </div>
        <a
            v-on:click.prevent="onClickEditSleeplab"
            href="#"
            style="margin-right:10px;float:right;"
        >Edit</a>
    </div>
</template>

<script src="./viewSleeplab.js"></script>

<style lang="scss" scoped>
    @import "../../../../assets/css/manage/form.scss";
    @import "../../../../assets/css/manage/admin.scss";
    @import "../../../../assets/css/manage/quick_view.scss";
</style>
