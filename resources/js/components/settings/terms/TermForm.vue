<template>
    <div>
        <h2>{{ term.id ? 'Edit Term' : 'Create Term' }}</h2>
        <form @submit.prevent="submitForm">
            <div>
                <label>Year:</label>
                <select v-model="form.year">
                    <option v-for="year in years" :key="year.id" :value="year.id">
                        {{ year.name }}
                    </option>
                </select>
            </div>
            <div>
                <label>Term:</label>
                <input v-model="form.term" />
            </div>
            <div>
                <label>Start Date:</label>
                <input type="date" v-model="form.start_date" />
            </div>
            <div>
                <label>End Date:</label>
                <input type="date" v-model="form.end_date" />
            </div>
            <div>
                <label>Next Term Start Date:</label>
                <input type="date" v-model="form.next_term_start_date" />
            </div>
            <button type="submit">Save</button>
            <button @click="$emit('close')">Cancel</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: ['term'],
    data() {
        return {
            form: {
                year: '',
                term: '',
                start_date: '',
                end_date: '',
                next_term_start_date: '',
            },
            years: [],
        };
    },
    methods: {
        fetchYears() {
            axios.get('/api/academic-years').then((response) => {
                this.years = response.data;
            });
        },
        submitForm() {
            const url = this.term ? `/site-settings/terms/update/${this.term.id}` : '/site-settings/terms/store';
            const method = this.term ? 'post' : 'post';

            axios[method](url, this.form).then(() => {
                this.$emit('saved');
                this.$emit('close');
            });
        },
    },
    mounted() {
        if (this.term) this.form = { ...this.term };
        this.fetchYears();
    },
};
</script>
