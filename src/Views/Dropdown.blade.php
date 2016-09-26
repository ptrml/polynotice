<template id="polynotice-template">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            <span class="text-danger" v-show="hasNots"><strong>! <small>@{{ NotsCount }}</small></strong><span class="caret"></span></span>
            <span class="text-muted" v-else>!</span>
        </a>


        <ul class="dropdown-menu" v-if="hasNots" role="menu">
            <li v-for="item in NotsList"><a class="text-muted" >@{{ item.text }}</a></li>
        </ul>
        <ul class="dropdown-menu" v-else role="menu">
            <li><a class="text-muted" >No notifications yet</a></li>
        </ul>
    </li>
</template>


<script>
    Vue.component('polynotice',{
        template: '#polynotice-template',

        data: function(){
            return {
                NotsList: []
            }
        },

        methods: {
            appendNotsList: function(title,text,url)
            {
                this.NotsList.push({title:title,text:text,url:url});
            },
            refreshNotsList: function()
            {
                //removes seen notices
            },
            seeNotice: function(target)
            {
                //marks notice as seen
            }

        },

        computed: {
            hasNots: function(){
                return (this.NotsCount > 0);
            },
            NotsCount: function(){
                return this.NotsList.length;
            }
        },

        created: function(){
            //TODO set socket and ajax
            this.appendNotsList("qwe","asd","zxc");
        }

    });

    new Vue({el: 'body'});

</script>