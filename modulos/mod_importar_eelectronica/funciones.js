/* 
 * @Copyright 2018, Alagoro Software. 
 * @licencia   GNU General Public License version 2 or later; see LICENSE.txt
 * @Autor Alberto Lago Rodríguez. Alagoro. alberto arroba alagoro punto com
 * @Descripción	
 */


$(function () {

});

function progresoImportar(){
        
        var mensajes = [];
            mensajes.push('Por favor da un nombre a la familia');
        if (mensajes.length > 0) {
            for (var i = 0; i < mensajes.length; i++) {
                alert(mensajes[i]);
            }
        } else {
            ajaxCall({pulsado: 'progresoImportar',
                }, function (respuesta) {
                var obj = JSON.parse(respuesta);
                console.log(obj);
                if (!obj.error) {
                    $('#progreso').parent().html(obj.html);
                } else {
                    alert('Error al borrar');
                }
            });
        }
}

function borrarProductoFamilia(){
    console.log("Entre en borrar familia");
    var seleccion = seleccionados('idproducto');
        var idfamilia = $('#idfamilia').val();

        if(seleccion.length > 0) {
            ajaxCall({pulsado: 'borrarFamiliaProducto',
                idfamilia: idfamilia,
                idsproductos : seleccion,
            }, function (respuesta) {
                var obj = JSON.parse(respuesta);
                console.log(obj);
                if (!obj.error) {
                    $('#tproductos').parent().html(obj.html);
                    alert('borrado correctamente');
                    borrarFamilia(); // ¡¡OJO se llama a si mismo!!. ¿Y funciona?
                } else {
                    alert('Error al borrar');
                }
            }
            );

        }
}


function ajaxCall(parametros, callback) {

    $.ajax({
        data: parametros,
        url: './tareas.php',
        type: 'post',
        success: callback,
        error: function (request, textStatus, error) {
            console.log(textStatus);
        }
    });
}




