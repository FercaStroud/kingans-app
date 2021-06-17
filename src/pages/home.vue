<template>
    <f7-page name="home">
        <f7-navbar no-shadow no-hairline>
            <f7-nav-left>
                <f7-link icon-ios="f7:menu" color="#bc203e" icon-md="material:menu" panel-open="left"/>
            </f7-nav-left>
            <f7-nav-title>
                <img style="height: 25px" src="../assets/kingansWhite.svg" alt="logo">
            </f7-nav-title>
            <f7-nav-right>
                <!--<f7-link @click="checkVisits" href="/promotions/false">
                    <f7-icon style="" material="stars"/>
                    <span>Premios</span>
                </f7-link>-->
            </f7-nav-right>
        </f7-navbar>

        <!--<f7-fab @click="checkVisits" position="right-bottom" slot="fixed">
            <div slot="text" v-if="$store.state.application.visits === null">
                <strong style="font-size:1.2em">Consultar Visitas</strong>
            </div>

            <div slot="text" v-else>
                <strong style="font-size:1.2em">{{$store.state.application.visits}}</strong> Visita(s)
            </div>

            <f7-icon material="account_balance_wallet"/>
        </f7-fab>-->

        <f7-block>
            <span style="font-size: 1.6em;color: black;">{{$store.state.application.user.name}}</span><br/>
            <span style="text-transform: capitalize">{{$store.state.application.user.city}}</span>
        </f7-block>

        <f7-block>
            <h1 style="color: black">{{$store.state.application.user.phone}}</h1>
        </f7-block>

        <f7-block class="active border-bottom" style="
                width: 94px;
                margin: 0;
                padding-bottom: 6px;">
            CÓDIGO
        </f7-block>

        <f7-block v-if="this.$device.ios"
                  style="margin: 0;">
            <vue-qr id="img-qr"
                    style="width: 100%" :size="600"
                    :text="$store.state.application.user.phone"/>
        </f7-block>
        <f7-block v-else style="margin: 0;">
            <vue-qr id="img-qr"
                    colorDark="#000000"
                    colorLight=""
                    bgSrc="http://kingans.com/imgs/logo-para-dentro.png"
                    style="width: 100%" :size="600"
                    :text="$store.state.application.user.phone"/>
        </f7-block>

        <f7-block v-if="$store.state.application.survey === true">
            <div>
                <f7-card v-ripple>
                    <f7-card-header style="border: none;color:white" class="bg-primary">
                        <img style="height: 47px" src="../assets/logoKingans.svg">
                        <strong>¡Hola,
                            {{$store.state.application.user.name.split(' ').slice(0,-1).join(' ')}}!
                        </strong>
                    </f7-card-header>
                    <f7-card-content>
                        <p style="text-align:left">
                            Tienes una (o más) encuesta(s) disponible(s) por tu(s) visita
                            a una de nuestras sucursales.
                        </p>
                    </f7-card-content>
                </f7-card>
            </div>
        </f7-block>

        <f7-block v-if="$store.state.application.survey === true">
            <f7-button class="bg-primary" large v-for="(survey, index) in $store.state.application.surveys" :key="index"
                       @click="getSurveyItemById(survey.id)">
                <img style="height: 44px" src="../assets/logoKingans.svg">
                <span style="top:-14px; position:relative; color:white;">
                    {{survey.name}}
                </span>
            </f7-button>
        </f7-block>

        <f7-popup v-if="$store.state.application.survey === true" :opened="surveyPopupOpened"
                  @popup:closed="surveyPopupOpened = false">
            <survey @onSendSurvey="onSendSurvey"
                    :survey="tempAnswers"/>
        </f7-popup>

        <div style="height: 65px"></div>
    </f7-page>
</template>

<script>
    import VueQr from 'vue-qr'
    import Survey from "./survey";

    export default {
        data() {
            return {
                surveyPopupOpened: false,
                tempAnswers: {
                    title: '',
                    description: '',
                    questions: []
                },
            };
        },
        mounted: function () {

        },
        methods: {
            onSendSurvey() {
                this.surveyPopupOpened = false
                this.tempAnswers = {
                    title: '',
                    description: '',
                    questions: []
                }
            },
            getSurveyItemById(id) {
                this.$f7.dialog.preloader('Obteniendo encuesta...');
                this.$http.post(this.$store.state.application.config.api + 'questions/withAnswers',
                    {id: id}
                ).then(response => {
                    this.tempAnswers = response.body;
                    this.$f7.dialog.close();
                    if (this.tempAnswers.length === 0) {
                        this.$f7.dialog.alert(' ', 'Sin datos disponibles');
                    } else {
                        this.surveyPopupOpened = true
                    }
                }, response => {
                    // error callback
                    this.$f7.dialog.alert(' ', 'Servidor no disponible');
                    console.log(response, 'error on getSurveys');
                    this.$f7.dialog.close();
                });
            },
            dateStringMX: function (arg) {
                let months = [
                    "ENERO",
                    "FEBRERO",
                    "MARZO",
                    "ABRIL",
                    "MAYO",
                    "JUNIO",
                    "JULIO",
                    "AGOSTO",
                    "SEPTIEMBRE",
                    "OCTUBRE",
                    "NOVIEMBRE",
                    "DICIEMBRE",
                ];
                let date = new Date(arg);
                let day = date.getDate();
                let month = months[date.getMonth()];
                let year = date.getFullYear();

                if (day.length < 2) {
                    day = '0' + day;
                }

                return month + " " + day + " DEL " + year;
            },
            checkVisits: function () {
                this.$f7.dialog.preloader('Obteniendo puntos...');
                this.$http.post(this.$store.state.application.config.api + 'visits/get', {
                    user_id: this.$store.state.application.user.id
                }).then(response => {
                    this.$f7.dialog.close();
                    this.$store.state.application.visits = response.data
                }, response => {
                    console.log(response, 'error on checkVisits users/visits/get');
                    this.$f7.dialog.close();
                    this.$f7.dialog.alert("", 'Servidor no disponible.');
                });
            }
        },
        components: {Survey, VueQr}
    }
</script>
