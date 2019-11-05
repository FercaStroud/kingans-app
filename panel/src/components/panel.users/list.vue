<template>
    <f7-page name="panelUsersList">
        <f7-navbar :sliding="true" back-link="Atrás" title="Listado de Usuarios del Panel">
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
        <f7-block>
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
                        <f7-row>
                            <f7-col width="33" medium="25" v-for="(item, index) in filteredList" :key="index">
                                <f7-card>
                                    <f7-card-header>
                                        <span style="font-weight: bold">{{item.username}}</span>
                                        / <span>{{item.name}}</span>
                                    </f7-card-header>
                                    <f7-card-content>
                                        <strong>Tipo: </strong>
                                        <span v-if="item.type === 'A'">Administrador</span>
                                        <span v-if="item.type === 'G'">Gerente</span>
                                        <span v-if="item.type === 'S'">Supervisor</span><br/>
                                        <strong>Sucursal: </strong>
                                        <span v-if="item.branch != null">
                                            {{item.branch.name}}
                                        </span><br/>
                                        <strong>Ciudad: </strong>
                                        <span v-if="item.branch != null">
                                             {{item.branch.city}}
                                        </span><br/>
                                        <strong>Creado por: </strong>
                                        <span v-if="item.created_by != null">
                                            {{item.created_by.username}}
                                            / {{item.created_by.name}}
                                        </span>
                                        <strong>Actualizado por: </strong>
                                        <span v-if="item.updated_by != null">
                                            {{item.updated_by.username}}
                                            / {{item.updated_by.name}}
                                        </span>
                                    </f7-card-content>
                                    <f7-card-footer>
                                        <f7-link @click="editItem(item)">
                                            <f7-icon class="icon-btn" material="edit"></f7-icon>
                                        </f7-link>
                                        <f7-link @click="deleteItem(item.id)">
                                            <f7-icon class="icon-btn" material="delete"></f7-icon>
                                        </f7-link>
                                    </f7-card-footer>
                                </f7-card>
                            </f7-col>
                        </f7-row>
                    </f7-block>
                </f7-card-content>
            </f7-card>
        </f7-block>
        <f7-popup class="" :opened="popupEditOpened" @popup:closed="popupEditOpened = false">
            <f7-page>
                <f7-navbar :title="'Editar usuario / panel: ' + itemToEdit.name">
                    <f7-nav-right>
                        <f7-link popup-close>Cancelar</f7-link>
                    </f7-nav-right>
                </f7-navbar>
                <f7-block>
                    <f7-card>
                        <f7-card-content>
                            <f7-list form style="margin: 15px;">
                                <f7-list-input
                                        class="kingans-border"
                                        label="Nombre de usuario"
                                        placeholder="EJ: ADMIN001"
                                        type="text"
                                        info="Obligatorio"
                                        :value="itemToEdit.name"
                                        clear-button
                                        validate
                                        required
                                        :error-message="'Campo Obligatorio'"
                                        @input="itemToEdit.name = $event.target.value"
                                ></f7-list-input>
                                <f7-list-input
                                        class="kingans-border"
                                        label="Nombre del usuario"
                                        placeholder="EJ: Lucas K."
                                        type="text"
                                        info="Obligatorio"
                                        :value="itemToEdit.username"
                                        clear-button
                                        validate
                                        required
                                        :error-message="'Campo Obligatorio'"
                                        @input="itemToEdit.username = $event.target.value"
                                ></f7-list-input>
                                <f7-list-input
                                        class="kingans-border"
                                        label="Sucursal"
                                        type="select"
                                        info="Obligatorio"
                                        placeholder="Sucursal"
                                        :value="itemToEdit.branchId"
                                        validate
                                        required
                                        :error-message="'Campo Obligatorio'"
                                        @input="itemToEdit.branchId = $event.target.value"
                                >
                                    <option v-for="(branch, index) in branches" :key="index"
                                            :value="branch.id">{{branch.name}}
                                    </option>
                                </f7-list-input>
                                <f7-list-input
                                        class="kingans-border"
                                        label="Tipo"
                                        type="select"
                                        info="Obligatorio"
                                        placeholder="Tipo de usuario"
                                        :value="itemToEdit.type"
                                        validate
                                        required
                                        :error-message="'Campo Obligatorio'"
                                        @input="itemToEdit.type = $event.target.value"
                                >
                                    <option value="A">Administrador</option>
                                    <option value="G">Gerente</option>
                                    <option value="S">Supervisor</option>
                                </f7-list-input>

                            </f7-list>
                            <f7-button style="margin: 15px"
                                       class="btn-primary"
                                       large @click="sendForm">
                                EDITAR SUCURSAL
                            </f7-button>
                        </f7-card-content>
                    </f7-card>

                </f7-block>
            </f7-page>
        </f7-popup>

    </f7-page>
</template>

<script>
    export default {
        name: "panelUsersList",
        data() {
            return {
                branches: [],
                popupEditOpened: false,
                search: '',
                itemToEdit: {type: '', branchId: '', username: '', name: ''},
                items: []
            }
        },
        computed: {
            filteredList() {
                return this.items.filter(item => {
                    return item.name.toLowerCase().includes(this.search.toLowerCase())
                })
            },
        },
        mounted: function () {
            this.getList()
            this.getBranches()
        },
        methods: {
            checkForm() {
                let vm = this;
                let isValid = true;
                Object.keys(this.itemToEdit).forEach(function (index, item) {
                    if (vm.itemToEdit[index] === "") {
                        isValid = false
                    }
                });
                return isValid;
            },
            sendForm: function () {
                let vm = this
                if (this.checkForm()) {
                    this.$f7.dialog.preloader('Enviando datos...');

                    this.$http.post(this.$store.state.application.config.api + 'users/panel/edit', {
                        id: this.itemToEdit.id,
                        type: this.itemToEdit.type,
                        branch_id: this.itemToEdit.branchId,
                        username: this.itemToEdit.username,
                        name: this.itemToEdit.name,
                        updated_by: this.$store.state.application.user.id
                    }).then(response => {
                        vm.$f7.dialog.close();
                        vm.$f7.dialog.alert("Datos enviados", "Éxito");
                        vm.itemToEdit = {
                            type: '', branchId: '', username: '', name: ''
                        }
                        vm.popupEditOpened = false;
                        vm.$f7.dialog.close();

                        vm.getList();
                    }, response => {
                        console.log(response, 'error on sendForm users/panel/edit');
                        vm.$f7.dialog.close();
                        vm.$f7.dialog.alert("Servidor no disponible", 'Intente más tarde');
                    });

                } else {
                    this.$f7.dialog.alert("Todos los campos son requeridos.");
                }
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
            getList() {
                let vm = this
                vm.$f7.dialog.preloader('Obteniendo datos...');
                this.$http.post(this.$store.state.application.config.api + 'users/panel/get').then(response => {
                    vm.$f7.dialog.close();
                    vm.items = response.data
                }, response => {
                    console.log(response, 'error on getList users/panel/get');
                    this.$f7.dialog.close();
                    this.$f7.dialog.alert("Servidor no disponible", 'Intente más tarde');
                });
            },
            editItem(item) {
                this.itemToEdit = item;
                this.popupEditOpened = true;
            },
            deleteItem(id) {
                let vm = this;

                vm.$f7.dialog.preloader('Enviando datos...');
                this.$http.post(this.$store.state.application.config.api + 'users/panel/delete', {
                    id: id
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
                    console.log(response, 'error on checkForm branches/add');
                    this.$f7.dialog.close();
                    this.$f7.dialog.alert("Servidor no disponible", 'Intente más tarde');
                });
            },
        },
    }
</script>

<style scoped>

</style>
