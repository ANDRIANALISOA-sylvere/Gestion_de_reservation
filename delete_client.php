<?php 
	session_start();
	require_once('db.php');
	if($_GET['id'] && !empty($_GET['id']))
	{

		$id=$_GET['id'];
		$sql='SELECT * FROM client where idcli= :id';
		$data = $connection->prepare($sql);
		$data->bindValue(':id',$id,PDO::PARAM_INT);
		$data->execute();
		$article=$data->fetch();
		if($article)
		{	
				$id=$_GET['id'];
			
				$sql=$connection->prepare("SELECT place as place FROM reserver,client WHERE reserver.idcli=client.idcli AND client.idcli=?");
				$sql->execute(array($id));
				$place=$sql->fetch()['place'];

				$sql=$connection->prepare("SELECT idvoit as idvoit FROM reserver,client WHERE reserver.idcli=client.idcli AND client.idcli=?");
				$sql->execute(array($id));
				$idvoit=$sql->fetch()['idvoit'];

				
				$sql='DELETE FROM client where idcli=:id';
				$data=$connection->prepare($sql);
				$data->bindValue(':id',$id,PDO::PARAM_INT);
				$data->execute();

				$occupation="non";
				$update=$connection->prepare("UPDATE place SET occupation=? WHERE idvoit=? AND place=?");
				$update->execute(array($occupation,$idvoit,$place));

				header('Location: client.php');			
		}
		else
		{
			header('Location: client.php');
		}
		
		
	}
	else
	{
		header('Location: client.php');
	}

 ?>
 