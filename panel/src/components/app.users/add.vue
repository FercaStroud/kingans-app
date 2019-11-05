<template>
    <f7-page name="appUsersAdd">
        <f7-navbar :sliding="true" back-link="Atrás" title="Añadir Usuario a la Aplicación">
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
                                placeholder="EJ: USER001"
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
                        <f7-list-input
                                class="kingans-border"
                                label="Teléfono del usuario"
                                placeholder="EJ: 8713351343"
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
                                label="Email del usuario"
                                placeholder="EJ: mail@kingans.com"
                                type="text"
                                info="Obligatorio"
                                :value="items.email"
                                clear-button
                                validate
                                required
                                :error-message="'Campo Obligatorio'"
                                @input="items.email = $event.target.value"
                        ></f7-list-input>
                        <f7-list-input
                                class="kingans-border"
                                label="Ciudad del usuario"
                                placeholder="EJ: Torreón"
                                type="text"
                                info="Obligatorio"
                                :value="items.city"
                                clear-button
                                validate
                                required
                                :error-message="'Campo Obligatorio'"
                                @input="items.city = $event.target.value"
                        ></f7-list-input>
                        <f7-list-input
                                class="kingans-border"
                                label="Sexo"
                                type="select"
                                info="Obligatorio"
                                :value="items.gender"
                                validate
                                required
                                :error-message="'Campo Obligatorio'"
                                @input="items.gender = $event.target.value"
                        >
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                        </f7-list-input>
                        <f7-list-input
                                class="kingans-border"
                                label="Contraseña"
                                type="password"
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
                        REGISTRAR USUARIO A LA APLICACIÓN
                    </f7-button>
                </f7-card-content>
            </f7-card>
        </f7-block>
    </f7-page>
</template>

<script>
    export default {
        name: "appUsersAdd",
        data() {
            return {
                calendarParams: {
                    closeOnSelect: true,
                    header: true,
                    footer: false,
                    dateFormat: 'dd MM yyyy',
                },
                items: {
                    name: '',
                    phone: '',
                    email: '',
                    city: '',
                    gender: '',
                    birthday: '',
                    password: '',
                }
            }
        },
        mounted: function () {
        },
        methods: {
            setCalendarDate: function (e) {
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

                this.items.birthday = [year, month, day].join('-');
            },
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
                    console.log(this.items)
                    this.$http.post(this.$store.state.application.config.api + 'users/app/add', {
                        name: this.items.name,
                        phone: this.items.phone,
                        email: this.items.email,
                        city: this.items.city,
                        gender: this.items.gender,
                        birthday: this.items.birthday,
                        password: this.items.password,
                        created_by: this.$store.state.application.user.id,
                    }).then(response => {
                        this.$f7.dialog.close();
                        this.$f7.dialog.alert("Datos enviados", "Éxito");
                        this.items = {
                            name: '',
                            phone: '',
                            email: '',
                            city: '',
                            gender: '',
                            birthday: '',
                            password: '',
                        }
                    }, response => {
                        console.log(response, 'error on checkForm users/app/add');
                        this.$f7.dialog.close();
                        this.$f7.dialog.alert("Servidor no  y/o Datos duplicados", 'Intente más tarde');
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
