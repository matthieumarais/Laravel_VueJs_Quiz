<template>
    <div>
        <div class="mt-4 mb-4">
            <ul class="list-unstyled">
                <li v-for="prospect in prospects" :key="prospect.id">
                    <input type="text" v-model="prospect.mail">
                    <button @click="deleteProspect(prospect.id)">Delete</button>
                </li>
            </ul>
            <ul v-if="isEditable" class="list-unstyled">
                <li>
                    <input type="text" :class="{'br-red' : errors.type}" v-model="newProspect">
                    <button class="btn-success" @click="insertProspect">Valider</button>
                    <p class="alert alert-danger" v-if="errors.mail" v-text="errors.mail[0]"></p>
                </li>
            </ul>
            <button @click="addProspect">Ajouter un prospect</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "addProspect",
        data() {
            return {
                id: window.location.href.split('/').pop(),
                isEditable: false,
                prospects: [],
                newProspect: '',
                errors: []
            }
        },
        methods: {
            showProspects: function () {
                axios.get(`/findProspects/${this.id}`).then(({data}) => {
                    this.prospects = data;
                })
            },
            deleteProspect: function (id) {
                axios.delete(`/delProspect/${id}`).then(() => {
                    let index = this.prospects.findIndex(prospect => prospect.id === id);
                    this.prospects.splice(index, 1);
                    this.$emit('decrementProspect');
                });
            },
            addProspect: function () {
                this.isEditable = true;
            },
            insertProspect: function () {
                axios.post(`/addProspect`, {
                    id_quiz: this.id,
                    state: 0,
                    mail: this.newProspect
                }).then(({data}) => {
                    const result = {
                        id: data,
                        mail: this.newProspect
                    };
                    this.prospects.push(result);
                    this.isEditable = false;
                    this.newProspect = "";
                    this.$emit('incrementProspect');
                })
                    .catch(error => {
                        this.errors = error.response.data.errors
                    });
            }
        },
        mounted() {
            this.showProspects()
        }
    }
</script>
