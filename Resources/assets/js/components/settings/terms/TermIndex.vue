<template>
    <div class="container">
        <h1>Terms</h1>

        <table class="table table-strped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Year</th>
                    <th>Term</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="term in terms.data" :key="term.id">
                    <td>{{ term.id }}</td>
                    <td>{{ term.year }}</td>
                    <td>{{ term.term }}</td>
                    <td>{{ term.start_date }}</td>
                    <td>{{ term.end_date }}</td>
                    <td>
                        <button @click="handleEvent" class="btn btn-sm btn-primary mx-1">Edit</button>
                        <button @click="deleteTerm(term.id)" class="btn btn-sm btn-danger">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>


        <button
            class="btn btn-primary"
            type="button"
            data-bs-toggle="offcanvas"
            data-bs-target="#Id1"
            aria-controls="Id1"
        >
            New Term
        </button>

        <div
            class="offcanvas offcanvas-start"
            data-bs-scroll="true"
            tabindex="-1"
            id="Id1"
            aria-labelledby="Enable both scrolling & backdrop"
        >
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="Enable both scrolling & backdrop">
                    Backdrop with scrolling
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="offcanvas"
                    aria-label="Close"
                ></button>
            </div>
            <div class="offcanvas-body">
                <p>
                    Try scrolling the rest of the page to see this option in
                    action.
                </p>
            </div>
        </div>



    </div>
</template>

<script>
import axios from 'axios';

export default {
    components: {  },
    data() {
        return {
            terms: {},
            showCreateForm: false,
        };
    },
    methods: {
        fetchTerms(page = 1) {
            axios.get(`/site-settings/terms?page=${page}`).then((response) => {
                this.terms = response.data.terms;
            });
        },
        deleteTerm(id) {
            if (confirm('Are you sure you want to delete this term?')) {
                axios.get(`/site-settings/terms/delete/${id}`).then(() => this.fetchTerms());
            }
        },
        editTerm(term) {
            this.$emit('edit', term);
        },

        handleEvent(){
            console.log(event);
        }

    },
    mounted() {
        this.fetchTerms();
    },
};
</script>
