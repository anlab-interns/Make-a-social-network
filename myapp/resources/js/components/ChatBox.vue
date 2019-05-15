<template>
    <div style="flex-direction: column;height:400px;padding: 0px;">
        <div class="messages" style="height: 67%;overflow-y: scroll;overflow-x: hidden">
            <div class="messages-content" style="margin-left: 10px">
                <ChatItem v-for="(message, index) in list_messages" :key="index" :message="message"></ChatItem>
            </div>
        </div>
        <div style="flex: 0 1 40px;width: 100%;padding: 10px;position: relative;">
            <input type="text" v-model="message" class="message-input" @keyup.enter="sendMessage"
                   placeholder="Type message..."/>
            <!--            <button type="button" class="message-submit" @click="sendMessage">Send</button>-->
        </div>

    </div>
</template>

<script>
    import ChatItem from './ChatItem.vue'

    export default {
        props: ['receiver_id', 'room_id'],
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
            this.loadMessage(this.room_id);
            Echo.private('message.' + this.room_id)
                .listen('PrivateEvent', (data) => {
                    console.log('listening');
                    let message = data.message;
                    message.user = data.user;
                    this.list_messages.push(message);
                    this.scrollToBottom()
                })
        },
        updated() {
            this.loadMessage(this.room_id);
        },
        mounted() {
            this.csrfToken = document.head.querySelector('meta[name="csrf-token"]').content
        },
        methods: {
            loadMessage(id) {
                axios.get('/privateMessages/' + id)
                    .then(response => {
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
                    receiver_id: this.receiver_id,
                    room_id: this.room_id
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
        bottom: 0px;
        left: 10px;
        background: none;
        border: none;
        outline: none !important;
        resize: none;
        color: rgba(0, 0, 0, .7);
        font-size: 11px;
        height: 17px;
        margin: 0;
        /*padding-right: 10px;*/
        width: 255px;
    }

    .message-submit {
        position: absolute;
        z-index: 1;
        bottom: 0px;
        right: 0px;
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