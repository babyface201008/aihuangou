<footer class="footer">
    <span id="btnTop" class="z-top" title="返回顶部" style="left: 1px; bottom: 58px;"><b class="z-arrow"></b></span>
    <div class="u-ft-nav">
        <ul>
            <li class="f_home"><a href="/"><i class="i-shouye"></i>首页</a></li>
            <li class="f_allgoods"><a href="{{Request::root()}}/glists"><i class="i-shouye"></i>所有商品</a></li>
            <li class="f_announced"><a href="{{Request::root()}}/lottery"><i class="i-shouye"></i>最新揭晓</a></li>
            <!-- <li class="f_car"><a id="btnCart" href="{{Request::root()}}/fshaidan"><i class="i-shouye"></i>晒单</a></li> -->
            <li class="f_car"><a id="btnCart" href="{{Request::root()}}/cartlist">
                    <i class="i-shouye">
                    @if ($cartTotal>0)
                        <em>{{$cartTotal}}</em>
                    @endif
                    </i>购物车</a>
            </li>
            <li class="f_personal"><a href="{{Request::root()}}/mcy/user"><i class="i-shouye"></i>我的主页</a></li>
        </ul>
    </div>
    <!--置顶按钮滚动特效-->
    <script src="/chyyg1/topHovertree.js" language="javascript" type="text/javascript"></script>
    <script>
        initTopHoverTree("btnTop",500,1,58);
    </script>
    <script>
        var _hmt = _hmt || [];
        (function() {
          var hm = document.createElement("script");
          hm.src = "https://hm.baidu.com/hm.js?62e23b8e8c1820698dada8aa949641a9";
          var s = document.getElementsByTagName("script")[0]; 
          s.parentNode.insertBefore(hm, s);
      })();
  </script>
</footer>