<template>
    <Carousel 
        v-model="value2"
        :autoplay="carousel.autoplay"
        :autoplay-speed=carousel.autoplaySpeed
        :dots="carousel.dots"
        :trigger="carousel.trigger"
        :height="carousel.height"
        :arrow="carousel.arrow">
        <div class="wcarousel-list" v-for="img in this.imglist">
            <Carousel-item>
                <div class="top-carousel"><img :src="img.imgurl"></div>
            </Carousel-item>
        </div>
    </Carousel>
</template>
<script>
    export default {
        data () {
            return {
                carousel : {
                    autoplay : true,
                    autoplaySpeed : 3000,
                    dots: 'inside',
                    trigger: 'hover',
                    height: 500,
                    arrow: 'hover'
                },
                value2: 0,
                autoplay: 0,
                speed: {
                    type : Number,
                    default: 3000
                },
                imglist : [
                   {
                       imgurl : '/images/test.jpg',
                       imgtitle: 'welkin'
                   },{
                       imgurl : '/images/test.jpg',
                       imgtitle: 'welkin'
                   },{
                       imgurl : '/images/test.jpg',
                       imgtitle: 'welkin'
                   },{
                       imgurl : '/images/test.jpg',
                       imgtitle: 'welkin'
                   },
                ]
            }
        },
        created() {
          var height = $(window).height()
          console.log(height)
          this.carousel.height = height - 40
          $(window).scroll(function(){
            console.log($(window).scrollTop())
          })

          var func = this.func.getfunc()
          console.log(func)
        }
    }
</script>
