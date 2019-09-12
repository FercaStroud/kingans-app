<template>
    <f7-page login-screen>
        <f7-navbar
                style="background-color: white !important;
                   border:none !important; box-shadow: none !important;">
            <f7-nav-right>
                <f7-link style="">Salir</f7-link>
            </f7-nav-right>
        </f7-navbar>
        <f7-statusbar></f7-statusbar>
        <div class="welcome-container">
            <f7-list form style="max-width: 350px;">
                <img style="width: 130px; margin-left: 50%; left: -65px; position:relative;"
                     src="../../../assets/round-account-button-with-user-inside.svg">
            </f7-list>
            <f7-list style="padding-top: 20px;">
                <f7-button
                        class="btn-primary"
                        style="width: 40%; margin-left: 30%;"
                        large @click="panelManagerPopupOpened = true">
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

        <f7-popup class="panel-manager-popup" tablet-fullscreen
                  :opened="panelManagerPopupOpened"
                  @popup:closed="panelManagerPopupOpened = false">
                <manager-index/>
        </f7-popup>

    </f7-page>
</template>

<script>
    import Codes from "../../../components/codes";
    import ManagerIndex from "../../../components/panel/manager/index";

    export default {
        name: 'welcome',
        components: {ManagerIndex, Codes},
        data() {
            return {
                codePopupOpened: false,
                panelManagerPopupOpened: false,
            };
        },
        mounted: function () {
            this.$store.state.application.drawer.left = false
        },
        methods: {},
    };
</script>

<style scoped>
    .navbar:before {
        content: none !important;
    }

    .welcome-container {
        margin: 0;
        width: 400px;
        margin-left: 50%;
        left: -200px;
        height: 300px;
        position: absolute;
        top: 40%;
        -ms-transform: translateY(-40%);
        transform: translateY(-40%);
    }
</style>