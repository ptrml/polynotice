<template id="polynotice-template">
    <li class="dropdown" >
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" >
            <span class="text-danger" v-show="hasNewNots"><strong>! <small>@{{ NewNotsCount }}</small></strong><span class="caret"></span></span>
            <span class="text-muted" v-else>!</span>
        </a>


        <ul class="dropdown-menu" v-if="hasNots" role="menu" >
            <li v-for="item in NotsList | orderBy 'seen' " @click="seeNotice(item)" class="polynotice-seen--@{{ isSeen(item) }}">
            <a class="text-muted " href="@{{ item.data.url }}" >

                <div v-if="item.data.type == 'message'">
                    <span class="pull-left" ><img class="polynotice-icon" src="@{{ item.data.icon }}"></span>
                    <span >
                                    <h4>@{{ item.data.title }}</h4>
                                    <p class="polynotice-content">@{{ item.data.content }}</p>
                                </span>
                </div>

                <div v-else >
                    <div>@{{ item.data.title }}</div>
                    <div>@{{ item.data.content }}</div>
                </div>

            </a>
            </li>
            <li v-if="hasNewNots"><a @click="seeAllNotices" class="text-muted pull-right" >x</a></li>
        </ul>
        <ul class="dropdown-menu" v-else role="menu">
            <li><a class="text-muted text-small" >No notifications yet</a></li>
        </ul>
    </li>
</template>


<!-- Scripts -->
{{--TODO dodadeno--}}
<Script src="https://vuejs.org/js/vue.js"></Script>
<script src="/js/app.js"></script>

<script>

    var polynotice_socket = io('192.168.10.10:3000');
    var polynotice_channel = "channelname";
    var polynotice_returnchannel = "returnchannel";

    Vue.component('polynotice',{
        template: '#polynotice-template',

        data: function(){
            return {
                NotsList: []
            }
        },

        methods: {
            appendNotsList: function(data)
            {
                this.NotsList.unshift({data:data,seen:false});
            },
            seeAllNotices: function(target)
            {
                target.stopPropagation();
                this.NotsList.filter(function (notice)
                {
                    notice.seen = true;
                });
            },
            seeNotice: function(notice)
            {
                notice.seen = true;
                polynotice_socket.emit(polynotice_returnchannel,this.notice.data.id);
                return false;
            },
            isSeen: function(notice)
            {
                return notice.seen;
            },
            isNew: function(notice)
            {
                return !notice.seen;
            },
            alert: function(target)
            {
                alert();
            }

        },

        computed: {
            hasNots: function(){
                return (this.NotsCount > 0);
            },
            hasNewNots: function(){
                return (this.NewNotsCount > 0);
            },
            NotsCount: function(){
                return this.NotsList.length;
            },
            NewNotsCount: function(){
                return this.NotsList.filter(this.isNew).length;
            }
        },

        created: function(){


            var data = {
                type: "message",
                title: "title",
                content: "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. ",
                url: "http://google.com",
                icon: "http://icons.iconarchive.com/icons/martz90/circle/128/chrome-icon.png"
            };

            this.appendNotsList(data);
            this.appendNotsList(data);
            this.appendNotsList(data);
        },

        ready: function()
        {

            polynotice_socket.on(polynotice_channel,function(data){
                this.appendNotsList(data);
            })
        }


    });

    new Vue({el: 'body'});


</script>

<style>
    .polynotice-seen--false *{
        font-weight: bolder !important;
    }

    .polynotice-seen--true *{
        /*font-weight: lighter !important;*/
    }

    .polynotice-icon {
        height: 50px;
        width: 50px;
        margin-right:30px;
    }

    .polynotice-content {
        word-wrap: break-word;
        width: 400px;
    }
</style>