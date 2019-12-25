<template>
    <form @submit.prevent="creatQuiz">
        <div class="mb-3 form-group">
            <input type="text" class="form-control" :class="{'br-red' : errors.title}"
                   placeholder="Titre du questionnaire" v-model="form.title">
            <p class="alert alert-danger" v-if="errors.title" v-text="errors.title[0]"></p>

        </div>
        <button type="submit" class="btn btn-success">Créer</button>
    </form>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    title: ''
                },
                errors: []
            }
        },
        methods: {
            creatQuiz: function() {
                axios.post('/quizzes', this.form).then(({data}) => {
                    this.$emit('newQuiz', data);
                    this.form.title = '';
                    this.errors = []
                })
                    .catch(error => {
                        this.errors = error.response.data.errors
                    })
            }
        }
    }

</script>
