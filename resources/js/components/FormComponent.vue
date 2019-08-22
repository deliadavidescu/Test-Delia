<template>
    <section>
        <div class="alert alert-danger">
            <p v-for="error in errors">{{error[0]}}</p>
        </div>
        <form method="post" @submit.prevent="createNewInput">
            <div class="form-group">
                <label for="title">Book Title</label>
                <input type="text" class="form-control" id="title" placeholder="Enter email" name="title"
                       v-model="form.bookTitle">
            </div>
            <div class="form-group">
                <label for="release_date">Release Date</label>
                <input type="date" class="form-control" id="release_date" placeholder="Enter email" name="date"
                       v-model="form.date">
            </div>
            <div class="form-group">
                <label for="author">Author Name</label>
                <input type="text" class="form-control" id="author" placeholder="Enter Author Name" name="name"
                       v-model="form.authorName">
            </div>
            <div class="form-group">
                <label for="address">Author Address</label>
                <input type="text" class="form-control" id="address" placeholder="Enter Author Address" name="address"
                       v-model="form.address">
            </div>
            <div class="form-group">
                <label for="age">Author Age</label>
                <input type="text" class="form-control" id="age" placeholder="Enter Author Age" name="age"
                       v-model="form.age">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </section>
</template>

<script>
    import axios from 'axios'

    export default {
        data() {
            return {
                form: {
                    authorName: '',
                    bookTitle: '',
                    address: '',
                    age: null,
                    date: null
                },
                errors: null
            }
        },
        mounted() {
        },
        methods: {
            createNewInput() {
                axios.post('/api/create', this.form)
                    .then((response) => {
                        this.$store.dispatch('loadData')
                    }).catch((error) => {
                    console.log(error.response.data.errors);
                    this.errors = error.response.data.errors;
                });
            }
        }
    }
</script>
