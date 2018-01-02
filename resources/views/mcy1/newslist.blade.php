@extends('mcy.layout')
@section('title','梦苍源新闻集中器')
@section('my-css')
 
@endsection
@section('content')
<div class="main">
    <div class="main_scroll" id="main_scroll">
        @foreach($news as $new)
        <a href="{{@$new->source_url}}">
            <div class="article_boxs article_lr_box" articleid="{{@$new->new_id}}" articletype="{{@$new->newstype}}">
                <div class="article_left_box">
                    <div class="article_left_title">
                        {{@$new->title}}%
                    </div>
                    <div class="article_marker_btn">
                        {{@$new->author_name}}
                    </div>
                </div>
                <div class="article_right_box">
                    <img class="article_imgs" src="{{@$new->thumb_pic}}">
                </div>
            </div>
        </a>
        @endforeach
    </div>
    <div class="scroll_bottom">
        <!-- 正在加载... -->
    </div>
</div>
@endsection
@section('my-js')
 
@endsection
