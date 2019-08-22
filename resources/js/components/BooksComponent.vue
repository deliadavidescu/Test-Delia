<template>
    <section>
        <div class="button" @click="showBooks = !showBooks">Show all books</div>
        <div v-show="showBooks">
            <div v-for="index in Books">
                <div v-for="book in index">
                    {{book.id}}
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
            this.$store.dispatch('loadData')
        },
        computed: {
            Books() {
                return this.$store.getters.Books
            }
        }
    }
</script>

