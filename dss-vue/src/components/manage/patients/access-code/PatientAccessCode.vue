<link href="css/admin.css?v=20160404" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/manage/admin/css/jquery-ui-1.8.22.custom.css" />
<link rel="stylesheet" href="css/modal.css" />

<template>
    <br />
    <h3>Online Patient Registration Without Text Messaging:</h3>
    <template v-if="isResetAccessCode">
        <p>
            Is this patient unable or unwilling to receive text messages?
            If so you can generate a temporary PIN that will allow the user to register without receiving a text message activation code.
        </p>
        <p>Temporary PIN: {{ patient.access_code }}</p>
        <form>
            <input
                v-on:click.prevent="onSubmit"
                type="submit"
                name="email_but"
                value="Email Patient and Print PIN"
            />
        </form>
    </template>
    <template v-else>
        A temporary PIN was created for this patient on {{ startDate }} and is valid until {{ expirationDate }}.
        The temporary PIN is: {{ patient.access_code }}.
        <br /><br />
        <a
            v-on:click.prevent="onClickReset"
            href="#"
        >Generate New PIN</a>
    </template>
</template>

<script type="text/javascript" src="/manage/admin/js/tracekit.js"></script>
<script type="text/javascript" src="/manage/admin/js/tracekit.handler.js"></script>
<script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="/manage/admin/script/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="/manage/includes/modal.js"></script>
<script type="text/javascript" src="script/validation.js"></script>

<script>
    module.exports = require('./PatientAccessCode.js');
</script>
