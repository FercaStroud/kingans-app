<template>
    <f7-page name="branchesAdd">
        <f7-navbar :sliding="true" back-link="Atrás" title="Añadir Sucursal">
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
                    <f7-list form style="margin: 15px;">
                        <f7-list-input
                                class="kingans-border"
                                label="Nombre de la sucursal"
                                placeholder="EJ: Colón"
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
                                label="Ciudad"
                                type="text"
                                placeholder="EJ: Torreón"
                                info="Obligatorio"
                                :value="items.city"
                                validate
                                required
                                :error-message="'Campo Obligatorio'"
                                clear-button
                                @input="items.city = $event.target.value"
                        ></f7-list-input>
                        <f7-list-input
                                class="kingans-border"
                                label="Dirección"
                                placeholder="EJ: C. Falsa, #123."
                                type="text"
                                info="Obligatorio"
                                :value="items.address"
                                clear-button
                                validate
                                required
                                :error-message="'Campo Obligatorio'"
                                @input="items.address = $event.target.value"
                        ></f7-list-input>
                        <f7-list-input
                                class="kingans-border"
                                label="Teléfono"
                                placeholder="EJ: +520011223344"
                                type="text"
                                info="Obligatorio"
                                :value="items.phone"
                                clear-button
                                validate
                                required
                                :error-message="'Campo Obligatorio'"
                                @input="items.phone = $event.target.value"
                        ></f7-list-input>
                        <f7-list-input
                                class="kingans-border"
                                label="Horarios"
                                placeholder="EJ: L-V 00:00Hrs - 00:00Hrs / S-D 00:00Hrs - 00:00Hrs"
                                type="text"
                                info="Obligatorio"
                                :value="items.scheduling"
                                clear-button
                                validate
                                required
                                :error-message="'Campo Obligatorio'"
                                @input="items.scheduling = $event.target.value"
                        ></f7-list-input>
                        <f7-list-input
                                class="kingans-border"
                                label="Facebook URL"
                                placeholder="EJ: https://..."
                                type="text"
                                info="Obligatorio"
                                :value="items.facebook"
                                clear-button
                                validate
                                required
                                :error-message="'Campo Obligatorio'"
                                @input="items.facebook = $event.target.value"
                        ></f7-list-input>
                        <f7-list-input
                                class="kingans-border"
                                label="GMaps URL"
                                placeholder="EJ: https://..."
                                type="text"
                                info="Obligatorio"
                                :value="items.map"
                                clear-button
                                validate
                                required
                                :error-message="'Campo Obligatorio'"
                                @input="items.map = $event.target.value"
                        ></f7-list-input>
                        <input type="file" ref="file"
                               accept="image/*"
                               required
                               @change="onChangeFileUpload"/>
                    </f7-list>
                    <f7-button style="margin: 15px"
                               class="btn-primary"
                               large @click="sendForm">
                        REGISTRAR SUCURSAL
                    </f7-button>
                </f7-card-content>
            </f7-card>
        </f7-block>
    </f7-page>
</template>

<script>
    export default {
        name: "branchesAdd",
        data: function () {
            return {
                items: {
                    name: '',
                    city: '',
                    address: '',
                    phone: '',
                    scheduling: '',
                    map: '',
                    facebook: '',
                    svg: ''
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

                    let formData = new FormData();
                    formData.append('name', this.items.name);
                    formData.append('city', this.items.city);
                    formData.append('address', this.items.address);
                    formData.append('phone', this.items.phone);
                    formData.append('scheduling', this.items.start);
                    formData.append('map', this.items.map);
                    formData.append('facebook', this.items.facebook);
                    formData.append('svg', this.items.svg);
                    formData.append('created_by', this.$store.state.application.user.id);

                    this.$http.post(this.$store.state.application.config.api + 'branches/add', formData).then(response => {
                        this.$f7.dialog.close();
                        this.$f7.dialog.alert("Datos enviados", "Éxito");
                        this.items = {
                            name: '', city: '', address: '',
                            phone: '', scheduling: '',
                            map: '', facebook: '', svg: ''
                        }
                    }, response => {
                        console.log(response, 'error on checkForm branches/add');
                        this.$f7.dialog.close();
                        this.$f7.dialog.alert("Servidor no disponible", 'Intente más tarde');
                    });

                } else {
                    this.$f7.dialog.alert("Todos los campos son requeridos.");
                }
            },
            onChangeFileUpload: function () {
                this.items.svg = this.$refs.file.files[0];
            }
        },
    }
</script>

<style scoped>

</style>