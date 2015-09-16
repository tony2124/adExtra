<?php
/**
* Access from index.php:
*/
if(!defined("_access")) {
die("Error: You don't have permission to access here...");
}

class Admin_Model extends ZP_Model {

public function __construct() {
$this->Db = $this->db();
$this->helpers();
$this->table = "contacts";
}

public function acentos()
{
	$this->Db->query("SET NAMES 'utf8'");
}

/****** PROMOTORES *******/
public function getResultadoProm()
{

return $this->Db->query("select * from ");
}

//*** AVISOS ****/
public function clubesNoAsignados($periodo){
	return $this->Db->query("SELECT clubes.id_club, nombre_club, horarios.id_club, periodo from clubes LEFT JOIN horarios on clubes.id_club = horarios.id_club AND horarios.periodo='$periodo' WHERE horarios.id_club is NULL and (clubes.tipo_club = 1 or clubes.tipo_club= 2) and clubes.eliminado_club = false");
}

public function clubesSinResena(){
	return $this->Db->query("SELECT nombre_club from clubes where (texto_club = '' or foto_club = '' ) and eliminado_club = false and (tipo_club = 1 or tipo_club = 2) order by nombre_club");
}

public function fecha_inscripcion_abierta(){
	return $this->Db->query("SELECT * from conf_fechas where '".date("Y-m-d")."' >= fecha_inicio_inscripcion AND '".date("Y-m-d")."' <= fecha_fin_inscripcion AND periodo = '".periodo_actual()."'");
}

public function fecha_liberacion_abierta(){
	return $this->Db->query("SELECT * from conf_fechas where '".date("Y-m-d")."' >= fecha_inicio_liberacion AND '".date("Y-m-d")."' <= fecha_fin_liberacion AND periodo = '".periodo_actual()."'");
}

public function adminActuales(){
	return $this->Db->query("SELECT count(id_administrador) as count from administradores where actual = 1");
}

public function visitas(){
	return $this->Db->query("SELECT numero_visitas from configuracion");
}

/*****************************/


public function getPromotorAsignado($id_club, $periodo){
		return $this->Db->query("SELECT * from horarios, clubes, promotores where horarios.id_club = clubes.id_club AND 
				horarios.usuario_promotor = promotores.usuario_promotor AND 
					horarios.id_club = '$id_club' AND horarios.periodo = '$periodo'");
}

public function obtenerListaPromotores($buscar)
{
	return $this->Db->query("SELECT * from promotores WHERE (nombre_promotor like '%$buscar%' OR apellido_paterno_promotor like '%$buscar%' OR apellido_materno_promotor like '%$buscar%' OR usuario_promotor like '%$buscar%')  order by  apellido_paterno_promotor asc, apellido_materno_promotor asc, nombre_promotor asc");	
	
}

public function getPromotores($periodo)
{
	if($periodo==NULL)
		return $this->Db->query("select * from promotores where eliminado_promotor=false order by nombre_promotor asc, apellido_paterno_promotor asc, apellido_materno_promotor asc");	
	else if(strcmp($periodo,"all") == 0)
		return $this->Db->query("select * from promotores order by  nombre_promotor asc, apellido_paterno_promotor asc, apellido_materno_promotor asc");	
	return $this->Db->query("select * from promotores natural join horarios natural join clubes where periodo='$periodo' order by nombre_promotor asc, apellido_paterno_promotor asc, apellido_materno_promotor asc");
}


public function habilitarpromotor($id,$dato){
	$this->Db->query("UPDATE promotores set eliminado_promotor = $dato WHERE usuario_promotor = '$id'");
}

public function subirBDAlumnos($ruta)
{
	return $this->Db->query("load data local infile '$ruta' into table alumnos FIELDS TERMINATED BY ',' ESCAPED BY '\\\\' LINES TERMINATED BY '\\r\\n'");
}

/*public function getEditPromotor($id)
{
return $this->Db->query("select * from promotores where eliminado_promotor = false and usuario_promotor = '$id'");
}*/

public function getPromotor($club, $periodo)
{
	return $this->Db->query("select nombre_promotor, horario, apellido_materno_promotor, apellido_paterno_promotor, nombre_club from promotores natural join horarios natural join clubes where id_club = '$club' and periodo ='$periodo'");
}

public function getPromotorId($id)
{
	return $this->Db->query("SELECT * from promotores where usuario_promotor = '$id'");
}

public function getHistorialPromotor($id)
{
	return $this->Db->query("SELECT horarios.periodo as per, substring(horarios.periodo,4,4) as ini, substring(horarios.periodo, 12,4) as fin, clubes.id_club as idclub, nombre_club, horario, lugar, count(folio) as ins from promotores, horarios, clubes, inscripciones where inscripciones.periodo = horarios.periodo AND horarios.id_club = inscripciones.id_club AND clubes.id_club = horarios.id_club AND promotores.usuario_promotor = horarios.usuario_promotor AND promotores.usuario_promotor = '$id' GROUP BY horarios.periodo ORDER BY ini DESC, fin DESC");
	//"SELECT periodo, substring(periodo,4,4) as ini, substring(periodo, 12,4) as fin,clubes.id_club as idclub, nombre_club, horario, lugar from promotores, horarios, clubes where clubes.id_club = horarios.id_club AND promotores.usuario_promotor = horarios.usuario_promotor AND promotores.usuario_promotor = '$id' ORDER BY ini DESC, fin DESC");

}



public function elimPromotor($id)
{
return $this->Db->query("update promotores set eliminado_promotor = true where usuario_promotor = '$id' ");
}

public function getPeriodos()
{
	//return $this->Db->query("SELECT periodo from inscripciones group by periodo ORDER BY fecha_inscripcion_club desc");	
	return $this->Db->query("SELECT periodo, substring(periodo,4,4) as ini, substring(periodo, 12,4) as fin from inscripciones group by periodo order by ini DESC, fin DESC");	
	
}

public function regPromotor($vars)
{

$query = "insert into promotores (usuario_promotor, contrasena_promotor, foto_promotor, nombre_promotor, apellido_paterno_promotor, apellido_materno_promotor, sexo_promotor, fecha_nacimiento_promotor, fecha_registro_promotor, correo_electronico_promotor, telefono_promotor, ocupacion_promotor, direccion_promotor)
values('$vars[user]', '$vars[pass]','$vars[foto]', '$vars[nombre]' ,'$vars[ap]','$vars[am]', $vars[sexo], '$vars[fecha_nac]', '$vars[fecha_reg]', '$vars[email]','$vars[tel]' ,'$vars[ocupacion]', '$vars[direccion]')";
//$this->acentos();
$this->Db->query($query);
return $query;
}

public function updatePromotor($vars)
{

$query = "UPDATE promotores set fecha_modificacion_promotor = '".date("Y-m-d")."', usuario_promotor = '$vars[usuarionuevo]', contrasena_promotor = '$vars[pass]', foto_promotor = '$vars[foto]', nombre_promotor = '$vars[nombre]', apellido_paterno_promotor = '$vars[ap]', apellido_materno_promotor = '$vars[am]', sexo_promotor = $vars[sexo], fecha_nacimiento_promotor = '$vars[fecha_nac]', correo_electronico_promotor = '$vars[email]', telefono_promotor = '$vars[tel]', ocupacion_promotor = '$vars[ocupacion]', direccion_promotor = '$vars[direccion]' where usuario_promotor = '$vars[usuario]'";
$this->Db->query($query);
return $query;
}

public function updatePromotorMantener($vars)
{

$query = "UPDATE promotores set fecha_modificacion_promotor = '".date("Y-m-d")."', usuario_promotor = '$vars[usuarionuevo]', contrasena_promotor = '$vars[pass]', nombre_promotor = '$vars[nombre]', apellido_paterno_promotor = '$vars[ap]', apellido_materno_promotor = '$vars[am]', sexo_promotor = $vars[sexo], fecha_nacimiento_promotor = '$vars[fecha_nac]', correo_electronico_promotor = '$vars[email]', telefono_promotor = '$vars[tel]', ocupacion_promotor = '$vars[ocupacion]', direccion_promotor = '$vars[direccion]' where usuario_promotor = '$vars[usuario]'";
$this->Db->query($query);
return $query;
}


/*ALUMNOS*/


public function updateLiberacion($vars)
{
	$this->Db->query("UPDATE conf_fechas set fecha_inicio_inscripcion = '$vars[ins_ini]', fecha_fin_inscripcion = '$vars[ins_fin]', fecha_inicio_liberacion = '$vars[lib_ini]', fecha_fin_liberacion = '$vars[lib_fin]', numero_clubes = '$vars[nper]' where periodo = '$vars[periodo]'");
}

public function insertarLiberacion($vars)
{
	$this->Db->query("INSERT INTO conf_fechas( fecha_inicio_inscripcion, fecha_fin_inscripcion, fecha_inicio_liberacion, fecha_fin_liberacion, periodo, numero_clubes) VALUES('$vars[ins_ini]', '$vars[ins_fin]', '$vars[lib_ini]', '$vars[lib_fin]', '$vars[periodo]', '$vars[nper]') ");
}

public function updateRes($acred, $folio, $obs, $fl)
{
//$this->acentos();
$dat = $this->Db->query("select * from inscripciones where folio = $folio");
$observaciones = $obs;
$this->acentos();
$query = "update inscripciones set acreditado = $acred, fecha_liberacion_club = '$fl', observaciones = '$observaciones' where folio = '$folio'";
$this->Db->query($query);
return $query;
}



public function guardarAviso($texto, $mostrar)
{
$this->Db->query("update configuracion set mostraraviso = $mostrar");
$this->acentos();
$query = "update noticias set texto_noticia = '$texto' where id_noticiaS = 1";
$this->Db->query($query);
return $query;
}

public function crearAlbum($id, $album, $club)
{
$fec = date("Y-m-d");
$this->Db->query("insert into albumes values('$id','$club','$album','$fec','')");
}


public function getConfiguracion()
{
	return $data = $this->Db->query("select * from configuracion");
}

public function getConfFechas($periodo)
{
	return $data = $this->Db->query("SELECT * from conf_fechas WHERE periodo = '$periodo'");
}

public function inscribirActividad($vars)
{
	$this->acentos();
	$query = "insert into inscripciones(id_administrador, numero_control, id_club, periodo, semestre,
		fecha_inscripcion_club, fecha_liberacion_club, observaciones, acreditado )
		values('$vars[id_administrador]','$vars[numero_control]','$vars[club]','$vars[periodo]','$vars[semestre]','$vars[fecha_inscripcion]',
		'$vars[fecha_modificacion]','$vars[observaciones]',$vars[acreditado])";
	$data = $this->Db->query($query);
	return $query;
}

public function getAviso()
{
	return $this->Db->query("select * from noticias where id_noticias = 1");
}

public function getFormatos()
{
	return $this->Db->query("select * from formatos");
}

public function getRevisiones()
{
	return $this->Db->query("select * from revisiones, formatos where tipo_formato= id_formato order by fecha_inicio_revision DESC");
}

public function getRevisionActual($tipo, $fecha)
{	

	return $this->Db->query("SELECT * FROM revisiones WHERE tipo_formato = '$tipo' AND '$fecha' > fecha_inicio_revision ORDER BY fecha_inicio_revision DESC");
}

public function getRevision($id)
{
	return $this->Db->query("select * from revisiones where id_revision = '$id'");
}

public function guardarRevision($v)
{
	return $this->Db->query("INSERT INTO revisiones (nombre_revision, codigo, norma, fecha_inicio_revision, tipo_formato) values ('$v[nombre]','$v[codigo]','$v[norma]','$v[fecha]',$v[tipo_formato])");
}

public function actualizarRevision($v, $id)
{
	return $this->Db->query("UPDATE revisiones set nombre_revision = '$v[nombre]', codigo = '$v[codigo]', norma = '$v[norma]', fecha_inicio_revision = '$v[fecha]', tipo_formato = $v[tipo_formato] where id_revision = '$id' ");
}

public function getClubes($hm = NULL)
{
	if(strcmp($hm, "all") == 0)
		return $data = $this->Db->query("select * from clubes where eliminado_club = 0 order by nombre_club asc");	

	if(strcmp($hm, "elim") == 0)
		return $data = $this->Db->query("SELECT * from clubes where tipo_club= 1 OR tipo_club = 2 order by nombre_club asc");	

	if($hm == 1 || $hm == 2)
		return $data = $this->Db->query("select * from clubes where eliminado_club = 0 and tipo_club = $hm order by nombre_club asc");	
	
	return $data = $this->Db->query("select * from clubes where eliminado_club = 0 and tipo_club!=3 order by nombre_club asc");
}

public function guardarHorario($vars)
{

	$data = $this->Db->query("select * from horarios where periodo = '$vars[periodo]' and id_club = '$vars[club]'");
	if($data == NULL)
		$this->Db->query("INSERT into horarios(id_club, usuario_promotor,periodo,grupo,lugar, horario) values($vars[club],'$vars[promotor]','$vars[periodo]','A','$vars[lugar]','$vars[horario]')");
	else
		$this->Db->query("update horarios set usuario_promotor = '$vars[promotor]', lugar = '$vars[lugar]', horario =  '$vars[horario]' where id_club = '$vars[club]' and periodo = '$vars[periodo]' ");
}

public function getClubesProm()
{
	return $data = $this->Db->query("select intersection from clubes join promotores where eliminado_club = 0 and tipo_club!=3 and eliminado_promotor = 0 order by nombre_club asc");
}


public function getAlbumes($var, $value)
{
	switch($var)
	{
		case 'club': return $this->Db->query("select * from albumes where id_club = '$value'");break;
		case 'album': return $this->Db->query("select * from albumes where dependiente = '$value'");break;	
	}

}

public function getFotos($album)
{
	return $this->Db->query("select * from galeria where id_album='$album'");
}

public function insertarFoto($vars){
	return $this->Db->query("INSERT into galeria values('$vars[id]','$vars[name]','$vars[album]','".date("Y-m-d")."','$vars[admin]','')");
}

public function getCarreras($id,$bool)
{
	if($id == NULL)
		if($bool == true)
			return $data = $this->Db->query("select * from carreras order by abreviatura_carrera asc");
		else
			return $data = $this->Db->query("select * from carreras where eliminada = false order by abreviatura_carrera asc");

	return $data = $this->Db->query("select * from carreras where id_carrera = '$id' order by abreviatura_carrera asc");
}

public function getAlumnosInscritos($periodo)
{
	$cad = "select id_club, sexo, periodo, tipo_club, acreditado, nombre_club, id_carrera, nombre_carrera from alumnos natural join inscripciones natural join clubes natural join carreras where periodo = '";
	foreach ($periodo as $per) {
		$cad .= $per."' or periodo = '";
	}

	$cad = substr($cad, 0,-14);
return $data = $this->Db->query($cad);	

}

public function getData($usuario)
{
return $this->Db->query("select * from administradores where usuario_administrador = '$usuario'");
}

public function getAdminData($id)
{
return $this->Db->query("select * from administradores where id_administrador = '$id'");	
}	

public function getAdminCampo($Campo, $Valor)
{
return $this->Db->query("select * from administradores where $Campo = $Valor");	
}

public function getAllAdminData()
{
return $this->Db->query("select * from administradores");
}

public function getActualAdmin(){
	return $this->Db->query("SELECT * from administradores where actual = 1");		
}

public function getRespuesta($datos, $sit)
{
return $this->Db->query("select * from alumnos natural join carreras where (numero_control like '$datos%' or nombre_alumno like '$datos%' or apellido_paterno_alumno like '$datos%') and situacion_escolar <= '$sit' order by apellido_paterno_alumno asc, apellido_materno_alumno asc, nombre_alumno asc");
}

public function getAlumno($n)
{
return $this->Db->query("select * from alumnos natural join carreras where numero_control = '$n'");
}

public function getClubesInscritosAlumno($n)
{
return $this->Db->query("select * from inscripciones natural join clubes where numero_control = '$n'");
}

public function getAlumnosClubes($club, $periodo)
{
return $this->Db->query("select * from inscripciones natural join alumnos natural join carreras
natural join clubes where id_club = '$club' and periodo = '$periodo' order by apellido_paterno_alumno asc,
apellido_materno_alumno asc, nombre_alumno asc");
}

public function getAlumnosClubes1($club, $periodo)
{
return $this->Db->query("select numero_control, sexo, id_administrador, id_club, periodo, nombre_club, apellido_paterno_alumno,apellido_materno_alumno, 
	nombre_alumno, semestre,acreditado, fecha_nacimiento, fecha_inscripcion_club, abreviatura_carrera, observaciones 
	from inscripciones natural join alumnos natural join carreras
	natural join clubes where id_club = '$club' and periodo = '$periodo' order by apellido_paterno_alumno asc,
	apellido_materno_alumno asc, nombre_alumno asc");
}


public function getAlumnosClubes2($club, $periodo)
{
	return $this->Db->query("SELECT alumnos.numero_control, apellido_paterno_alumno,apellido_materno_alumno, 
		nombre_alumno, nombre_club FROM inscripciones, alumnos, clubes WHERE inscripciones.numero_control = alumnos.numero_control 
		AND inscripciones.id_club = clubes.id_club AND clubes.id_club = '$club' and inscripciones.periodo = '$periodo' order by alumnos.apellido_paterno_alumno asc,
		apellido_materno_alumno asc, nombre_alumno asc");

}


public function getAlumnosCarreras($carrera, $periodo = NULL)
{
return $this->Db->query("select * from inscripciones natural join alumnos natural join carreras
natural join clubes where id_carrera = '$carrera' and periodo = '$periodo' and tipo_club != 3 order by apellido_paterno_alumno asc,
apellido_materno_alumno asc, nombre_alumno asc");
}

public function getNoticias()
{
return $this->Db->query("select * from noticias where id_noticias != '1' order by fecha_modificacion desc, hora desc");
}

public function getNoticia($id)
{
return $this->Db->query("select * from noticias where id_noticias = '$id'");
}

public function saveNew($vars)
{
$query = "insert into noticias(id_noticias, nombre_noticia, texto_noticia, imagen_noticia, fecha_modificacion, hora, id_administrador)
values ('$vars[id_noticias]','$vars[nombre_noticia]','$vars[texto_noticia]','$vars[imagen_noticia]','$vars[fecha_modificacion]','$vars[hora]',$vars[id_administrador])";
$this->acentos();
$this->Db->query($query);
return $query;

}

public function updateNew($vars)
{
$query = "update noticias set nombre_noticia = '$vars[nombre_noticia]' ,
texto_noticia = '$vars[texto_noticia]', imagen_noticia = '$vars[imagen_noticia]', fecha_modificacion = '$vars[fecha_modificacion]',
hora = '$vars[hora]', id_administrador = $vars[id_administrador] where id_noticias = '$vars[id_noticias]'";
$this->acentos();
$this->Db->query($query);
return $query;
}

public function elimNoticia($id)
{
return $this->Db->query("delete from noticias where id_noticias = '$id'");
}

public function guardarClub($vars)
{
$query = "insert into clubes(nombre_club, tipo_club, texto_club, foto_club, fecha_creacion, fecha_modificacion)
values ('$vars[nombre_club]','$vars[tipo_club]','$vars[texto_club]','$vars[foto_club]','$vars[fecha_creacion]','$vars[fecha_creacion]')";
$this->acentos();
$this->Db->query($query);
return $query;
}

public function guardarcarrera($vars)
{
$query = "INSERT INTO carreras(id_carrera, nombre_carrera, abreviatura_carrera, semestres_carrera, plan_estudio, fecha_registro)
values ('$vars[id]','$vars[nombre_carrera]','$vars[abreviatura_carrera]','$vars[semestres_carrera]','$vars[plan]','".date("Y-m-d")."')";
$this->acentos();
$this->Db->query($query);
return $query;
}


public function updateClub($vars)
{
$query = "update clubes set nombre_club = '$vars[nombre_club]' , tipo_club = '$vars[tipo_club]' ,
texto_club = '$vars[texto_club]', foto_club = '$vars[foto_club]', fecha_modificacion = '$vars[fecha_modificacion]'
where id_club = '$vars[id_club]'";
$this->acentos();
$this->Db->query($query);
return $query;
}

public function modcarrera($vars)
{
$query = "update carreras set nombre_carrera = '$vars[nombre_carrera]' , abreviatura_carrera = '$vars[abreviatura_carrera]' ,
semestres_carrera = '$vars[semestres_carrera]', plan_estudio = '$vars[plan]' where id_carrera = '$vars[id_carrera]'";
$this->acentos();
$this->Db->query($query);
return $query;
}

public function hclub($id, $e)
{
	return $this->Db->query("update clubes set eliminado_club = '$e' where id_club = '$id' ");
}

public function habilitarCarrera($id, $estado)
{
return $this->Db->query("update carreras set eliminada = '$estado' where id_carrera = '$id' ");
}

public function elimActividad($folio)
{
return $this->Db->query("delete from inscripciones where folio = '$folio'");
}

public function elimFoto($id_foto)
{
return $this->Db->query("delete from galeria where id_imagen = '$id_foto'");
}
public function updateAlumno($vars)
{
$query = "update alumnos set numero_control = '$vars[numero_control]', nombre_alumno = '$vars[nombre]', id_carrera = '$vars[car]' , 
apellido_paterno_alumno = '$vars[ap]', apellido_materno_alumno = '$vars[am]',
sexo = $vars[sexo], fecha_nacimiento = '$vars[fecha_nac]', correo_electronico = '$vars[email]',
situacion_escolar = $vars[se], clave = '$vars[clave]' where numero_control = '$vars[numero_control_ant]'";

$this->Db->query($query);
return $query;
}

public function updateActividad($folio, $act)
{
$query = "update inscripciones set id_club='$act' where folio = '$folio'";

$this->Db->query($query);
return $query;
}

public function regAlumno($vars)
{
$query = "insert into alumnos (numero_control, nombre_alumno, apellido_paterno_alumno, apellido_materno_alumno, id_carrera, sexo, fecha_nacimiento, fecha_inscripcion, correo_electronico, situacion_escolar, clave)
values('$vars[numero_control]', '$vars[nombre]', '$vars[ap]','$vars[am]', '$vars[car]', $vars[sexo], '$vars[fecha_nac]', '$vars[fecha_ins]', '$vars[email]', $vars[se], '$vars[clave]')";

$this->Db->query($query);
return $query;
}


public function eliminarAlbum($album)
{
$query = "delete from albumes where id_album = '$album'";
$this->Db->query($query);
return $query;
}

public function eliminargeneracion($gen)
{
$query = "delete from inscripciones where numero_control like '$gen%'";
$this->Db->query($query);
$query = "delete from alumnos where numero_control like '$gen%'";
$this->Db->query($query);
return $query;
}

public function eliminarFotosAlbum($album)
{
$query = "delete from galeria where id_album = '$album'";
$this->Db->query($query);
return $query;
}

public function editAlbum($album, $name)
{
$query = "update albumes set nombre_album = '$name' where id_album = '$album'";
$this->Db->query($query);
return $query;
}

/*
public function insertarFoto($id, $name, $album)
{
$fecha = date("Y-m-d");
$admin = SESSION('id_admin');
$query = "insert into galeria (id_imagen, nombre_imagen, id_album, fecha_modificacion, id_administrador, pie) values('$id', '$name', '$album', '$fecha', $admin, '')";
$this->Db->query($query);
return $query;
}
*/
public function getAlumnoInscrito($folio)
{
	return $this->Db->query("select * from inscripciones natural join alumnos natural join carreras natural join clubes where folio = '$folio'");
}

public function setCampos($tabla, $campos, $ID)
{
$this->Db->update($tabla, $campos, $ID);
}

public function setRow($tabla,$datos)
{
return $this->Db->insert($tabla,$datos);
}

	public function getCampos($tabla,$campos,$where = NULL)
	{
		$this->Db->select($campos);
		$this->Db->from($tabla);
		$this->Db->where($where);
		return $this->Db->get();
	}

	public function obtenerDatosClub($id)
	{
		return $this->Db->query("select * from clubes where id_club = $id and eliminado_club = false");
	}

	public function comprobarEstados()
	{
		return $this->Db->countBySQL("actual > 0","administradores");
	}

	public function isValid ($argumentos)
	{
		if($argumentos[1])
			if($argumentos[0] != $argumentos[1])
			{
				return "No coinciden los valores";
			}
		if($argumentos[2])
			if(strlen($argumentos[0]) < $argumentos[2])
			{
				return "Demasiado corto, ingrese un valor de tamaño mayor o igual que ".$argumentos[2];
			}
		if($argumentos[3])
			if(strlen($argumentos[0]) > $argumentos[3])
			{
				return "Demasiado largo, ingrese un valor de tamaño menor o igual que ".$argumentos[2];
			}
		if($argumentos[4])
			if(!preg_match($argumentos[4], $argumentos[0]))
			{
				return "Valor del campo no valido, ingrese un valor aceptable";
			}
		if($argumentos[5] && $argumentos[6])
		{	
			if($this->getCampos($argumentos[5],$argumentos[6],$argumentos[6]."='".$argumentos[0]."'"))
			{
			return "Ya existe uno igual, elija otro por favor";
			}
		}
	}

	public function obtenerReglamento()
	{
		return $this->Db->query("SELECT reglamento from configuracion");
	}

	public function guardarReglamento($reg)
	{
		$this->acentos();
		$this->Db->query("update configuracion set reglamento = '$reg'");
	}

	public function hacerespaldo($backupFile, $table)
	{
		return $this->Db->query( "SELECT * INTO OUTFILE '$backupFile' FIELDS TERMINATED BY ',' ENCLOSED BY '|' LINES TERMINATED BY '\n' FROM $table" );
	}

}