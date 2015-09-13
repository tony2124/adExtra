<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}
?>
			
			</div>

			<hr>
			<footer>
				<center><a href="http://itsa.edu.mx">Instituto Tecnológico Superior de Apatzingán</a> | <a href="http://itsaextraescolares.com">Departamento de Actividades Culturales, Deportivas y Recreativas</a> | <a href="http://simpus.com.mx/es/software/acerca">acerca de</a></center>
			</footer>
		  
		</div>
		<div id="totop">
			<a class="icon-animation" href="#">
				<i class="fa fa-angle-up"></i>
			</a>
		</div>

		<style type="text/css">

			.activo-totop{
				right: 15px !important;
			}

			#totop {
				float: right;
				bottom: 15px;
				right: -50px;
				position: fixed;
				width: 45px;
				height: 45px;
				border-radius: 7px;
				z-index: 20 !important;
				text-align: center;
				overflow: hidden;
				background: #101010;
				transition: all 0.5s ease-in-out 0s;
			}

			#totop a{
				display: block;
				width: 100%;
				height: 100%;
				color: #ffffff;
				line-height: 45px;
				font-size: 2em;
			}

			#totop a:hover{
				background: #101010;
			}

			#totop a i{
				line-height: 45px;
			}


		</style>
	</body>

</html>