<template>
    <f7-page name="surveys">
        <f7-navbar :sliding="true" back-link="Atrás" title="Encuestas">
            <f7-nav-right>
                <f7-link @click="getList">
                    <f7-icon material="cached"></f7-icon>
                </f7-link>
                <f7-link icon-ios="f7:menu"
                         icon-aurora="f7:menu"
                         icon-md="material:menu"
                         panel-open="left">
                </f7-link>
            </f7-nav-right>
        </f7-navbar>
        <f7-card>
            <f7-card-content>
                <f7-block>
                    <f7-row>
                        <f7-col>
                            <f7-list form style="margin: 15px;max-width: 100%;">
                                <f7-list-input
                                        class="kingans-border"
                                        label="Buscar por Nombre"
                                        placeholder="EJ: Lucas K."
                                        type="text"
                                        :value="search"
                                        clear-button
                                        @input="search = $event.target.value"
                                ></f7-list-input>
                            </f7-list>
                        </f7-col>
                    </f7-row>
                </f7-block>
            </f7-card-content>
        </f7-card>
        <f7-row>
            <f7-card v-for="(item, index) in filteredList" :key="index" style="width:100%">
                <f7-card-header>
                    <strong>{{item.name}}</strong>
                    <f7-button @click="deleteSurvey(item.id)">
                        <f7-icon style="margin-right: 10px;" material="delete"></f7-icon>
                        Eliminar Encuesta
                    </f7-button>
                </f7-card-header>
                <f7-card-content>
                    <p>
                        {{item.description}}
                    </p>
                    <f7-card v-for="(question,index) in questions[item.id]" :key="index" style="margin-top:10px">
                        <f7-card-header>
                            <strong>Pregunta: {{ question.title }}</strong>
                            <f7-button @click="deleteQuestion(question.id, item.id)">
                                <f7-icon style="margin-right: 10px;" material="delete"></f7-icon>
                                Eliminar Pregunta
                            </f7-button>
                        </f7-card-header>
                        <f7-card-content>
                            <strong>Tipo: </strong>{{ question.type }} <br/>

                            <strong style="">Respuestas: </strong><br/>
                            <ul style="">
                                <li v-for="(item, index) in answers[question.id]" :key="index">
                                    {{ item.title }}
                                </li>
                            </ul>
                            <!--<f7-row>
                                <f7-col width="33">
                                    <apexchart type=pie :options="chartOptions" :series="series"/>
                                </f7-col>
                            </f7-row>-->
                        </f7-card-content>
                        <f7-card-footer>
                            <f7-button @click="getAnswersByQuestionId(question.id)" v-show="question.type !== 'TEXT'">
                                <f7-icon style="margin-right: 10px;" material="visibility"></f7-icon>
                                Ver Respuestas de la Pregunta
                            </f7-button>
                        </f7-card-footer>
                    </f7-card>
                </f7-card-content>
                <f7-card-footer class="no-border">
                    <f7-button @click="selectedQuestion = item; answerAddDialog = true;">
                        <f7-icon style="margin-right: 10px;" material="playlist_add"></f7-icon>
                        Añadir Respuesta
                    </f7-button>
                    <f7-button @click="getQuestionsBySurveyId(item.id)">
                        <f7-icon style="margin-right: 10px;" material="visibility"></f7-icon>
                        Ver Preguntas
                    </f7-button>
                    <!--<f7-button>
                        <f7-icon style="margin-right: 10px;" material="equalizer"></f7-icon>
                        Obtener Resultados
                    </f7-button>-->
                    <f7-button @click="changeSurveyStatus(item.id, 1)" v-if="item.is_active === 0">
                        <f7-icon style="margin-right: 10px;" material="play_circle_filled"></f7-icon>
                        Habilitar
                    </f7-button>
                    <f7-button @click="changeSurveyStatus(item.id, 0)" v-else>
                        <f7-icon style="margin-right: 10px;" material="pause_circle_filled"></f7-icon>
                        Deshabilitar
                    </f7-button>
                    <f7-button
                            @click="openUrl($store.state.application.config.api + 'question-answers/excel?survey_id='+item.id)"
                            target="_blank">
                        <f7-icon style="margin-right: 10px;" material="cloud_download"></f7-icon>
                        Descargar Excel
                    </f7-button>
                </f7-card-footer>
            </f7-card>
        </f7-row>

        <f7-popup class="demo-popup" :opened="answerAddDialog" @popup:closed="answerAddDialog = false">
            <f7-page>
                <f7-navbar :title="'Añadir Pregunta a ' + selectedQuestion.name">
                    <f7-nav-right>
                        <f7-link popup-close>Cerrar</f7-link>
                    </f7-nav-right>
                </f7-navbar>
                <f7-block>
                    <SurveyBuilder :options="SurveyBuilderJson"/>
                </f7-block>
            </f7-page>
        </f7-popup>
    </f7-page>
</template>

<script>
    import {SurveyBuilder, SurveyBuilderJson} from 'vue-survey-builder';

    export default {
        name: "surveyList",
        data() {
            return {
                selectedQuestion: {},
                answerAddDialog: false,
                SurveyBuilderJson: {
                    "question": null,
                    "type": null,
                    "multiSelect": false,
                    "labels": [],
                    "options": [
                        {
                            "body": null,
                            "sequence": 1
                        },
                        {
                            "body": null,
                            "sequence": 2
                        }
                    ]
                },
                questions: [],
                answers: [],
                search: '',
                surveys: [],
                series: [44, 55, 13, 43, 22],
                chartOptions: {
                    labels: ['Respuesta A', 'Respuesta B', 'Respuesta C', 'Respuesta D', 'Respuesta E'],
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }],
                }
            }
        },
        computed: {
            filteredList() {
                return this.surveys.filter(item => {
                    return item.name.toLowerCase().includes(this.search.toLowerCase())
                })
            },
        },
        created: function () {
            this.$root.$on('add-update-question', question => {
                this.sendAnswerForm(question)
            });
            this.$root.$on('cancel-question', question => {
                this.answerAddDialog = false
            });
        },
        mounted: function () {
            this.getList()
        },
        methods: {
            openUrl(url) {
                window.open(url);
            },
            getAnswersByQuestionId(qId) {
                let vm = this
                vm.$f7.dialog.preloader('Obteniendo datos...');

                this.$http.post(this.$store.state.application.config.api + 'answers/get', {
                    question_id: qId
                }).then(response => {
                    this.answers[qId] = response.data
                    vm.$f7.dialog.close();
                    this.$forceUpdate();
                }, response => {
                    // error callback
                    vm.$f7.dialog.close();
                    vm.$f7.dialog.alert("Servidor no disponible", 'Intente más tarde');
                    console.log(response, 'error on getQuestionsBySurveyId');
                });
            },
            deleteQuestion(questionId, surveyId) {
                let vm = this;

                vm.$f7.dialog.preloader('Enviando datos...');
                this.$http.post(this.$store.state.application.config.api + 'questions/delete', {
                    id: questionId
                }).then(response => {
                    vm.$f7.dialog.close();
                    if (response.data.success) {
                        vm.$f7.dialog.alert("Elemento Eliminado", 'Éxito');
                    } else {
                        vm.$f7.dialog.alert("Error desconocido", 'Intente más tarde');
                    }
                    vm.$f7.dialog.close();

                    this.getQuestionsBySurveyId(surveyId);

                    //this.items = response.data
                }, response => {
                    console.log(response, 'error on deleteQuestion question/delete');
                    this.$f7.dialog.close();
                    this.$f7.dialog.alert("Servidor no disponible", 'Intente más tarde');
                });
            },
            deleteSurvey(surveyId) {
                let vm = this;

                vm.$f7.dialog.preloader('Enviando datos...');
                this.$http.post(this.$store.state.application.config.api + 'surveys/delete', {
                    id: surveyId
                }).then(response => {
                    vm.$f7.dialog.close();
                    if (response.data.success) {
                        vm.$f7.dialog.alert("Elemento Eliminado", 'Éxito');
                    } else {
                        vm.$f7.dialog.alert("Error desconocido", 'Intente más tarde');
                    }
                    vm.$f7.dialog.close();

                    this.getList();

                    //this.items = response.data
                }, response => {
                    console.log(response, 'error on deleteQuestion question/delete');
                    this.$f7.dialog.close();
                    this.$f7.dialog.alert("Servidor no disponible", 'Intente más tarde');
                });
            },
            changeSurveyStatus(surveyId, isActive) {
                let vm = this;

                vm.$f7.dialog.preloader('Enviando datos...');
                this.$http.post(this.$store.state.application.config.api + 'surveys/status', {
                    id: surveyId,
                    is_active: isActive
                }).then(response => {
                    vm.$f7.dialog.close();

                    vm.getList();

                    //this.items = response.data
                }, response => {
                    console.log(response, 'error on deleteQuestion question/delete');
                    vm.$f7.dialog.close();
                    vm.$f7.dialog.alert("Servidor no disponible", 'Intente más tarde');
                });
            },
            getQuestionsBySurveyId(id) {
                let vm = this
                vm.$f7.dialog.preloader('Obteniendo datos...');

                this.$http.post(this.$store.state.application.config.api + 'questions/get', {
                    survey_id: id
                }).then(response => {
                    this.questions[id] = response.data
                    vm.$f7.dialog.close();
                    this.$forceUpdate();
                }, response => {
                    // error callback
                    vm.$f7.dialog.close();
                    vm.$f7.dialog.alert("Servidor no disponible", 'Intente más tarde');
                    console.log(response, 'error on getQuestionsBySurveyId');
                });
            },
            sendAnswerForm(question) {
                let type = question.type //BOOLEAN, TEXT, MULTI_CHOICE
                let title = question.body
                let answers = question.options
                let vm = this
                vm.$f7.dialog.preloader('Enviando datos...');

                this.$http.post(this.$store.state.application.config.api + 'question-answers/add', {
                    survey_id: vm.selectedQuestion.id,
                    type: type,
                    title: title,
                    answers: answers,
                }).then(response => {
                    vm.answerAddDialog = false
                    vm.$f7.dialog.close();
                    vm.$f7.dialog.alert("Pregunta y Respuestas agregadas", 'Éxito');
                }, response => {
                    // error callback
                    vm.answerAddDialog = false
                    vm.$f7.dialog.close();
                    vm.$f7.dialog.alert("Servidor no disponible", 'Intente más tarde');
                    console.log(response, 'error on sendAnswerForm');
                });
            },
            getList() {
                let vm = this
                vm.$f7.dialog.preloader('Obteniendo datos...');
                this.$http.post(this.$store.state.application.config.api + 'surveys/get').then(response => {
                    vm.$f7.dialog.close();
                    vm.surveys = response.data
                }, response => {
                    console.log(response, 'error on getList sueveys/get');
                    this.$f7.dialog.close();
                    this.$f7.dialog.alert("Servidor no disponible", 'Intente más tarde');
                });
            },
        },
        components: {SurveyBuilder, SurveyBuilderJson}
    }
</script>

<style scoped>

</style>