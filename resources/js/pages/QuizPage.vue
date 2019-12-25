<template>
    <div>
        <div v-if="isSend === 0">
            <form @submit.prevent="sendForm" class="col-md-8 mx-auto shadow p-3 mb-5 bg-white rounded">
                <h3 class="text-center">{{title}}</h3>
                    <print-question v-for="infoQuestion in questions" :key="infoQuestion.id" :question="infoQuestion" @answer="saveAnswer" :id_prospect="idProspect"></print-question>
                <div class="text-center">
                    <button type="submit" class="btn btn-success">Envoyer</button>
                </div>
            </form>
        </div>
        <div v-else>
            <div class="alert alert-success text-center" role="alert">
                Merci d'avoir répondu à notre questionnaire.
            </div>
        </div>
    </div>
</template>

<script>
    import PrintQuestion from "../components/PrintQuestion";
    export default {
        name: "QuizPage",
        components: {PrintQuestion},
        props: ['dataInfos', 'dataTitle', 'dataId', 'dataState'],
        data() {
            return {
                idProspect: null,
                idQuiz: this.dataId,
                title: this.dataTitle,
                questions: this.dataInfos,
                isSend: this.dataState
            }
        },
        methods: {
            getIdProspect: function() {
                const url = window.location.href.split('/').pop();
                this.idProspect = parseInt(url.split('__').shift());
            },
            saveAnswer: async function({id_question, value}){
                let formattedValue;
                if(!value.length){
                    return
                }else if(value.length === 1){
                    formattedValue = value[0];
                }else{
                    formattedValue = value.join(';');
                }
               const data = await axios.post('/replyQuestion', {
                    id_quiz: this.idQuiz,
                    id_question,
                    id_prospect: this.idProspect,
                    value: formattedValue
                })

            },
            sendForm: function () {
                if(confirm("Après cette validation aucun changement ne sera possible")){
                console.log('send');
                    axios.post(`/sendForm/${this.idProspect}`).then((data) => {
                        console.log('send mail');
                        this.isSend = 1;
                    })
                }
            }
        },
        mounted() {
            this.getIdProspect()
        }
    }
</script>
