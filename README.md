# Polynotice
Simple realtime notifications for your Laravel app in 5 minutes.
<br><br><br>
##Prerequisites

### Redis
<pre>apt-get install redis</pre>
### node.js
<pre>curl -sL https://deb.nodesource.com/setup_6.x | sudo -E bash -
sudo apt-get install -y nodejs</pre>
or use nvm
### Custom node socket server
<pre>will update when uploaded</pre>
<br><br>
##Installation
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
<br><br><br>
## Usage
#### Import and instantiate
<pre>import Polynotice from './polynotice/Polynotice.js';
import polynotice_dropdown from './polynotice/components/dropdown.vue';

let polynotice = new Polynotice();</pre>
#### Make sure to append your the ready function and add the following event to your parent Vue block.
<pre>ready: function(){
        ...
        polynotice.cfg(this);
    },
    events: {
        ...
        'polynotice_seenotice' : polynotice.seeNotice,
    }</pre>

#### Use the dropdown template in your bootstrap navbar
```html
<ul class="nav navbar-nav navbar-right">
    ...
    <polynotice_dropdown></polynotice_dropdown>
</ul>
```
<br><br><br>
## Customization
Edit Vue components in <b>assets/js/polynotice/components</b> for a custom look and feel. 
Don't forget to gulp!

<br>
###Enjoy

<br><br><br><br>
## License

[MIT license](http://opensource.org/licenses/MIT).
