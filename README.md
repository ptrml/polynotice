# Polynotice
Simple realtime notifications for your Laravel app in less then 5 minutes.

##Prerequisites
<ul>
<li>Laravel 5+</li>
<li>Redis</li>
<li>Socket.IO</li>
<li>Node</li>
<li>Gulp</li>
<li>Browserify</li>
<li>Vue</li>
<li>Bootstrap</li>
<li>jQuery</li>
</ul>

##Installation

### Backbone
#### Install Redis
<pre>apt-get install redis</pre>
#### Install current version of node.js
<pre>curl -sL https://deb.nodesource.com/setup_6.x | sudo -E bash -
sudo apt-get install -y nodejs</pre>
#### Deploy the node socket server
<pre>will update when uploaded</pre>

### Backend
#### Install via composer:
<pre>composer require ptrml/polynotice "dev-master"</pre>

#### Register the service provider in <b>conf/app.php</b>
<pre>Ptrml\Polynotice\PolynoticeServiceProvider::class</pre>

#### Publish stuff and migrate:
<pre>php artisan vendor:publish --tag=polynotice</pre>
<pre>php artisan migrate</pre>

### Frontend
#### Make sure your projects <b>packages.json</b> file contains these dependencies or install jquery, bootstrap, vue and socket.io manually
<pre>"bootstrap-sass": "^3.3.7",
    "gulp": "^3.9.1",
    "jquery": "^3.1.0",
    "laravel-elixir": "^6.0.0-11",
    "laravel-elixir-browserify-official": "^0.1.3",
    "laravel-elixir-vue": "^0.1.4",
    "laravel-elixir-vueify": "^2.0.0",
    "lodash": "^4.14.0",
    "vue": "^1.0.26",
    "babel-preset-es2015": "^6.16.0",
    "babel-preset-react": "^6.16.0"</pre>
    
    
#### Install packages
  <pre>npm install</pre>
  <pre>gulp</pre>

## Usage
#### Import component
<pre>import polynotice_dropdown from './components/dropdown.vue';</pre>
#### Make sure to add the folowing code to the ready function of your main Vue block
<pre>ready: function(){

        $.getJSON( "/polynotice/cfg", function( cfgdata ) {
            var polynotice_channel = "polynotice";
            var polynotice_socket = io(cfgdata.node_url, {secure: true, query: 'jwt=' + cfgdata.jwt});
            polynotice_socket.on(polynotice_channel,function(socdata){
                socdata.data = JSON.parse(socdata.data);
                if(socdata.type === 1)
                {
                    this.$broadcast('polynotice_newnotice',socdata.data);
                }
            }.bind(this));
        }.bind(this));
    },</pre>
#### Make sure to register the folowing event to your main Vue block
<pre>events: {
        'polynotice_seenotice' : function(notice){
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
    }</pre>
