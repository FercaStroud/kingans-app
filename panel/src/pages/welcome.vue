<template>
    <f7-page login-screen>
        <f7-navbar
                style="background-color: white !important;
                   border:none !important; box-shadow: none !important;">
            <f7-nav-right>
                <f7-button panel-open="left">
                    <f7-icon f7="bars"></f7-icon>
                </f7-button>
            </f7-nav-right>
        </f7-navbar>
        <f7-statusbar></f7-statusbar>
        <div class="welcome-container">
            <f7-block>
                <f7-row>
                    <f7-col style="text-align: center">
                        <strong>Panel de Administración</strong>
                    </f7-col>
                </f7-row>
            </f7-block>
            <f7-list form style="max-width: 350px;">
                <img style="width: 300px; margin-left: 50%; left: -150px; position:relative;"
                     src="../assets/logoKingans.svg" class="circle-image">
            </f7-list>
            <f7-block>
                <f7-row>
                    <f7-col style="text-align: center">
                        <strong style="font-size: 2em">Usuario Administrador,</strong><br/>
                        <span>Selecciona una opción desde la barra de menús
                            <f7-button panel-open="left">
                                <f7-icon f7="bars"></f7-icon>
                            </f7-button>
                        </span>
                    </f7-col>
                </f7-row>
            </f7-block>
        </div>
    </f7-page>
</template>

<script>
    export default {
        name: 'welcome',
        data() {
            return {
            };
        },
        mounted: function () {
        },
        methods: {
        },
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
        top: 30%;
        -ms-transform: translateY(-30%);
        transform: translateY(-30%);
    }
</style>