/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


// import axios from "axios";
// import * as Vue from "vue";

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('chat-layout', require('./components/ChatLayout.vue').default);
Vue.component('chat-box', require('./components/ChatBox.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    // props: ['friendInbox'],
    data: {
        msg: 'hello',
        body: '',
        posts: [],
        postId: '',
        bUrl: 'http://127.0.0.1:8000/',
        commentData: {},
        showComment: null,
        index: false,
        isDislike: false,
        dislike: null,
        currentUserLogin: {},
        user_id: null,
        friends: [],
        friendInbox: null,
        chatRoom: null,
        isInbox: false,
        inboxId: null,
        inboxWindowVisibility: 'hidden',
        allUsers: []
    },
    created() {
        this.getCurrentUserLogin();
        this.getAllUsers();
        this.getFriendList();
    },
    mounted: function () {
        this.create();
    },
    methods: {
        create: function () {
            axios.get(this.bUrl + '/dashboard/count')
                .then(response => {
                    // console.log(response.data); // show if success
                    app.posts = response.data; //we are putting data into our posts array
                })
                .catch(function (error) {
                    console.log(error); // run if we have error
                });
        },

        getRouteUrl(route, id) {
            return ('http://127.0.0.1:8000/' + route + "/" + id);
        },
        getImgUrl(pic) {
            return ('../../public/images/' + pic)
        },
        getAllUsers() {
            axios.get(this.bUrl + '/getAllUsers')
                .then(response => {
                    this.allUsers = response.data;
                })
                .catch(error => {

                })
        },
        getCurrentUserLogin() {
            axios.get('/getUserLogin')
                .then(response => {
                    this.currentUserLogin = response.data
                })
                .catch(error => {

                })
        },
        getFriendList() {
            axios.get('/getFriendList')
                .then(response => {
                    this.friends = response.data
                })
                .catch(error => {

                })
        },
        getFriendInbox(friend) {
            this.friendInbox = friend;
        },
        postChatRoom(id) {
            axios.post('/postChatRoom', {
                creater_id: this.currentUserLogin.id,
                member_id: id
            })
                .then(response => {
                    console.log(response.data);
                    this.chatRoom = null;
                    this.chatRoom = response.data
                })
                .catch(error => {

                })
        },
        displayInboxWindow(item) {
            if (app.inboxId !== item) {
                app.inboxId = item;
                app.isInbox = true;
            } else {
                app.isInbox = !app.isInbox;
            }
        },
        addPost: function () {
            axios.post(this.bUrl + '/createpost', {
                body: this.body,
            })
                .then((response) => {
                    app.body = "";
                    if (response.status === 200) {
                        app.posts = response.data;
                    }
                })
                .catch(function (error) {
                    console.log(error); // run if we have error
                });
        },
        deletePost: function (id) {
            axios.get(this.bUrl + '/delete-post/' + id)
                .then(response => {
                    if (response.status === 200) {
                        app.posts = response.data;
                    }
                })
                .catch(function (error) {
                    console.log(error); // run if we have error
                });
        },
        deleteLike: function (id) {
            axios.get(this.bUrl + '/deleteLike/' + id)
                .then(response => {
                    console.log(response);
                    // show if success
                    app.posts = response.data;
                })
                .catch(function (error) {
                    console.log(error); // run if we have error
                });
        },
        likePost: function (id) {
            axios.get(this.bUrl + '/likePost/' + id)
                .then(response => {
                    console.log(response); // show if success
                    app.posts = response.data; //we are putting data into our posts array
                })
                .catch(function (error) {
                    console.log(error); // run if we have error
                });
        },
        addComment: function (post, key) {
            axios.post(this.bUrl + '/addComment', {
                comment: this.commentData[key],
                id: post.id
            })
                .then((response) => {
                    app.commentData = {};
                    console.log(response); // show if success
                    if (response.status === 200) {
                        app.posts = response.data;
                    }
                })
                .catch(function (error) {
                    console.log(error); // run if we have error
                });
        },
        toggle: function (item) {

            if (app.showComment !== item) {
                app.showComment = item;
                app.index = true;
            } else {
                app.index = !app.index;
            }

        },
        dislikeToggle: function (item, id) {

            if (app.dislike !== item) {
                app.dislike = item;
                app.isDislike = true;

            } else {
                app.isDislike = !app.isDislike;
                this.deleteLike(id);
            }

        },
    },
});