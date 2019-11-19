<template>
    <f7-page name="home">
        <f7-navbar no-shadow no-hairline>
            <f7-nav-left>
                <f7-link icon-ios="f7:menu" color="#bc203e" icon-md="material:menu" panel-open="left"></f7-link>
            </f7-nav-left>
            <f7-nav-title></f7-nav-title>
            <f7-nav-right>
                <f7-link href="/promotions/">
                    <span class="navbar-text-color">Promociones</span>
                    <f7-icon style="padding-left: 5px" material="new_releases"></f7-icon>
                </f7-link>
            </f7-nav-right>
        </f7-navbar>

        <f7-block>
            <span style="font-size: 1.6em;color: black;">{{$store.state.application.user.name}}</span><br/>
            <span style="text-transform: capitalize">{{$store.state.application.user.city}}</span>
        </f7-block>

        <f7-block>
            <h1 style="color: black">{{$store.state.application.user.phone}}</h1>
        </f7-block>

        <f7-block style="
                color: #f16989;
                width: 94px;
                border-bottom: 1px solid #f16989;
                margin: 0;
                padding-bottom: 6px;">
            CÓDIGO
        </f7-block>

        <f7-block style="margin: 0;">
            <vue-qr id="img-qr" style="width: 100%" size="600" :text="$store.state.application.user.phone"></vue-qr>
        </f7-block>

        <!--<f7-block style="text-align: center;">
            <f7-link style="font-size: 1.3em; color: #d9d9d8; font-weight: bold" @click="surveyPopupOpened = true">
                Vista de prueba - Encuesta
            </f7-link>
        </f7-block>-->

        <f7-block>
            <img style="border-radius: 50%; width: 30%; margin-left: 35%" src="../assets/logoKingans.svg"/>
        </f7-block>

        <f7-popup :opened="surveyPopupOpened" @popup:closed="surveyPopupOpened = false">
            <survey/>
        </f7-popup>
    </f7-page>
</template>
<script>
    import VueQr from 'vue-qr'
    import Survey from "./survey";
    export default {
        data() {
            return {
                surveyPopupOpened: false,
            };
        },
        components: {Survey, VueQr}
    }
</script>