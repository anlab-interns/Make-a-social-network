<template>
    <div class="row"
         :class="{'is-test': $root.currentUserLogin.id === message.user.id}"

    >
        <img v-if="message.user.picture_path === '' && $root.currentUserLogin.id !== message.user.id"
             class="rounded-circle "
             style="margin: 10px 10px;"
             src="../../../public/public/images/male.png" width="40px" height="40px">
        <img v-else-if="message.user.picture_path !== '' && $root.currentUserLogin.id !== message.user.id"
             class="rounded-circle"
             style="margin: 10px 5px;"
             :src="getImgUrl(message.user.picture_path)" width="40px"
             height="40px">
        <!--        <div class="message-item timestamp">-->
        <!--            | {{ message.created_at.split(' ')[1] }}:-->
        <!--        </div>-->
        <div class="message message-item row"

             :class="{'is-current-user': $root.currentUserLogin.id === message.user.id}"
             style="word-break: break-word;display: flex;align-items: center;">
            {{ message.message }}
        </div>
    </div>
</template>

<script>
    export default {
        props: ['message'],
        methods: {
            getImgUrl(pic) {
                return ('../../../public/images/' + pic)
            },
        }
    }
</script>

<style lang="scss" scoped>
    .message {
        border: 2px solid #dedede;
        background-color: #f1f1f1;
        border-radius: 15px;
        padding: 5px 10px;
        margin: 10px 0;

        .message-item:not(:last-child) {
            margin-right: 5px;
        }
    }

    .message:not(:last-child) {
        padding-bottom: 10px;
    }

    .is-current-user {
        border-radius: 15px;
        padding: 5px 10px;
        margin: 10px 20px;
        background-color: #ddd;
        border: 2px solid #ccc;
    }

    .is-float-right {
        display: flex;
        justify-content: flex-end;
        margin-right: 5px;
    }

    .is-row {
        flex-direction: row;
    }

    .is-test {
        -ms-flex-pack: end !important;
        justify-content: flex-end !important;
    }
</style>