<template>
    <f7-page>
        <f7-navbar back-link="Atrás"></f7-navbar>
        <f7-block strong style="margin:0 ">
            <f7-row>
                <f7-col width="30">
                    <div style="
                        width: 75px;
                        height: 75px;
                        border-radius: 100%;
                        background-color: #f6b05d
                        ">
                        <f7-icon style="font-size: 3em;margin: 16px;" material="place"></f7-icon>
                    </div>
                </f7-col>
                <f7-col width="70">
                    <h1 style="margin:0">Sucursales</h1>
                    <span>KINGANS</span>
                </f7-col>
            </f7-row>
        </f7-block>

        <f7-card class="elevation-2">
            <f7-card-content>
                <p>
                    <span style="font-size: .9em">TORREÓN</span><br/>
                    <span style="font-size: 1.6em">Independencia</span>
                </p>
                <p style="color: #6e6e74">
                    Blvd. Independencia #2295 <br/>
                    San Isidro, C.P. 27100, <br/>
                    Torreón, Coahuila.
                </p>
            </f7-card-content>
            <f7-card-footer>
                <f7-link><f7-icon style="font-size: 1.5em" material="place"></f7-icon></f7-link>
                <f7-link><f7-icon style="font-size: 1.5em" material="access_time"></f7-icon></f7-link>
                <f7-link><f7-icon style="font-size: 1.5em" material="phone"></f7-icon></f7-link>
            </f7-card-footer>
        </f7-card>
        <f7-card class="elevation-2">
            <f7-card-content>
                <p>
                    <span style="font-size: .9em">TORREÓN</span><br/>
                    <span style="font-size: 1.6em">Colón</span>
                </p>
                <p style="color: #6e6e74">
                    Calz. Cristobal Colón #245 <br/>
                    Segundo de Cobián, C.P. 27100, <br/>
                    Torreón, Coahuila.
                </p>
            </f7-card-content>
            <f7-card-footer>
                <f7-link><f7-icon style="font-size: 1.5em" material="place"></f7-icon></f7-link>
                <f7-link><f7-icon style="font-size: 1.5em" material="access_time"></f7-icon></f7-link>
                <f7-link><f7-icon style="font-size: 1.5em" material="phone"></f7-icon></f7-link>
            </f7-card-footer>
        </f7-card>
        <f7-card class="elevation-2">
            <f7-card-content>
                <p>
                    <span style="font-size: .9em">SALTILLO</span><br/>
                    <span style="font-size: 1.6em">San Patricio</span>
                </p>
                <p style="color: #6e6e74">
                    Blvd. Pedro Figueroa #2990 <br/>
                    Residencial San Patricio, C.P. 25204, <br/>
                    Saltillo, Coahuila.
                </p>
            </f7-card-content>
            <f7-card-footer>
                <f7-link><f7-icon style="font-size: 1.5em" material="place"></f7-icon></f7-link>
                <f7-link><f7-icon style="font-size: 1.5em" material="access_time"></f7-icon></f7-link>
                <f7-link><f7-icon style="font-size: 1.5em" material="phone"></f7-icon></f7-link>
            </f7-card-footer>
        </f7-card>
    </f7-page>
</template>

<script>
    export default {
        name: "branchOffices"
    }
</script>

<style >
    .block-strong:before, .block-strong:after{
        content: none !important;
    }
</style>