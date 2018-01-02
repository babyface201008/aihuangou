<!doctype html>
<html lang="zh">
<head>
<!-- 效果：http://hovertree.com/code/run/jquery/a1gr3gm9.html -->
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0"><style>body{overflow:scroll}</style>
<title>jQuery手机端触摸卡片切换效果 - 何问起</title>
 
<link rel="stylesheet" type="text/css" href="http://hovertree.com/texiao/mobile/7/css/normalize.css" />
<link rel="stylesheet" type="text/css" href="http://hovertree.com/texiao/mobile/7/css/demo.css" />
<link rel="stylesheet" type="text/css" href="http://hovertree.com/texiao/mobile/7/css/style.css" />
 
</head>
<body>
<br><br>
<div class="view">
    <div class="card__full">
        <div class="card__full-top">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M16.59 8.59l-4.59 4.58-4.59-4.58-1.41 1.41 6 6 6-6z"/>
                    <path d="M0 0h24v24h-24z" fill="none"/>
            </svg>
            <span class="card__full-num"></span>
        </div>
        <div class="card__full-bottom">
            <p class="card__full-handle"></p>
            <p class="card__full-info"></p>
        </div>
    </div>
    <ul class="card__list">
        <li class="card__item card__item--blue">
            <div class="card__info">
                <div class="info-player">
                    <p class="info-player__num">9</p>
                    <p class="info-player__name"><small>忘了</small><br>算了</p>
                </div>
                <div class="info-place">1<sup>st</sup></div>
            </div>
        </li>
        <li class="card__item card__item--purple">
            <div class="card__info">
                <div class="info-player">
                    <p class="info-player__num">18</p>
                    <p class="info-player__name"><small>Tom</small><br><a href="http://hovertree.com/code/jquery/a1gr3gm9.htm">原文</a></p>
                </div>
                <div class="info-place">2<sup>nd</sup></div>
            </div>
        </li>
        <li class="card__item card__item--green">
            <div class="card__info">
                <div class="info-player">
                    <p class="info-player__num">12</p>
                    <p class="info-player__name"><small>Hoverc</small><br><a href="http://hovertree.com/h/bjaf/lxxidg7g.htm">下载</a></p>
                </div>
                <div class="info-place">3<sup>rd</sup></div>
            </div>
        </li>
        <li class="card__item card__item--yellow">
            <div class="card__info">
                <div class="info-player">
                    <p class="info-player__num">7</p>
                    <p class="info-player__name"><small>何问起</small><br>如何了断思念</p>
                </div>
                <div class="info-place">4<sup>th</sup></div>
            </div>
        </li>
        <li class="card__item card__item--tan">
            <div class="card__info">
                <div class="info-player">
                    <p class="info-player__num">9</p>
                    <p class="info-player__name"><small>柯乐义</small><br>keleyi.com</p>
                </div>
                <div class="info-place">5<sup>th</sup></div>
            </div>
        </li>
        <li class="card__item card__item--orange">
            <div class="card__info">
                <div class="info-player">
                    <p class="info-player__num">18</p>
                    <p class="info-player__name"><small>hewenqi</small><br>HoverTree</p>
                </div>
                <div class="info-place">6<sup>th</sup></div>
            </div>
        </li>
    </ul>
</div>
 
<script src="http://hovertree.com/ziyuan/jquery/jquery-2.2.0.min.js" type="text/javascript"></script>
<script src="http://hovertree.com/texiao/mobile/7/js/cards.js" charset="utf-8" type="text/javascript"></script>
 
</body>
</html>