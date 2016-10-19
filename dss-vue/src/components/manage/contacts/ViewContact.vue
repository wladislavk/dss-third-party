<style></style>

<template>
    <div style="padding-top: 10px; background: #fff; width: 98%; height: 380px; margin-left: 1%;">
        <div class="info">
            <label>Name: </label>
            <span class="value">
                {{ contact.salutation }} {{ contact.firstname }} {{ contact.middlename }} {{ contact.lastname }}
            </span>
        </div>
        <div class="info">
            <label>Company: </label>
            <span class="value">
                {{ contact.company }}
            </span>
        </div>
        <div class="info">
            <label>Contact Type: </label>
            <span class="value">
                {{ contact.contacttype }}
            </span>
        </div>
        <div class="info">
            <label>Address: </label>
            <span class="value">
                {{ contact.add1 }}
            </span>
        </div>
        <div class="info">
            <label>&nbsp;</label>
            <span class="value">
                {{ contact.add2 }}
            </span>
        </div>
        <div class="info">
            <label>&nbsp;</label>
            <span class="value">
                {{ contact.city }} {{ contact.state }} {{ contact.zip }}
            </span>
        </div>
        <div class="info">
            <label>Phone: </label>
            <span class="value">
                {{ contact.phone1 }}
            </span>
        </div>
        <div class="info">
            <label>Phone 2: </label>
            <span class="value">
                {{ contact.phone2 }}
            </span>
        </div>
        <div class="info">
            <label>Fax: </label>
            <span class="value">
                {{ contact.fax }}
            </span>
        </div>
        <div class="info">
            <label>Email: </label>
            <span class="value">
                {{ contact.email }}
            </span>
        </div>
        <div class="info">
            <label>Notes: </label>
            <span class="value">
                {{ contact.notes }}
            </span>
        </div>

        <a
            v-if="corporate"
            href="view_fcontact.php?ed={{ request.ed }}"
            style="margin-right:10px;float:right;"
        >View Full</a>
        <a
            v-else
            href="add_contact.php?ed={{ request.ed }}"
            style="margin-right:10px;float:right;"
        >Edit</a>
    </div>
</template>

<script>
    module.exports = require('./ViewContact.js');
</script>
