<template>
    <div class="center ">
        <!-- {{ Products[0].data }} -->
        <div v-for="unread in Products" :key="unread.id">
            <!-- {{ unread.type}} -->
            <div  v-if="unread.type==='App\\Notifications\\UserFollowed'">
                <a :href="'/profile/'+unread.data.follower_id">
                    {{ unread.data.follower_name }} followed you at
                    <hr>
                </a>
            </div>
            <div v-else-if="unread.type === 'App\\Notifications\\NewPost'">
                <a :href="'/p/'+unread.data.post_id">
                    {{ unread.data.following_name }} created a post
                    <hr>
                </a>
            </div>
        </div>
        <infinite-loading @distance="1" @infinite="handleLoadMore"></infinite-loading>
    </div>
</template>

<script>
    export default {
         mounted() {
            console.log('Component noti mounted.')
        },
        data() {
            return {
                Products: [],
                page: 1,
                Url: '',
                Url2: '',
            };
        },
        methods: {
             handleLoadMore($state){
                axios.get('/notifications?page=' + this.page)
                     .then((response)=>{
                        //  console.log(response.data.data)
                         $.each(response.data.data, (key, value) => {
                            this.Products.push(value);
                        });
                         if(Object.keys(response.data.data).length){
                            $state.loaded();
                         }
                         else{
                             $state.complete();
                         }

                     });
                     this.page = this.page + 1;
            },

        },


    }
</script>
