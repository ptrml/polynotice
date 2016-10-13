

var polynotice_socket;
var polynotice_channel = "polynotice";
var polynotice_returnchannel = "polynotice";
var jwt;

$(document).ready(function(){

    $.ajaxSetup({
        headers:
        { 'X-CSRF-TOKEN': '{{ Session::token() }}' }
    });


    $.getJSON( "/polynotice/cfg", function( data ) {
        polynotice_socket = io(data.node_url, {secure: true, query: 'jwt=' + data.jwt});
        new Vue({
            el: 'body',
        });


    });
});


Vue.component('polynotice',{
    template: '#polynotice-template',

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
                $.post('/polynotice/see', {id:notice.data.id}, function() {
                    console.log(notice.data.id+ ' seen');
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
        vm = this;
        $.getJSON( "/polynotice/unseen", function( result )
        {
            console.log(result);
            for(i=0;i<result.length;i++)
            {
                vm.appendNotsList(result[i]);
            }
        });
        polynotice_socket.on(polynotice_channel,function(socdata){

            if(socdata.type === 1)
            {
                socdata.data = JSON.parse(socdata.data);
                vm.appendNotsList(socdata.data);
            }
        });
    }


});



