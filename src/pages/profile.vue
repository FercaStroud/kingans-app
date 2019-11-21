<template>
    <f7-page>
        <f7-navbar back-link="Atrás"></f7-navbar>
        <f7-block style="
                color: #f16989;
                width: 205px;
                border-bottom: 1px solid #f16989;
                margin: 0;
                margin-top: 20px;
                padding-bottom: 6px;">
            Configuración de la cuenta
        </f7-block>
        <f7-block>
            <span style="font-size: 1.6em;color: black;">{{$store.state.application.user.name}}</span><br/>
            <span>{{$store.state.application.user.email}}</span><br/>
            {{$store.state.application.user}}
        </f7-block>
        <f7-block>
            <img style="border-radius: 50%;width: 23%;float: right;margin-top: -19%;" src="../assets/logoKingans.svg"/>
        </f7-block>

        <f7-list form style="
                background-color: rgba(255,255,255,1);
                margin: 15px;">
            <f7-list-input
                    class="kingans-border"
                    label="Nombre Completo"
                    type="text"
                    placeholder="EJ: Mr. Schwarzenegger."
                    info="Obligatorio"
                    :value="items.name"
                    clear-button
                    @input="items.name = $event.target.value"
                    :error-message="'Campo Obligatorio'"
                    validate
                    required
            ></f7-list-input>
            <f7-list-input
                    class="kingans-border"
                    label="Teléfono"
                    type="number"
                    placeholder="XXX XXX XX XX"
                    info="Obligatorio"
                    :value="items.phone"
                    clear-button
                    @input="items.phone = $event.target.value"
                    validate
                    required
                    :error-message="'Campo Obligatorio'"
            ></f7-list-input>
            <f7-list-input
                    class="kingans-border"
                    info="Obligatorio"
                    label="Ciudad"
                    type="select"
                    placeholder="Seleccione una opción"
                    :value="items.city"
                    @input="items.city = $event.target.value"
            >
                <option value="Saltillo">Saltillo</option>
                <option value="Torreón">Torreón</option>
            </f7-list-input>
        </f7-list>
        <f7-list style="padding-top: 20px;">
            <f7-button
                    class="btn-primary"
                    style="margin-left:15px;"
                    large>
                <f7-icon style="margin-top: -4px" material="person"></f7-icon>
                VINCULAR CON FACEBOOK
            </f7-button>
        </f7-list>
    </f7-page>
</template>

<script>
    export default {
        name: "profile",
        data() {
            return {
                calendarParams: {
                    closeOnSelect: true,
                    header: true,
                    footer: false,
                    dateFormat: 'dd MM yyyy',
                },
                items: {
                    phone: '',
                    name: '',
                    email: '',
                    city: '',
                    gender: '',
                    birthday: '',
                    password: '',
                },
            };
        },
        mounted: function () {
            this.items = this.$store.state.application.user;
        },
        methods: {

        }
    }
</script>

<style scoped>

</style>