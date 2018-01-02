
<div style="text-align: center">
    <p>代理商的专属二维码
        <br>会员id:{{@$mcy_supermaster_apply->mcy_user_id}}
    </p>

    {!! QrCode::size(300)->encoding('UTF-8')->generate($url); !!}
    <br>
    长按复制邀请链接:{{$url}}
</div>