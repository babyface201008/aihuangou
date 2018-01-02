
function makeMenu(items,tags,cla)
{
  tags = tags || ['ul','li'];
  cla  = cla  || ['menu_ul','menu_items']
  var parent = tags[0];
  var child  = tags[1];

  var menu_ul   = cla[0];
  var menu_items= cla[1];
  var item,value='';

  for (var i = 0; i < items.length; i++) {
    item  =  items[i];
    if (/:/.test(item))
    {
      item = items[i].split(':')[0];
      value= items[i].split(':')[1];
    }
    items[i] = '<' + child + ' ' +
      'class="' + menu_items + '"' +
      (value && 'value="' + value + '"') + '>' + //add value if present
      item + '</' + child + '>';
  }
  var menu = '<' + parent + ' class="' + menu_ul +'"">' + items.join('') + '</' + parent + '>';
  return menu;
}

function avatarimg(target,preview,pcnt,pimg)
{
  var jcrop_api,
      boundx,
      boundy,
      $preview = $('' + preview + ''),
      $pcnt    = $('' + pcnt + ''),
      $pimg    = $('' + pimg + ''),
      $target  = $('' + target + ''),
      xsize    = $pcnt.width(),
      ysize    = $pcnt.height(),
      targetw  = $target.width(),
      targeth  = $target.height();
       console.log('init',[xsize,ysize]);
      $('' + target + '').Jcrop({
        onSelect: updatePreviewSelect,
        onChange: updatePreview,
        aspectRatio: xsize / ysize
      },function(){
        var bounds = this.getBounds();
        boundx = bounds[0];
        boundy = bounds[1];
        jcrop_api = this
        $preview.appendTo(jcrop_api.ui.holder);
      });
  function updatePreview(c)
  {
    if (parseInt(c.w) > 0)
    {
      var rx = xsize / c.w;
      var ry = ysize / c.h;
      $pimg.css({
        width : Math.round(rx * boundx) + 'px',
        height: Math.round(ry * boundy) + 'px',
        marginLeft : '-' + Math.round(rx * c.x) + 'px',
        marginTop  : '-' + Math.round(ry * c.y) + 'px',
      });
     
    }
  };    

  function updatePreviewSelect(c)
  {
    if (parseInt(c.w) > 0)
    {
      var rx = xsize / c.w;
      var ry = ysize / c.h;
      $pimg.css({
        width : Math.round(rx * boundx) + 'px',
        height: Math.round(ry * boundy) + 'px',
        marginLeft : '-' + Math.round(rx * c.x) + 'px',
        marginTop  : '-' + Math.round(ry * c.y) + 'px',
      });
    }
    // console.log(rx);
    // console.log(ry);
    // console.log(xsize);
    // console.log(ysize);
    // console.log(c.w);
    // console.log(c.h);
    // console.log(boundx);
    // console.log(boundy);
    // c.w 实际截屏宽度
    // c.h 实际截屏高度
    // xsize 缩放宽度
    // ysize 缩放高度
    // boundx 原图压缩成宽
    // boundy 原图压缩成高
    if($(".avatarupload").length != 0 )
    {
      var _avatar = $(".avatarupload");
      $(_avatar).val(''+ c.x +',' + c.y + ',' + c.w + ',' + c.h + ',' + targetw + ',' + targeth + ','+ xsize + ',' + ysize + '');
      console.log(_avatar.val());
    }
  }  
}

//function prototype base on jquery
jQuery.prototype.myvalid = function()
{
  console.log("welkin is here for you !");
}


  //function  extend base on jquery 
jQuery.extend({
  myajax:function(url,type,data,callback){
    jQuery.ajax({
      url      : url,
      type     : type,
      dataType :'json',
      data   : data,
      success: callback,
      error: function(xhr, ret, error) {
        console.log(xhr);
        console.log(ret);
        console.log(error);
        layer.msg('ajax error', {icon:2, time:2000});
      },
      beforeSend: function(xhr){
        layer.load(0, {shade: false});
      },
      complete: function(){
        layer.closeAll('loading');
      }
    });
    return false;
  }
})

