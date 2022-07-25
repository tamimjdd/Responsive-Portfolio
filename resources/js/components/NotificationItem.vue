<template>
    <div class="wrap">
        <div  v-if="this.unread.type==='App\\Notifications\\UserFollowed'">
            <a :href="Url">
                {{ this.unread.data.follower_name }} followed you
                <div>
                {{ this.unread.created_at | diffForHumans }}
                </div>
            </a>
        </div>
        <div v-else-if="this.unread.type === 'App\\Notifications\\NewPost'">
            <a :href="Url2">
                {{ this.unread.data.following_name }} created a post
                <div>
                {{ this.unread.created_at | diffForHumans }}
                </div>
            </a>
        </div>

    </div>
</template>

<script>
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
    export default{

        props:['unread'],
        created() {
            dayjs.extend(relativeTime);
        },

        filters: {
            diffForHumans: (date) => {
                if (!date){
                    return null;
                }

                return dayjs(date).fromNow();
            }
        },

        data(){
            return{
                Url:"",
                Url2:"",
            }
        },


        mounted(){
            this.Url="/profile/"+this.unread.data.follower_id;
            this.Url2="/p/"+this.unread.data.post_id;
        }
    }
</script>
