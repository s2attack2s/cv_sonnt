/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */
var elfNode, elfInstance, dialogName,
    elfUrl = '/el-finder-file-system/connector', // Your connector's URL
    elfDirHashMap = { // Dialog name / elFinder holder hash Map
        image: 'v1_L2ltYWdlcw2', //uploads/images
        flash: 'v1_L2ZsYXNocw2', //uploads/flashs
        files: 'v1_L2xpbmtz0', //uploads/files
        link: 'v1_L2ZpbGVz0', //uploads/links
        fb: 'v1_dXBsb2Fkcw2' // Fall back target : `/` uploads
    },
    imgShowMaxSize = 400, // Max image size(px) to show
    customData = {},
    // Set image size to show
    setShowImgSize = function (url, callback) {
        $('<img/>').attr('src', url).on('load', function () {
            var w = this.naturalWidth,
                h = this.naturalHeight,
                s = imgShowMaxSize;
            if (w > s || h > s) {
                if (w > h) {
                    h = Math.floor(h * (s / w));
                    w = s;
                } else {
                    w = Math.floor(w * (s / h));
                    h = s;
                }
            }
            callback({ width: w, height: h });
        });
    },
    // Set values to dialog of CKEditor  
    setDialogValue = function (file, fm) {
        var url = file.url,
            dialog = CKEDITOR.dialog.getCurrent(),
            dialogName = dialog._.name,
            tabName = dialog._.currentTabId,
            urlObj;
        if (fm === undefined) {
            var hash = file.hash;
            url = '/uploads' + Secure.DecodeBase64(hash.substring(3));
        }
        if (dialogName == 'image') {
            urlObj = 'txtUrl';
        } else if (dialogName == 'flash') {
            urlObj = 'src';
        } else if (dialogName == 'files' || dialogName == 'link') {
            urlObj = 'url';
        } else if (dialogName == 'image2') {
            urlObj = 'src';
        } else {
            return;
        }
        if (tabName == 'Upload' || tabName == 'upload') {
            tabName = 'info';
            dialog.selectPage(tabName);
        }
        dialog.setValueOf(tabName, urlObj, url);
        if (dialogName == 'image' && tabName == 'info') {
            setShowImgSize(url, function (size) {
                dialog.setValueOf('info', 'txtWidth', size.width);
                dialog.setValueOf('info', 'txtHeight', size.height);
                dialog.preview.$.style.width = size.width + 'px';
                dialog.preview.$.style.height = size.height + 'px';
                dialog.setValueOf('Link', 'txtUrl', url);
                dialog.setValueOf('Link', 'cmbTarget', '_blank');
            });
        }
        else if (dialogName == 'image' && tabName == 'Link') {
            setShowImgSize(url, function (size) {
                dialog.setValueOf('info', 'txtWidth', size.width);
                dialog.setValueOf('info', 'txtUrl', url);
                dialog.setValueOf('info', 'txtHeight', size.height);
                dialog.preview.$.style.width = size.width + 'px';
                dialog.preview.$.style.height = size.height + 'px';
            });
        }
        else if (dialogName == 'image2' && tabName == 'info') {
            dialog.setValueOf(tabName, 'alt', file.name + ' (' + elfInstance.formatSize(file.size) + ')');
            setShowImgSize(url, function (size) {
                setTimeout(function () {
                    dialog.setValueOf('info', 'width', size.width);
                    dialog.setValueOf('info', 'height', size.height);
                }, 100);
            });
        } else if (dialogName == 'files' || dialogName == 'link') {
            try {
                if (tabName == 'Link') {
                    dialog.setValueOf('info', 'url', url);
                }
                dialog.setValueOf('info', 'linkDisplayText', file.name);
            } catch (e) { }
        }
    };

// Setup upload tab in CKEditor dialog
CKEDITOR.on('dialogDefinition', function (event) {
    var editor = event.editor,
        dialogDefinition = event.data.definition,
        tabCount = dialogDefinition.contents.length,
        browseButton, uploadButton, submitButton, inputId;

    for (var i = 0; i < tabCount; i++) {
        try {
            browseButton = dialogDefinition.contents[i].get('browse');
            uploadButton = dialogDefinition.contents[i].get('upload');
            submitButton = dialogDefinition.contents[i].get('uploadButton');
        } catch (e) {
            browseButton = uploadButton = null;
        }

        if (browseButton !== null) {
            browseButton.hidden = false;
            browseButton.onClick = function (dialog, i) {
                dialogName = CKEDITOR.dialog.getCurrent()._.name;
                if (dialogName === 'image2') {
                    dialogName = 'image';
                }
                if (elfNode) {
                    if (elfDirHashMap[dialogName] && elfDirHashMap[dialogName] != elfInstance.cwd().hash) {
                        elfInstance.request({
                            data: { cmd: 'open', target: elfDirHashMap[dialogName] },
                            notify: { type: 'open', cnt: 1, hideCnt: true },
                            syncOnFail: true
                        });
                    }
                    elfNode.dialog('open');
                }
            }
        }

        if (uploadButton !== null && submitButton !== null) {
            uploadButton.hidden = false;
            submitButton.hidden = false;
            uploadButton.onChange = function () {
                inputId = this.domId;
            }
            // upload a file to elFinder connector
            submitButton.onClick = function (e) {
                dialogName = CKEDITOR.dialog.getCurrent()._.name;
                if (dialogName === 'image2') {
                    dialogName = 'image';
                }
                var target = elfDirHashMap[dialogName] ? elfDirHashMap[dialogName] : elfDirHashMap['fb'],
                    name = $('#' + inputId),
                    input = name.find('iframe').contents().find('form').find('input:file'),
                    error = function (err) {
                        alert(elfInstance.i18n(err).replace('<br>', '\n'));
                    };

                if (input.val()) {
                    var fd = new FormData();
                    fd.append('cmd', 'upload');
                    fd.append('target', target);
                    fd.append('overwrite', 0); // Instruction to save alias when same name file exists  
                    $.each(customData, function (key, val) {
                        fd.append(key, val);
                    });
                    fd.append('upload[]', input[0].files[0]);
                    $.ajax({
                        url: editor.config.filebrowserUploadUrl,
                        type: "POST",
                        data: fd,
                        processData: false,
                        contentType: false,
                        dataType: 'json'
                    })
                        .done(function (data) {
                            if (data.added && data.added[0]) {
                                elfInstance.exec('reload');
                                setDialogValue(data.added[0]);
                            } else {
                                error(data.error || data.warning || 'errUploadFile');
                            }
                        })
                        .fail(function () {
                            error('errUploadFile');
                        })
                        .always(function () {
                            input.val('');
                        });
                }
                return false;
            }
        }
    }
});

// Create elFinder dialog for CKEditor
CKEDITOR.on('instanceReady', function (e) {
    elfNode = $('<div style="padding:0;">');
    elfNode.dialog({
        autoOpen: false,
        modal: true,
        width: '80%',
        title: TransModule.Trans('Server File Manager'),
        create: function (event, ui) {
            var startPathHash = (elfDirHashMap[dialogName] && elfDirHashMap[dialogName]) ? elfDirHashMap[dialogName] : '';
            // elFinder configure
            elfInstance = $(this).elfinder({
                baseUrl: "/public/assets/elFinder/",
                startPathHash: startPathHash,
                useBrowserHistory: false,
                resizable: false,
                width: '100%',
                url: elfUrl,
                lang: lang,
                dialogContained: true,
                getFileCallback: function (file, fm) {
                    setDialogValue(file, fm);
                    elfNode.dialog('close');
                }
            }).elfinder('instance');
        },
        open: function () {
            elfNode.find('div.elfinder-toolbar input').blur();
            setTimeout(function () {
                elfInstance.enable();
            }, 100);
        },
        resizeStop: function () {
            elfNode.trigger('resize');
        }
    }).parent().css({ 'zIndex': '11000' });

    // CKEditor instance 
    var cke = e.editor;

    // Setup the procedure when DnD image upload was completed  
    cke.widgets.registered.uploadimage.onUploaded = function (upload) {
        var self = this;
        setShowImgSize(upload.url, function (size) {
            self.replaceWith('<img src="' + encodeURI(upload.url) + '" width="' + size.width + '" height="' + size.height + '"></img>');
        });
    }

    // Setup the procedure when send DnD image upload data to elFinder's connector 
    cke.on('fileUploadRequest', function (e) {
        var target = elfDirHashMap['image'] ? elfDirHashMap['image'] : elfDirHashMap['fb'],
            fileLoader = e.data.fileLoader,
            xhr = fileLoader.xhr,
            formData = new FormData();
        e.stop();
        xhr.open('POST', fileLoader.uploadUrl, true);
        formData.append('cmd', 'upload');
        formData.append('target', target);
        formData.append('upload[]', fileLoader.file, fileLoader.fileName);
        xhr.send(formData);
    }, null, null, 4);

    // Setup the procedure when got DnD image upload response
    cke.on('fileUploadResponse', function (e) {
        var file;
        e.stop();
        var data = e.data,
            res = JSON.parse(data.fileLoader.xhr.responseText);
        if (!res.added || res.added.length < 1) {
            data.message = 'Can not upload.';
            e.cancel();
        } else {
            elfInstance.exec('reload');
            file = res.added[0];
            if (file.url && file.url != '1') {
                data.url = file.url;
                try {
                    data.url = decodeURIComponent(data.url);
                } catch (e) { }
            } else {
                data.url = elfInstance.options.url + ((elfInstance.options.url.indexOf('?') === -1) ? '?' : '&') + 'cmd=file&target=' + file.hash;
            }
            data.url = elfInstance.convAbsUrl(data.url);
        }
    });
});

CKEDITOR.editorConfig = function (config) {
    token = $.cookie('token');
    config.language = lang;
    config.htmlEncodeOutput = false;
    config.filebrowserBrowseUrl = '/el-finder-file-system/connector';
    config.filebrowserImageBrowseUrl = '/el-finder-file-system/connector';
    config.filebrowserFlashBrowseUrl = '/el-finder-file-system/connector';
    config.filebrowserUploadUrl = '/el-finder-file-system/connector';
    config.filebrowserImageUploadUrl = '/el-finder-file-system/connector';
    config.filebrowserFlashUploadUrl = '/el-finder-file-system/connector';
    config.toolbarGroups = [
        { name: 'document', groups: ['mode', 'document', 'doctools'] },
        { name: 'clipboard', groups: ['clipboard', 'undo'] },
        { name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing'] },
        { name: 'basicstyles', groups: ['basicstyles', 'cleanup'] },
        '/',
        { name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph'] },
        { name: 'links', groups: ['links'] },
        { name: 'insert', groups: ['insert'] },
        '/',
        { name: 'styles', groups: ['styles'] },
        { name: 'colors', groups: ['colors'] },
        { name: 'tools', groups: ['tools'] },
        { name: 'others', groups: ['others'] },
        { name: 'about', groups: ['about'] }
    ];
    config.removeButtons = 'Source,CreateDiv,Iframe,ShowBlocks';
    //config.extraPlugins += (config.extraPlugins.length === 0 ? '' : ',') + 'ckeditor_wiris';
    config.allowedContent = true;
};
