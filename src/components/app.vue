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
                        <span style="font-size: 1.6em;color: black;">Alberto Martínez</span><br/>
                        <span>TORREÓN</span>
                    </f7-block>
                    <f7-block-title>EN CONSTRUCCIÓN</f7-block-title>
                    <f7-list>
                        <f7-list-item @click="$store.commit('resetLogin')" panel-close title="Cerrar Sesión"></f7-list-item>
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
                f7params: {
                    id: 'com.kingans', // App bundle ID
                    name: 'Kingans', // App name
                    theme: 'auto', // Automatic theme detection
                    // App root data
                    data: function () {
                        return {
                            user: {
                                firstName: 'John',
                                lastName: 'Doe',
                            },

                        };
                    },
                    // App routes
                    routes: routes,
                    // Enable panel left visibility breakpoint
                    panel: {
                        leftBreakpoint: 960,
                    },
                    // Input settings
                    input: {
                        scrollIntoViewOnFocus: this.$device.cordova && !this.$device.electron,
                        scrollIntoViewCentered: this.$device.cordova && !this.$device.electron,
                    },
                    // Cordova Statusbar settings
                    statusbar: {
                        overlay: this.$device.cordova && this.$device.ios || 'auto',
                        iosOverlaysWebView: true,
                        androidOverlaysWebView: false,
                    },
                },

                // Login screen data
                username: '',
                password: '',
            }
        },
        methods: {
            alertLoginData() {
                this.$f7.dialog.alert('Username: ' + this.username + '<br>Password: ' + this.password);
            }
        },
        mounted() {
            this.$f7ready((f7) => {
                // Init cordova APIs (see cordova-app.js)
                if (f7.device.cordova) {
                    cordovaApp.init(f7);
                }
                // Call F7 APIs here
            });
        }
    }
</script>