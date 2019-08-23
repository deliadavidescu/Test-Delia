<template>
    <section class="my-5">
        <div v-if="errors.response" class="alert alert-danger">
            <p v-for="error in errors.response.data.errors">{{error[0]}}</p>
        </div>
        <div v-else-if="errors.length" class="alert alert-danger">
            <p v-for="error in errors">{{error}}</p>
        </div>
        <div v-if="success" class="alert alert-success">
            <p>Your form was sucessfully submitted.</p>
        </div>
        <form method="post" @keyup="formValidation" @submit.prevent="createNewInput">
            <div class="form-group">
                <label for="title">Book Title</label>
                <input type="text" v-bind:class="{'is-invalid' : validationErrors.bookTitle}"  class="form-control" id="title" placeholder="Enter Book Title" name="title"
                       v-model="form.bookTitle">
                <div v-if=" validationErrors.bookTitle" class="invalid-feedback">
                    {{ validationErrors.bookTitle}}
                </div>
            </div>
            <div class="form-group">
                <label for="release_date">Release Date</label>
                <input type="date" v-bind:class="{'is-invalid' : validationErrors.date}" class="form-control" id="release_date" placeholder="Enter email" name="date"
                       v-model="form.date">
                <div v-if=" validationErrors.date" class="invalid-feedback">
                    {{ validationErrors.date}}
                </div>
            </div>
            <div class="form-group">
                <label for="author">Author Name</label>
                <input type="text" v-bind:class="{'is-invalid' : validationErrors.authorName}" class="form-control" id="author" placeholder="Enter Author Name" name="name"
                       v-model="form.authorName">
                <div v-if=" validationErrors.authorName" class="invalid-feedback">
                    {{ validationErrors.authorName }}
                </div>
            </div>
            <div class="form-group">
                <label for="address">Author Address</label>
                <input type="text" v-bind:class="{'is-invalid' : validationErrors.address}" class="form-control" id="address" placeholder="Enter Author Address" name="address"
                       v-model="form.address">
                <div v-if=" validationErrors.address" class="invalid-feedback">
                    {{ validationErrors.address}}
                </div>
            </div>
            <div class="form-group">
                <label for="age">Author Age</label>
                <input type="text" v-bind:class="{'is-invalid' : validationErrors.age}" class="form-control" id="age" placeholder="Enter Author Age" name="age"
                       v-model="form.age">
                <div v-if=" validationErrors.age" class="invalid-feedback">
                    {{ validationErrors.age}}
                </div>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </section>
</template>

<script>
    import axios from 'axios'

    export default {
        data() {
            return {
                form: {
                    authorName: null,
                    bookTitle: null,
                    address: null,
                    age: null,
                    date: null
                },
                errors: [],
                success: false,
                validationErrors: {
                    authorName: null,
                    bookTitle: null,
                    address: null,
                    age: null,
                    date: null
                }
            }
        },
        methods: {
            createNewInput() {
                axios.post('/api/create', this.form)
                    .then((response) => {
                        this.$store.dispatch('loadData');
                        this.form = _.mapValues(this.form, () => null);
                        this.errors = [];
                        var obj = this;
                        setTimeout(function () {
                            obj.success = false;
                        }, 2000);
                        console.log(response);

                    }).catch((error) => {
                    this.errors = error;
                });
            },

            formValidation() {
                if (this.form.authorName && this.form.age && this.form.bookTitle && this.form.date && this.form.address) {
                    this.validationErrors = _.mapValues(this.validationErrors, () => null);
                }

                if (!this.form.authorName) {
                    this.validationErrors.authorName = 'Author name is required.';
                }else{ if(!this.isNameValid(this.form.authorName)){
                    this.validationErrors.authorName = 'Please enter a valid name';
                }else{
                    this.validationErrors.authorName = null;
                }}
                if (!this.form.address) {
                    this.validationErrors.address = 'Address is required.';
                }
                if (!this.form.age == null) {
                    this.validationErrors.age = 'Age is required.';
                }else{
                    if(!this.isAgeValid(this.form.bookTitle)){
                        this.validationErrors.age = 'Please enter a valid age';
                    }else{
                        this.validationErrors.age = null;
                    }
                }
                if (!this.form.bookTitle == null) {
                    this.validationErrors.bookTitle = 'Book title is required.';
                }else{
                    if(!this.isNameValid(this.form.bookTitle)){
                        this.validationErrors.bookTitle = 'Please enter a valid name';
                    }else{
                        this.validationErrors.bookTitle = null;
                    }

                }
                if (!this.form.date == null) {
                    this.validationErrors.date = 'Release date is required.';
                }





                console.log(this.validationErrors)

            },

            isNameValid(str) {
                let re = /^[A-Za-z ]+$/;
                console.log(re.test(str))
                return re.test(str);
            },
            isAgeValid() {
                let re = /^\d{1,3}$/;
                console.log(re.test(this.form.age))
                return re.test(this.form.age)

            }
        }
    }
</script>
