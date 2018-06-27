<?php
header('Access-Control-Allow-Origin: *');
include 'conexao.php';
$key= $_REQUEST['key'];
switch($key) { 
 case 'estados':
 $sql="SELECT *  FROM estados  ORDER BY nome";
 $stmt=$pdo->query($sql);
 if($stmt->rowCount()>0){
  while($row=$stmt->fetch(PDO::FETCH_OBJ)){
   $data[]=$row;
  } 
  mb_convert_variables('UTF-8','ISO-8859-1',$data);
  echo json_encode(array('key'=>$key,'result'=>$data));
 } 
 break;
 case 'estilosevt':
 $idcategoria=$_REQUEST['idcategoria'];
 $idestilo=$_REQUEST['idestilo'];
 $MOREANDS="";
 if($idestilo!="-1")
  $MOREANDS=$MOREANDS."ev.idestilo=es.id AND";
 $sql="SELECT *  FROM estilos WHERE id IN (SELECT ev.idestilo FROM eventos AS ev,estilos AS es WHERE $MOREANDS ev.idcategoria=$idcategoria)  ORDER BY nome";
 
 $stmt=$pdo->query($sql);
 if($stmt->rowCount()>0){
  while($row=$stmt->fetch(PDO::FETCH_OBJ)){
   $data[]=$row;
  } 
  echo json_encode(array('key'=>$key,'result'=>$data));
 } 
 break;
 case 'estadosevt':
 $idcategoria=$_REQUEST['idcategoria'];
 $idestilo=$_REQUEST['idestilo'];
 $sql="SELECT *  FROM estados WHERE uf IN (SELECT l.uf FROM locais AS l,eventos AS ev WHERE l.id=ev.idlocal AND ev.idcategoria=$idcategoria AND ev.idestilo=$idestilo)  ORDER BY nome";
 $stmt=$pdo->query($sql);
 if($stmt->rowCount()>0){
  while($row=$stmt->fetch(PDO::FETCH_OBJ)){
   $data[]=$row;
  } 
  mb_convert_variables('UTF-8','ISO-8859-1',$data);
  echo json_encode(array('key'=>$key,'result'=>$data));
 } 
 break;
 case 'cidadesevt':
 $uf=$_REQUEST['uf'];
 $idcategoria=$_REQUEST['idcategoria'];
 $idestilo=$_REQUEST['idestilo'];
 $sql="SELECT *  FROM cidades WHERE nome IN (SELECT l.localidade FROM locais AS l,eventos AS ev WHERE l.id=ev.idlocal AND ev.idcategoria=$idcategoria AND ev.idestilo=$idestilo AND l.uf='$uf')  ORDER BY nome";
 $stmt=$pdo->query($sql);
 if($stmt->rowCount()>0){
  while($row=$stmt->fetch(PDO::FETCH_OBJ)){
   $data[]=$row;
  } 
  mb_convert_variables('UTF-8','ISO-8859-1',$data);
  echo json_encode(array('key'=>$key,'result'=>$data));
 } 
 break;
 case 'bairrosevt':
 $uf=$_REQUEST['uf'];
 $cidade=$_REQUEST['cidade'];
 $idcategoria=$_REQUEST['idcategoria'];
 $idestilo=$_REQUEST['idestilo'];
 $sql="SELECT *  FROM bairros WHERE (nome IN (SELECT l.bairro FROM locais AS l,eventos AS ev WHERE l.id=ev.idlocal AND ev.idcategoria=$idcategoria AND ev.idestilo=$idestilo AND l.uf='$uf')) AND  cidade='$cidade' ORDER BY nome";
 $stmt=$pdo->query($sql);
 if($stmt->rowCount()>0){
  while($row=$stmt->fetch(PDO::FETCH_OBJ)){
   $data[]=$row;
  } 
  mb_convert_variables('UTF-8','ISO-8859-1',$data);
  echo json_encode(array('key'=>$key,'result'=>$data));
 } 
 break;
 case 'artistasevt':
 $idcategoria=$_REQUEST['idcategoria'];
 $idestilo=$_REQUEST['idestilo'];
 $sql="SELECT *  FROM artistas WHERE (id IN (SELECT ev.idartista FROM eventos AS ev WHERE ev.idcategoria=$idcategoria AND ev.idestilo=$idestilo )) ORDER BY nome";
 $stmt=$pdo->query($sql);
 if($stmt->rowCount()>0){
  while($row=$stmt->fetch(PDO::FETCH_OBJ)){
   $data[]=$row;
  } 
  echo json_encode(array('key'=>$key,'result'=>$data));
 } 
 break;
 case 'eventosregiao':
 $idcategoria=$_REQUEST['idcategoria'];
 $uf=$_REQUEST['uf'];
 $cidade=$_REQUEST['cidade']; 
 $bairro=$_REQUEST['bairro'];
 $idestilo=$_REQUEST['idestilo'];
 $idartista=$_REQUEST['idartista'];
 $nomecidade="";

 if($cidade!=""){
  $sql="SELECT nome FROM cidades  WHERE  id=$cidade"; 
  $stmt=$pdo->query($sql);
  if($stmt->rowCount()>0)
   if($row=$stmt->fetch(PDO::FETCH_OBJ)){
    $nomecidade=$row->nome;
   } 
 }

 $MOREANDS="";
 if($uf!="")
  $MOREANDS=$MOREANDS."AND l.uf='$uf'";
  if($nomecidade!="")
  $MOREANDS=$MOREANDS." AND l.localidade='$nomecidade'";
  if($bairro!="")
  $MOREANDS=$MOREANDS." AND l.bairro='$bairro'";
  if($idartista!="")
  $MOREANDS=$MOREANDS." AND ar.id=$idartista";

  if($idestilo!="-1")
  $MOREANDS=$MOREANDS." AND ev.idestilo=$idestilo";
  //echo "more ands =$MOREANDS";
 
 $sql="SELECT ar.nome AS artista,es.nome AS estilo,ev.id,ev.nome,ev.descricao,ev.datahorario,l.nome AS nomelocal,l.logradouro,l.bairro,l.localidade,l.uf,l.cep,l.site,l.fone,l.numero,l.complemento FROM eventos AS ev,locais AS l,estilos AS es,artistas AS ar  WHERE  ev.idestilo=es.id AND ar.id=ev.idartista AND  ev.idcategoria=$idcategoria  AND ev.idlocal=l.id $MOREANDS ORDER BY ev.nome"; 
 $stmt=$pdo->query($sql);
 if($stmt->rowCount()>0){
  
  while($row=$stmt->fetch(PDO::FETCH_OBJ)){
   $data[]=$row;
  } 
  echo json_encode(array('key'=>$key,'result'=>$data));
 } 
 break;
 case 'estilos':
 $idcategoria=$_REQUEST['idcategoria'];
 $sql="SELECT *  FROM estilos  WHERE  idcategoria=$idcategoria ORDER BY nome";
 $stmt=$pdo->query($sql);
 if($stmt->rowCount()>0){
  while($row=$stmt->fetch(PDO::FETCH_OBJ)){
   $data[]=$row;
  } 
  echo json_encode(array('key'=>$key,'result'=>$data));
 } 
 break;
 case 'locais':
 $idcategoria=$_REQUEST['idcategoria'];
 $idadmin=$_REQUEST['idadmin'];
 if($idadmin=='undefined')
 $sql="SELECT *  FROM locais  WHERE  1 ORDER BY nome";
 else
 $sql="SELECT *  FROM locais  WHERE  idadmin=$idadmin ORDER BY nome";
 $stmt=$pdo->query($sql);
 if($stmt->rowCount()>0){
  while($row=$stmt->fetch(PDO::FETCH_OBJ)){
   $data[]=$row;
  } 
  echo json_encode(array('key'=>$key,'result'=>$data));
 } 
 break;
 case 'eventos':
 $idcategoria=$_REQUEST['idcategoria'];
 $idadmin=$_REQUEST['idadmin'];
 if($idadmin=='undefined')
 $sql="SELECT *  FROM eventos  WHERE  idcategoria=$idcategoria  ORDER BY nome";
 else
 $sql="SELECT *  FROM eventos  WHERE  idadmin=$idadmin AND idcategoria=$idcategoria ORDER BY nome";
 $stmt=$pdo->query($sql);
 if($stmt->rowCount()>0){
  while($row=$stmt->fetch(PDO::FETCH_OBJ)){
   $data[]=$row;
  } 
  echo json_encode(array('key'=>$key,'result'=>$data));
 } 
 break;
 case 'artistas':
 $idcategoria=$_REQUEST['idcategoria'];
 $idadmin=$_REQUEST['idadmin'];
 if($idadmin=='undefined')
 $sql="SELECT *  FROM artistas  WHERE  idcategoria=$idcategoria  ORDER BY nome";
 else
 $sql="SELECT *  FROM artistas  WHERE  idcategoria=$idcategoria AND idadmin=$idadmin ORDER BY nome";
 $stmt=$pdo->query($sql);
 if($stmt->rowCount()>0){
  while($row=$stmt->fetch(PDO::FETCH_OBJ)){
   $data[]=$row;
  }
  echo json_encode(array('key'=>$key,'result'=>$data));
 } 
 break;
}

?>