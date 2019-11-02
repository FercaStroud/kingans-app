<template>
    <f7-page name="panelUsersAdd">
        <f7-navbar :sliding="true" back-link="Atrás" title="Añadir Usuario al Panel">
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
                                label="Nombre de usuario"
                                placeholder="EJ: ADMIN001"
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
                                label="Nombre del usuario"
                                placeholder="EJ: Lucas K."
                                type="text"
                                info="Obligatorio"
                                :value="items.username"
                                clear-button
                                validate
                                required
                                :error-message="'Campo Obligatorio'"
                                @input="items.username = $event.target.value"
                        ></f7-list-input>
                        <f7-list-input
                                class="kingans-border"
                                label="Sucursal"
                                type="select"
                                info="Obligatorio"
                                placeholder="Sucursal"
                                :value="items.branchId"
                                validate
                                required
                                :error-message="'Campo Obligatorio'"
                                @input="items.branchId = $event.target.value"
                        >
                            <option v-for="(branch, index) in branches" :key="index"
                                    value="branch.id">{{branch.name}}</option>
                        </f7-list-input>
                        <f7-list-input
                                class="kingans-border"
                                label="Tipo"
                                type="select"
                                info="Obligatorio"
                                placeholder="Tipo de usuario"
                                :value="items.type"
                                validate
                                required
                                :error-message="'Campo Obligatorio'"
                                @input="items.type = $event.target.value"
                        >
                            <option value="A">Administrador</option>
                            <option value="G">Gerente</option>
                            <option value="S">Supervisor</option>
                        </f7-list-input>
                        <f7-list-input
                                class="kingans-border"
                                label="Contraseña"
                                type="text"
                                placeholder="**********"
                                info="Obligatorio"
                                :value="items.password"
                                clear-button
                                validate
                                required
                                :error-message="'Campo Obligatorio'"
                                @input="items.password = $event.target.value"
                        ></f7-list-input>
                    </f7-list>
                    <f7-button style="margin: 15px"
                               class="btn-primary"
                               large @click="sendForm">
                        REGISTRAR USUARIO AL PANEL
                    </f7-button>
                </f7-card-content>
            </f7-card>
        </f7-block>
    </f7-page>
</template>

<script>
    export default {
        name: "panelUsersAdd",
        data() {
            return {
                branches:[],
                items: {
                    username: '',
                    name: '',
                    branchId: '',
                    type: '',
                    password: '',
                }
            }
        },
        mounted: function () {
            this.getBranches()
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
            getBranches() {
                let vm = this
                vm.$f7.dialog.preloader('Obteniendo datos...');
                this.$http.post(this.$store.state.application.config.api + 'branches/get').then(response => {
                    vm.$f7.dialog.close();
                    vm.branches = response.data
                }, response => {
                    console.log(response, 'error on getBranches branches/get');
                    this.$f7.dialog.close();
                    this.$f7.dialog.alert("Servidor no disponible", 'Intente más tarde');
                });
            },
            sendForm: function () {
                if (this.checkForm()) {
                    this.$f7.dialog.preloader('Enviando datos...');

                    this.$http.post(this.$store.state.application.config.api + 'users/panel/add', {
                        username: this.items.username,
                        name: this.items.name,
                        branch_id: this.items.branchId,
                        type: this.items.type,
                        password: this.items.password,
                    }).then(response => {
                        this.$f7.dialog.close();
                        this.$f7.dialog.alert("Datos enviados", "Éxito");
                        this.items = {
                            username: '', name: '',
                            branchId: '', type: '',
                            password: '',
                        }
                    }, response => {
                        console.log(response, 'error on checkForm users/panel/add');
                        this.$f7.dialog.close();
                        this.$f7.dialog.alert("Servidor no disponible", 'Intente más tarde');
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
