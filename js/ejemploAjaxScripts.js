// ========================================================================
//
//      FUNCIONES DE AJAX
// 
/*
 * @file ejemploAjaxScripts.js
 * @brief Manejo de peticiones AJAX para carga dinámica de contenido
 * @date 12-05-2025
 * @author Atom Nava, Julen Franco
 */
// ========================================================================

/**
 * @brief Carga contenido dinámico según parámetros
 * @param number contenido - Tipo de contenido a cargar (1-7)
 * @param string cadena - Parámetro 'nombre' para la petición
 * @param  valor - Parámetro 'numero' para la petición
 * @return  Siempre retorna true
 */
function despliegaContenido(contenido, cadena, valor){
        
    var params = "nombre="+cadena+"&numero="+valor;
    
    if (contenido == 1) {
        url = "./ejemploAjaxContenido1.php";
    }
    else if (contenido == 2) {
        url = "./ejemploAjaxContenido2.php";
    }
    else if (contenido == 3) {
        url = "./ejemploAjaxContenido3.php";
    }
    else if (contenido == 4) {
        url = "./ejemploAjaxContenido4.php";
    }
    else if (contenido == 5) {
        url = "./ejemploAjaxContenido5.php";
    }
    
    $.ajax({
        url: url,
        dataType: 'html',
        type: 'POST',
        async: true,
        data: params,
        success: muestraContenido,
        error: funcionErrors
    });
    
    return true;
}

/**
 * @brief Callback para mostrar contenido HTML recibido
 * @param string result - HTML recibido del servidor
 * @param string status - Estado de la petición
 * @param object} xhr - Objeto XMLHttpRequest
 */
function muestraContenido(result,status,xhr){
    $("#contenido").html(result);
}

/**
 * @brief Maneja errores en peticiones AJAX
 * @param object xhr - Objeto XMLHttpRequest
 * @param string status - Estado del error
 * @param string error - Mensaje de error
 */
function funcionErrors(xhr,status,error){
    alert(xhr);
}

/**
 * @brief Carga contenido dinámico por tipo (versión alternativa)
 * @param string tipo - Tipo de contenido a cargar
 */
function cargarContenido(tipo) {
    $.ajax({
        url: 'cargar_'+tipo+'.php',
        method: 'GET',
        success: function(response) {
            $('#'+tipo+'-content').html(response);
        },
        error: function(xhr) {
            alert('Error al cargar '+tipo+': ' + xhr.responseText);
        }
    });
}