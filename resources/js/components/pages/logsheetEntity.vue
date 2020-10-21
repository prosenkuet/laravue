<template>
    <div>
        <form class="entityForm">
            <fieldset id="fieldset_documentinformation" class="fieldset">
                <legend class="legend">Header Information</legend>
                <div class="form-group col-md-3">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
            </fieldset>
            <fieldset class="fieldset">
                <legend class="legend">RAM</legend>
                <div id="fieldset_ram" style="position: relative">
                    <table border="0" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <th></th>
                    <th class="idlines" style="display:none;">idlines</th>
                    <th class="linenumber">Line</th>
                    <th class="criteria">Criteria</th>
                    <th class="testingmethod">Testing Method</th>
                    <th class="requirement">Requirement</th>
                </tr>
                </thead>
                <tbody>
<!--                <tr data-id="1" v-for="(input, index) in inputs" v-bind:class="{'success': (index == selectedIndex)}">-->
                <tr v-for="(input, index) in inputs" :key="input.counter" v-bind:class="[(index == selectedIndex)?'editable':'valid']" data-id={{}}>
                    <td>
                        <div class="div_editButton" style="float: left; position: absolute; display: none;">
<!--                            <i class="fa fa-pencil fa-2x" aria-hidden="true"></i>-->
                        </div>
                        <div class="div_labelButton" style="float:left;position:absolute;display:none;">
                            <input type="button" class="printLine btn-blue material-icons" style="font-size:24px;" value="print">
                        </div>
                        <div id="div_floatingButton" style="float:left;position:absolute">
                            <div id="div_floatingButton1" style="float:left;position:absolute;top:24px;width:200px;">
                                <i class="fa fa-trash fa-2x" @click="deleteRow(index)" aria-hidden="true"></i>
<!--                                <i class="fa fa-check fa-2x" @click="addRow()" aria-hidden="true"></i>-->
                                <i class="fa fa-check fa-2x" v-on:click.prevent="addRow(index)" aria-hidden="true"></i>
                            </div>
                        </div>
                    </td>
                    <td class="idlines" style="display:none;">
                        <span></span>
                        <input type="hidden" name="lines[1][idlines]">
                    </td>
                    <td class="linenumber">
                        <span>{{index+1}}</span>
                        <br><br>&nbsp;<input type="hidden" name="lines[1][linenumber]" value="1">
                    </td>
                    <td class="criteria">
                        <span>{{input.one}}</span>
                        <input type="text" name="lines[1][criteria]" value="">
                    </td>
                    <td class="testingmethod">
                        <span></span>
                        <textarea name="lines[1][testingmethod]" id="testingmethod"></textarea>
                    </td>
                    <td class="requirement">
                        <span></span>
                        <textarea name="lines[1][requirement]" id="requirement"></textarea>
                    </td>
                </tr>
                </tbody>
            </table>
                </div>
            </fieldset>
            <button type="submit" class="btn btn-primary">Submit</button>

        </form>
    </div>
</template>
<script>
    export default {
        data(){
            return {
                counter:1,
                inputs:[{'counter':this.counter}],
                selectedIndex:''
            }
        },
        methods:{

            addRow(indx) {
                this.counter +=1
                this.inputs.push({
                    one: '',
                    counter: this.counter
                })

                this.selectedIndex = indx;
            },

            deleteRow(index) {
                if(this.inputs.length == 1) return;
                this.inputs.splice(index,1)
            }
        }
    }
</script>
