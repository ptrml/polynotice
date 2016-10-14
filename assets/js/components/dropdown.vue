<template>
    <li class="dropdown" >
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" >
            <span class="text-danger" v-show="hasNewNots"><strong>! <small>{{ NewNotsCount }}</small></strong><span class="caret"></span></span>
            <span class="text-muted" v-else>!</span>
        </a>


        <ul class="dropdown-menu" v-if="hasNots" role="menu" >
            <li v-for="item in NotsList | orderBy 'seen' " @click="seeNotice(item)" class="polynotice-seen--{{ isSeen(item) }}">
                <a class="text-muted " href="{{ item.data.action }}" >

                    <div v-if="item.data.type == 'message'">
                        <span class="pull-left" >
                            <img class="polynotice-icon" v-bind:src="item.data.icon" >
                        </span>
                        <span >
                                    <h4>{{ item.data.title }}</h4>
                                    <p class="polynotice-content">{{ item.data.content }}</p>
                                </span>
                    </div>

                    <div v-else >
                        <div>{{ item.data.title }}</div>
                        <div>{{ item.data.content }}</div>
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

<script>
    export default {
        data: function(){
            return {
                NotsList: []
            }
        },

        methods: {
            appendNotsList: function(result)
            {
                this.NotsList.unshift({data:result,seen:false});
            },
            seeAllNotices: function(target)
            {
                target.stopPropagation();
                this.NotsList.filter(function (notice)
                {
                    notice.data.seen = true;
                });
            },
            seeNotice: function(notice)
            {
                notice.data.seen = true;

                if(notice.data.id)
                {
                    //polynotice_socket.emit(polynotice_returnchannel,{type : 2,data : notice.data.id});
                    $.ajax({
                        url: '/polynotice/see',
                        type: 'post',
                        data: {
                            id: notice.data.id
                        },
                        headers: {
                            'X-CSRF-Token': window.Laravel.csrfToken
                        },
                        dataType: 'json'
                    });
                }
                return false;
            },
            isSeen: function(notice)
            {
                if(notice.data.seen)
                    return true;
                else
                    return false;
            },
            isNew: function(notice)
            {
                if(notice.data.seen)
                    return false;
                else
                    return true;
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

        },

        ready: function()
        {
            var vm = this;
            $.getJSON( "/polynotice/unseen", function( result )
            {
                console.log(result);
                for(i=0;i<result.length;i++)
                {
                    vm.appendNotsList(result[i]);
                }
            });

        },

        events: {
            'polynotice_newnotice' : function(result)
            {
                this.appendNotsList(result);
            }
        }
    }
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