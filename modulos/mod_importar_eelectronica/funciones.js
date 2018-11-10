/* 
 * @Copyright 2018, Alagoro Software. 
 * @licencia   GNU General Public License version 2 or later; see LICENSE.txt
 * @Autor Alberto Lago Rodríguez. Alagoro. alberto arroba alagoro punto com
 * @Descripción	
 */

var timer;
var contador = 0;

$(function () {
    timer = setInterval(progresoImportar, 2000);
});

function progresoImportar() {

    ajaxCall({pulsado: 'progresoImportar',
    }, function (respuesta) {
        var obj = JSON.parse(respuesta);
        console.log(obj);
        if (!obj.error) {
            $('#contador').val(++contador);
            $('#lineas').html(obj.html);
//            if (contador == 10) {
//                clearInterval(timer);
//                contador = 0;
//            }
        } else {
            alert('Error ');
            clearInterval(timer);
            contador = 0;
        }
    });
}

function progresoIniciar() {
    clearInterval(timer);
    contador = 0;
    timer = setInterval(progresoImportar, 2000);
}

function progresoParar() {

    clearInterval(timer);
    contador = 0;
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




