<template>
    <f7-page no-toolbar no-navbar no-swipeback login-screen>
        <f7-statusbar></f7-statusbar>
        <f7-login-screen-title style="color: white;max-width: 350px">
            <div style="width: 100%">
                <img class="circle-image" style="width: 50%; margin-top: 40px" src="../assets/logoKingans.svg"/>
            </div>
        </f7-login-screen-title>
        <f7-list form style="max-width: 350px">
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
        </f7-list>
    </f7-page>
</template>

<script>
    export default {
        name: 'login',
        data() {
            return {
                username: '',
                password: '',
            };
        },
        methods: {
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