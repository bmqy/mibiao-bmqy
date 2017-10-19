// layer全局配置
var layer = layer || window.layer;
(function layerInit() {
    layui.use('layer', function(){
        layer = layui.layer;
        layer.config({
            title: '提示',
            icon: 5,
            shade: 0
        });
    });
})();

// 头部搜索域名
(function searchDomainList() {
    var oInputSearch = $('#searchKeyword');

    if(oInputSearch){
        oInputSearch.on('input', function () {
            var sInputSearchKeyword = $(this).val();
            if(sInputSearchKeyword !== ''){
                $.ajax({
                    url: '/callback/',
                    type: 'post',
                    data: {
                        action: 'searchDomainList',
                        searchKeyword: sInputSearchKeyword
                    },
                    success: function (res) {
                        var oResult = JSON.parse(res);
                        if(oResult.status === 0){
                            var _data = eval(oResult.data);
                            var oSearchResultParrent = $('.navbar-form');
                            $('#searchResult').remove();
                            var oSearchResultWarp = $('<div id="searchResult" class="list-group"></div>');
                            var oSearchResultItem = null;

                            if(_data.length > 0){
                                for(var i=0; i<_data.length; i++){
                                    for(var key in _data[i]){
                                        oSearchResultItem = $('<a href="/detail.php?id='+ _data[i]['id'] +'" title="'+ _data[i]['title'] +'" class="list-group-item" target="_blank"><span class="badge">'+ _data[i]['price'] +' ￥</span>'+ _data[i]['title'] +'</a>');
                                    }
                                    oSearchResultWarp.append(oSearchResultItem);
                                }
                            }
                            else{
                                oSearchResultItem = '<p class="list-group-item">未找到域名!</p>';
                                oSearchResultWarp.append(oSearchResultItem);
                            }
                            oSearchResultParrent.append(oSearchResultWarp);
                        }
                        else{
                            alert(oResult.message);
                        }
                    }
                })
            }
            else{
                $('#searchResult').remove();
            }
        });
    }
})();

// 更新域名列表排序
(function doSortDomainList() {
    var oBtnSorts = $('#btnSorts');
    oBtnSorts.find('.btn').each(function (i, e) {
        $(e).on('click', function () {
            location = '?sort='+ $(this).find('input[type=radio]').val();
        })
    })
})();

// bootstrap式警告框
function modal(option){
    var argLength = modal.arguments.length;
    var sTitleDefault = '提示';
    var optionDefalut = {
        'title': '提示',
        'content': '操作成功',
        'size': 'modal-sm'
    };
    for(var k in option){
        optionDefalut[k] = option[k];
    }
    var _temp = '';
    _temp += '<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">';
    _temp += '<div class="modal-dialog '+ optionDefalut.size +'" role="document">';
    _temp += '<div class="modal-content">';
    _temp += '<div class="modal-header">';
    _temp += '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    _temp += '<h4 class="modal-title">'+ optionDefalut.title +'</h4>';
    _temp += '</div>';
    _temp += '<div class="modal-body">';
    _temp += '<p>'+ optionDefalut.content +'</p>';
    _temp += '</div>';
    _temp += '</div>';
    _temp += '</div>';
    _temp += '</div>';

    $(top.document).find('.modal').remove();
    $(top.document).find('body').append(_temp);
    $(top.document).find('.modal').modal('show');
}

// 打开上传界面
function openUpload(sType) {
    if(!sType){
        layer.alert('参数不正确');
    }
    else{
        if($('.upload_iframe_'+ sType +':visible').size() > 0){
            $('.upload_iframe_'+ sType).addClass('hide');
        }
        else{
            $('.upload_iframe_'+ sType).removeClass('hide');
        }
    }
}

// 完成上传
function completeUpload(sType, url) {
    if(!sType || !url){
        layer.alert('参数错误！');
    }
    else{
        $('.upload_'+ sType).val(url);
    }
}

// 选择指定name的checkbox，并开启排序修改
function selectIt(obj) {
    if($(obj).is(':checked') && $(obj).parents('tr').find('input[name="orderNumber[]"]').size() > 0) {
        $(obj).parents('tr').find('input[name="orderNumber[]"]').removeClass('disabled').prop('disabled', false);
    }
    else{
        $(obj).parents('tr').find('input[name="orderNumber[]"]').addClass('disabled').prop('disabled', true);
    }
}
// 全选指定name的checkbox，并开启排序修改
function selectAll(obj, inputName) {
    if($(obj).is(':checked')){
        $('input[name="'+ inputName +'[]"]').each(function (i, e) {
            $(e).prop('checked', true);
            if($(e).parents('tr').find('input[name="orderNumber[]"]').size() > 0){
                $(e).parents('tr').find('input[name="orderNumber[]"]').removeClass('disabled').prop('disabled', false);
            }
        })
    }
    else{
        $('input[name="'+ inputName +'[]"]').each(function (i, e) {
            $(e).prop('checked', false);
            if($(e).parents('tr').find('input[name="orderNumber[]"]').size() > 0){
                $(e).parents('tr').find('input[name="orderNumber[]"]').addClass('disabled').prop('disabled', true);
            }
        })
    }
}