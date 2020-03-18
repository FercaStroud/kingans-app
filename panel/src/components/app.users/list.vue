<template>
    <f7-page name="appUsersList">
        <f7-navbar :sliding="true" back-link="Atrás" title="Listado de Usuarios de la Aplicación">
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
                                        <span style="font-weight: bold">{{item.phone}}</span>
                                        / <span>{{item.name}}</span>
                                    </f7-card-header>
                                    <f7-card-content>
                                        <strong>Email: </strong>
                                        <span>{{item.email}}</span><br/>
                                        <strong>Ciudad: </strong>
                                        <span>
                                            {{item.city}}
                                        </span><br/>
                                        <strong>Sexo: </strong>
                                        <span>
                                             {{item.gender}}
                                        </span><br/>
                                        <strong style="font-size: .7em">YYYY/MM/DD:</strong><br/>
                                        <strong>Cumpleaños: </strong>
                                        <span>
                                            {{dateStringMX(item.birthday)}}
                                        </span><br/>
                                        <strong>Creado por: </strong>
                                        <span v-if="item.created_by != null">
                                            {{item.created_by.username}}
                                            / {{item.created_by.name}}
                                        </span><br/>
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
                                        <f7-link @click="openPasswordDialog(item.id)">
                                            <f7-icon class="icon-btn" material="lock"></f7-icon>
                                        </f7-link>
                                        <f7-link @click="openBirthdayDialog(item.id)">
                                            <f7-icon class="icon-btn" material="event"></f7-icon>
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
                <f7-navbar :title="'Editar usuario / Aplicación: ' + itemToEdit.name">
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
                                        placeholder="EJ: USER001"
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
                                        label="Teléfono del usuario"
                                        placeholder="EJ: 8713351343"
                                        type="text"
                                        info="Obligatorio"
                                        :value="itemToEdit.phone"
                                        clear-button
                                        validate
                                        required
                                        :error-message="'Campo Obligatorio'"
                                        @input="itemToEdit.phone = $event.target.value"
                                ></f7-list-input>
                                <f7-list-input
                                        class="kingans-border"
                                        label="Email del usuario"
                                        placeholder="EJ: mail@kingans.com"
                                        type="text"
                                        info="Obligatorio"
                                        :value="itemToEdit.email"
                                        clear-button
                                        validate
                                        required
                                        :error-message="'Campo Obligatorio'"
                                        @input="itemToEdit.email = $event.target.value"
                                ></f7-list-input>
                                <f7-list-input
                                        class="kingans-border"
                                        label="Ciudad del usuario"
                                        placeholder="EJ: Torreón"
                                        type="text"
                                        info="Obligatorio"
                                        :value="itemToEdit.city"
                                        clear-button
                                        validate
                                        required
                                        :error-message="'Campo Obligatorio'"
                                        @input="itemToEdit.city = $event.target.value"
                                ></f7-list-input>
                                <f7-list-input
                                        class="kingans-border"
                                        label="Sexo"
                                        type="select"
                                        info="Obligatorio"
                                        :value="itemToEdit.gender"
                                        validate
                                        required
                                        :error-message="'Campo Obligatorio'"
                                        @input="itemToEdit.gender = $event.target.value"
                                >
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </f7-list-input>

                            </f7-list>
                            <f7-button style="margin: 15px"
                                       class="btn-primary"
                                       large @click="sendForm">
                                EDITAR USUARIO
                            </f7-button>
                        </f7-card-content>
                    </f7-card>

                </f7-block>
            </f7-page>
        </f7-popup>
        <f7-popup class="" :opened="passwordDialog" @popup:closed="passwordDialog = false">
            <f7-page>
                <f7-navbar title="Editar Contraseña">
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
                                        label="Nueva Contraseña"
                                        placeholder="Pass51w00rd1"
                                        type="text"
                                        info="Obligatorio"
                                        :value="tempItem.password"
                                        clear-button
                                        validate
                                        required
                                        :error-message="'Campo Obligatorio'"
                                        @input="tempItem.password = $event.target.value"
                                ></f7-list-input>
                            </f7-list>
                        </f7-card-content>
                    </f7-card>
                    <f7-button
                            class="btn-primary"
                            style="width: 50%; margin-left: 25%;"
                            large @click="updatePassword">
                        GUARDAR CONTRASEÑA
                    </f7-button>
                </f7-block>
            </f7-page>
        </f7-popup>
        <f7-popup class="" :opened="birthdayDialog" @popup:closed="birthdayDialog = false">
            <f7-page>
                <f7-navbar title="Editar Cumpleaños">
                    <f7-nav-right>
                        <f7-link popup-close>Cancelar</f7-link>
                    </f7-nav-right>
                </f7-navbar>
                <f7-block>
                    <f7-card>
                        <f7-card-content>
                            <f7-list form style="margin: 15px;">
                                <f7-list-input
                                        label="Fecha de nacimiento"
                                        type="datepicker"
                                        placeholder="Selecciona una Fecha"
                                        clear-button
                                        @calendar:change="setCalendarDate"
                                        validate
                                        required
                                        readonly
                                        :error-message="'Campo Obligatorio'"
                                        :calendar-params="calendarParams">
                                </f7-list-input>
                            </f7-list>
                        </f7-card-content>
                    </f7-card>
                    <f7-button
                            class="btn-primary"
                            style="width: 50%; margin-left: 25%;"
                            large @click="updateBirthday">
                        GUARDAR FECHA DE NACIMIENTO
                    </f7-button>
                </f7-block>
            </f7-page>
        </f7-popup>

    </f7-page>
</template>

<script>
    export default {
        name: "appUsersList",
        data() {
            return {
                tempItem: {password: '', id: '', birthday: ''},
                passwordDialog: false,
                birthdayDialog: false,
                setBirthday: null,
                calendarParams: {
                    closeOnSelect: true,
                    header: true,
                    footer: false,
                    dateFormat: 'dd MM yyyy',
                },
                items: [],
                popupEditOpened: false,
                search: '',
                itemToEdit: {
                    name: '',
                    phone: '',
                    email: '',
                    city: '',
                    gender: '',
                    password: '',
                },
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
        },
        methods: {
            dateStringMX: function (arg) {
                let months = [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre",
                ];

                let date = new Date(
                    String(arg).replace(/-/g, "/")
                );

                let day = date.getDate();
                let month = months[date.getMonth()];
                let year = date.getFullYear();

                if (day.length < 2) {
                    day = '0' + day.toString();
                }

                if (month !== undefined) {
                    return String(month) + " " + String(day) + " del " + String(year);
                } else {
                    return "Sin registro."
                }
            },
            getDateSQLFormat(e) {
                let d = new Date(e);
                let month = '' + (d.getMonth() + 1);
                let day = '' + d.getDate();
                let year = d.getFullYear();

                if (month.length < 2) {
                    month = '0' + month;
                }
                if (day.length < 2) {
                    day = '0' + day;
                }
                return [year, month, day].join('-');
            },
            setCalendarDate: function (e) {
                this.tempItem.birthday = this.getDateSQLFormat(e);
            },
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

                    this.$http.post(this.$store.state.application.config.api + 'users/app/edit', {
                        id: this.itemToEdit.id,
                        name: this.itemToEdit.name,
                        phone: this.itemToEdit.phone,
                        email: this.itemToEdit.email,
                        city: this.itemToEdit.city,
                        gender: this.itemToEdit.gender,
                        //birthday: this.itemToEdit.birthday,
                        password: this.itemToEdit.password,
                        updated_by: this.$store.state.application.user.id
                    }).then(response => {
                        vm.$f7.dialog.close();
                        vm.$f7.dialog.alert("Datos enviados", "Éxito");
                        vm.itemToEdit = {
                            name: '',
                            phone: '',
                            email: '',
                            city: '',
                            gender: '',
                            password: '',
                        }
                        vm.popupEditOpened = false;
                        vm.$f7.dialog.close();

                        vm.getList();
                    }, response => {
                        console.log(response, 'error on sendForm users/app/edit');
                        vm.$f7.dialog.close();
                        vm.$f7.dialog.alert("Servidor no disponible", 'Intente más tarde');
                    });

                } else {
                    this.$f7.dialog.alert("Todos los campos son requeridos.");
                }
            },
            getList() {
                let vm = this
                vm.$f7.dialog.preloader('Obteniendo datos...');
                this.$http.post(this.$store.state.application.config.api + 'users/app/get').then(response => {
                    vm.$f7.dialog.close();
                    vm.items = response.data
                }, response => {
                    console.log(response, 'error on getList users/app/get');
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
                this.$http.post(this.$store.state.application.config.api + 'users/app/delete', {
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
                    console.log(response, 'error on checkForm users/delete');
                    this.$f7.dialog.close();
                    this.$f7.dialog.alert("Servidor no disponible", 'Intente más tarde');
                });
            },
            openPasswordDialog(id) {
                this.tempItem.id = id;
                this.passwordDialog = true;
            },
            openBirthdayDialog(id) {
                this.tempItem.id = id;
                this.birthdayDialog = true;
            },
            updatePassword() {
                let vm = this;
                if (vm.tempItem.password === '') {
                    vm.$f7.dialog.alert("", 'Todos los campos son requeridos.');
                } else {
                    vm.$f7.dialog.preloader('Enviando datos...');

                    this.$http.post(this.$store.state.application.config.api + 'users/panel/edit/password', {
                        id: vm.tempItem.id,
                        password: vm.tempItem.password,
                    }).then(response => {
                        vm.$f7.dialog.close();
                        vm.passwordDialog = false;
                        if (response.data.id !== undefined) {
                            vm.$f7.dialog.alert("Usuario modificado", 'Éxito');
                        } else {
                            vm.$f7.dialog.alert("Error desconocido", 'Intente más tarde');
                        }
                        vm.tempItem = {
                            id: '', password: '', birthday: ''
                        }

                        vm.$f7.dialog.close();
                        vm.passwordDialog = false;

                        //this.items = response.data
                    }, response => {
                        console.log(response, 'error on checkForm users/app/edit/password');
                        this.$f7.dialog.close();
                        this.$f7.dialog.alert("Servidor no disponible", 'Intente más tarde');
                    });
                }
            },
            updateBirthday() {
                let vm = this;
                if (vm.tempItem.birthday === '') {
                    vm.$f7.dialog.alert("", 'Todos los campos son requeridos.');
                } else {
                    vm.$f7.dialog.preloader('Enviando datos...');
                    this.$http.post(this.$store.state.application.config.api + 'users/app/edit/birthday', {
                        id: this.tempItem.id,
                        birthday: this.tempItem.birthday
                    }).then(response => {
                        vm.$f7.dialog.close();
                        vm.birthdayDialog = false;
                        if (response.data.id !== undefined) {
                            vm.$f7.dialog.alert("Usuario modificado", 'Éxito');
                        } else {
                            vm.$f7.dialog.alert("Error desconocido", 'Intente más tarde');
                        }
                        vm.tempItem = {
                            id: '', password: '', birthday: ''
                        }

                        //this.items = response.data
                    }, response => {
                        console.log(response, 'error on checkForm branches/add');
                        this.$f7.dialog.close();
                        this.$f7.dialog.alert("Servidor no disponible", 'Intente más tarde');
                    });
                }
            },

        },
    }
</script>

<style scoped>

</style>
