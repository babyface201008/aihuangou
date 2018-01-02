<style scoped>
    .time{
        font-size: 14px;
        font-weight: bold;
    }
    .content{
        padding-left: 5px;
    }
    .timeline { 
        margin-top: 20px;
        margin-left:20px;
    }
</style>
<template>
    <Timeline class="timeline">
        <Timeline-item v-for="tl in timeline" class="timeline-item">
            <p class="time">{{ tl.time }}</p>
            <p class="content">{{ tl.content }}</p>
        </Timeline-item>
    </Timeline>
</template>
<script>
    export default {
        data () {
            return {
                timeline : [
                    {
                        time : '2017 年 5 月 17 日',
                        content : '小型的梦苍源站点低调上线'
                    }
                ]
            }
        }
    }
</script>
