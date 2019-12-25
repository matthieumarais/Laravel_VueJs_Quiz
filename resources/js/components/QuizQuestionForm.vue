<template>
    <div v-if="showBloc">
        <h2>Ajouter une nouvelle question</h2>
        <form @submit.prevent="creatQuestion">
            <div class="mb-3 form-group">
                <input type="text" class="form-control" :class="{'br-red' : errors.label}" placeholder="label"
                       v-model="form.label">
                <p class="alert alert-danger" v-if="errors.label" v-text="errors.label[0]"></p>
            </div>
            <div class="mb-3 form-group">
                <select class="form-control" :class="{'br-red' : errors.type}" v-model="form.type" @change="showHide">
                    <option disabled value="">Choisissez</option>
                    <option>textarea</option>
                    <option>radio</option>
                    <option>checkbox</option>
                </select>
                <p class="alert alert-danger" v-if="errors.type" v-text="errors.type[0]"></p>
                <div class="mb-3" v-if="showValue">
                    <h3>Values</h3>
                    <ul>
                        <li v-for="(value, index) in form.values">
                            <input type="text" v-model="value.val">
                            <button @click.prevent="deleteRow(index)">Delete</button>
                        </li>
                    </ul>
                    <button @click.prevent="addRow">Ajouter un choix</button>
                </div>
            </div>
            <button type="submit" class="btn btn-success">Ajouter</button>
        </form>
    </div>
    <div v-else>
        <div @click.prevent="showBloc = true" class="text-center"><i class="material-icons fs-64 pointer">add_circle_outline</i>
        </div>
    </div>
</template>

<script>
    import LabelType from "./LabelType";

    export default {
        name: "QuizQuestionForm",
        components: {LabelType},
        data() {
            return {
                showBloc: false,
                showValue: false,
                form: {
                    id_quiz: window.location.href.split('/').pop(),
                    label: '',
                    type: '',
                    values: []
                },
                errors: []
            }
        },
        methods: {
            creatQuestion() {
                axios.post('/creatQuestion', this.form).then(({data}) => {
                    const {label, type, ...rest} = data
                    const newQuestion = {
                        options: data.values.flatMap(v => Object.values(v)),
                        id: data.id_quiz,
                        label,
                        type
                    };
                    this.$emit('onNewQuestionCreated', newQuestion);
                    this.form.label = '';
                    this.form.type = '';
                    this.showValue = false;
                    this.showBloc = false;
                    this.errors = []
                })
                    .catch(error => {
                        this.errors = error.response.data.errors
                    })
            },
            showHide: function (e) {
                this.showValue = e.target.value !== 'textarea'
            },
            addRow: function() {
                this.form.values.push({
                    val: ''
                });
            },
            deleteRow: function(index) {
                this.form.values.splice(index, 1);
            }
        }
    }
</script>

<style scoped>
    .fs-64 {
        font-size: 54px;
    }

    .pointer {
        cursor: pointer;
    }
</style>
