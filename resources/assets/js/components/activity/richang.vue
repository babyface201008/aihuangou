<style scoped>
	.wbox {
		/*border:1px solid #333;*/
		/*box-shadow: 10px 10px 5px #888888;*/
		border-radius: 5px;
		min-height: 50px;
		padding: 5px 2px;
	}
	.wbox img {
		width: 100%;
	    box-shadow: 3px 4px 11px #748e92;
		border-radius: 5px;
	}
	.wbox span {
		position: absolute;
		right: 10px;
		bottom: 5px;
	    color: gray;
	}
</style>
<template>
	<div class="richang">
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
				<router-link :to="{path: img.href}"
				<div class="top-carousel"><img :src="img.imgurl"></div>
			</Carousel-item>
		</div>
		</Carousel>
		<Row>
			<!-- <Col span="4" class="wbox">col-12</Col> -->
			<Col span="24" class="wbox">
				<Row>
					<Col span="12" class="wbox">	
						<Row>
							<Col span="24" class="wbox">
								<router-link :to="{ path: wlist.t1.href }" >
									<div>
										<img :src="wlist.t1.imgurl">
										<span>
											{{ wlist.t1.title }}
										</span>
									</div>
								</router-link>
							</Col>
						</Row>
						<Row>
							<Col span="24" class="wbox">
								<router-link :to="{ path: wlist.t2.href }" >
									<div>
										<img :src="wlist.t2.imgurl">
										<span>
											{{ wlist.t2.title }}
										</span>
									</div>
								</router-link>
							</Col>
						</Row>
					</Col>
					<Col span="12" class="wbox">
						<Row>
							<Col span="24" class="wbox">
								<router-link :to="{ path: wlist.t3.href }" >
									<div>
										<img :src="wlist.t3.imgurl">
										<span>
											{{ wlist.t3.title }}
										</span>
									</div>
								</router-link>
							</Col>
						</Row>
						<Row>
							<Col span="24" class="wbox">
								<router-link :to="{ path: wlist.t4.href }" >
									<div>
										<img :src="wlist.t4.imgurl">
										<span>
											{{ wlist.t4.title }}
										</span>
									</div>
								</router-link>
							</Col>
						</Row>
					</Col>
				</Row>
				<Row>
					<Col span="8" class="wbox">
						<router-link :to="{ path: wlist.t5.href }" >
							<div>
								<img :src="wlist.t5.imgurl">
								<span>
									{{ wlist.t5.title }}
								</span>
							</div>
						</router-link>
					</Col>
					<Col span="8" class="wbox">
						<router-link :to="{ path: wlist.t6.href }" >
							<div>
								<img :src="wlist.t6.imgurl">
								<span>
									{{ wlist.t6.title }}
								</span>
							</div>
						</router-link>
					</Col>
					<Col span="8" class="wbox">
						<router-link :to="{ path: wlist.t7.href }" >
							<div>
								<img :src="wlist.t7.imgurl">
								<span>
									{{ wlist.t7.title }}
								</span>
							</div>
						</router-link>
					</Col>
				</Row>

				<Row>
					<Col span="12" class="wbox">
						<router-link :to="{ path: wlist.t8.href }" >
							<div>
								<img :src="wlist.t8.imgurl">
								<span>
									{{ wlist.t8.title }}
								</span>
							</div>
						</router-link>
					</Col>
					<Col span="12" class="wbox">
						<router-link :to="{ path: wlist.t9.href }" >
							<div>
								<img :src="wlist.t9.imgurl">
								<span>
									{{ wlist.t9.title }}
								</span>
							</div>
						</router-link>
					</Col>
				</Row>
				<Row>
					<Col span="6" class="wbox">
						<router-link :to="{ path: wlist.t10.href }" >
							<div>
								<img :src="wlist.t10.imgurl">
								<span>
									{{ wlist.t10.title }}
								</span>
							</div>
						</router-link>
					</Col>
					<Col span="6" class="wbox">
						<router-link :to="{ path: wlist.t11.href }" >
							<div>
								<img :src="wlist.t11.imgurl">
								<span>
									{{ wlist.t11.title }}
								</span>
							</div>
						</router-link>
					</Col>
					<Col span="6" class="wbox">
						<router-link :to="{ path: wlist.t12.href }" >
							<div>
								<img :src="wlist.t12.imgurl">
								<span>
									{{ wlist.t12.title }}
								</span>
							</div>
						</router-link>
					</Col>
					<Col span="6" class="wbox">
						<router-link :to="{ path: wlist.t13.href }" >
							<div>
								<img :src="wlist.t13.imgurl">
								<span>
									{{ wlist.t13.title }}
								</span>
							</div>
						</router-link>
					</Col>
				</Row>
			</Col>
		</Row>

	</div>
</template>

<script>
	import carousel from '../shop/carousel.vue'
	export default {
		data () {
			return {
				wlist : {
					t1 : {
						title:	'趣闻',
						imgurl : '/images/test.jpg',
						href : ''
					},
					t2 : {
						title:	'11区',
						imgurl : '/images/test.jpg',
						href : ''
					},
					t3 : {
						title:	'漫图',
						imgurl : '/images/test.jpg',
						href : ''
					},
					t4 : {
						title:	'漫展',
						imgurl : '/images/test.jpg',
						href : ''
					},
					t5 : {
						title:	'日语',
						imgurl : '/images/test.jpg',
						href : ''
					},
					t6 : {
						title:	'德语',
						imgurl : '/images/test.jpg',
						href : ''
					},
					t7 : {
						title:	'英语',
						imgurl : '/images/test.jpg',
						href : ''
					},
					t8 : {
						title:	'学习资料',
						imgurl : '/images/test.jpg',
						href : ''
					},
					t9 : {
						title:	'周边日常',
						imgurl : '/images/test.jpg',
						href : ''
					},
					t10 : {
						title:	'小说',
						imgurl : '/images/test.jpg',
						href : ''
					},
					t11 : {
						title:	'本子',
						imgurl : '/images/test.jpg',
						href : ''
					},
					t12 : {
						title:	'同人',
						imgurl : '/images/test.jpg',
						href : ''
					},
					t13 : {
						title:	'梦友',
						imgurl : '/images/test.jpg',
						href : ''
					}
				},
				carousel : {
					autoplay : true,
					autoplaySpeed : 3000,
					dots: 'inside',
					trigger: 'hover',
					height: 215,
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
					imgtitle: '加载中……',
					href : '/news'
				},
				{
					imgurl : '/images/test.jpg',
					imgtitle: '加载中……',
					href : '/news'
				},
				{
					imgurl : '/images/test.jpg',
					imgtitle: '加载中……',
					href : '/news'
				}
				]
			}
		},
		methods: {
			loadnav () {
                axios.get('/api/getRiChangNav')
                .then((res) => {
                    if(res.data.ret == 0)
                    {
                        let nav = res.data.data;
                        if (nav !== '')
                        {
                            this.wlist = nav;
                        }else{
                            console.log('bad nav list');
                        }
                        //return  res.data.data;
                    }else{
                        return false
                    }
                }).catch((err) => {
                    console.log(err)
                })
			}
		},
		mounted () {
			this.loadnav();
		}
	}
</script>
