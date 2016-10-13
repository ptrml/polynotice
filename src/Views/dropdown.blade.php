
<template id="polynotice-template">
    <li class="dropdown" >
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" >
            <span class="text-danger" v-show="hasNewNots"><strong>! <small>@{{ NewNotsCount }}</small></strong><span class="caret"></span></span>
            <span class="text-muted" v-else>!</span>
        </a>


        <ul class="dropdown-menu" v-if="hasNots" role="menu" >
            <li v-for="item in NotsList | orderBy 'seen' " @click="seeNotice(item)" class="polynotice-seen--@{{ isSeen(item) }}">
            <a class="text-muted " {{--href="@{{ item.data.action }}"--}} >

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

<script type="text/javascript" src="{{ asset('polynotice.js') }}"></script>