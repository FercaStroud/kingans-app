<template>
    <f7-page>
        <f7-navbar back-link="Atrás"></f7-navbar>
        <f7-block>
            <span style="font-size: 1.6em;color: black;">Alberto Martínez</span><br/>
            <span>Usuario</span>
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
                    :value="username"
                    clear-button
                    @input="username = $event.target.value"
            ></f7-list-input>
            <f7-list-input
                    class="kingans-border"
                    info="Obligatorio"
                    label="Ciudad"
                    type="select"
                    placeholder="Seleccione una opción"
                    :value="username"
                    @input="username = $event.target.value"
            >
                <option value="Saltillo">Saltillo</option>
                <option value="Torreón">Torreón</option>
            </f7-list-input>
        </f7-list>
        <f7-list style="padding-top: 20px;">
            <f7-button
                    class="btn-primary"
                    style="width: 60%; margin-left:15px;"
                    large>
                <f7-icon style="margin-top: -4px" material="person"></f7-icon>
                VINCULAR CON FACEBOOK
            </f7-button>
        </f7-list>
    </f7-page>
</template>

<script>
    export default {
        name: "profile"
    }
</script>

<style scoped>

</style>