import Dropzone from "dropzone";

Dropzone.autoDiscover = false;

const dropzone = new Dropzone("#dropzone", {
    dictDefaultMessage: "Sube aquí tu imágen",
    acceptedFiles: ".png,.jpg,.jpeg,.gif",
    addRemoveLinks: true,
    dictRemoveFile: "Borrar Archivo",
    maxFiles: 1,
    uploadMultiple: false,

    // Colocamos imágen al dropzone
    init: function () {
        if (document.querySelector('[name="imagen"]').value.trim()) {
            // Opciones obligatorias
            const imagenPublicada = {};
            imagenPublicada.size = 1234;
            imagenPublicada.name =
                document.querySelector('[name="imagen"]').value;

            // Se agrega la imágen a la lista de archivos cargados en dropzone
            this.options.addedfile.call(this, imagenPublicada);
            this.options.thumbnail.call(
                this,
                imagenPublicada,
                `/uploads/${imagenPublicada.name}`
            );

            imagenPublicada.previewElement.classList.add(
                "dz-success",
                "dz-complete"
            );
        }
    },
});

// dropzone.on("sending", function (file, xhr, formData) {
//     console.log(formData);
// });

dropzone.on("success", function (file, response) {
    // console.log(response.imagen);
    document.querySelector('[name="imagen"]').value = response.imagen;
});

// dropzone.on("error", function (file, message) {
//     console.log(message);
// });

dropzone.on("removedfile", function () {
    document.querySelector('[name="imagen"]').value = "";
    fetch("/imagenes/eliminar").then((res) => res.json());
});
