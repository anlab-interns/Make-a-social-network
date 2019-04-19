<template>
    <div>
        <p v-for="message in messages">{{ message }}</p>
        <input v-model="text">
        <button @click="postMessage" :disabled="!contentExists">submit</button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                text: '',
                messages: []
            }
        },
        computed: {
            contentExists() {
                return this.text.length > 0;
            }
        },
        methods: {
            postMessage() {
                axios.post('/postMessages', {message: this.text}).then(({data}) => {
                    this.messages.push(data);
                    this.text = '';
                });
            }
        },
        created() {
            axios.get('/getAllMessages').then(({data}) => {
                this.messages = data;
            });
            // Registered client on public channel to listen to MessageSent event
            Echo.channel('public').listen('MessagePosted', ({message}) => {
                this.messages.push(message);
            });
        }
    }
</script>/