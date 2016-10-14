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

##Step by step installation instructions coming soon!

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
#### Register the service provider in <b>conf/app.php</b>:
<pre>
'providers' => [
...
Ptrml\Polynotice\PolynoticeServiceProvider::class,
...
],
</pre>
#### Publish stuff and migrate:
<pre>php artisan vendor:publish --tag=polynotice</pre>
<pre>php artisan migrate</pre>

### Frontend
#### Make sure your projects <b>packages.json</b> file contains these dependencies or install jquery, bootstrap, vue and socket.io manually
<pre>
    "bootstrap-sass": "^3.3.7",
    "gulp": "^3.9.1",
    "jquery": "^3.1.0",
    "laravel-elixir": "^6.0.0-11",
    "laravel-elixir-browserify-official": "^0.1.3",
    "laravel-elixir-vue": "^0.1.4",
    "laravel-elixir-vueify": "^2.0.0",
    "lodash": "^4.14.0",
    "vue": "^1.0.26",
    "babel-preset-es2015": "^6.16.0",
    "babel-preset-react": "^6.16.0"
  </pre>
  #### Install packages
  <pre>npm install</pre>
  <pre>gulp</pre>
