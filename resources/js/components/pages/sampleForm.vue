<template>
    <div id="app">
        <div class="row" v-for="address in addresses">
            <div class="form-element">
                <label>
                    ZIP: <input v-model="address.zip">
                </label>
            </div>
            <div class="form-element">
                <label>
                    Town: <input v-model="address.town">
                </label>
            </div>
            <div class="form-element">
                <label>
                    Street: <input v-model="address.street">
                </label>
            </div>
        </div>
        <button class="add-row" @click="addAddressRow">
            Add new address
        </button>
    </div>
</template>

<script>
    import Vue from 'vue';
    import Vuex from 'vuex';

    // The `getField()` and `updateField()`
    // helper functions, are needed to update
    // the mapped fields in a Vuex conform manner.
    import { getField, updateField } from 'vuex-map-fields';

    Vue.use(Vuex);

    export default new Vuex.Store({
        state: {
            // We add one empty address to
            // render the first form row.
            addresses: [
                {
                    zip: '',
                    town: '',
                    street: '',
                },
            ],
        },
        getters: {
            getField,
        },
        mutations: {
            updateField,
            // We'll use this mutation to
            // dynamically add new rows.
            addAddressRow(state) {
                state.addresses.push({
                    zip: '',
                    town: '',
                    street: '',
                });
            },
        },
    });

</script>

<style>
    /* Some very basic styling */
    .row:not(:first-child) {
        margin-top: 1em;
        padding-top: 1em;
        border-top: 1px solid #e2e2e2;
    }

    .form-element:not(:first-child) {
        margin-top: 0.5em;
    }

    .add-row {
        margin-top: 2em;
    }
</style>
