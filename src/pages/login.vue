<template>
    <f7-page no-toolbar no-navbar no-swipeback login-screen>
        <f7-statusbar></f7-statusbar>
        <f7-tabs swipeable>
            <f7-tab id="tab-login" class="page-content" tab-active>
                <f7-login-screen-title style="color: white">
                    <div style="width: 100%">
                        <img class="circle-image" style="width: 50%; margin-top: 40px" src="../assets/logoKingans.svg"/>
                    </div>
                </f7-login-screen-title>
                <f7-block>
                    <f7-list form style="
                background-color: rgba(255,255,255,1);

                margin: 15px;
                ">
                        <f7-list-input
                                class="kingans-border"
                                label="Móvil"
                                type="text"
                                placeholder="XXX XXX XX XX"
                                info="Códugo de usuario"
                                :value="phone"
                                clear-button
                                @input="phone = $event.target.value"
                        ></f7-list-input>
                        <f7-list-input
                                class="kingans-border"
                                label="Contraseña"
                                type="password"
                                placeholder="Contraseña"
                                clear-button
                                :value="password"
                                @input="password = $event.target.value"
                        ></f7-list-input>
                        <f7-link style="color: darkgrey;
                    text-align: center;
                    font-size: 0.8em;
                    margin-top: -23px;
                    position: absolute;"
                        >¿Olvidaste la Contraseña?
                        </f7-link>
                    </f7-list>
                </f7-block>
                <f7-list style="padding-top: 20px;">
                    <f7-button
                            class="btn-primary"
                            style="width: 50%; margin-left: 25%;"
                            large @click="logIn">
                        <f7-icon style="margin-top: -4px" material="person"></f7-icon>
                        INICIA SESIÓN
                    </f7-button>
                    <f7-button
                            class="btn-secondary"
                            style="width: 50%; margin-left: 25%;margin-top: 10px"
                            large tab-link="#tab-register">
                        <f7-icon style="margin-top: -4px" material="add"></f7-icon>
                        SUSCRÍBETE
                    </f7-button>
                    <f7-button
                            class="btn-secondary"
                            style="width: 50%; margin-left: 25%;margin-top: 10px"
                            large @click="">
                        <f7-icon style="margin-top: -4px" material="people"></f7-icon>
                        FACEBOOK
                    </f7-button>
                </f7-list>
            </f7-tab>
            <f7-tab id="tab-register" class="page-content">
                <f7-page>
                    <f7-toolbar style="background: #fff;" :position="'bottom'">
                        <f7-link tab-link="#tab-login">CANCELAR</f7-link>
                        <f7-link style="color:#f16989" @click="signIn">
                            <f7-icon style="margin-top: -4px" material="add"></f7-icon>
                            SUSCRIBIR
                        </f7-link>
                    </f7-toolbar>
                    <f7-block>
                        <f7-block>
                        <span style="font-size: 1.6em;color: black;">
                            Suscríbete
                        </span><br/>
                            <span>Cliente Frecuente</span>
                        </f7-block>
                        <f7-list form style="
                background-color: rgba(255,255,255,1);
                margin: 15px;">
                            <f7-list-input
                                    class="kingans-border"
                                    label="Teléfono"
                                    type="number"
                                    placeholder="XXX XXX XX XX"
                                    info="Códugo de usuario"
                                    :value="addUserForm.phone"
                                    clear-button
                                    @input="addUserForm.phone = $event.target.value"
                                    validate
                                    required
                                    :error-message="'Campo Obligatorio'"
                            ></f7-list-input>
                            <f7-list-input
                                    class="kingans-border"
                                    label="Nombre"
                                    placeholder="Nombre"
                                    type="text"
                                    :value="addUserForm.name"
                                    clear-button
                                    @input="addUserForm.name = $event.target.value"
                                    validate
                                    required
                                    :error-message="'Campo Obligatorio'"
                            ></f7-list-input>
                            <f7-list-input
                                    class="kingans-border"
                                    label="Correo"
                                    placeholder="Correo Electrónico"
                                    type="email"
                                    :value="addUserForm.email"
                                    clear-button
                                    @input="addUserForm.email = $event.target.value"
                                    validate
                                    required
                                    :error-message="'Campo Obligatorio'"
                            ></f7-list-input>
                            <f7-list-input
                                    class="kingans-border"
                                    label="Ciudad"
                                    type="select"
                                    placeholder="Seleccione una opción"
                                    :value="addUserForm.city"
                                    @input="addUserForm.city = $event.target.value"
                                    validate
                                    required
                                    :error-message="'Campo Obligatorio'"
                            >
                                <option value="Saltillo">Saltillo</option>
                                <option value="Torreón">Torreón</option>
                            </f7-list-input>
                            <f7-list-input
                                    class="kingans-border"
                                    label="Sexo"
                                    type="select"
                                    placeholder="Seleccione una opción"
                                    :value="addUserForm.gender"
                                    @input="addUserForm.gender = $event.target.value"
                                    validate
                                    required
                                    :error-message="'Campo Obligatorio'"
                            >
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                            </f7-list-input>
                            <f7-list-input
                                    label="Fecha de nacimiento"
                                    type="datepicker"
                                    placeholder="Selecciona una Fecha"
                                    clear-button
                                    @calendar:change="setCalendarSubscriberDate"
                                    validate
                                    required
                                    readonly
                                    :error-message="'Campo Obligatorio'"
                                    :calendar-params="calendarParams">
                            </f7-list-input>
                            <f7-list-input
                                    class="kingans-border"
                                    label="Contraseña"
                                    type="text"
                                    placeholder="**********"
                                    info="Contraseña"
                                    :value="addUserForm.password"
                                    clear-button
                                    @input="addUserForm.password = $event.target.value"
                                    validate
                                    required
                                    :error-message="'Campo Obligatorio'"
                            ></f7-list-input>

                        </f7-list>
                    </f7-block>
                </f7-page>
            </f7-tab>
        </f7-tabs>
    </f7-page>
</template>

<script>
    export default {
        name: 'login',
        data() {
            return {
                calendarParams: {
                    closeOnSelect: true,
                    header: true,
                    footer: false,
                    dateFormat: 'dd MM yyyy',
                },
                addUserForm: {
                    phone: '',
                    name: '',
                    email: '',
                    city: '',
                    gender: '',
                    birthday: '',
                    password: '',
                },
                phone: '',
                password: '',
            };
        },
        mounted: function(){
        },
        methods: {
            checkForm() {
                let vm = this;
                let isValid = true;
                Object.keys(this.addUserForm).forEach(function (index, item) {
                    if (vm.addUserForm[index] === "") {
                        isValid = false
                    }
                });
                return isValid;
            },
            setCalendarSubscriberDate: function (e) {
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

                this.addUserForm.birthday = [year, month, day].join('-');
            },
            logIn() {
                let vm = this;
                this.$f7.dialog.preloader('Iniciando Sesión')
                this.$http.post(this.$store.state.application.config.api + 'users/app/login', {
                    phone: this.phone,
                    password: this.password,
                }).then(response => {
                    this.$f7.dialog.close();
                    if (response.data.success === false || response.data === '') {
                        this.$f7.dialog.alert(' ', 'Nombre y/o Contraseña incorrecta(s)')
                        this.$f7.dialog.close();
                    } else {
                        vm.$store.commit('setLogin', false)
                        vm.$store.commit('setUser', response.data)
                        //this.$f7.dialog.alert(this.$store.state.application.user.name, 'Bienvenido', function () {
                        //    this.$store.state.application.drawer.login = false
                        //}.bind(this))
                    }
                }, response => {
                    console.log(response, 'error signIn login.vue')
                    this.$f7.dialog.alert(' ', 'Nombre y/o Contraseña incorrecta(s)')
                    this.$f7.dialog.close();
                });
            },
            signIn() {
                if (this.checkForm()) {
                    this.$f7.dialog.preloader('Enviando datos...');
                    this.$http.post(this.$store.state.application.config.api + 'users/app/add', {
                        name: this.addUserForm.name,
                        phone: this.addUserForm.phone,
                        email: this.addUserForm.email,
                        city: this.addUserForm.city,
                        gender: this.addUserForm.gender,
                        birthday: this.addUserForm.birthday,
                        password: this.addUserForm.password,
                    }).then(response => {
                        this.$f7.dialog.close();
                        this.$f7.dialog.alert("Registro completo, ahora puedes iniciar sesión.", "Éxito");
                        this.addUserForm = {
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
                        this.$f7.dialog.alert("Datos duplicados.", '¡Hola, revisa tus datos!');
                    });

                } else {
                    this.$f7.dialog.alert("Todos los campos son requeridos.");
                }
            },
        },
    };
</script>

<style scoped>

</style>