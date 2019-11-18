<template>
    
</template>

<script>
    export default {
        name: "logout",
        data() {
            return {
            };
        },
        mounted() {
            this.$store.state.application.user = {
                id: null,
                branch_id: null,
                username: null,
                type: null,
                name: null,
            };
            this.$store.state.application.drawer ={
                left: false,
                right: false,
                codes: false,
                dashboard: false,
                login: true,
            };
        }
    }
</script>

<style scoped>

</style>