<style scoped>
.mcylogin {
    position: relative;
    width: 100%;
    /*padding-top: 40px;*/
    padding-bottom:50px;
    background: -webkit-gradient(linear, 0 0, 0 bottom, from(#ff0000), to(rgba(0, 0, 255, 0.5)));
    background: #fff;
    background-size: 100% ;
}
.mcylogin > h1{
  text-align: center;
  vertical-align: middle;
  margin-bottom: 20px;
  color: #000;
}
.login {
    margin: 0 auto;
    /*padding: 200px auto;*/
    width: 200px;
    height: 100%;
}
</style>

<template>
<div class="mcylogin" :style="{ background:'url('+ backgroundimg + ')',height: backgroundheight + 'px','padding-top':loginpadding + 'px','background-size': '100% 100%'}">
<h1>
梦苍源管理后台
</h1>
    <div class="login">
        <i-form ref="formInline" :model="formInline" :rules="ruleInline">
            <Form-item prop="username">
                <Input v-model="formInline.username"></Input>
            </Form-item>
            <Form-item prop="password">
                <Input v-model="formInline.password" type="password"></Input>
            </Form-item>
            <Form-item>
                <i-button type="success" @click.native="handleSubmit('formInline')" long>登录</i-button>
            </Form-item>
        </i-form>
    </div>
</div>

</template>

<script>
import func from '../public/func.js'
export default {
    data() {
            return {
            	backgroundimg : '/images/test.jpg',
            	backgroundheight : '400',
            	loginpadding : '200',
                formInline: {
                    username: '',
                    password: '',
                },
                ruleInline: {
                    username: [{
                        required: true,
                        message: '请填写用户名',
                        trigger: 'blur'
                    }],
                    password: [{
                        required: true,
                        message: '请填写密码',
                        trigger: 'blur'
                    }, {
                        type: 'string',
                        min: 6,
                        message: '密码长度不能小于6位',
                        trigger: 'blur'
                    }]
                }
            }
        },
        methods: {
            handleSubmit(name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        axios.post(
                            '/api/mcyLogin',
                            {
                                username : this.formInline.username,
                                password : this.formInline.password
                            })
                        .then ( (res) => {
                            console.log(res);
                            if (res.data.ret == 0)
                            {
                                let self = this
                                this.$Message.success(res.data.msg);
                                this.$store.dispatch('updateIsAdmin',1);
                                console.log(this.$store.state.isAdmin);
                                setTimeout(function(){
                                    self.$router.push('/mcy');
                                },1000);                                
                            }else{
                                this.$Message.error(res.data.msg);
                            }
                        }).catch((err) => {
                            console.log(err);
                        });
                        } else {
                            this.$Message.error('表单验证失败!');
                        }
                    })
            },
            handleReset(val) {
                console.log(val)
            },
        },
        created() {
        	if (this.$store.state.isAdmin == 1)
            {
                let self = this
                layer.msg('您已经登录过了，正在跳转中……');
                setTimeout(function(){
                    layer.closeAll();
                    self.$router.push('/mcy');
                },1500)
            }else{
                console.log('good');
            }
        	this.backgroundheight = $(window).height();
        	this.loginpadding = this.backgroundheight / 3;
        	if ($(window).width() > 650)
        	{
        		this.backgroundimg = '/images/mcylogin3.jpg';
        	}
        	else{
	        	this.backgroundimg = '/images/mcylogin1.jpg';
        	}
        	if ($(window).width() > 960)
        	{
        		this.backgroundimg = '/images/mcylogin2.jpg';
        	}else{}
        }
}
</script>