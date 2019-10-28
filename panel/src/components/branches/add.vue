<template>
    <f7-page name="branchesAdd">
        <f7-navbar :sliding="true" back-link="Atrás" title="Añadir Sucursal">
            <f7-nav-right>
                <f7-link icon-ios="f7:menu"
                         icon-aurora="f7:menu"
                         icon-md="material:menu"
                         panel-open="left">
                </f7-link>
            </f7-nav-right>
        </f7-navbar>
        <f7-block>
            <f7-card>
                <f7-card-content>
                    <f7-list form style="margin: 15px;max-width: 100%;">
                        <f7-list-input
                                class="kingans-border"
                                label="Nombre de la sucursal"
                                placeholder="EJ: Colón"
                                type="text"
                                info="Obligatorio"
                                :value="name"
                                clear-button
                                @input="name = $event.target.value"
                        ></f7-list-input>
                        <f7-list-input
                                class="kingans-border"
                                label="Ciudad"
                                type="text"
                                placeholder="EJ: Torreón"
                                info="Obligatorio"
                                :value="city"
                                clear-button
                                @input="city = $event.target.value"
                        ></f7-list-input>
                    </f7-list>
                    <f7-button style="margin: 15px"
                               class="btn-primary"
                               large @click="">
                        REGISTRAR SUCURSAL
                    </f7-button>
                </f7-card-content>
            </f7-card>
        </f7-block>
    </f7-page>
</template>

<script>
    export default {
        name: "branchesAdd",
        data() {
            return {
                name: '',
                city: '',
                user_id: '',
            }
        },
        mounted: function () {
        },
        methods: {},
    }
</script>

<style scoped>

</style>