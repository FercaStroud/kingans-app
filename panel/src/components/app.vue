<template>
    <f7-app :params="f7params">
        <!-- Status bar overlay for fullscreen mode-->
        <f7-statusbar></f7-statusbar>

        <!-- Left panel with cover effect when hidden -->
        <f7-panel left cover v-if="$store.state.application.drawer.left">
            <f7-view>
                <f7-page>
                    <f7-navbar title="Left Panel"></f7-navbar>
                    <f7-block-title>Left View Navigation</f7-block-title>
                    <f7-list>
                        <f7-list-item link="/left-page-1/" title="Left Page 1"></f7-list-item>
                        <f7-list-item link="/left-page-2/" title="Left Page 2"></f7-list-item>
                    </f7-list>
                    <f7-block-title>Control Main View</f7-block-title>
                    <f7-list>
                        <f7-list-item link="/about/" view=".view-main" panel-close title="About"></f7-list-item>
                        <f7-list-item link="/form/" view=".view-main" panel-close title="Form"></f7-list-item>
                        <f7-list-item link="#" view=".view-main" back panel-close
                                      title="Back in history">
                        </f7-list-item>
                    </f7-list>
                </f7-page>
            </f7-view>
        </f7-panel>

        <!-- Your main view, should have "view-main" class -->
        <f7-view main class="safe-areas" url="/"></f7-view>

        <f7-login-screen :opened="$store.state.application.drawer.login">
            <f7-view>
                <login/>
            </f7-view>
        </f7-login-screen>
    </f7-app>
</template>
<script>

    import routes from '../js/routes.js';
    import Login from "../pages/login";

    export default {
        components: {Login},
        data() {
            return {
                // Framework7 Parameters
                f7params: {
                    name: 'Panel Kingans', // App name
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

                // Call F7 APIs here
            });
        }
    }
</script>