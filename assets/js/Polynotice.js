import io from 'socket.io-client';

export default class Polynotice {
    constructor() {
    }

    cfg(vm) {
        $.getJSON( "/polynotice/cfg", function( cfgdata ) {
            var polynotice_channel = "polynotice";
            var polynotice_socket = io(cfgdata.node_url, {secure: true, query: 'jwt=' + cfgdata.jwt});
            polynotice_socket.on(polynotice_channel,function(socdata){
                socdata.data = JSON.parse(socdata.data);
                if(socdata.type === 1)
                {
                    vm.$broadcast('polynotice_newnotice',socdata.data);
                }
            });
        });
    }

    seeNotice(notice) {
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
}