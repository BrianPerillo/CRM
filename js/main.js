/*if ($('nav ul li').hasClass('pagina')){
console.log("hola");
const stateObj = { foo: 'index' };
history.replaceState(stateObj, '', 'http://localhost/crud/index.php?pagina=1');
}*/

function eliminar(id_tarea, id_eliminar){
  var desea_eliminar = confirm("¿Seguro que desea eliminar esta tarea? " /*+ id_tarea + " " + id_eliminar*/);
  if (desea_eliminar == true) {
    $("#"+id_eliminar+"").attr("href", "delete.php?tarea="+id_tarea+"")
} else {
  return false;
}
}

function eliminar_nota(id_nota, id_eliminar){
  var desea_eliminar = confirm("¿Seguro que desea eliminar esta nota? " /*+ id_tarea + " " + id_eliminar*/);
  if (desea_eliminar == true) {
    $("#nota"+id_eliminar+"").attr("href", "delete.php?nota="+id_nota+"")
} else {
  return false;
}
}
