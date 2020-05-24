<template>
    <f7-page name="newsAdd">
        <f7-navbar :sliding="true" back-link="Atrás" title="Añadir Noticia a Sucursal">
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
                    <f7-list form style="margin: 15px;">
                        <f7-list-input
                                class="kingans-border"
                                label="Nombre de la Noticia"
                                placeholder="(Informativa, no aparecerá en la app)"
                                type="text"
                                info="Obligatorio"
                                :value="items.title"
                                clear-button
                                validate
                                required
                                :error-message="'Campo Obligatorio'"
                                @input="items.title = $event.target.value"
                        ></f7-list-input>
                        <f7-list-input
                                class="kingans-border"
                                label="Sucursal"
                                type="select"
                                info="Obligatorio"
                                placeholder="Sucursal"
                                :value="items.branch_id"
                                validate
                                required
                                :error-message="'Campo Obligatorio'"
                                @input="items.branch_id = $event.target.value"
                        >
                            <option value="0">Todas</option>
                            <option v-for="(branch, index) in branches" :key="index"
                                    :value="branch.id">{{branch.name}}
                            </option>
                        </f7-list-input>
                        <input type="file" ref="file"
                               accept="image/*"
                               required
                               @change="onChangeFileUpload"/>
                    </f7-list>
                    <f7-block>
                        <p style="margin:15px; font-size:1.2em;">
                            <strong>NOTA:</strong> Asegúrese de que la imagen esté optimizada para
                            ser utilizada en una aplicación. <br/>
                            <strong>SE RECOMIENDA</strong> que su peso no exceda a 1Mb.
                        </p>
                    </f7-block>
                    <f7-button style="margin: 15px"
                               class="btn-primary"
                               large @click="sendForm">
                        AGREGAR NOTICIA A SUCURSAL
                    </f7-button>
                </f7-card-content>
            </f7-card>
        </f7-block>
    </f7-page>
</template>

<script>
    export default {
        name: "newsAdd",
        data: function () {
            return {
                branches: [],
                items: {
                    branch_id: 0,
                    src: '',
                    title: '',
                }
            }
        },
        mounted: function () {
            this.getBranches()
        },
        methods: {
            getBranches() {
                let vm = this
                vm.$f7.dialog.preloader('Obteniendo datos...');
                this.$http.post(this.$store.state.application.config.api + 'branches/get').then(response => {
                    vm.$f7.dialog.close();
                    vm.branches = response.data
                }, response => {
                    console.log(response, 'error on getBranches branches/get');
                    this.$f7.dialog.close();
                    this.$f7.dialog.alert("Servidor no disponible", 'Intente más tarde');
                });
            },
            checkForm() {
                let vm = this;
                let isValid = true;
                Object.keys(this.items).forEach(function (index, item) {
                    if (vm.items[index] === "") {
                        isValid = false
                    }
                });
                return isValid;
            },
            sendForm: function () {
                if (this.checkForm()) {
                    this.$f7.dialog.preloader('Enviando datos...');

                    let formData = new FormData();
                    formData.append('branch_id', this.items.branch_id);
                    formData.append('src', this.items.src);
                    formData.append('title', this.items.title);
                    formData.append('user_id', this.$store.state.application.user.id);

                    this.$http.post(this.$store.state.application.config.api + 'news/add', formData).then(response => {
                        this.$f7.dialog.close();
                        this.$f7.dialog.alert("Datos enviados", "Éxito");
                        this.items = {
                            branchId: 0,
                            src: '',
                            title: '',
                        }
                    }, response => {
                        console.log(response, 'error on checkForm news/add');
                        this.$f7.dialog.close();
                        this.$f7.dialog.alert("Servidor no disponible", 'Intente más tarde');
                    });

                } else {
                    this.$f7.dialog.alert("Todos los campos son requeridos.");
                }
            },
            onChangeFileUpload: function () {
                this.items.src = this.$refs.file.files[0];
            }
        },
    }
</script>

<style scoped>

</style>