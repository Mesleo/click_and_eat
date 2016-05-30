$(function(){

    var ul = $('#upload ul');

    $('#drop a').click(function(){
        $(this).parent().find('input').click();
    });

    $('#upload').fileupload({
        dataType: 'json',
        dropZone: $('#drop'),
        add: function (e, data) {
            var tpl = $('<li class="working"><input type="text" value="0" data-width="48" data-height="48"'+
                ' data-fgColor="#0788a5" data-readOnly="1" data-bgColor="#3e4043" /><p></p><span></span></li>');
            tpl.find('p').text(data.files[0].name)
                .append('<i>' + formatFileSize(data.files[0].size) + '</i>');
            data.context = tpl.appendTo(ul);
            tpl.find('input').knob();
            tpl.find('span').click(function(){
                if(tpl.hasClass('working')){
                    jqXHR.abort();
                }
                tpl.fadeOut(function(){
                    tpl.remove();
                });
            });
            var jqXHR = data.submit();
        },

        progress: function(e, data){
            var progress = parseInt(data.loaded / data.total * 100, 10);
            data.context.find('input').val(progress).change();
            if(progress == 100){
                data.context.removeClass('working');
            }
        },

        fail:function(e, data){
            data.context.addClass('error');
        },

        done:function(e, data){
            if (data.result.Ok){
                document.getElementById('lastImage').value = data.result.route;
            }else{
                data.context.addClass('error');
            }
        }
    });

    $(document).on('drop dragover', function (e) {
        e.preventDefault();
    });

    function formatFileSize(bytes) {
        if (typeof bytes !== 'number') {
            return '';
        }

        if (bytes >= 1000000000) {
            return (bytes / 1000000000).toFixed(2) + ' GB';
        }

        if (bytes >= 1000000) {
            return (bytes / 1000000).toFixed(2) + ' MB';
        }

        return (bytes / 1000).toFixed(2) + ' KB';
    }

    $(document).on('click', '#listMediaLibrary li', function(e){
        var el = $(e.currentTarget);
        el.parents('ul').find('.selected').removeClass('selected');
        el.addClass('selected');
        $('#lastImage').val(el.find('img').attr('src'));
    });
});