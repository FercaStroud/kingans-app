<template>
    <f7-page>
        <f7-navbar no-shadow no-hairline back-link="Atrás">
            <f7-nav-title>
                <img style="height: 25px" src="../assets/kingansWhite.svg">
            </f7-nav-title>
            <f7-nav-right>
                <f7-link class="active" @click="sendForm">
                    Guardar
                </f7-link>
            </f7-nav-right>
        </f7-navbar>

        <f7-block class="active border-bottom" style="
                width: 205px;
                margin: 0;
                margin-top: 20px;
                padding-bottom: 6px;">
            Configuración de la cuenta
        </f7-block>
        <f7-block>
            <span style="font-weight: bold">ID: {{$store.state.application.user.phone}}</span><br/>
            <span style="font-size: 1.6em;color: black;">{{$store.state.application.user.name}}</span><br/>
            <span class="active">CUMPLEAÑOS: {{dateStringMX($store.state.application.user.birthday)}}</span><br/>
        </f7-block>
        <f7-block>
            <f7-list form style="
                background-color: rgba(255,255,255,1);
                margin: 15px;">
                <f7-list-input
                        class="kingans-border"
                        label="Nombre Completo"
                        type="text"
                        placeholder="EJ: Mr. Schwarzenegger."
                        info="Obligatorio"
                        :value="items.name"
                        clear-button
                        @input="items.name = $event.target.value"
                        :error-message="'Campo Obligatorio'"
                        validate
                        required
                ></f7-list-input>
                <f7-list-input
                        class="kingans-border"
                        label="Email del usuario"
                        placeholder="EJ: mail@kingans.com"
                        type="email"
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
                        info="Obligatorio"
                        label="Ciudad"
                        type="select"
                        placeholder="Seleccione una opción"
                        :value="items.city"
                        @input="items.city = $event.target.value"
                >
                    <option value="Saltillo">Saltillo</option>
                    <option value="Torreón">Torreón</option>
                </f7-list-input>
                <f7-list-input
                        class="kingans-border"
                        label="Sexo"
                        type="select"
                        placeholder="Seleccione una opción"
                        :value="items.gender"
                        @input="items.gender = $event.target.value"
                        validate
                        required
                        :error-message="'Campo Obligatorio'"
                >
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                </f7-list-input>
            </f7-list>
            <!--<f7-list style="padding-top: 20px;">
                <f7-button class="btn-primary" style="margin-left:15px; width: calc(100% - 30px)" large>
                    <f7-icon style="margin-top: -4px" material="person"></f7-icon>
                    VINCULAR CON FACEBOOK
                </f7-button>
            </f7-list>-->
        </f7-block>
        <f7-block>
            <p style="text-align: center">CLIENTE DESDE: {{dateStringMX($store.state.application.user.created_at)}}</p>
            <br/>
        </f7-block>
        <!--<f7-block style="
                color: #f16989;
                width: 215px;
                border-bottom: 1px solid #f16989;
                margin: 0;
                margin-top: 20px;
                padding-bottom: 6px;">
            Configuración de la aplicación
        </f7-block>
        <f7-list simple-list>
            <f7-list-item>
                <span>Permitir Notificaciones</span>
                <f7-toggle @toggle:change="requestPermission" checked color=""></f7-toggle>
            </f7-list-item>
        </f7-list>-->
        <f7-block>
            <f7-button class="active"
                       style="margin-left:15px; width: calc(100% - 30px)"
                       large @click="resetPopupOpened = true">
                Cambiar contraseña
            </f7-button>
        </f7-block>
        <f7-popup
                :tablet-fullscreen="true"
                class="reset-password-popup-profile" :opened="resetPopupOpened" @popup:closed="resetPopupOpened = false">
            <f7-page>
                <f7-navbar no-shadow no-hairline>
                    <f7-nav-left>
                        <f7-link popup-close>Cerrar</f7-link>
                    </f7-nav-left>
                    <f7-nav-title>
                        <img style="height: 25px" src="../assets/kingansWhite.svg">
                    </f7-nav-title>
                    <f7-nav-right>
                        <f7-link class="active" @click="sendResetPasswordForm">
                            Guardar
                        </f7-link>
                    </f7-nav-right>
                </f7-navbar>

                <f7-block>
                    <f7-list form style="
                background-color: rgba(255,255,255,1);
                margin: 15px;">
                        <f7-list-input
                                class="kingans-border"
                                label="Nueva contraseña"
                                type="text"
                                placeholder="************"
                                info="Obligatorio"
                                :value="resetItems.newPassword"
                                clear-button
                                @input="resetItems.newPassword = $event.target.value"
                                :error-message="'Campo Obligatorio'"
                                validate
                                required
                        ></f7-list-input>
                        <f7-list-input
                                class="kingans-border"
                                label="Confirmar contraseña"
                                type="text"
                                placeholder="************"
                                info="Obligatorio"
                                :value="resetItems.confirmPassword"
                                clear-button
                                @input="resetItems.confirmPassword = $event.target.value"
                                :error-message="'Campo Obligatorio'"
                                validate
                                required
                        ></f7-list-input>
                    </f7-list>
                </f7-block>
            </f7-page>
        </f7-popup>
    </f7-page>
</template>

<script>
    export default {
        name: "profile",
        data() {
            return {
                resetPopupOpened: false,
                resetItems: {
                    newPassword: '',
                    confirmPassword: ''
                },
                calendarParams: {
                    closeOnSelect: true,
                    header: true,
                    footer: false,
                    dateFormat: 'dd MM yyyy',
                },
                items: {
                    created_at: '',
                    name: '',
                    email: '',
                    city: '',
                    birthday: '',
                    gender: ''
                },
            }
        },
        created: function () {
        },
        mounted: function () {
            //console.log(this.$store.state.application.user)
            //this.items = this.$store.state.application.user;
            this.items.name = this.$store.state.application.user.name;
            this.items.email = this.$store.state.application.user.email;
            this.items.city = this.$store.state.application.user.city;
            this.items.gender = this.$store.state.application.user.gender;
            this.items.created_at = this.$store.state.application.user.created_at;
            this.items.birthday = this.$store.state.application.user.birthday;

            //console.log(this.items.birthday, "this.items.birthday")
            //console.log(this.items.created_at, "created_at")
            let vm = this;
            document.addEventListener('backbutton', function (e) {
                vm.$f7router.navigate('/')
            }, false);
        },
        methods: {
            sendResetPasswordForm: function () {
                if (this.resetItems.confirmPassword === this.resetItems.newPassword && this.resetItems.confirmPassword != '') {
                    this.$f7.dialog.preloader('Actualizando datos...');

                    this.$http.post(this.$store.state.application.config.api + 'users/app/edit/password', {
                        id: this.$store.state.application.user.id,
                        password: this.resetItems.confirmPassword,
                        updated_by: this.$store.state.application.user.id
                    }).then(response => {
                        this.$f7.dialog.close();
                        this.$f7.dialog.alert("Datos actualizados", "Éxito");
                        this.resetItems = {
                            newPassword: '',
                            confirmPassword: ''
                        }
                    }, response => {
                        console.log(response, 'error on sendForm users/app/edit/password');
                        this.$f7.dialog.close();
                        this.$f7.dialog.alert("Servidor no disponible", 'Intente más tarde');
                    });
                } else {
                    this.$f7.dialog.alert(" ", 'Las contraseñas no coinciden');
                }
            },
            /*requestPermission: function (successPermission) {
                let vm = this
                if(successPermission) {
                    cordova.plugins.notification.local.requestPermission(function (granted) {
                        //vm.$f7.dialog.alert("Permisos Otorgados", "Éxito");
                    });
                }else {
                    cordova.plugins.notification.local.schedule({
                        title: 'My first notification',
                        text: 'Thats pretty easy...',
                        foreground: true
                    });
                }

            },*/
            sendForm: function () {
                let vm = this
                if (this.checkForm()) {
                    this.$f7.dialog.preloader('Actualizando datos...');

                    this.$http.post(this.$store.state.application.config.api + 'users/app/edit', {
                        id: this.$store.state.application.user.id,
                        name: this.items.name,
                        email: this.items.email,
                        city: this.items.city,
                        gender: this.items.gender,
                        updated_by: this.$store.state.application.user.id
                    }).then(response => {
                        vm.$f7.dialog.close();
                        vm.$f7.dialog.alert("Datos actualizados", "Éxito");
                        this.$f7.dialog.alert("Favor de iniciar sesión nuevamente", 'Éxito', function () {
                            this.$store.commit('resetLogin')
                        }.bind(this))
                        vm.items = {
                            created_at: '',
                            name: '',
                            email: '',
                            city: '',
                            birthday: '',
                            gender: ''
                        }
                    }, response => {
                        console.log(response, 'error on sendForm users/app/edit');
                        vm.$f7.dialog.close();
                        vm.$f7.dialog.alert("Servidor no disponible", 'Intente más tarde');
                    });

                } else {
                    this.$f7.dialog.alert("Todos los campos son requeridos.");
                }
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

                if(month !== undefined){
                    return String(month) + " " + String(day) + " del " + String(year);
                }
                else {
                    return "Sin registro."
                }
            }
        },
        computed: {}
    }
</script>

<style>

</style>