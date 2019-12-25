<template>
    <div class="container">
        <h2 v-show="quizzes.length > 0" class="mb-4">Liste des questionnaires</h2>
        <div v-for="quiz in quizzes" class="mb-5">
            <quiz :quiz="quiz" @delete="del"></quiz>
        </div>
        <h2>Créer un questionnaire</h2>
        <quiz-form @newQuiz="quizzes.push($event)"></quiz-form>
    </div>
</template>
<script>

    import QuizForm from "./QuizForm.vue";
    import Quiz from "./Quiz.vue";

    export default {
        components: {QuizForm, Quiz},
        data() {
            return {

                quizzes: [],
            }
        },
        mounted() {
            this.getAll();
        },
        methods: {
            getAll: function () {
                axios.get('/quizzes').then((response) => {
                    this.quizzes = response.data
                })
            },
            del(id) {
                axios.delete(`/quizzes/${id}`).then(() => {
                    let index = this.quizzes.findIndex(quiz => quiz.id === id);
                    this.quizzes.splice(index, 1);
                });
            }
        }
    }
</script>
<style>
    .br-red {
        border: 1px solid #f9d6d5;
    }
</style>
