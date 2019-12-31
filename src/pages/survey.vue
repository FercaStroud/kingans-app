<template>
    <f7-page>
        <f7-navbar title="">
            <f7-nav-left>
                <img
                        style="width: 70px; position:absolute; top:-15px"
                        class="circle-image"
                        src="../assets/logoKingans.svg">
            </f7-nav-left>
            <f7-nav-right>
                <f7-link popup-close>Cerrar</f7-link>
            </f7-nav-right>
        </f7-navbar>
        <f7-block strong style="margin:0 ">
            <f7-row>
                <f7-col style="text-align: center; margin-top:20px;">
                    <h1 style="margin:0">
                        {{survey.name}}
                    </h1>
                </f7-col>
            </f7-row>
            <f7-row>
                <f7-col style="text-align: center; margin-top:20px;">
                    <p style="margin:0; color:#707074;">
                        {{survey.description}}
                    </p>
                </f7-col>
            </f7-row>

            <f7-card v-for="(question, index) in survey.questions" :key="index">
                <f7-block class="bg-primary" style="border-radius: 4px">
                    <f7-row>
                        <p style="text-align: left">
                            <span class="s-subtitle" style="color:white !important">
                                {{ question.title }}
                            </span>
                        </p>
                    </f7-row>
                </f7-block>
                <div v-if="question.type !== 'TEXT'">
                    <f7-list inline-labels>
                        <f7-list-input
                                type="select"
                                @input="question.vModel = $event.target.value">
                            <option value="">
                                *Selecciona una respuesta
                            </option>
                            <option v-for="answer in question.answers" :value="answer.id">
                                {{ answer.title }}
                            </option>
                        </f7-list-input>
                    </f7-list>
                </div>
                <div v-else>
                    <f7-list inline-labels>
                        <f7-list-input type="text" placeholder="Escriba una respuesta"
                                       @input="question.vModel = $event.target.value">
                        </f7-list-input>
                    </f7-list>
                </div>

            </f7-card>

            <f7-block>
                <f7-button class="bg-primary" style="height: 60px; font-size: 1.2em;" @click="sendForm">
                    <p style="font-weight: bold;color:white;">
                        <f7-icon style="margin-top: -4px" material="done"></f7-icon>

                        Enviar
                    </p>
                </f7-button>
            </f7-block>
        </f7-block>
    </f7-page>
</template>

<script>
    export default {
        name: "survey",
        props:{
            survey: {}
        },
        methods: {
            sendForm() {
                const self = this;
                const app = self.$f7;
                app.dialog.preloader('Enviando Encuesta');
                this.$http.post(this.$store.state.application.config.api + 'question-answers/app/add', {
                    survey_id: this.survey.survey_id,
                    questions: this.survey.questions
                }).then(response => {
                    app.dialog.close();
                    // get body data
                    this.$emit('onSendSurvey')
                    app.dialog.alert(
                        "¡Muchas gracias!",
                        'Encuesta enviada'
                    )
                    self.$store.commit('setSurvey', false);

                }, response => {
                    app.dialog.close();
                    app.dialog.alert(
                        "Intenta más tarde",
                        'Servidor no disponible'
                    )
                    console.log(response, 'error on sendForm')
                });
            },
            checkBeforeSendForm(arg) {
                if (arg.answer === this.tempAnswers.answers[0][0]) {
                    return true
                } else {
                    return false
                }
            },
        }
    }
</script>

<style scoped>
    .radio-color {
        color: #f16989;
    }
</style>