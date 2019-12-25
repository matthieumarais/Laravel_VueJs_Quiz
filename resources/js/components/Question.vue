<template>
    <div class="card mb-4 p-4">
        <span @click="isEditMode = true" class="edit"><i class="material-icons pointer center-y txt-white">edit</i></span>
        <span @click="delQuestion" class="del"><i class="material-icons pointer center-y txt-white">delete_forever</i></span>
        <h4 v-if="!isEditMode" class="mt-2">titre question : {{newQuestion.label}} </h4>
        <div v-else class="input-group mb-3">
            <input type="text" class="form-control mt-2" :class="{'br-red' : errors.label}" v-model="newQuestion.label">
            <p class="alert alert-danger" v-if="errors.label" v-text="errors.label[0]"></p>
        </div>
        <p>type: {{newQuestion.type}}</p>
        <div v-if="isEditMode" class="form-group">
            <select class="form-control" @change="editType" required>
                <option disabled value="">Choisissez</option>
                <option v-for="(selectType, index) in selectTypes" :selected="newQuestion.type === selectType">
                    {{selectType}}
                </option>
            </select>
            <p class="alert alert-danger" v-if="errors.type" v-text="errors.type[0]"></p>
        </div>
        <div v-if="!isEditMode">
            <template v-if="this.newQuestion.type==='textarea'">
                <textarea></textarea>
            </template>
            <template v-else>
                <div v-for="(option,index) in newQuestion.options" :key="index">
                    <label>{{option}}</label>
                    <input :type="newQuestion.type">
                </div>
            </template>
        </div>
        <div v-else>
            <div v-if="newQuestionTypeDiffTextarea">
                <h1>Values</h1>
                <ul class="list-unstyled">
                    <li v-for="(option, index) in newQuestion.options">
                        <input type="text" :value="option" @input="(event)=>updateOption(event, index)">
                        <button @click="deleteRow(index)">Delete</button>
                    </li>
                </ul>
                <p class="alert alert-danger" v-if="errors.options" v-text="errors.options[0].split(' unless')[0]"></p>
                <button @click="addOption">Ajouter un choix</button>
            </div>
            <button @click="saveEditQuestion" class="btn btn-success" type="button">Valider</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Question",
        props: {
            question: {
                type: Object,
                default: () => {
                }
            }
        },
        data() {
            return {
                selectTypes: ['textarea', 'radio', 'checkbox'],
                newQuestion: {
                    idQuiz: window.location.href.split('/').pop(),
                    id: '',
                    label: '',
                    type: '',
                    options: []
                },
                isEditMode: false,
                errors : []
            }
        },
        computed: {
            newQuestionTypeDiffTextarea() {
                return this.newQuestion.type !== 'textarea'
            }
        },
        methods: {
            delQuestion: function(index){
                this.$emit('delQuestion', this.newQuestion.id);
            },
            deleteRow: function(index) {
                this.newQuestion.options.splice(index, 1);
            },
            editType: function (e) {
                this.$set(this.newQuestion, 'type', e.target.value)
                if (e.target.value === 'textarea') {
                    this.newQuestion.options = []
                }
            },
            updateOption: function(event, index) {
                this.newQuestion.options[index] = event.target.value;

            },
            addOption: function() {
                this.newQuestion.options.push('');
            },
            saveEditQuestion: function () {
                this.isEditTitle = false
                axios.post('/editQuestion', this.newQuestion).then(({data}) => {
                    this.isEditMode = false;
                    this.errors = []
                })
                    .catch(error => {
                        this.errors = error.response.data.errors
                    })
            },
        },
        mounted() {
            const {id, label, options, type} = this.question;
            this.newQuestion.id = id;
            this.newQuestion.label = label;
            this.newQuestion.type = type;
            if (options && options.length) {
                this.newQuestion.options = options;
            }
        }
    }
</script>

<style scoped>
    .pointer {
        cursor: pointer;
    }
    .edit{
        position: absolute;
        top: 0;
        left: 0;
        width: 30px;
        height: 30px;
        background: #17a2b8;
    }
    .center-y{
        position: absolute;
        top:50%;
        left:50%;
        transform: translate(-50%, -50%);
    }
    .txt-white{
        color: #fff;
    }
    .del{
        position: absolute;
        top:0;
        right:0;
        width: 30px;
        height: 30px;
        background: #dc3545;
    }
</style>
