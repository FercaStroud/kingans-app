<template>
    <f7-page no-toolbar no-navbar no-swipeback login-screen>
        <f7-statusbar></f7-statusbar>
        <div class="welcome-container">
            <f7-list form style="max-width: 350px;">
                <img style="width: 130px; margin-left: 50%; left: -65px; position:relative;"
                     src="../assets/round-account-button-with-user-inside.svg">
            </f7-list>
            <f7-list style="padding-top: 20px;">
                <f7-button
                        class="btn-primary"
                        style="width: 40%; margin-left: 30%;"
                        large @click="">
                    PANEL
                </f7-button>
            </f7-list>
            <f7-list style="">
                <f7-button
                        class="btn-primary"
                        style="width: 40%; margin-left: 30%;"
                        large @click="codePopupOpened = true">
                    CAPTURAR
                </f7-button>
            </f7-list>
        </div>

        <f7-popup class="code-popup" tablet-fullscreen
                  :opened="codePopupOpened"
                  @popup:closed="codePopupOpened = false">
            <codes/>
        </f7-popup>

    </f7-page>
</template>

<script>
    import Codes from "../components/codes";
    export default {
        name: 'welcome',
        components: {Codes},
        data() {
            return {
                codePopupOpened: false,
            };
        },
        mounted: function () {
            this.$store.state.application.drawer.left = false
        },
        methods: {},
    };
</script>

<style scoped>
    .welcome-container {
        margin: 0;
        width: 400px;
        margin-left: 50%;
        left: -200px;
        height: 300px;
        position: absolute;
        top: 50%;
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
    }
</style>