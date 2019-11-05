<template>
    <f7-page name="surveyAdd">
        <f7-navbar :sliding="true" back-link="Atrás" title="Añadir Encuesta">
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
                    <f7-list form style="margin: 15px;max-width: 100%;">
                        <f7-list-input
                                class="kingans-border"
                                label="Nombre de la encuesta"
                                placeholder="EJ: Satisfacción 2019"
                                type="text"
                                info="Obligatorio"
                                :value="items.name"
                                clear-button
                                validate
                                required
                                :error-message="'Campo Obligatorio'"
                                @input="items.name = $event.target.value"
                        ></f7-list-input>
                        <f7-list-input
                                class="kingans-border"
                                label="Descripción"
                                placeholder="EJ: Para contestar, ten en cuenta..."
                                type="textarea"
                                info="Obligatorio"
                                :value="items.description"
                                clear-button
                                validate
                                required
                                :error-message="'Campo Obligatorio'"
                                @input="items.description = $event.target.value"
                        ></f7-list-input>
                    </f7-list>
                    <f7-button style="margin: 15px"
                               class="btn-primary"
                               large @click="sendForm">
                        REGISTRAR ENCUESTA
                    </f7-button>
                </f7-card-content>
            </f7-card>
        </f7-block>
    </f7-page>
</template>

<script>
    export default {
        name: "surveyAdd",
        data() {
            return {
                items: {
                    name: '',
                    description: '',
                }
            }
        },
        mounted: function () {
        },
        methods: {
            checkForm() {
                let vm = this;
                let isValid = true;
                Object.keys(this.items).forEach(function (index, item) {
                    if (vm.items[index] === "") {
                        isValid = false
                    }
                });
                return isValid;
            },
            sendForm: function () {
                if (this.checkForm()) {
                    this.$f7.dialog.preloader('Enviando datos...');
                    this.$http.post(this.$store.state.application.config.api + 'surveys/add', {
                        name: this.items.name,
                        description: this.items.description,
                        created_by: this.$store.state.application.user.id,
                    }).then(response => {
                        this.$f7.dialog.close();
                        this.$f7.dialog.alert("Datos enviados", "Éxito");
                        this.items = {
                            name: '',
                            description: '',
                        }
                    }, response => {
                        console.log(response, 'error on checkForm surveys/add');
                        this.$f7.dialog.close();
                        this.$f7.dialog.alert("Servidor no disponible y/o Datos duplicados", 'Intente más tarde');
                    });

                } else {
                    this.$f7.dialog.alert("Todos los campos son requeridos.");
                }
            },
        },
    }
</script>

<style scoped>

</style>
