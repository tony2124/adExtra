<?php
		$vars["clubesnoasignados"] = $this->Admin_Model->clubesNoAsignados(periodo_actual());
		$vars["clubessinresena"] = $this->Admin_Model->clubesSinResena();
		$vars["fecha_inscripcion_abierta"] = $this->Admin_Model->fecha_inscripcion_abierta();
		$vars["fecha_liberacion_abierta"] = $this->Admin_Model->fecha_liberacion_abierta();
		$vars["adminactuales"] = $this->Admin_Model->adminActuales();
		$vars["visitas"] = $this->Admin_Model->visitas();

		/************************************/
?>