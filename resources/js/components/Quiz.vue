<template>
    <div class="card mb-4 p-4">
        <div class="row">
            <div class="col-md-8">
                <h5>{{quiz.title}} - <em>{{quiz.human_created_at}}</em></h5>
            </div>
            <div class="col-md-4 text-right">
                <a :href="'/edit/' + quiz.id" class="btn btn-info">Éditer</a>
                <button class="btn btn-danger" @click="del">Supprimer</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['quiz'],

        methods: {
            del() {
                this.$emit('delete', this.quiz.id);
            },
        }
    }
</script>
