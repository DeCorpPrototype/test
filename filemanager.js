$(document).ready(function(){
    var handler = '/filemanagerHandler.php';
    var filesDirDefault = '/var/www/vhosts/site-local/public/filemanagerfiles';
    var windowInfo = {
        right : {
            currentPath : '',
            up          : '',
            content     : ''
        },
        left  : {
            currentPath : '',
            up          : '',
            content     : ''
        }
    };
    
    $.ajaxSetup({
        url: handler,
        type: 'POST'
    });
    
    function scanDir(dirPath,window) {
        $.ajax({
            data: {
                'dirPath' : dirPath,
                'rootPath': filesDirDefault
            },
            success: function(data) {
                windowInfo[window]['currentPath'] = filesDirDefault+dirPath;
                windowInfo[window]['up'] = windowInfo[window]['currentPath'].split('/').slice(0,-1).join('/');                
                $('#filemanager-window-'+window+' .filemanager-windowheader').html('');
                $('#filemanager-window-'+window+' .filemanager-windowcontent').html('');
                windowInfo[window]['content'] = JSON.parse(data);
                $('#filemanager-window-'+window+' .filemanager-windowheader').
                            append('<span class="filemanager-windowheader-title">'+dirPath+'</span>');
                $.each(windowInfo[window]['content'], function(key,element) {
                    if (key === 'dirs') {
                        $.each(element, function(){
                        $('#filemanager-window-'+window+' .filemanager-windowcontent').
                            append('<div class="filemanager-windowcontent-element" data="folder">\n\
                                    <i class="material-icons">folder</i><span>'
                                    +this+
                                    '</span></div>');
                    });
                    }
                    else {
                        $.each(element, function(){
                            $('#filemanager-window-'+window+' .filemanager-windowcontent').
                                append('<div class="filemanager-windowcontent-element" data="file">\n\
                                        <i class="material-icons">insert_drive_file</i><span>'
                                        +this+
                                        '<span></div>');
                        });
                    }
                });
            }         
        });
    }
    
    function getStarted () {
        scanDir('/','left');
        scanDir('/','right');
    }
    
    getStarted();
    
    $(document).on('click','.filemanager-windowcontent-element',function() {
        if ($(this).attr('data') === 'folder') {
            scanDir('/'+$(this).find('span').text(),'left');
        };
        console.log(windowInfo);
    });
    
    
});