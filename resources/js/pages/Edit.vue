<template>
    <div class='container pb-5 col-md-8 mx-auto'>
        <a href="/home">Retour</a>
        <h1 class="mb-4">{{title}}</h1>
        <question v-for="question in questions" :key="question.id" :question="question"
                  @onQuestionLabelChange="handleQuestionLabelChange" @delQuestion="del"></question>
        <!-- <quiz-question :questions="questions"></quiz-question>-->
        <quiz-question-form @onNewQuestionCreated="handleNewQuestionCreated"></quiz-question-form>
        <ul v-if="newQuestions.length">
            <li v-for="question in newQuestions"></li>
        </ul>
        <add-prospect @incrementProspect="nbProspect++" @decrementProspect="nbProspect--"></add-prospect>
        <div v-if="isSend" class="alert alert-success" role="alert">
            Questionnaire envoyé !!
        </div>
        <button v-if="nbProspect > 0" @click="sendMail" class="btn btn-info">Envoyer le questionnaire</button>
    </div>
</template>

<script>
    import QuizQuestion from "../components/QuizQuestion";
    import QuizQuestionForm from "../components/QuizQuestionForm";
    import AddProspect from "../components/addProspect";

    export default {
        name: "Edit",
        props: ['dataInfos', 'dataTitle', 'dataProspect'],
        components: {AddProspect, QuizQuestionForm, QuizQuestion},

        data() {

            return {
                newQuestions: [],
                id: window.location.href.split('/').pop(),
                title: this.dataTitle,
                questions: this.dataInfos || [],
                isSend: false,
                nbProspect: this.dataProspect
            };
        },


        methods: {
            del(id) {
                axios.delete(`/delQuestion/${id}`).then(() => {
                    let index = this.questions.findIndex(question => question.id === id);
                    this.questions.splice(index, 1);
                });
            },
            handleQuestionLabelChange: function ({id, label}) {
                const index = this.questions.findIndex((question) => question.id === id);
                this.questions[index].label = label;
            },
            handleNewQuestionCreated: function (newQuestion) {
                console.log(newQuestion)
                this.questions = [...this.questions, newQuestion];
            },
            sendMail: function () {
                if (this.nbProspect > 0) {
                    axios.get('/send-mail/' + this.id).then((data) => {
                        this.isSend = true
                    })
                }
            }
        },
    };
</script>

