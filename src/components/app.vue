<template>
    <f7-app :params="f7params">
        <!-- Status bar overlay for fullscreen mode-->
        <f7-statusbar></f7-statusbar>

        <f7-panel left cover>
            <f7-view>
                <f7-page>

                    <f7-block-title>
                        <img style="width: 50px" class="circle-image" src="../assets/logoKingans.svg"/>
                    </f7-block-title>

                    <f7-block>
                        <span style="font-size: 1.6em;color: black;">{{$store.state.application.user.name}}</span><br/>
                        <span>{{$store.state.application.user.city}}</span>
                    </f7-block>

                    <f7-list :style="{
                            position: 'absolute',
                            width: '100%',
                            marginTop: ((window.height - 206) / 2) - 132 + 'px',
                            }">
                        <f7-list-item class="custom-btn" flat link="/"
                                      view=".view-main" v-ripple
                                      panel-close>
                            <f7-icon class="active" style="" material="favorite"></f7-icon>
                            <span class="active" style="
                                    font-size: 1.2em;
                            ">Home</span>
                        </f7-list-item>
                        <f7-list-item class="custom-btn" flat v-ripple
                                      link="/promotions/true" view=".view-main"
                                      panel-close>
                            <f7-icon style="" material="stars"></f7-icon>
                            <span style="
                                    font-size: 1.2em;
                            ">Mis Premios</span>
                        </f7-list-item>
                        <f7-list-item class="custom-btn" flat v-ripple
                                      link="/howToUse/" view=".view-main"
                                      panel-close>
                            <f7-icon style="" material="smartphone"></f7-icon>
                            <span style="
                                    font-size: 1.2em;
                            ">¿Cómo funciona?</span>
                        </f7-list-item>
                        <f7-list-item class="custom-btn" flat v-ripple
                                      link="/branches/" view=".view-main"
                                      panel-close>
                            <f7-icon style="" material="place"></f7-icon>
                            <span style="
                                    font-size: 1.2em;
                            ">Sucursales</span>
                        </f7-list-item>
                        <f7-list-item class="custom-btn" flat v-ripple
                                      link="/profile/" view=".view-main"
                                      panel-close>
                            <f7-icon style="" material="person"></f7-icon>
                            <span style="
                                    font-size: 1.2em;
                            ">Usuario</span>
                        </f7-list-item>
                    </f7-list>

                    <f7-list style=" cursor:pointer;
                            position: absolute;
                            bottom: 0;
                            width: 100%;
                            margin: 0;">
                        <f7-list-item @click="$store.commit('resetLogin')" panel-close>
                            <f7-icon style="" material="close"></f7-icon>
                            <span style="
                                    position: absolute;
                                    margin-left: 42px;
                                    font-weight: 100;
                            ">Cerrar Sesión</span>
                        </f7-list-item>
                    </f7-list>
                </f7-page>
            </f7-view>
        </f7-panel>

        <!-- Your main view, should have "view-main" class -->
        <f7-view main class="safe-areas" url="/"></f7-view>

        <f7-login-screen
                :opened="$store.state.application.drawer.login"
                @loginscreen:closed="$store.state.application.drawer.login = false">
            <f7-view>
                <login/>
            </f7-view>
        </f7-login-screen>
    </f7-app>
</template>
<script>
    import cordovaApp from '../js/cordova-app.js';
    import routes from '../js/routes.js';
    import login from "../pages/login";

    export default {
        components: {login},
        data() {
            return {
                // Framework7 Parameters
                window: {
                    width: 0,
                    height: 0
                },
                f7params: {
                    id: 'com.kingans', // App bundle ID
                    name: 'Kingans', // App name
                    theme: 'ios', // Automatic theme detection
                    // App root data
                    data: function () {
                        return {};
                    },
                    pushState: true,
                    // App routes
                    routes: routes,
                    // Enable panel left visibility breakpoint
                    panel: {
                        leftBreakpoint: 768,
                    },
                    // Input settings
                    input: {
                        scrollIntoViewOnFocus: this.$device.cordova && !this.$device.electron,
                        scrollIntoViewCentered: this.$device.cordova && !this.$device.electron,
                    },
                    // Cordova Statusbar settings
                    statusbar: {
                        iosBackgroundColor: '#f18a30',
                        androidBackgroundColor: '#f18a30',
                        overlay: this.$device.cordova && this.$device.ios || 'auto',
                        iosOverlaysWebView: false,
                        androidOverlaysWebView: false,
                    },
                },
            }
        },
        created() {
            window.addEventListener('resize', this.handleResize)
            this.handleResize();
        },
        destroyed() {
            window.removeEventListener('resize', this.handleResize)
        },
        methods: {
            alertLoginData() {
                this.$f7.dialog.alert('Username: ' + this.username + '<br>Password: ' + this.password);
            },
            handleResize() {
                this.window.width = window.innerWidth;
                this.window.height = window.innerHeight;
            },
            getSurveys: function () {
                let vm = this
                this.$http.post(this.$store.state.application.config.api + 'surveys/get').then(response => {
                    vm.$store.commit('setSurveys', response.body);
                }, response => {
                    // error callback
                    console.log(response, 'error on getSurveys');
                });
            },
        },
        mounted() {
            let vm = this;
            this.$f7ready((f7) => {
                // Init cordova APIs (see cordova-app.js)
                if (f7.device.cordova) {
                    cordovaApp.init(f7);

                    cordova.plugins.firebase.messaging.requestPermission().then(function () {
                        console.log("Push messaging is allowed");
                    });
                    cordova.plugins.firebase.messaging.requestPermission({forceShow: true}).then(function () {
                        console.log("You'll get foreground notifications when a push message arrives");
                    });
                    cordova.plugins.firebase.messaging.onMessage(function (payload) {
                        console.log("New foreground FCM message: ", payload);
                    });
                    cordova.plugins.firebase.messaging.onBackgroundMessage(function (payload) {
                        console.log("New background FCM message: ", payload);
                    });

                    // Call F7 APIs here
                    let fetchCallback = function () {
                        console.log('[js] BackgroundFetch event received');

                        vm.$http.post(vm.$store.state.application.config.api + 'users/app/visit/log', {
                            user_id: vm.$store.state.application.user.id
                        }).then(response => {
                            if (response.data.user_id !== undefined) {
                                cordova.plugins.notification.local.schedule({
                                    title: '¡Gracias por tu visita!',
                                    text: '¿Nos ayudas contestando una encuesta?',
                                    foreground: true
                                });
                                vm.$store.commit('setSurvey', true);
                                vm.getSurveys();
                            }
                        }, response => {
                            console.log(response, 'error on checkVisitLog users/app/visit/log');
                        });

                        BackgroundFetch.finish();
                    };

                    let failureCallback = function (error) {
                        console.log('- BackgroundFetch failed', error);
                    };

                    BackgroundFetch.configure(fetchCallback, failureCallback, {
                        minimumFetchInterval: 15
                    });
                }
            });
        }
    }
</script>