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
                <f7-col style="text-align: center">
                    <h1 style="margin:0">Reseña</h1>
                </f7-col>
            </f7-row>


            <f7-row style="margin-top: 40px">
                <f7-col style="text-align: center">
                    <strong>¿Cómo te atendieron?</strong><br/>
                    <span style="color:#6d6d72">5 Perfecto 0 Pésimo</span>
                </f7-col>
            </f7-row>
            <f7-row style="width: 80%; margin-left: 10%; margin-top: 10px">
                <f7-col style="text-align: center">
                    <f7-radio name="demo-radio-inline"></f7-radio>
                    <br/>
                    <span class="radio-color">1</span>
                </f7-col>
                <f7-col style="text-align: center">
                    <f7-radio name="demo-radio-inline"></f7-radio>
                    <br/>
                    <span class="radio-color">2</span>
                </f7-col>
                <f7-col style="text-align: center">
                    <f7-radio name="demo-radio-inline"></f7-radio>
                    <br/>
                    <span class="radio-color">3</span>
                </f7-col>
                <f7-col style="text-align: center">
                    <f7-radio name="demo-radio-inline"></f7-radio>
                    <br/>
                    <span class="radio-color">4</span>
                </f7-col>
                <f7-col style="text-align: center">
                    <f7-radio name="demo-radio-inline"></f7-radio>
                    <br/>
                    <span class="radio-color">5</span>
                </f7-col>
            </f7-row>

            <f7-row style="margin-top: 40px">
                <f7-col style="text-align: center">
                    <strong>¿Cómo te atendieron?</strong><br/>
                    <span style="color:#6d6d72">5 Perfecto 0 Pésimo</span>
                </f7-col>
            </f7-row>
            <f7-row style="width: 80%; margin-left: 10%; margin-top: 10px">
                <f7-col style="text-align: center">
                    <f7-radio name="demo-radio-inline"></f7-radio>
                    <br/>
                    <span class="radio-color">1</span>
                </f7-col>
                <f7-col style="text-align: center">
                    <f7-radio name="demo-radio-inline"></f7-radio>
                    <br/>
                    <span class="radio-color">2</span>
                </f7-col>
                <f7-col style="text-align: center">
                    <f7-radio name="demo-radio-inline"></f7-radio>
                    <br/>
                    <span class="radio-color">3</span>
                </f7-col>
                <f7-col style="text-align: center">
                    <f7-radio name="demo-radio-inline"></f7-radio>
                    <br/>
                    <span class="radio-color">4</span>
                </f7-col>
                <f7-col style="text-align: center">
                    <f7-radio name="demo-radio-inline"></f7-radio>
                    <br/>
                    <span class="radio-color">5</span>
                </f7-col>
            </f7-row>

            <f7-row style="margin-top: 40px">
                <f7-col style="text-align: center">
                    <strong>¿Cómo te atendieron?</strong><br/>
                    <span style="color:#6d6d72">Pregunta abierta</span>
                </f7-col>
            </f7-row>
            <f7-block style="text-align: center">
                <f7-list>
                    <f7-list-input
                            outline
                            type="textarea"
                            placeholder="Escriba aquí"
                    >
                    </f7-list-input>
                </f7-list>
            </f7-block>
        </f7-block>
        <f7-list style="padding-top: 20px;">
            <f7-button
                    class="btn-primary"
                    style="width: 50%; margin-left: 25%;" large>
                <f7-icon style="margin-top: -4px" material="done"></f7-icon>
                ENVIAR
            </f7-button>
        </f7-list>
    </f7-page>
</template>

<script>
    export default {
        name: "survey"
    }
</script>

<style scoped>
    .radio-color {
        color: #f16989;
    }
</style>