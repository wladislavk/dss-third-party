<template>
    <tr v-bind:class="{ unviewed: unviewedClass }">
        <td valign="top">
            {{ vob.front_office_request_date }}
        </td>
        <td valign="top">
            {{ vob.firstname }} {{ vob.lastname }}
        </td>
        <td valign="top" :class="'status_' + vob.status">
            {{ statusLabel }}
        </td>
        <td valign="top">
            {{ rejectReason }}
        </td>
        <td valign="top">
            <router-link
                :to="{
                  path: '/manage/insurance',
                  query: {
                    pid: routeParameters.patientId,
                    vob_id: vob.id
                  }
                }"
                class="editlink"
                title="EDIT"
            >View</router-link>
            <br />
            <a
                href="#"
                v-on:click.prevent="setViewStatus()"
                class="editlink"
                title="EDIT"
            >{{ vob.viewed === 1 ? 'Mark Unread' : 'Mark Read' }}</a>
        </td>
    </tr>
</template>

<script src="./SingleVob.js"></script>
