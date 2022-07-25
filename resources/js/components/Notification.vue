<template>
     <div class="dropdown inline-block relative pr-4" id="markasread" @mouseover="markNotificationAsRead" >

            <span class="mr-1 flex">
                <i class="fas fa-bell"></i>
                <div  v-if="unreadNotifications.length > 0">
                    <span id="myDiv" ref="myDiv" class="inline-flex items-center
                        justify-center px-2 py-1 text-xs font-bold
                        leading-none text-red-100 bg-red-600
                        rounded-full">{{unreadNotifications.length}}</span>
                </div>
            </span>

        <div>
            <ul class="dropdown-menu absolute hidden text-gray-700 pt-1 overflow-y-auto h-80">
                <li>
                    <!-- {{ allnoti }} -->
                <notification-item v-for="unread in allnoti" :unread="unread" :key="unread.id"></notification-item>
                <infinite-loading @distance="1" @infinite="handleLoadMore"></infinite-loading>
                </li>

            </ul>

        </div>

        </div>
</template>

<script>
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import NotificationItem from './NotificationItem.vue';

export default{
    props:['unreads','userid'],
    components:{NotificationItem},
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
        return {
            unreadNotifications: this.unreads,
            allnoti: [],
            date: new Date(),
            page: 1,
        }
    },
    methods:{
        markNotificationAsRead(){
            if(this.unreadNotifications.length){
                axios.get('/markAsRead');
                this.unreadNotifications.splice(0);
            }
        },

        handleLoadMore($state){
                axios.get('/notifications?page=' + this.page)
                     .then((response)=>{
                        //   console.log(response.data.data)
                         $.each(response.data.data, (key, value) => {
                            this.allnoti.push(value);
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
            getNextUser() {
            window.onscroll = () => {
                let bottomOfWindow = document.documentElement.scrollTop + window.innerHeight === document.documentElement.offsetHeight;
                if (bottomOfWindow) {
                    axios.get('/notifications?page=' + this.page)
                     .then((response)=>{
                          console.log("this is working")
                         $.each(response.data.data, (key, value) => {
                            this.allnoti.push(value);
                        });
                        if(Object.keys(response.data.data).length){
                            $state.loaded();
                         }
                         else{
                             $state.complete();
                         }

                     });
                     this.page = this.page + 1;
                }
            }
            },

    },
     beforeMount() {
        this.handleLoadMore();
    },
    mounted(){
        this.getNextUser();

        console.log('component mounted.noti-desktop')
        Echo.private('App.Models.User.'+this.userid)
        .notification((notification) => {
            // console.log(this.userid);
            if(notification.type=="App\\Notifications\\UserFollowed"){
                let newUnreadNotifications={data:{follower_id:notification.follower_id,
                follower_name: notification.follower_name},
                created_at: this.date, type:'App\\Notifications\\UserFollowed'};
                this.unreadNotifications.unshift(newUnreadNotifications);
                this.allnoti.unshift(newUnreadNotifications);
            }
            else if(notification.type=="App\\Notifications\\NewPost"){
                let newUnreadNotifications={data:{following_id:notification.following_id,
                following_name: notification.following_name,
                post_id: notification.post_id},
                created_at: this.date, type: 'App\\Notifications\\NewPost'};
                this.unreadNotifications.unshift(newUnreadNotifications);
                this.allnoti.unshift(newUnreadNotifications);
            }
        });
    }
}
</script>
