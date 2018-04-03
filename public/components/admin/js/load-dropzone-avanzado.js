$('#loader-wrapper').hide();
var i = 0;

function limpiaForm(miForm) {
    $(':input', miForm).each(function() {
        var type = this.type;
        var tag = this.tagName.toLowerCase();
        if (type =='text' || type == 'password' || tag == 'textarea')
            this.value = "";
        else if (type == 'checkbox' || type == 'radio')
            this.checked = false;
        else if (tag == 'select')
            this.selectedIndex = -1;
    });
}
Dropzone.options.myDropzoneAvanzado = {
    autoProcessQueue: false,
    uploadMultiple: true,
    maxFilezise: 10,
    maxFiles: 10,
    parallelUploads : 100,
    acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",
    maxFilesize : 2,
    previewsContainer: ".dropzone-previews-avanzado",
    init: function() {
        var submitBtn = document.querySelector("#submit-avanzado");
        myDropzoneAvanzado = this;
        submitBtn.addEventListener("click", function(e){
            e.preventDefault();
            e.stopPropagation();
            if (myDropzoneAvanzado.getQueuedFiles().length > 0) {
                myDropzoneAvanzado.on("sending", function(file, xhr, formData) {
                    //xhr.setRequestHeader():
                    formData.append('Accept', 'application/json');
                    formData.append('Content-type', 'application/json');
                });
                myDropzoneAvanzado.processQueue();
            } else {
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "3000",
                    "preventDuplicates": true,
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }

                toastr["warning"]("Debes escoger al menos una imagen");
            }
        });
        this.on("addedfile", function(file) {
            var removeButton = Dropzone.createElement("<button class='btn btn-block btn-primary' style='margin-top: 3%; cursor: pointer'>Remove</button>");
            var _this = this;
            removeButton.addEventListener("click", function (e) {
                e.preventDefault();
                e.stopPropagation();
                _this.removeFile(file);
            });
            file.previewElement.appendChild(removeButton);
        });
        this.on("complete", function(file) {
            myDropzoneAvanzado.removeFile(file);
        });
        var toas = '';
        this.on("sendingmultiple",function(totalBytesSent){
                $('#loading').addClass('show');
            }
        );
        this.on("successmultiple",function(files,response) {
            myDropzone.processQueue.bind(myDropzone);
            $('#loading').addClass('hide');
            $('#loading').removeClass('show');
            myDropzone.removeFile(files);
            $(this).closest('#my-dropzone ').find("input[type=text], textarea").val("");
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            toastr["success"]("Tu producto fue agregado correctamente");
            $('div.help-block-create').addClass('hidden');
            limpiaForm($("#my-dropzone"));
        });
        this.on("errormultiple", function(files, response) {
            console.log(response);
            $('#loading').addClass('hide');
            $('#loading').removeClass('show');
            $.each(response , function (i , v) {
                $('div.help-block-create').removeClass('hidden');
                $('div.help-block-create#'+i).html('');
                $.each(v , function (index , value) {
                    $('div.help-block-create#'+i).append(value);
                })
            });
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "3000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            // setTimeout("location.reload(true);",3000);
            toastr["error"]("Hubo un error al crear tu producto");
        });
        this.on("thumbnail", function(file) {
            if (file.width < maxImageWidth || file.height < maxImageHeight) {
                alert('Te recomendamos que subas imagenes con mayor resolucion.')
            }
            if(file.width > 1000 || file.height > 2000){
                alert('Tal vez la resoulcion de tu imagen no sea la optima para tu tienda       .')
            }
        });
    }
};
