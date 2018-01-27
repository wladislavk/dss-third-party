<template>
    <div>
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
            A temporary PIN was created for this patient on {{ patient.access_code_date | moment("MM/DD/YYYY") }} and is valid until {{ patient.access_code_date | moment("add", "5 days", "MM/DD/YYYY") }}.
            The temporary PIN is: {{ patient.access_code }}.
            <br /><br />
            <a
                v-on:click.prevent="onClickReset"
                href="#"
            >Generate New PIN</a>
        </template>
    </div>
</template>

<script src="./PatientAccessCode.js"></script>

<style lang="scss" scoped>
    @import "../../../../assets/css/manage/admin.scss";
</style>
