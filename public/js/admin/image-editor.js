function saveImageData(){
    var imageData = $('.image-editor').cropit('export');
    $('.hidden-image-data').val(imageData);
};


function startImageEditor(form,src) {
    $('.image-editor').cropit({ 
        imageState: { 
            src: src
        },
        smallImage:'allow',
        onFileChange:function(e) {
            var elm = e.target;
            setTimeout(saveImageData,100);
        }
    });

    $('.cropit-image-zoom-input').change(function() {
        setTimeout(saveImageData,100);
    });
    $(form).submit(function() {
        saveImageData();
        return true;
    });
    
}

function checkfile(input) {
    if (window.File && window.FileList && window.FileReader){
        var files = input.files || [];
        if(files.length){

        }
    }
}