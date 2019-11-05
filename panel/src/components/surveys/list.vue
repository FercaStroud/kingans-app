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
                    <f7-button>
                        <f7-icon style="margin-right: 10px;" material="playlist_add"></f7-icon>
                        Añadir Respuesta
                    </f7-button>
                </f7-card-header>
                <f7-card-content>
                    <p>
                        {{item.description}}
                    </p>
                    <!--<f7-row>
                        <f7-col width="33">
                            Pregunta 1: ¿Pregunta 1?
                            <apexchart type=pie :options="chartOptions" :series="series"/>
                        </f7-col>
                        <f7-col width="33">
                            Pregunta 2: ¿Pregunta 2?
                            <apexchart type=pie :options="chartOptions" :series="series"/>
                        </f7-col>
                        <f7-col width="33">
                            Pregunta 3: ¿Pregunta 3?
                            <apexchart type=pie :options="chartOptions" :series="series"/>
                        </f7-col>
                        <f7-col width="33">
                            Pregunta 1: ¿Pregunta 1?
                            <apexchart type=pie :options="chartOptions" :series="series"/>
                        </f7-col>
                        <f7-col width="33">
                            Pregunta 2: ¿Pregunta 2?
                            <apexchart type=pie :options="chartOptions" :series="series"/>
                        </f7-col>
                        <f7-col width="33">
                            Pregunta 3: ¿Pregunta 3?
                            <apexchart type=pie :options="chartOptions" :series="series"/>
                        </f7-col>
                    </f7-row>-->
                </f7-card-content>
                <f7-card-footer class="no-border">
                    <f7-button>
                        <f7-icon style="margin-right: 10px;" material="visibility"></f7-icon>
                        Ver Respuestas
                    </f7-button>
                    <f7-button>
                        <f7-icon style="margin-right: 10px;" material="equalizer"></f7-icon>
                        Obtener Resultados
                    </f7-button>
                    <f7-button>
                        <f7-icon style="margin-right: 10px;" material="play_circle_filled"></f7-icon>
                        Habilitar
                    </f7-button>
                    <!--<f7-button>
                        <f7-icon style="margin-right: 10px;" material="pause_circle_filled"></f7-icon>
                        Deshabilitar
                    </f7-button>-->
                    <f7-button>
                        <f7-icon style="margin-right: 10px;" material="cloud_download"></f7-icon>
                        Descargar Excel
                    </f7-button>
                </f7-card-footer>
            </f7-card>
        </f7-row>
    </f7-page>
</template>

<script>
    export default {
        name: "surveyList",
        data() {
            return {
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
        mounted: function () {
            this.getList()
        },
        methods: {
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
        }
    }
</script>

<style scoped>

</style>