<template>
  <div id="modal" class="modal">
    <div id="popupContact" style="width:750px">
      <a id="popupContactClose" v-on:click="disable"><button>X</button></a>

      <div id="modal-content">
        <component :is="currentView"></component>
      </div>
    </div>

    <div id="backgroundPopup" v-on:click="disable"></div>
  </div>
</template>

<script src="./modal.js"></script>

<style src="../../assets/css/manage/popup.css" scoped></style>
<style scoped>
  #modal-content {
    background: url(~assets/images/tall.jpg);
    background-repeat: repeat-x;
    background-color: rgb(191, 207, 220);
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
    width: 100%;
    height: 100%;
    overflow: auto;
  }
</style>
