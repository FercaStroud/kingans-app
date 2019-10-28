<template>
    <f7-page login-screen>
        <f7-navbar title="Captura de Visitas"
                   style="background-color: white !important;
                   border:none !important; box-shadow: none !important;" :sliding="true" back-link="Atrás">
            <f7-nav-right>
                <f7-link icon-ios="f7:menu"
                         icon-aurora="f7:menu"
                         icon-md="material:menu"
                         panel-open="left">
                </f7-link>
            </f7-nav-right>
        </f7-navbar>

        <f7-login-screen-title style="color: white;max-width: 200px">
            <div style="width: 100%">
                <img class="circle-image" style="width: 50%; margin-top: 40px" src="../../assets/logoKingans.svg"/>
            </div>
        </f7-login-screen-title>
        <f7-list form style="max-width: 350px">
            <f7-list-input
                    class="kingans-border"
                    label="Código"
                    type="text"
                    placeholder="XXX XXX XX XX"
                    :value="username"
                    clear-button
                    @input="username = $event.target.value"
            ></f7-list-input>
            <f7-list-item>
                <f7-button
                        class="btn-primary" style="
                    width: 100%;
                    "
                        large @click="">
                    Registrar Visita
                </f7-button>
            </f7-list-item>
        </f7-list>
    </f7-page>
</template>

<script>
    export default {
        name: "visitAdd",
        data() {
            return {
                username: '',
                password: '',
            };
        },
    }
</script>

<style scoped>
    .navbar:before{
        content: none !important;
    }
</style>