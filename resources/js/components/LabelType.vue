<template>
    <div>
        <h1>Values</h1>
        <ul>
            <li v-for="(label, index) in labels">
                <input type="text" v-model="label.val">
                <button @click.prevent="deleteRow(index)">Delete</button>
            </li>
        </ul>
        <button @click.prevent="addRow">Ajouter un choix</button>
    </div>
</template>

<script>
    export default {
        name: "LabelType",
        props: {
            values: [Array]
        },
        data() {
            return {
                labels: []
            }
        },
        methods: {}
    }
</script>
