@extends('mcy.layout')
@section('title','计算结果')
@section('my-css')
 <link href="/chyyg1/comm.css" rel="stylesheet" type="text/css">
<link href="/chyyg1/lottery.css" rel="stylesheet" type="text/css">
<link href="/chyyg1/ssc_lottery.css" rel="stylesheet" type="text/css">
    <style type="text/css">
        .cur {
            margin-left: 20px;
        }
    </style>
@endsection
@section('content')
      <section class="z-minheight">
                <div class="infoResult">
            <ul class="result1"></ul>
            <dl>截至商品揭晓时间【{{@$yungou_shop->show_time}}】<em>最后100条全站购买时间记录</em></dl>
            <ul class="result2">
                <li class="iTitle"><span>购买时间</span><span>转换数据</span><span>会员账号</span></li>
                @foreach($lists as $key => $list)
                                <li>
                    <span>{{date("Y-m-d",strtotime($list->created_at))}}<dd>{{date("H:i:s",strtotime($list->created_at))}}</dd></span>
                    @if ($key == 50)
                    <span>{{strtotime($list->created_at) + $cha}}</span>
                    @else
                    <span>{{strtotime($list->created_at)}}</span>
                    @endif
                    <span><a href="{{Request::root()}}/userinfo/{{@$list->mcy_user_id}}">{{@$list->username}}</a></span>
                    <p><b class="z-arrow"></b></p>
                </li>
                @endforeach
        </ul>
        </div>
        <div class="infoCount">
            <div class="infoCount2">
                <ul>
                    <li style="border:0 none;">取以上数值结果得：</li>
                    <li>
                        <p>1、求和：{{$all}}<em>(上面100条购买记录时间之和)</em>
                        )</em>
                        </p>
                    </li>
                    <li>
                        <p>2、取余：{{@$all}}<em>(步骤1获得的数值)</em><br/>
                            % {{@$yungou_shop->zongshu}}<em>(本商品总需参与人次)</em> = {{fmod($all,$yungou_shop->zongshu)}}<em>(余数)</em>
                        </p>
                    </li>
                    <li>3、计算结果：{{fmod($all,$yungou_shop->zongshu)}}<em>(余数)</em> + 1000001 = <span>{{fmod($all,$yungou_shop->zongshu) + 1000001}}</span></li>
                </ul>
            </div>
        </div>
    </section>
@endsection
@section('my-js')

@endsection