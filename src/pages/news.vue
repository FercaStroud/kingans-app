<template>
    <f7-page>
        <f7-navbar no-shadow no-hairline back-link="Atrás">
            <f7-nav-title>
                <img style="height: 25px" src="../assets/kingansWhite.svg">
            </f7-nav-title>
            <f7-nav-right></f7-nav-right>
        </f7-navbar>
        <f7-block>
            <f7-row>
                <f7-col>
                    <f7-card v-for="(item, key) in items" :key="key">
                        <f7-card-header
                                class="no-border"
                                valign="bottom"
                        >
                            <strong>{{item.title}}</strong>
                        </f7-card-header>
                        <f7-card-content>
                            <img :src="$store.state.application.config.api + 'images/news/'+item.src"
                                 alt=""
                                 style="width:100%"
                            >
                        </f7-card-content>
                        <f7-card-footer v-if="item.svg">
                            <img style="width:32px"
                                 :src="$store.state.application.config.api + 'images/branches/'+item.svg" alt="">
                            {{item.name}}
                        </f7-card-footer>
                    </f7-card>
                </f7-col>
            </f7-row>
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
            this.getNews();

            let vm = this;
            document.addEventListener('backbutton', function (e) {
                vm.$f7router.navigate('/')
            }, false);
        },
        methods: {
            getNews: function () {
                this.$f7.dialog.preloader('Cargando...');
                this.$http.post(this.$store.state.application.config.api + 'news/get').then(response => {
                    this.$f7.dialog.close();
                    this.items = response.data
                }, response => {
                    console.log(response, 'error on getBranches news/get');
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
