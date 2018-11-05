/* 
 * @Copyright 2018, Alagoro Software. 
 * @licencia   GNU General Public License version 2 or later; see LICENSE.txt
 * @Autor Alberto Lago Rodríguez. Alagoro. alberto arroba alagoro punto com
 * @Descripción	
 */


$(function () {

});

function progresoImportar(){
        
            ajaxCall({pulsado: 'progresoImportar',
                }, function (respuesta) {
                var obj = JSON.parse(respuesta);
                console.log(obj);
                if (!obj.error) {
                    $('#lineas').html(obj.html);
                } else {
                    alert('Error ');
                }
            });
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




