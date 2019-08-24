<template>
    <section>
        <button class="btn btn-primary mx-auto mb-3" @click="showBooks = !showBooks">Show all books</button>
        <div class="books-container" v-show="showBooks">
            <div v-for="index in Books">
                <div v-for="book in index">
                    <div class="card my-5">
                        <div class="card-body">
                            <h5 class="card-title">{{book.name}}</h5>
                            <p class="card-text font-italic">{{book.author.name}}</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Release date: {{book.release_date}}</li>
                            <li class="list-group-item">Author address: {{book.author.address}}</li>
                            <li class="list-group-item">Author Age: {{book.author.age}} years</li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        data() {
            return {
                showBooks: false
            }
        },
        mounted() {
            this.$store.dispatch('loadData');
        },
        computed: {
            Books() {
                return this.$store.getters.Books;
            }
        }
    }
</script>

