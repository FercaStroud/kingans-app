<template>
    <f7-page no-toolbar no-navbar no-swipeback>
        <f7-statusbar></f7-statusbar>
        <f7-block>
            <f7-row>
                <f7-col style="text-align:center">
                    <img class="circle-image" style="width: 50%; margin-top: 40px"
                         src="../assets/logoKingans.svg"
                    />
                </f7-col>
            </f7-row>
        </f7-block>
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
                        info="Código de usuario"
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
                <f7-link @click="resetPasswordPupopOpened = true"
                         style="color: darkgrey;
                    text-align: center;
                    font-size: 0.8em;
                    margin-top: -23px;
                    position: absolute;">
                    ¿Olvidaste la Contraseña?
                </f7-link>
            </f7-list>
        </f7-block>
        <f7-list style="padding-top: 20px;">
            <f7-button
                    class="btn-primary"
                    style="width: 50%; margin-left: 25%;"
                    large @click="logIn">
                <f7-icon style="margin-top: -4px" material="person"></f7-icon>
                Inicia Sesión
            </f7-button>
            <f7-button
                    class="btn-secondary"
                    style="width: 50%; margin-left: 25%;margin-top: 10px"
                    large
                    fill @click="signInPupopOpened = true">
                <f7-icon style="margin-top: -4px" material="add"></f7-icon>
                Regístrate
            </f7-button>
            <!--<f7-button
                    class="btn-secondary"
                    style="width: 50%; margin-left: 25%;margin-top: 10px"
                    large @click="">
                <f7-icon style="margin-top: -4px" material="people"></f7-icon>
                FACEBOOK
            </f7-button>-->
        </f7-list>
        <f7-popup class="signin-popup" :tablet-fullscreen="true"
                  :opened="signInPupopOpened" @popup:closed="signInPupopOpened = false">
            <f7-page>
                <f7-navbar no-shadow no-hairline>
                    <f7-nav-left>
                        <f7-link popup-close>¿Ya tienes cuenta?</f7-link>
                    </f7-nav-left>
                    <f7-nav-title>
                        <img style="height: 47px" src="../assets/logoKingans.svg">
                    </f7-nav-title>
                    <f7-nav-right>
                        <f7-link @click="signIn">
                            ¡Regístrame!
                        </f7-link>
                    </f7-nav-right>
                </f7-navbar>
                <f7-block>
                    <f7-block>
                        ¡Hola!, regístrate con nosotros para empezar a generar puntos como
                        <strong>cliente frecuente</strong>.
                    </f7-block>
                    <f7-list form style="
                background-color: rgba(255,255,255,1);
                margin: 15px;">
                        <f7-list-input
                                class="kingans-border"
                                label="* Teléfono"
                                type="number"
                                placeholder="XXX XXX XX XX"
                                info="Código de usuario"
                                :value="addUserForm.phone"
                                clear-button
                                @input="addUserForm.phone = $event.target.value"
                                validate
                                required
                                :error-message="'Campo Obligatorio'"
                        ></f7-list-input>
                        <f7-list-input
                                class="kingans-border"
                                label="* Nombre"
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
                                label="* Correo"
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
                                v-if="this.$device.ios"
                                class="kingans-border"
                                label="Sexo"
                                type="select"
                                placeholder="Seleccione una opción"
                                :value="addUserForm.gender"
                                @input="addUserForm.gender = $event.target.value"
                        >
                            <option value="N">Seleccione una opción</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                        </f7-list-input>
                        <f7-list-input
                                v-else
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
                                v-if="this.$device.ios"
                                class="kingans-border"
                                label="Fecha de nacimiento"
                                type="datepicker"
                                placeholder="Selecciona una Fecha"
                                clear-button
                                @calendar:change="setCalendarSubscriberDate"
                                readonly
                                :calendar-params="calendarParams">
                        </f7-list-input>
                        <f7-list-input
                                v-else
                                class="kingans-border"
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
                                label="* Contraseña"
                                type="password"
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
                    <f7-block>
                        Nos interesa saber tu <strong>fecha de cumpleaños</strong> y tu
                        <strong>sexo</strong> para mandarte cupones de promoción personalizados.
                    </f7-block>
                    <f7-block>
                        Aunque estás en tu derecho de no compartirlos con nosotros. Para más información visita <strong
                            class="active">www.kingans.com</strong>
                    </f7-block>
                </f7-block>
                <!--<f7-block>
                    <f7-button
                            class="btn-secondary"
                            style="width: 50%; margin-left: 25%;margin-top: 10px"
                            large @click="signInWithFbApi">
                        <f7-icon style="margin-top: -4px" material="people"></f7-icon>
                        Regístrate con Facebook
                    </f7-button>
                </f7-block>-->
            </f7-page>
        </f7-popup>

        <f7-popup :tablet-fullscreen="true"
                  class="reset-password" :opened="resetPasswordPupopOpened"
                  @popup:closed="resetPasswordPupopOpened = false">
            <f7-page>
                <f7-navbar no-shadow no-hairline>
                    <f7-nav-left>
                        <f7-link popup-close>Cerrar</f7-link>
                    </f7-nav-left>
                    <f7-nav-title>
                        <img style="height: 25px" src="../assets/kingansWhite.svg">
                    </f7-nav-title>
                </f7-navbar>
                <f7-block>
                    <f7-block>
                        <p style="text-align:center">
                            <strong>¡Hola!</strong>,
                            lamentamos que hayas olvidado tus accesos &#x1F614;.
                        </p>
                        <p style="text-align:center">
                            Te enviaremos una contraseña temporal al correo con el cual te registraste.
                            <strong>Recuerda cambiarla</strong> en la sección de
                            <span style="font-weight: bold" class="active">"Mi Perfil"</span>
                            una vez hayas iniciado sesión.
                        </p>
                        <p style="text-align:center">
                            Si tienes algún problema, visita cualquiera de nuestras sucursales
                            para reiniciar la contraseña.
                        </p>
                    </f7-block>
                    <f7-list form style="
                background-color: rgba(255,255,255,1);
                margin: 15px;">
                        <f7-list-input
                                class="kingans-border"
                                label="Teléfono de recuperación"
                                type="number"
                                placeholder="XXX XXX XX XX"
                                :value="resetPasswordForm.phone"
                                clear-button
                                @input="resetPasswordForm.phone = $event.target.value"
                                validate
                                required
                                :error-message="'Campo Obligatorio'"
                        ></f7-list-input>
                    </f7-list>
                </f7-block>
                <f7-block>
                    <p style="text-align:center">
                        Si tienes algún problema, visita cualquiera de nuestras sucursales
                        para reiniciar tu contraseña.
                    </p>
                </f7-block>
                <f7-block v-if="this.$device.ios">
                    <f7-button @click="sendResetForm"
                               style="color:white;  font-weight: bold" large class="bg-primary">
                        Enviar
                    </f7-button>
                </f7-block>
                <f7-button v-else @click="sendResetForm" style="
                color:white; position: fixed; bottom: 0;width: 100%; border-radius: 0; margin: 0;padding: 0; font-weight: bold
                " large class="bg-primary">
                    Enviar
                </f7-button>
            </f7-page>
        </f7-popup>

    </f7-page>
</template>

<script>
    export default {
        name: 'login',
        data() {
            return {
                resetPasswordPupopOpened: false,
                signInPupopOpened: false,
                calendarParams: {
                    //openIn: 'customModal',
                    //minDate: new Date(1920,1,1),
                    //maxDate: new Date(2010, 12, 31),
                    //yearPickerMax: 2010,
                    closeOnSelect: false,
                    direction: "vertical",
                    header: true,
                    footer: true,
                    dateFormat: 'dd MM yyyy',
                },
                resetPasswordForm: {
                    phone: '',
                },
                addUserForm: {
                    phone: '',
                    name: '',
                    email: '',
                    city: 'Torreón',
                    gender: 'N',
                    birthday: '0000,00,00',
                    password: '',
                },
                phone: '',
                password: '',
            };
        },
        mounted: function () {
        },
        methods: {
            sendResetForm() {
                if (this.resetPasswordForm.phone !== '') {
                    let vm = this;
                    this.$f7.dialog.preloader('Enviando datos')
                    this.$http.post(vm.$store.state.application.config.api + 'users/app/reset', {
                        phone: this.phone,
                    }).then(response => {
                        this.$f7.dialog.close();
                        this.$f7.dialog.alert(' ', '¡Correo enviado!')
                    }, response => {
                        console.log(response, 'error sendResetForm login.vue')
                        this.$f7.dialog.alert('Intente más tarde', 'Servidor no disponible')
                        this.$f7.dialog.close();
                    });
                } else {
                    this.$f7.dialog.alert(' ', 'Revisa tu número de celular')
                }
            },
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
                this.$http.post(vm.$store.state.application.config.api + 'users/app/login', {
                    phone: this.phone,
                    password: this.password,
                }).then(response => {
                    this.$f7.dialog.close();
                    if (response.data.success === false || response.data === '') {
                        this.$f7.dialog.alert(' ', 'Nombre y/o Contraseña incorrecta(s)')
                        this.$f7.dialog.close();
                    } else {
                        vm.$store.commit('setLogin', false);
                        vm.$store.commit('setUser', response.data);
                    }
                }, response => {
                    console.log(response, 'error signIn login.vue')
                    this.$f7.dialog.alert(' ', 'Nombre y/o Contraseña incorrecta(s)')
                    this.$f7.dialog.close();
                });
            },
            /*signInWithFbApi(){
                let fbLoginSuccess = function (userData) {
                    console.log("UserInfo: ", userData);
                    facebookConnectPlugin.getAccessToken(function(token) {
                        console.log("Token: " + token);
                    });
                }

                facebookConnectPlugin.login(["public_profile"], fbLoginSuccess,
                    function (error) {
                        console.error(error)
                    }
                );
            },*/
            signIn() {
                let vm = this
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
                        this.$f7.dialog.alert("Registro completo, ahora puedes iniciar sesión.",
                            "Éxito", function () {
                                vm.phone = vm.addUserForm.phone;
                                vm.password = vm.addUserForm.password;
                                vm.signInPupopOpened = false;
                                vm.addUserForm = {
                                    name: '',
                                    phone: '',
                                    email: '',
                                    city: '',
                                    gender: '',
                                    birthday: '',
                                    password: '',
                                };
                            });
                    }, response => {
                        console.log(response, 'error on checkForm users/app/add');
                        this.$f7.dialog.close();
                        this.$f7.dialog.alert("Cuenta ya registrada.", '¡Hola, revisa tus datos!');
                    });

                } else {
                    this.$f7.dialog.alert("Nombre, Teléfono, Contraseña y Email son requeridos.", '¡Hola, revisa tus datos!');
                }
            },
        },
    };
</script>

<style scoped>

</style>