<template>
    <div class="form-group">
        <label>{{question.label}}</label>
        <template v-if="question.type==='textarea'">
            <textarea class="form-control" @input="handleTextareaChange">{{prospectAnswer[0]}}</textarea>
        </template>
        <template v-else>
            <div v-for="(option,index) in question.options" :key="index">
                <span>{{option}}</span>
                <input :name="question.id" :type="question.type" :checked="isChecked(option)"
                       @input="(event)=>handleInputChange(event, option)">
            </div>
        </template>
    </div>
</template>

<script>
    import _ from 'lodash'

    export default {
        name: "PrintQuestion",
        props: {
            question: {
                type: Object,
                default: () => {
                }
            },
            id_prospect: {
                type: Number,
            }
        },
        watch: {
            prospectAnswer: _.debounce(function (answer) {
                this.$emit('answer', {
                    id_question: this.question.id,
                    value: answer
                })
            }, 1200),
            id_prospect: {
                immediate: true,
                async handler(id) {
                    if (id) {
                        const {data} = await this.fetchAnswer();
                        if (data.length) {
                            if (this.question.type === 'textarea' || this.question.type === 'radio') {
                                this.prospectAnswer = [data[0].value];
                            } else {
                                this.prospectAnswer = data[0].value.split(';');
                            }
                        }
                    }
                }
            }
        },
        data() {
            return {
                prospectAnswer: []
            }
        },
        methods: {
            handleInputChange: function (event, option) {
                if (this.prospectAnswer.includes(option)) {
                    this.prospectAnswer = this.prospectAnswer.filter(answer => answer !== option)
                } else if (this.question.type === 'radio') {
                    this.prospectAnswer = [option];
                } else {
                    this.prospectAnswer = [...this.prospectAnswer, option]
                }
            },
            handleTextareaChange: function (e) {
                this.prospectAnswer = [e.target.value];
            },
            fetchAnswer: async function () {
                return await axios(`/fetchAnswer/${this.question.id}/${this.id_prospect}`)
            },
            isChecked: function (option) {
                return this.prospectAnswer.includes(option);
            }
        },
    }
</script>
