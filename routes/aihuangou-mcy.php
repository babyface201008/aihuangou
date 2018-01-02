<?php 
// 新闻管理
// Route::get('/news/{type?}/{subtype?}','Mcy\McyNewsController@news');

// 导航管理
// Route::get('/navs/{navname?}/{subnavname?}','Mcy\McyNavController@navs');

// 推特新闻
// Route::get('/api/twitter/callback','Mcy\McyTwitterController@callback');
// Route::get('/twitters/{twitteruser?}/{action?}','Mcy\McyTwitterController@twitters');

/* vue PC router */
// Route::get('/','Mcy\McyController@index');

/* vue Mobile router */
// Route::get('/m','Mcy\McyController@mindex');

/* vue PC Background */
// Route::get('/mcy','Mcy\McyAdminController@mcy');

/* uve Mobile Background */
// Route::get('/m/mcy','Mcy\McyAdminController@mcy_mobile');

// 站点后台管理
// Route::get('/mcy/login','Mcy\McyAdminController@adminLogin');
#Route::group(['middleware'=>'MAUser'],function(){
#    Route::get('/mcy','Mcy\McyAdminController@admin');
#});
// Route::get('/mcy','Mcy\McyAdminController@admin');


/* 3步分路由 */
/* 1.Admin总路由和其他的子项目控制器分离 */
/* 2.子项目各分接口和控制器 */
/* 3.所有数据只做api接口输出，前端所有项目仅提供数据链 */

/* 2017/5/31 后端就只做后端工作 只提供api接口 只做数据的统计和维护 */
Route::get('/welkin/login','Admin\AdminController@welkinLogin');
Route::get('/welkin/logout','Admin\AdminController@welkinLogout');
Route::post('/api/welkin/login','Api\ApiAdminController@apiWelkinLogin');
/* 总站点管理 */
Route::group(['middleware'=>'AiHuanGouAdmin','prefix'=>'/welkin'],function(){
	Route::get('/','Admin\AdminController@welkin');
	Route::get('/dashboard','Admin\AdminController@dashboard');
	Route::get('/users/password','Admin\AdminController@password');

	/* 总后台用户管理 */
	Route::get('/users','Admin\AiHuanGouUserController@users');
	Route::get('/user/create','Admin\AiHuanGouUserController@userCreate');
	Route::get('/user/update','Admin\AiHuanGouUserController@userUpdate');
	Route::get('/user/resotre','Admin\AiHuanGouUserController@userResotre');

	/* 文章管理 */
	Route::get('/article','Admin\ArticleController@article');

	/* 标签管理 */	
	Route::get('/tag','Admin\TagController@tag');
	Route::get('/tag/create','Admin\TagController@tagCreate');
	Route::get('/tag/update','Admin\TagController@tagUpdate');

	/* 种类管理 */
	Route::get('/category','Admin\CategoryController@category');
	Route::get('/category/create','Admin\CategoryController@categoryCreate');
	Route::get('/category/update','Admin\CategoryController@categoryUpdate');


	Route::get('/article/create','Admin\ArticleController@articleCreate');
	Route::get('/article/update','Admin\ArticleController@articleUpdate');

	/* markdown 创建文章 */
	Route::get('/article/md/create','Admin\ArticleController@mdArticleCreate');
	Route::get('/article/md/update','Admin\ArticleController@mdArticleUpdate');

});
/******************************************************  总后台接口 ***********************************************************/
Route::group(['middleware'=>'AiHuanGouAdmin','prefix'=>'/api/welkin'],function(){

	/* 用户管理 */
	Route::post('/user/create','Api\ApiAdminController@apiUserCreate');
	Route::post('/user/update','Api\ApiAdminController@apiUserUpdate');
	Route::post('/user/delete','Api\ApiAdminController@apiUserDelete');
	Route::post('/user/restore','Api\ApiAdminController@apiUserRestore');
	Route::post('/user/password/update','Api\ApiAdminController@apiUserPassword');

	/* 文章集中管理中心 */
	Route::post('/article/md/create','Api\ApiArticleController@apiArticleCreate');
	Route::post('/article/md/update','Api\ApiArticleController@apiArticleUpdate');
	Route::post('/article/create','Api\ApiArticleController@apiArticleCreate');
	Route::post('/article/update','Api\ApiArticleController@apiArticleUpdate');
	Route::post('/article/delete','Api\ApiArticleController@apiArticledelete');


	/* 文章管理 */
	Route::post('/tag/create','Api\ApiTagController@apiTagCreate');
	Route::post('/tag/update','Api\ApiTagController@apiTagUpdate');
	Route::post('/tag/delete','Api\ApiTagController@apiTagDelelte');

	/* 种类管理接口 */
	Route::post('/category/create','Api\ApiCategoryController@apiCategoryCreate');
	Route::post('/category/update','Api\ApiCategoryController@apiCategoryUpdate');
	Route::post('/category/delete','Api\ApiCategoryController@apiCategoryDelete');

	/* markdown 图片上传路径 */
	Route::post('/markdown/upload/images','Api\UploadController@mkUploadImages');
});
/******************************************************************************************************************************/
/* 商城后台管理中心  */
Route::group(['middleware'=>'AiHuanGouAdmin','prefix'=>'/welkin/mcy'],function(){
	/* 商城用户管理 */
	Route::get('/users','Mcy\McyUserController@users');
	Route::get('/user/create','Mcy\McyUserController@userCreate');
	Route::get('/user/update','Mcy\McyUserController@userUpdate');
	Route::get('/user/resotre','Mcy\McyUserController@userResotre');
	Route::get('/user/update/search','Mcy\McyUserController@userUpdateSearch');

	/* 活动管理 */
	Route::get('/activity','Mcy\McyActivityController@activity');
	/* 商城配置管理 */
	Route::get('/wxinfo','Mcy\McyWxInfoController@wxinfo');
	Route::get('/siteinfo','Mcy\McySiteInfoController@siteInfo');
	Route::get('/smsinfo','Mcy\McySmsInfoController@smsInfo');
	Route::get('/emailinfo','Mcy\McyEmailInfoController@emailInfo');
	// Route::get('/smstemplate','Mcy\McyUserController@smstemplate');

	/* 支付配置管理 */
	Route::get('/payinfo','Mcy\McyPayInfoController@payinfo');
	Route::get('/payinfos','Mcy\McyPayInfoController@payinfo');
	Route::get('/payinfo/create','Mcy\McyPayInfoController@payinfoCreate');
	Route::get('/payinfo/update','Mcy\McyPayInfoController@payinfoUpdate');


	/* 商城产品管理 */
	Route::get('/products','Mcy\McyProductController@products');
	Route::get('/product/create','Mcy\McyProductController@productCreate');
	Route::get('/product/update','Mcy\McyProductController@productUpdate');

	/* 商城发货订单管理 */
	Route::get('/sends','Mcy\McySendsController@sends');
	Route::get('/send','Mcy\McySendsController@sends');
	Route::get('/sends/update','Mcy\McySendsController@sendUpdate');
	/* 商城充值订单管理 */
	Route::get('/topup','Mcy\McyOrderController@topUp');
	Route::get('/topups','Mcy\McyOrderController@topUp');

	/* 商城提现管理 */
	Route::get('/withdraw','Mcy\McyOrderController@withdraw');

    /* 超级代理商管理 */
    Route::get('/supper/master','Mcy\McySupperMasterController@supperlist');
	/* 查看超级代理商推广的客户信息 */
	Route::get('/supper/master/client/{user_id}','Mcy\McySupperMasterController@supperClientList');

	/* 商城普通商品订单管理 */
	Route::get('/order','Mcy\McyOrderController@orders');
	Route::get('/orders','Mcy\McyOrderController@orders');

	/* 测试指定 */
	Route::get('/orders/zhiding','Mcy\McyOrderController@zhiding');

	// Route::get('/shops','Mcy\McyShopController@shops');
	// Route::get('/shop/create','Mcy\McyShopController@shopCreate');
	// Route::get('/shop/update','Mcy\McyShopController@shopUpdate');

	/* 广告位 管理 */
	// Route::get('/ads','Mcy\McyAdsController@ads');
	// Route::get('/ads/create','Mcy\McyAdsController@adsCreate');
	// Route::get('/ads/update','Mcy\McyAdsController@adsUpdate');

	/* 首页轮播图 */
	Route::get('/loopimg','Mcy\McyloopImgController@loopImg');
	Route::get('/loopimgs','Mcy\McyloopImgController@loopImg');
	Route::get('/loopimg/create','Mcy\McyloopImgController@loopImgCreate');
	Route::get('/loopimg/update','Mcy\McyloopImgController@loopImgUpdate');

	/* 晒单管理 */
	Route::get('/shaidan','Mcy\McyShaiDanController@shaidan');
	Route::get('/shaidans','Mcy\McyShaiDanController@shaidan');
	Route::get('/shaidan/create','Mcy\McyShaiDanController@shaidanCreate');
	Route::get('/shaidan/update','Mcy\McyShaiDanController@shaidanUpdate');

	/* 分类管理 */
	Route::get('/categorys','Mcy\McyCategoryController@categorys');
	Route::get('/category','Mcy\McyCategoryController@categorys');
	Route::get('/category/create','Mcy\McyCategoryController@categoryCreate');
	Route::get('/category/update','Mcy\McyCategoryController@categoryUpdate');

	/* 评论管理 */
	Route::get('/replys','Mcy\McyReplayController@replys');
	Route::get('/reply','Mcy\McyReplayController@replys');
	Route::get('/reply/create','Mcy\McyReplayController@replyCreate');
	Route::get('/reply/update','Mcy\McyReplayController@replyUpdate');

	/* 友链管理 */
	// Route::get('/flinks','Mcy\McyFlinkController@flinks');
	// Route::get('/flink/create','Mcy\McyFlinkController@flinkCreate');
	// Route::get('/flink/update','Mcy\McyFlinkController@flinkUpdate');

	/* 文章管理*/
	Route::get('/article','Mcy\McyArticleController@articles');
	Route::get('/articles','Mcy\McyArticleController@articles');
	Route::get('/article/create','Mcy\McyArticleController@articleCreate');
	Route::get('/article/update','Mcy\McyArticleController@articleUpdate');


	

	/* 优惠券管理 */
	Route::get('/juan','Mcy\McyActivityController@juan');

	/* 统计使用管理 */
	Route::get('/tongji','Mcy\McyTongjiController@tongji');


	/* 测试专用*/
	Route::get('/automan','Mcy\McyAutoManController@automan');
	Route::get('/automan/add','Mcy\McyAutoManController@automanAdd');
	Route::get('/automan/run','Mcy\McyAutoManController@automanRun');
	Route::get('/automan/go','Mcy\McyAutoManController@automanGo');
});

Route::group(['middleware'=>'AiHuanGouAdmin','prefix'=>'/api/welkin/mcy'],function(){

	/* 用户管理 */
	Route::post('/user/create','Api\Mcy\ApiMcyUserController@apiUserCreate');
	Route::post('/user/update','Api\Mcy\ApiMcyUserController@apiUserUpdate');
	Route::post('/user/delete','Api\Mcy\ApiMcyUserController@apiUserDelete');
	Route::post('/user/restore','Api\Mcy\ApiMcyUserController@apiUserRestore');
	Route::post('/user/password/update','Api\Mcy\ApiMcyUserController@apiUserPassword');

	/* 梦苍源文章独立管理中心 */
	Route::post('/article/create','Api\ApiArticleController@apiArticleCreate');
	Route::post('/article/update','Api\ApiArticleController@apiArticleUpdate');
	Route::post('/article/delete','Api\ApiArticleController@apiArticleDelete');


	/* 商城微信配置管理 */
	Route::post('/wxinfo/update','Api\Mcy\ApiMcyWxinfoController@apiMcyWxInfoUpdate');

	/* 活动配置 */
	Route::post('/activity/update','Api\Mcy\ApiMcyWxinfoController@apiMcyActivityUpdate');

	/* 商城基本信息配置管理　*/
	Route::post('/siteinfo/update','Api\Mcy\ApiMcySiteInfoController@apiMcySiteInfoUpdate');

	/* 商城短信配置 */
	Route::post('/sms/update','Api\Mcy\ApiMcySmsController@apiMcySmsUpdate');

	/* 支付配置管理*/
	Route::post('/payinfo/create','Api\Mcy\ApiMcyPayInfoController@apiMcyPayInfoCreate');
	Route::post('/payinfo/update','Api\Mcy\ApiMcyPayInfoController@apiMcyPayInfoUpdate');
	Route::post('/payinfo/delete','Api\Mcy\ApiMcyPayInfoController@apiMcyPayInfoDelete');


	/* 商城商品管理 */
	Route::post('/product/create','Api\Mcy\ApiMcyProductController@apiProductCreate');
	Route::post('/product/update','Api\Mcy\ApiMcyProductController@apiProductUpdate');
	Route::post('/product/delete','Api\Mcy\ApiMcyProductController@apiProductDelete');

	/*  设置热门事件 */
	Route::post('/product/set/hot','Api\Mcy\ApiMcyProductController@apiProductSetHot');
	/* 设置置顶事件 */
	Route::post('/product/set/sort','Api\Mcy\ApiMcyProductController@apiProductSetSort');

	/* 商城发货订单管理 */
	Route::post('/sends/update','Api\Mcy\ApiMcySendsController@apiSendsUpdate');

	/* 商城订单管理接口 */
	Route::post('/orders/update','Api\Mcy\ApiMcyOrderController@apiOrderUpdate');

	/* 指定接口 */
	Route::post('/orders/zhiding','Api\Mcy\ApiMcyOrderController@apiOrderZhiDing');

	/* 商城分类管理 */
	Route::post('/category/create','Api\Mcy\ApiMcyCategoryController@apiMcyCategoryCreate');
	Route::post('/category/update','Api\Mcy\ApiMcyCategoryController@apiMcyCategoryUpdate');
	Route::post('/category/delete','Api\Mcy\ApiMcyCategoryController@apiMcyCategoryDelete');

	/* 商城晒单管理 */
	Route::post('/shaidan/create','Api\Mcy\ApiMcyShaiDanController@apiMcyShaiDanCreate');
	Route::post('/shaidan/update','Api\Mcy\ApiMcyShaiDanController@apiMcyShaiDanUpdate');
	Route::post('/shaidan/update/status','Api\Mcy\ApiMcyShaiDanController@apiMcyShaiDanUpdateStatus');
	Route::post('/shaidan/delete','Api\Mcy\ApiMcyShaiDanController@apiMcyShaiDanDelete');

	/* 晒单评论管理 */
	Route::post('/reply/create','Api\Mcy\ApiMcyReplyController@apiMcyReplyCreate');
	Route::post('/reply/update','Api\Mcy\ApiMcyReplyController@apiMcyReplyUpdate');
	Route::post('/reply/delete','Api\Mcy\ApiMcyReplyController@apiMcyReplyDelete');

	/* 晒单评论管理 */
	Route::post('/loopimg/create','Api\Mcy\ApiMcyloopImgController@apiMcyloopImgCreate');
	Route::post('/loopimg/update','Api\Mcy\ApiMcyloopImgController@apiMcyloopImgUpdate');
	Route::post('/loopimg/delete','Api\Mcy\ApiMcyloopImgController@apiMcyloopImgDelete');

	/* 订单更新 */
	Route::post('/order/info/update','Api\Mcy\ApiMcyOrderController@apiSendOrderUpdate');
	/* 发送消息 */
	Route::post('/sends/message','Api\Mcy\ApiMcyOrderController@apiSendOrderSendMessage');
	Route::post('/sends/message1','Api\Mcy\ApiMcyOrderController@apiSendOrderSendMessage1');

	/*提现申请通过*/
	Route::post('/withdraw/ok','Api\Mcy\ApiMcyOrderController@apiWithDrawOk');

    /*超级代理商审核通过*/
    Route::post('/supper/master/ok','Api\Mcy\ApiMcySupperMasterController@apiSuperMasterOk');
    /*超级代理商审核不通过*/
    Route::post('/supper/master/no','Api\Mcy\ApiMcySupperMasterController@apiSuperMasterNO');

	/*　测试平台 */
	Route::post('/automan/update','Api\Mcy\ApiMcyAutomanController@apiMcyAutoManUpdate');
});

	/* 商城上传图片路径　*/
	Route::post('/api/welkin/mcy/upload/images','Api\Mcy\ApiMcyUploadController@imagesUpload_local');
	Route::post('/api/welkin/mcy/upload/excelupload','Api\Mcy\ApiMcyUploadController@excelUpload');
    /*会员头像上传*/
    Route::post('/api/welkin/mcy/upload/avatorimg','Api\Mcy\ApiMcyUploadController@avatorimgUpload_local');
	/*超级代理商二维码*/
	Route::any('/super/master/my_code/{user_id}','Mcy\McySupperMasterController@userMyCode');

/* 企业站点管理 */
Route::group(['middleware'=>'AiHuanGouAdmin','prefix' => '/welkin/mcy'],function(){
	Route::get('/sites','Mcy\McySiteController@sites');
	Route::get('/site/create','Mcy\McySiteController@siteCreate');
	Route::get('/site/update','Mcy\McySiteController@siteUpdate');
	Route::get('/site/resotre','Mcy\McySiteController@siteResotre');


	/* 企业后台用户管理 */
	Route::get('/users','Mcy\McyUserController@users');
	Route::get('/user/create','Mcy\McyUserController@userCreate');
	Route::get('/user/update','Mcy\McyUserController@userUpdate');
	Route::get('/user/resotre','Mcy\McyUserController@userResotre');
});

Route::group(['middleware'=>'AiHuanGouAdmin','prefix'=>'/api/welkin/kuurin'],function(){

	/* 企业后台用户管理 */
	Route::post('/user/create','Api\Mcy\ApiMcyAdminController@apiUserCreate');
	Route::post('/user/update','Api\Mcy\ApiMcyAdminController@apiUserUpdate');
	Route::post('/user/delete','Api\Mcy\ApiMcyAdminController@apiUserDelete');
	Route::post('/user/restore','Api\Mcy\ApiMcyAdminController@apiUserRestore');
	Route::post('/user/password/update','Api\Mcy\ApiMcyAdminController@apiUserPassword');
});


Route::group(['middleware'=>'AiHuanGouAdmin','prefix'=>'/api/welkin'],function(){
	Route::post('/upload/images','Api\UploadController@imagesUpload');
});

/* 前端登录后控制页面 */
Route::group(['middleware'=>'McyUser'],function(){
	/* 个人中心页面　*/
	Route::get('/mcy/user','Mcy\Front\McyFrontUserController@user');
	/* 个人账户明细　*/
	Route::get('/mcy/user/detail','Mcy\Front\McyFrontUserController@userData');
	/* 个人佣金页面　*/
	Route::get('/mcy/user/yongjin','Mcy\Front\McyFrontUserController@userYongjin');
	/*　购物车　*/
	Route::get('/user/cart','Mcy\Front\McyFrontUserController@userCartList');
	/* 兼容原有平台不替换链接   ==== 购物车*/ 
	Route::get('/cartlist','Mcy\Front\McyFrontUserController@userCartList');
	/* 分享赚钱 */
	Route::any("/mcy/user/invite/friends/{userid}",'Mcy\Front\McyFrontUserController@userInviteFriend');
	Route::any("/mcy/user/invite/friends",'Mcy\Front\McyFrontUserController@userInviteFriends');
	Route::any("/mcy/user/invite/history",'Mcy\Front\McyFrontUserController@userInviteHistory');
    Route::any("/mcy/user/duihuan/list",'Mcy\Front\McyFrontUserController@userDuihuanHistory');
    Route::any("/mcy/user/yongjing/list",'Mcy\Front\McyFrontUserController@userYongjingHistory');

    /*福分申请提现表*/
    Route::any("/mcy/user/invite/fubiwithdraw",'Mcy\Front\McyFrontUserController@userFubiWithdraw');

    /* 提款信息表 */
	Route::any('/mcy/user/withdraw/list','Mcy\Front\McyFrontUserController@userWithDrawList');
	/* 提款申请表 */
	Route::any('/mcy/user/invite/withdraw','Mcy\Front\McyFrontUserController@userWithDraw');
	/* 中奖获得页面 */
	Route::any('/mcy/user/huode','Mcy\Front\McyFrontUserController@userHuode');
	/*兑换福分页面*/
	Route::any('/mcy/user/duihuan/{yungou_id}','Mcy\Front\McyFrontUserController@userDuihuan');
	/* 我的二维码页面=》分享赚钱*/
	Route::any('/mcy/user/my_code','Mcy\Front\McyFrontUserController@userMyCode');
	/* 签到页面 */
	Route::any('mcy/user/qiandao','Mcy\Front\McyFrontUserController@userQianDao');
	/* 我的红包（抢红包）*/
	Route::any('/mcy/user/red/bag','Mcy\Front\McyFrontUserController@userRedBag');
	/* 我的快购记录 */
	Route::any('/mcy/user/buylist','Mcy\Front\McyFrontUserController@userBuyList');
	/* 我的中奖记录 */
	Route::any('/mcy/user/huode_list','Mcy\Front\McyFrontUserController@userHuodeList');
	/* 我的账号修改 */
	Route::get('/mcy/user/profile','Mcy\Front\McyFrontUserController@userProfile');
	/* 我的晒单记录 */
	Route::get('/mcy/user/shaidan','Mcy\Front\McyFrontUserController@userShaiDan');
	/* 申请超级代理商页面 */
	Route::get('/mcy/user/apply/supper/master','Mcy\Front\McyFrontUserController@userSupperMaster');

    //好友管理
	Route::any("/mcy/user/home/friend/",'Mcy\Front\McyFrontUserController@userHomeFriend');
	Route::any("/mcy/user/home/friends/",'Mcy\Front\McyFrontUserController@userHomeFriends');
	//明细
	Route::any("/mcy/user/invite/commissions/",'Mcy\Front\McyFrontUserController@userInviteCommissions');
	//提现
	Route::any("/mcy/user/invite/cashout/",'Mcy\Front\McyFrontUserController@userInviteCashout');


	/* 创建晒单和修改晒单 */
	Route::get('/mcy/user/fshaidan/create/{yungou_id}','Mcy\Front\McyFrontUserController@userCreateShaiDan');
	// Route::get('/mcy/user/fshaidan/update/{order_id}','Mcy\Front\McyFrontUserController@userUpdateShaiDan');

	/* 添加快递地址和查看快递进度 */
	Route::get('/mcy/user/huode_list/create/kuaidi/{yungou_id}','Mcy\Front\McyFrontUserController@userHuodeListCreateKuaiDi');
	// Route::get('/mcy/user/huode_list/update/kuaidi/{order_id}','Mcy\Front\McyFrontUserController@userHuodeListUpdateKuaiDi');
	/* 查看快递详情 */
	Route::get('/mcy/user/huode_list/get/kuaidi/{order_id}','Mcy\Front\McyFrontUserController@userHuodeListCheckKuaiDi');

	Route::get('/mcy/user/address','Mcy\Front\McyFrontUserController@userAddress');
	Route::get('/mcy/user/address/create','Mcy\Front\McyFrontUserController@userAddressCreate');
	Route::get('/mcy/user/address/update/{address_id}','Mcy\Front\McyFrontUserController@userAddressUpdate');

	Route::post('/api/mcy/user/create/address','Api\Mcy\ApiMcyUserController@apiAddressCreate');
	Route::post('/api/mcy/user/update/address','Api\Mcy\ApiMcyUserController@apiAddressUpdate');
	Route::post('/api/mcy/user/delete/address','Api\Mcy\ApiMcyUserController@apiAddressDelete');

	/* 获取默认地址信息 */
	Route::post('/api/mcy/user/get/default/address','Api\Mcy\ApiMcyUserController@apiGetDefaultAddress');

	/* 我的抵用卷 */
	Route::get('/mcy/user/diyongjuan','Mcy\Front\McyFrontUserController@userDiYongJuan');
	/* 退出登录 */
	Route::get('/mcy/user/logout','Mcy\Front\McyFrontUserController@userLogOut');
	/* 我的充值页面 */
	Route::any('/mcy/user/topup','Mcy\Front\McyFrontUserController@userTopUp');

	/* 支付订单页面 */
	Route::get('/user/cart/pay','Mcy\Front\McyFrontUserController@userCartPay');

	/* 手机验证 */
	Route::get('/mcy/user/add/mobile','Mcy\Front\McyFrontUserController@userAddMobile');
	Route::post('/api/mcy/user/send/sms','Api\Mcy\ApiMcyMobileController@apiMobileSend');
	/* 手机添加接口 */
	Route::post('/api/mcy/user/mobile/add','Api\Mcy\ApiMcyMobileController@apiMobileAdd');

	/*　支付页面 */
	/* 充值接口 */
	Route::get('/mcy/topup/pay/{pid}/{money}','Api\Mcy\ApiMcyPayInfoController@topUpPay');
	/*Route::get('/mcy/topup/pay/{pid}','Api\Mcy\ApiMcyPayInfoController@topUpPay1');*/
	/* 福分支付 */
	Route::any('/user/chaofen/pay','Api\Mcy\ApiMcyPayInfoController@chaofenPay');
	/* 余额支付*/
	Route::any('/user/chaobi/pay','Api\Mcy\ApiMcyPayInfoController@chaobiPay');
	/* 微信直接支付 */
	Route::any('/user/weixin/pay','Api\Mcy\ApiMcyPayInfoController@weixinPay');

	/* 接口页面 */
	/* 兼容原有平台的接口 */
	// Route::post('/addShopCart','Api\Mcy\ApiMcyProductController@apiAddCart');
	/* 前台直接支付接口 */
	Route::any('/api/user/cart/pay','Api\Mcy\ApiMcyProductController@apiCartPay');
	/* 充值接口 */
	Route::post('/api/user/topup','Api\Mcy\ApiMcyTopUpController@apiTopUp');

	/* 钱方支付路径 */
	Route::any('/m/product/pay/1','Mcy\Front\McyFrontUserController@QianDangPay');

	/* 前台结果判断 */
	Route::any('/payinfo/return_url/{method}','Mcy\McyPayInfoController@ReturnUrl');

	/*前台接口*/
	Route::post('/api/mcy/user/update/username','Api\Mcy\ApiMcyUserController@apiUserUpdateUserName');

	/* 佣金充值 */
	// Route::post('/api/mcy/user/withdraw/apply','Api\Mcy\ApiMcyUserController@apiUserWithdrawApply');
	
	/* 佣金充值 */
	Route::post('/api/mcy/user/sharetomoney','Api\Mcy\ApiMcyUserController@apiUserShareToMoney');

	/* 提款申请人信息 */
	Route::any('/api/mcy/user/withdraw/welkin/apply','Api\Mcy\ApiMcyUserController@apiUserWithdrawApply');

    /* 申请人福分提现 */
    Route::any('/api/mcy/user/withdraw/fubi/apply','Api\Mcy\ApiMcyUserController@apiUserWithdrawFubiApply');

	/* 用户晒单 */
	Route::post('/api/mcy/user/create/fshaidan','Api\Mcy\ApiMcyUserController@apiUserFShaiDan');
	Route::post('/api/mcy/user/update/order/addr','Api\Mcy\ApiMcyUserController@apiUserKuaiDi');

    /* 中奖商品直接兑换成福分*/
    Route::post('/api/mcy/user/create/duihuan','Api\Mcy\ApiMcyUserController@apiCreateDuihuan');

	// 分享赚钱接口
	Route::any('/api/mcy/user/share/get/money','Api\Mcy\ApiMcyUserController@apiShareGetMoney');

	//申请超级代理商接口
	Route::any('/api/mcy/user/supper/master/apply','Api\Mcy\ApiMcyUserController@apiUserSupperMasterApply');



});

/* 首页前端页面　不分所有用户直接拉去信息　*/
/*　首页　*/
Route::get('/','Mcy\Front\McyIndexController@index');
Route::get('/index','Mcy\Front\McyIndexController@index');
/* 即将揭晓页面　*/
Route::get('/productlist','Mcy\Front\McyIndexController@productList');
/* 所有商品列表 */
Route::get('/glists','Mcy\Front\McyIndexController@glist');
/* 商品详情页面　*/
Route::get('/product','Mcy\Front\McyIndexController@product');

/* 商品倒计时页面 */
Route::get('/going/product','Mcy\Front\McyIndexController@goingProduct');

/* 云购记录 */
Route::get('/buyrecords/{product_id}/{qishu}','Mcy\Front\McyIndexController@buyrecords');
Route::get('/apiGetBuyRecords/{product_id}/{qishu}/{table}/{pos}/{rid}','Api\Mcy\ApiMcyProductController@apiGetBuyRecords');
/* 云购详情 */
Route::get('/goodsdesc/{product_id}','Mcy\Front\McyIndexController@productDesc');
/* 云购晒单 */
Route::get('/goodspost','Mcy\Front\McyIndexController@productPost');
/* 购物车 */
/* 倒计时页面 */
Route::get('/lottery','Mcy\Front\McyLotteryController@lottery');
/* 晒单页面 */
Route::get('/fshaidan','Mcy\McyShaiDanController@fshaidan');
/* 晒单详情 */
Route::get('/fshaidan/detail','Mcy\McyShaiDanController@fshaidanDetail');
/*产品晒单*/
Route::get('/goodspost/{product_id}/{qishu}','Mcy\McyShaiDanController@goodspost');
/* 消息提醒页面 */
Route::get('/msg','Mcy\Front\McyIndexController@msg');

/*计算结果*/
Route::get('/calresult/{yungou_id}','Mcy\Front\McyIndexController@calResult');

Route::get('/userinfo/{mcy_user_id}','Mcy\Front\McyFrontUserController@userInfo');

/*wap登录*/
Route::get('/login','Mcy\Front\McyFrontUserController@login');
/*注册*/
Route::get('/register','Mcy\Front\McyFrontUserController@register');
/*用户协议*/
Route::get('/terms','Mcy\Front\McyFrontUserController@terms');

/*邀请好友注册*/
Route::get('/invite/friend/{mcy_user_id?}','Api\Mcy\ApiMcyUserController@inviteFriend');

/*超级代理商邀请好友注册*/
Route::get('/invite/super/friend/{token?}','Api\Mcy\ApiMcyUserController@inviteSuperFriend');

/* 前台接口 */
/* 加入购物车 */
Route::get('/api/add/cart/{product_id}/{number}','Api\Mcy\ApiMcyProductController@apiAddCart');
/* 减少购物车 */
Route::get('/api/delete/cart/{product_id}/{number}','Api\Mcy\ApiMcyProductController@apiDeleteCart');

Route::get('/api/zhiding/cart/{product_id}/{number}','Api\Mcy\ApiMcyProductController@apiZhiDingCart');

/* 获取商品列表 */
Route::get('/glistajax/{category_id}/{order}/{page}','Api\Mcy\ApiMcyProductController@apiGetProduct');
/* 首页产品类型获取 */
Route::any('/api/index_get_product/{order}/{page}','Api\Mcy\ApiMcyProductController@apiGetProduct');

/*提交登录*/
Route::get('/api/mcy/user/dologin/{username}/{password}','Api\Mcy\ApiMcyUserController@apiPostLogin');
/*提交注册*/
Route::post('/api/mcy/user/doregister','Api\Mcy\ApiMcyUserController@apiPostRegister');

/*注册发送短信验证码*/
Route::post('/api/mcy/user/send/register/sms','Api\Mcy\ApiMcyMobileController@apiRegisterSend');

/* 前台倒计时接口 */


Route::get('/api/getshop/lottery_huode_shoplist/{number}/{page}','Api\Mcy\ApiMcyProductController@LotteryHuodeShopList');
/* 获取已经开奖的商品 */
Route::get('/api/getshop/gone_shoplist','Api\Mcy\ApiMcyProductController@aptGetGoneShopList');
/* 倒计时结束，获取商品中间人 */
Route::get('/api/getshop/lottery_huode_shop','Api\Mcy\ApiMcyProductController@aptGetHuodeShop');
/* 测试页面 */
Route::get('/welkin/mcy/category_count','Mcy\McyTestController@category_count');

/* 频繁接口，检查商品是否已经满人，是否进入倒计时 */
Route::any('/api/check/product','Api\Mcy\ApiMcyProductController@apiCheckProduct');
/* 触发倒计时 */
Route::any('/api/go_product_daojishi/{yungou_id}','Mcy\McyAutoManController@go_product_daojishi1');
Route::any('/api/fixbug/product','Api\Mcy\ApiMcyProductController@apiFixBugProduct');


/* 支付回调 */
Route::any('/payinfo/notify_url/{method}','Mcy\McyPayInfoController@NotifyUrl');


/* 首页获奖奖品拉取 */
Route::any('/api/getshop/lottery_index_shop_get/{show_time}','Api\Mcy\ApiMcyProductController@indexLotteryGet');
/* 倒计时获取正在开奖的商品 */
Route::get('/api/getshop/lottery_going_shoplist','Api\Mcy\ApiMcyProductController@apiGetGoingLotteryShopList');

/* 获取个人信息接口 */
Route::any('/api/userinfo/getUserBuyList/{type}/{mcy_user_id}/{yungou_id}/{number}/{count}','Api\Mcy\ApiMcyProductController@apiGetUserBuyList');

/* 修复 */
Route::get('/chkg/fix/product','Api\Mcy\ApiMcyProductController@apiChkgFixProduct');
 ?>