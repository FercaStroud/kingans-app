<template>
    <f7-page>
        <f7-navbar no-shadow no-hairline back-link="Atrás">
            <f7-nav-title>
                <img style="height: 25px" src="../assets/kingansWhite.svg">
            </f7-nav-title>
            <f7-nav-right>
               
            </f7-nav-right>
        </f7-navbar>
        <f7-block>
            <img src="../assets/howToUse.svg">
        </f7-block>
    </f7-page>
</template>

<script>
    export default {
        name: "howToUse",
        data() {
            return {
                items: [],
                scheduling: '',
                phone: '',
            }
        },
        created() {
        },
        mounted: function () {

        },
        methods() {

        }
    }
</script>

<style scoped>

</style>