<template>
    <div>
        <div class="messages">
            <div class="messages-content">
                <!--                <ChatItem v-for="(message, index) in list_messages" :key="index" :message="message"></ChatItem>-->
                <p>hello</p>
                <p>hello</p>
                <p>hello</p>
                <p>hello</p>
                <p>hello</p>
            </div>
        </div>
        <input type="text" class="message-input" @keyup.enter="sendMessage"
               placeholder="Type message..."/>
        <button type="button" class="message-submit" @click="sendMessage">Send</button>
    </div>
</template>

<script>
    import ChatItem from './ChatItem.vue'

    export default {
        props: ['receiver_id'],
        components: {
            ChatItem
        },
        data() {
            return {
                message: '',
                list_messages: [],
                csrfToken: ''
            }
        },
        created() {
            this.loadMessage();
            Echo.private('message.' + this.receiver_id)
                .listen('PrivateEvent', (data) => {
                    let message = data.message;
                    message.user = data.user;
                    this.list_messages.push(message);
                    this.scrollToBottom()
                })
        },
        mounted() {
            this.csrfToken = document.head.querySelector('meta[name="csrf-token"]').content
        },
        methods: {
            loadMessage(id) {
                axios.get('/privateMessages/' + id)
                    .then(response => {
                        // console.log(response);
                        this.list_messages = response.data
                    })
                    .catch(error => {
                        console.log(error)
                    })
            },
            scrollToBottom() {
                const container = document.querySelector('.messages')
                if (container) {
                    $(container).animate(
                        {scrollTop: container.scrollHeight},
                        {duration: 'medium', easing: 'swing'}
                    )
                }

            },
            sendMessage() {
                axios.post('/privateMessages', {
                    message: this.message,
                    receiver_id: this.receiver_id
                })
                    .then(response => {
                        this.list_messages.push({
                            message: this.message,
                            created_at: new Date().toJSON().replace(/T|Z/gi, ' '),
                            user: this.$root.currentUserLogin,
                            receiver_id: this.receiver_id
                        });
                        this.message = '';
                        this.scrollToBottom()
                    })
                    .catch(error => {
                        console.log(error)
                    })
            },

        }
    }
</script>
<style lang="scss" scoped>
    .message-input {
        position: absolute;
        z-index: 1;
        bottom: 9px;
        left: 10px;
        background: none;
        border: none;
        outline: none !important;
        resize: none;
        color: rgba(0, 0, 0, .7);
        font-size: 11px;
        height: 17px;
        margin: 0;
        padding-right: 20px;
        width: 200px;
    }

    .message-submit {
        position: absolute;
        z-index: 1;
        bottom: 9px;
        right: 10px;
        color: #fff;
        border: none;
        background: #248A52;
        font-size: 10px;
        text-transform: uppercase;
        line-height: 1;
        padding: 6px 10px;
        border-radius: 10px;
        outline: none !important;
        transition: background .2s ease;
    }
</style>