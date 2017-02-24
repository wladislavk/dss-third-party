<style src="../../../assets/css/manage/admin.css" scoped></style>
<style src="../../../assets/css/manage/quick_view.css" scoped></style>
<style src="../../../assets/css/manage/form.css" scoped></style>

<template>
  <div id="view-contact">
    <div style="padding-top: 10px; background: #fff; width: 98%; height: 380px; margin-left: 1%;">
      <div class="info">
        <label>Name: </label>
        <span class="value">
          {{ filteredContact.salutation }} {{ filteredContact.firstname }} {{ filteredContact.middlename }} {{ filteredContact.lastname }}
        </span>
      </div>
      <div class="info">
        <label>Company: </label>
        <span class="value">
          {{ filteredContact.company }}
        </span>
      </div>
      <div class="info">
        <label>Contact Type: </label>
        <span class="value">
          {{ filteredContact.contacttype }}
        </span>
      </div>
      <div class="info">
        <label>Address: </label>
        <span class="value">
          {{ filteredContact.add1 }}
        </span>
      </div>
      <div class="info">
        <label>&nbsp;</label>
        <span class="value">
          {{ filteredContact.add2 }}
        </span>
      </div>
      <div class="info">
        <label>&nbsp;</label>
        <span class="value">
          {{ filteredContact.city }} {{ filteredContact.state }} {{ filteredContact.zip }}
        </span>
      </div>
      <div class="info">
        <label>Phone: </label>
        <span class="value">
          {{ filteredContact.phone1 }}
        </span>
      </div>
      <div class="info">
        <label>Phone 2: </label>
        <span class="value">
          {{ filteredContact.phone2 }}
        </span>
      </div>
      <div class="info">
        <label>Fax: </label>
        <span class="value">
          {{ filteredContact.fax }}
        </span>
      </div>
      <div class="info">
        <label>Email: </label>
        <span class="value">
          {{ filteredContact.email }}
        </span>
      </div>
      <div class="info">
        <label>Notes: </label>
        <span class="value">
          {{ filteredContact.notes }}
        </span>
      </div>

      <router-link
        v-if="corporate"
        :to="'view_fcontact.php?ed=' + componentParams.contactId"
        style="margin-right:10px;float:right;"
      >View Full</router-link>
      <route-link
        v-else
        :to="'add_contact.php?ed=' + componentParams.contactId"
        style="margin-right:10px;float:right;"
      >Edit</router-link>
    </div>
  </div>
</template>

<script>
  module.exports = require('./ViewContact.js')
</script>
