<template>
    <div class="laravel-like">

        <i
        class="icon laravelLike-icon thumbs up outline-none"
        v-on:click="increment"
        v-bind:class="{ outline: isoutlinelike, disabled: isdisable}"
        data-vote="1">
        </i>
        <span >{{ this.likes }}</span>
        <i
        class="icon  laravelLike-icon thumbs down outline-none"
        v-on:click="decrement"
        v-bind:class="{ outline: isoutlinedislike, disabled: isdisable}"
        data-vote="-1">
    </i>
    <span >{{ this.dislikes }}</span>
    </div>
</template>

<script>
      export default {
        props:['like_item_id'],
        data() {
            return {
              data: {},
              isoutlinelike: "",
              isdisable: "",
              isoutlinedislike: "",
              likes: null,
              dislikes: null,
            }
        },
        methods: {
            getUser(){
                axios.get('/laravellikecomment/likes/'+this.like_item_id)
                     .then((response)=>{
                        this.data = response.data

                        this.isoutlinelike=this.data[this.like_item_id+'likeIconOutlined']
                        this.isoutlinedislike=this.data[this.like_item_id+'dislikeIconOutlined']
                        this.isdisable=this.data[this.like_item_id+'likeDisabled']
                        this.likes=this.data[this.like_item_id+'total_like']
                        this.dislikes=this.data[this.like_item_id+'total_dislike']
                     })
            },
            increment(){
                 axios.get('/laravellikecomment/like/vote',{
                       params: {
                            item_id: this.like_item_id,
                            vote: 1,
                        }
                 })
                     .then((response)=>{

                         if(response.data.flag==1 && this.isoutlinelike=="outline"){
                            this.isoutlinelike=""
                            this.isoutlinedislike="outline"
                            this.likes=response.data.totalLike
                            this.dislikes=response.data.totalDislike
                         }
                         else if(response.data.flag==1 && this.isoutlinelike==""){
                            this.isoutlinelike="outline"
                            this.isoutlinedislike="outline"
                            this.likes=response.data.totalLike
                            this.dislikes=response.data.totalDislike
                         }

                     });
            },
            decrement(){
                 axios.get('/laravellikecomment/like/vote',{
                        params: {
                            item_id: this.like_item_id,
                            vote: -1,
                        }
                 })
                     .then((response)=>{
                        if(response.data.flag==1 && this.isoutlinedislike=="outline"){
                            this.isoutlinelike="outline"
                            this.isoutlinedislike=""
                            this.dislikes=response.data.totalDislike
                            this.likes=response.data.totalLike
                         }
                         else if(response.data.flag==1 && this.isoutlinedislike==""){
                            this.isoutlinelike="outline"
                            this.isoutlinedislike="outline"
                            this.dislikes=response.data.totalDislike
                            this.likes=response.data.totalLike
                         }
                     });
            }
        },
        created() {
            this.getUser()
        },

        mounted(){
            console.log('component mounted2.')
            Echo.private('likes')
                .listen('likeEvent', (e)=>{
                    this.likes=e.n1;
                    this.dislikes=e.n2;
                });

        }
    }
</script>
