<?php session_start();


//aqui empieza el carrito
if(isset($_SESSION['carrito']) || isset($_POST['titulo'])){
	if(isset($_SESSION['carrito'])){
		$carrito_mio=$_SESSION['carrito'];
		if(isset($_POST['titulo'])){
			$titulo=$_POST['titulo'];
			$precio=$_POST['precio'];
			$cantidad=$_POST['cantidad'];
			$disponilibilidad=$_POST['disponibilidad'];
			$ref=$_POST['ref'];
			$donde=-1;
			for($i=0;$i<=count($carrito_mio)-1;$i ++){
			   if($ref==$carrito_mio[$i]['ref']){
			   	  //Quitamos esta linea para que no aumente la cantidad y genere una linea nueva
			   //	$donde=$i;
			   }
			}}
			if($donde != -1){
				$cuanto=$carrito_mio[$donde]['cantidad'] + $cantidad;
				$carrito_mio[$donde]=array("titulo"=>$titulo,"precio"=>$precio,"cantidad"=>$cuanto,"disponibilidad"=>$disponilibilidad,"ref"=>$ref);
			}else{
				$carrito_mio[]=array("titulo"=>$titulo,"precio"=>$precio,"cantidad"=>$cantidad,"disponibilidad"=>$disponilibilidad,"ref"=>$ref);
			}
		}
	}else{
		$titulo=$_POST['titulo'];
		$precio=$_POST['precio'];
		$cantidad=$_POST['cantidad'];
		$disponilibilidad=$_POST['disponibilidad'];
		$ref=$_POST['ref'];
		$carrito_mio[]=array("titulo"=>$titulo,"precio"=>$precio,"cantidad"=>$cantidad,"disponibilidad"=>$disponilibilidad,"ref"=>$ref);	
	}
	
	if(isset($_POST['cantidad'])){
		$id=$_POST['id'];
		$cuantos=$_POST['cantidad'];
		if($cuantos<1){
			$carrito_mio[$id]=NULL;
		}else{
			$carrito_mio[$id]['cantidad']=$cuantos;
			$totaldisponilibilad= $disponilibilidad - $cuantos;
	if($totaldisponilibilad>0){
	echo "<script>alert('insertado bien')</script>";
					  }else {
	echo "<script>alert('Error de autentificación')</script>";

		}
	}
	if(isset($_POST['id2'])){
		$id=$_POST['id2'];
		$carrito_mio[$id]=NULL;
	}
	
		
	
	


$_SESSION['carrito']=$carrito_mio;
}
//aqui termina el carrito



if(isset($_SESSION['carrito'])){

for($i=0;$i<=count($carrito_mio)-1;$i ++){
if($carrito_mio[$i]!=NULL){ 
$totalc = $carrito_mio['cantidad'];
$totalc ++ ;
$totalcantidad += $totalc;
}}}





header("Location: ".$_SERVER['HTTP_REFERER']."");
?>



