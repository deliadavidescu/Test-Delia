<template>
    <section class="mb-3">
        <div v-if="success" class="alert alert-success success-msg my-4">
            <p>Your form was sucessfully submitted.</p>
        </div>
        <form class="form" @click="clearServerErrors()" method="post" @submit.prevent="createNewInput">
            <div class="form-group">
                <label for="title">Book Title</label>
                <input @input="wrongName($event)" type="text"
                       v-bind:class="{'is-invalid' : validationErrors.bookTitle || serverErrors.bookTitle }"
                       class="form-control form-control-sm"
                       id="title" placeholder="Enter Book Title" name="bookTitle"
                       v-model="form.bookTitle">
                <div v-if=" validationErrors.bookTitle" class="invalid-feedback">
                    {{ validationErrors.bookTitle}}
                </div>
                <div v-else-if="serverErrors.bookTitle" class="invalid-feedback">
                    {{serverErrors.bookTitle[0]}}
                </div>
            </div>
            <div class="form-group">
                <label for="release_date">Release Date</label>
                <input type="date" v-bind:class="{'is-invalid' : validationErrors.date || serverErrors.date}"
                       class="form-control form-control-sm"
                       id="release_date" placeholder="Enter email" name="date"
                       v-model="form.date">
                <div v-if=" validationErrors.date" class="invalid-feedback">
                    {{ validationErrors.date}}
                </div>
                <div v-else-if="serverErrors.date" class="invalid-feedback">
                    {{serverErrors.date[0]}}
                </div>

            </div>
            <div class="form-group">
                <label for="author">Author Name</label>
                <input type="text" @input="wrongName($event)"
                       v-bind:class="{'is-invalid' : validationErrors.authorName || serverErrors.authorName}"
                       class="form-control form-control-sm"
                       id="author" placeholder="Enter Author Name" name="authorName"
                       v-model="form.authorName">
                <div v-if=" validationErrors.authorName" class="invalid-feedback">
                    {{ validationErrors.authorName }}
                </div>
                <div v-else-if="serverErrors.authorName" class="invalid-feedback">
                    {{serverErrors.authorName[0]}}
                </div>
            </div>
            <div class="form-group">
                <label for="address">Author Address</label>
                <input @input="wrongAddress()" type="text"
                       v-bind:class="{'is-invalid' : validationErrors.address || serverErrors.address}"
                       class="form-control form-control-sm"
                       id="address" placeholder="Enter Author Address" name="address"
                       v-model="form.address">
                <div v-if=" validationErrors.address" class="invalid-feedback">
                    {{ validationErrors.address}}
                </div>
                <div v-else-if="serverErrors.address" class="invalid-feedback">
                    {{serverErrors.address[0]}}
                </div>
            </div>
            <div class="form-group">
                <label for="age">Author Age</label>
                <input @input="wrongAge()" type="text"
                       v-bind:class="{'is-invalid' : validationErrors.age || serverErrors.age}"
                       class="form-control form-control-sm" id="age"
                       placeholder="Enter Author Age" name="age"
                       v-model="form.age">
                <div v-if="validationErrors.age" class="invalid-feedback">
                    {{ validationErrors.age}}
                </div>
                <div v-else-if="serverErrors.age" class="invalid-feedback">
                    {{serverErrors.age[0]}}
                </div>

            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </section>
</template>

<script>
    import axiosRequest from '../axiosRequest'

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
                serverErrors: {
                    authorName: null,
                    bookTitle: null,
                    address: null,
                    age: null,
                    date: null
                },
                success: false,
                focus: false

            }
        },
        methods: {
            createNewInput() {
                axiosRequest.post('/api/create', this.form)
                    .then((response) => {
                        this.$store.dispatch('loadData');
                        this.form = _.mapValues(this.form, () => null);
                        this.serverErrors = _.mapValues(this.serverErrors, () => null);
                        let obj = this;
                        this.success = true;
                        setTimeout(function () {
                            obj.success = false;
                        }, 3000);
                        console.log(response);

                    }).catch((error) => {
                    this.serverErrors = error.response.data.errors;
                });
            }

            ,

            clearServerErrors() {
                this.serverErrors = _.mapValues(this.serverErrors, () => null);
            },

            isNameValid(str) {
                let re = /^[A-Za-z ]+$/;
                return re.test(str);
            },

            isAgeValid() {
                let re = /^\d{1,3}$/;
                return re.test(this.form.age)

            },

            validateAlfaNoumeric(field) {
                let re = /^[a-z A-Z 0-9 / -]+$/;
                return re.test(field);
            },

            checkErrors() {
                const values = Object.values(this.validationErrors);
                console.log(values.every(element => element === null));
                return values.every(element => element === null)
            },

            wrongName(event) {
                let str = event.target.name;
                let obj = this.form;
                let errors = this.validationErrors;
                errors[str] = (!this.isNameValid(obj[str])) ? "Please enter only letters" : null;
            },

            wrongAge() {
                this.validationErrors.age = (!this.isAgeValid()) ? "Please enter a valid age" : null;
            },

            wrongAddress() {
                this.validationErrors.address = (!this.validateAlfaNoumeric(this.form.address)) ? 'Please enter only numbers and letters' : null;
            }
        }
    }

</script>
