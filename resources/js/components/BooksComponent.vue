<template>
    <section>
<button @click="displayBooks">Show all books</button>
       <div v-if="books !== null">
           <div v-for="index in books.data">
               <div v-for="books in index">
                   <p>{{books.name}}</p>
                   <p>{{books.author.name}}</p>
               </div>
           </div>
        </div>
</section>
</template>

<script>
    import axios from 'axios'
    export default {
        data() {
            return{
                books:null
            }
        },
        methods:{
            displayBooks(){
                console.log("works")
                console.log(this.form)
                axios.get('/api/books')
                    .then((response) => {
                        this.books=response;
                        console.log(response)
                    }).catch((error) => {
                    console.log(error);
                });
            }
        }
    }
</script>

