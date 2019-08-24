<template>
    <section class="mb-3">
        <div v-if="errors.response" class="alert alert-danger">
            <p v-for="error in errors.response.data.errors">{{error[0]}}</p>
        </div>
        <div v-else-if="errors.length" class="alert alert-danger">
            <p v-for="error in errors">{{error}}</p>
        </div>
        <div v-if="success" class="alert alert-success">
            <p>Your form was sucessfully submitted.</p>
        </div>
        <form class="form" method="post" @submit.prevent="createNewInput">
            <div class="form-group">
                <label for="title">Book Title</label>
                <input @input="wrongName($event)" type="text" v-bind:class="{'is-invalid' : validationErrors.bookTitle}"
                       class="form-control form-control-sm"
                       id="title" placeholder="Enter Book Title" name="bookTitle"
                       v-model="form.bookTitle" required>
                <div v-if=" validationErrors.bookTitle" class="invalid-feedback">
                    {{ validationErrors.bookTitle}}
                </div>
            </div>
            <div class="form-group">
                <label for="release_date">Release Date</label>
                <input type="date" v-bind:class="{'is-invalid' : validationErrors.date}"
                       class="form-control form-control-sm"
                       id="release_date" placeholder="Enter email" name="date"
                       v-model="form.date" required>
                <div v-if=" validationErrors.date" class="invalid-feedback">
                    {{ validationErrors.date}}
                </div>
            </div>
            <div class="form-group">
                <label for="author">Author Name</label>
                <input type="text" @input="wrongName($event)"
                       v-bind:class="{'is-invalid' : validationErrors.authorName}"
                       class="form-control form-control-sm"
                       id="author" placeholder="Enter Author Name" name="authorName"
                       v-model="form.authorName" required>
                <div v-if=" validationErrors.authorName" class="invalid-feedback">
                    {{ validationErrors.authorName }}
                </div>
            </div>
            <div class="form-group">
                <label for="address">Author Address</label>
                <input type="text" v-bind:class="{'is-invalid' : validationErrors.address}"
                       class="form-control form-control-sm"
                       id="address" placeholder="Enter Author Address" name="address"
                       v-model="form.address" required>
                <div v-if=" validationErrors.address" class="invalid-feedback">
                    {{ validationErrors.address}}
                </div>
            </div>
            <div class="form-group">
                <label for="age">Author Age</label>
                <input @input="wrongAge()" type="text" v-bind:class="{'is-invalid' : validationErrors.age}"
                       class="form-control form-control-sm" id="age"
                       placeholder="Enter Author Age" name="age"
                       v-model="form.age" required>
                <div v-if="validationErrors.age" class="invalid-feedback">
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
                validationErrors: {
                    authorName: null,
                    bookTitle: null,
                    address: null,
                    age: null,
                    date: null
                },
                errors: [],
                success: false,
                focus: false

            }
        },
        methods: {

            createNewInput() {
                let token = document.head.querySelector('meta[name="csrf-token"]');
                var headers = {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': token.content
                };

                if (this.checkErrors()) {
                    axios.post('/api/create', this.form, {headers: headers})
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
                }
            },

            isNameValid(str) {
                let re = /^[A-Za-z ]+$/;
                return re.test(str);
            },

            isAgeValid() {
                let re = /^\d{1,3}$/;
                return re.test(this.form.age)

            },

            checkErrors() {
                const values = Object.values(this.validationErrors);
                console.log(values.every(element => element === null));
                return values.every(element => element === null)
            },

            wrongName(event) {
                var str = event.target.name;
                var obj = this.form;
                var errors = this.validationErrors;
                console.log(obj[str])

                if (!this.isNameValid(obj[str])) {
                    errors[str] = 'Please enter only letters';
                } else {
                    errors[str] = null;
                }
            },

            wrongAge() {

                if (!this.isAgeValid()) {
                    this.validationErrors.age = 'Please enter a valid age';
                } else {
                    this.validationErrors.age = null;
                }

            },
        }
    }

</script>
