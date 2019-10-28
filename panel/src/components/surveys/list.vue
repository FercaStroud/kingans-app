<template>
    <f7-page name="surveys">
        <f7-navbar :sliding="true" back-link="Atrás" title="Encuestas">
            <f7-nav-right>
                <f7-link icon-ios="f7:menu"
                         icon-aurora="f7:menu"
                         icon-md="material:menu"
                         panel-open="left">
                </f7-link>
            </f7-nav-right>
        </f7-navbar>
        <f7-block>
            <f7-card>
                <f7-card-content>
                    <strong>Título de la encuesta de prueba</strong>
                    <p>
                        Nos gustaría saber tu opinión. Aquí va una descripción con lorem ipsum
                        dolor sit amet.
                    </p>
                    <f7-row>
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
                    </f7-row>
                </f7-card-content>
                <f7-card-footer class="no-border">
                    <f7-button>
                        <f7-icon style="margin-right: 10px;" material="cloud_download"></f7-icon>
                        Descargar Respuestas
                    </f7-button>
                </f7-card-footer>
            </f7-card>
        </f7-block>
    </f7-page>
</template>

<script>
    export default {
        name: "surveyList",
        data() {
            return {
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
        }
    }
</script>

<style scoped>

</style>