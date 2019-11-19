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
                <f7-list form style="
                background-color: rgba(255,255,255,1);
                width: 90%;
                margin: 15px;">
                    <f7-list-input
                            class="kingans-border"
                            label="Móvil"
                            type="text"
                            placeholder="XXX XXX XX XX"
                            info="Códugo de usuario"
                            :value="username"
                            clear-button
                            @input="username = $event.target.value"
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
                <f7-list style="padding-top: 20px;">
                    <f7-button
                            class="btn-primary"
                            style="width: 50%; margin-left: 25%;"
                            large @click="falseSignIn">
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
                            large @click="falseSignIn">
                        <f7-icon style="margin-top: -4px" material="people"></f7-icon>
                        FACEBOOK
                    </f7-button>
                </f7-list>
            </f7-tab>
            <f7-tab id="tab-register" class="page-content">
                <f7-block>
                    <f7-block>
                        <span style="font-size: 1.6em;color: black;">
                            Suscríbete
                        </span><br/>
                        <span>Cliente Frecuente</span>
                    </f7-block>
                    <f7-list form style="
                background-color: rgba(255,255,255,1);
                width: 90%;
                margin: 15px;">
                        <f7-list-input
                                class="kingans-border"
                                label="Teléfono"
                                type="text"
                                placeholder="XXX XXX XX XX"
                                info="Códugo de usuario"
                                :value="subscribe.phone"
                                clear-button
                                @input="subscribe.phone = $event.target.value"
                        ></f7-list-input>
                        <f7-list-input
                                class="kingans-border"
                                label="Nombre"
                                placeholder="Nombre"
                                type="text"
                                :value="subscribe.name"
                                clear-button
                                @input="subscribe.name = $event.target.value"
                        ></f7-list-input>
                        <f7-list-input
                                class="kingans-border"
                                label="Correo"
                                placeholder="Correo Electrónico"
                                type="email"
                                :value="subscribe.email"
                                clear-button
                                @input="subscribe.email = $event.target.value"
                        ></f7-list-input>
                        <f7-list-input
                                class="kingans-border"
                                label="Ciudad"
                                type="select"
                                placeholder="Seleccione una opción"
                                :value="subscribe.city"
                                @input="subscribe.city = $event.target.value"
                        >
                            <option value="Saltillo">Saltillo</option>
                            <option value="Torreón">Torreón</option>
                        </f7-list-input>
                        <f7-list-input
                                class="kingans-border"
                                label="Sexo"
                                type="select"
                                placeholder="Seleccione una opción"
                                :value="subscribe.gender"
                                @input="subscribe.gender = $event.target.value"
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
                                :value="subscribe.password"
                                clear-button
                                @input="subscribe.password = $event.target.value"
                        ></f7-list-input>
                        <f7-button flat
                                tab-link="#tab-login"
                                style="width: 90px;font-size:.7em;float:left;margin-right:5%">
                            CANCELAR
                        </f7-button>
                        <f7-button
                                class="btn-primary"
                                style="width: 60%;"
                                large @click="falseSignIn">
                            <f7-icon style="margin-top: -4px" material="add"></f7-icon>
                            SUSCRIR
                        </f7-button>
                    </f7-list>
                </f7-block>
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
                username: '',
                password: '',
            };
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
            falseSignIn() {
                this.$f7.dialog.preloader('Iniciando Sesión')
                this.$http.post(/*this.$store.state.application.config.api + */  '', {
                    name: this.username,
                    pwd: this.password,
                }).then(response => {
                    this.$f7.dialog.close();
                    this.$f7.dialog.alert("Usuario de Pruebas", 'Bienvenido', function () {
                        this.$store.state.application.drawer.login = false
                    }.bind(this))
                }, response => {
                    console.log(response, 'error get username')
                    this.$f7.dialog.close();
                    this.$f7.dialog.alert("Usuario de Pruebas", 'Bienvenido', function () {
                        this.$store.state.application.drawer.login = false
                    }.bind(this))
                });
            },
            signIn() {
                this.$f7.dialog.preloader('Iniciando Sesión')
                this.$http.post(this.$store.state.application.config.api + 'login', {
                    name: this.username,
                    pwd: this.password,
                }).then(response => {
                    this.$store.state.application.user = response.body
                    this.$f7.dialog.close();
                    if (this.$store.state.application.user.name != null &&
                        this.$store.state.application.user.name != undefined &&
                        this.$store.state.application.user.name != '') {
                        this.$store.commit('setLogin', false)
                        this.$f7.dialog.alert(this.$store.state.application.user.name, 'Bienvenido', function () {
                            this.$store.state.application.drawer.login = false
                        }.bind(this))
                    } else {
                        this.$f7.dialog.alert(' ', 'Nombre y/o Contraseña incorrecta(s)')
                        //this.$f7.dialog.alert('Intente más tarde', 'Servidor no disponible')
                        console.log(response, 'error get username')
                        this.$f7.dialog.close();
                    }
                }, response => {
                    this.$f7.dialog.alert(' ', 'Nombre y/o Contraseña incorrecta(s)')
                    //this.$f7.dialog.alert('Intente más tarde', 'Servidor no disponible')
                    console.log(response, 'error get username')
                    this.$f7.dialog.close();
                });
            },
        },
    };
</script>

<style scoped>

</style>