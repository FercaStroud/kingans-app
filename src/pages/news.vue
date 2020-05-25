<template>
    <f7-page>
        <f7-navbar no-shadow no-hairline back-link="Atrás">
            <f7-nav-title>
                <img style="height: 25px" src="../assets/kingansWhite.svg">
            </f7-nav-title>
        </f7-navbar>
        <f7-block>

        </f7-block>
    </f7-page>
</template>

<script>
    export default {
        name: "news",
        data() {
            return {
                items: [],
            }
        },
        mounted: function () {
            this.getBranches();

            let vm = this;
            document.addEventListener('backbutton', function (e) {
                vm.$f7router.navigate('/')
            }, false);
        },
        methods: {
            getBranches: function () {
                this.$f7.dialog.preloader('Cargando...');
                this.$http.post(this.$store.state.application.config.api + 'branches/get').then(response => {
                    this.$f7.dialog.close();
                    this.items = response.data
                }, response => {
                    console.log(response, 'error on getBranches branches/get');
                    this.$f7.dialog.close();
                    this.$f7.dialog.alert("", 'Servidor no disponible.');
                });
            }
        },
    }
</script>

<style>
    .block-strong:before, .block-strong:after {
        content: none !important;
    }
</style>