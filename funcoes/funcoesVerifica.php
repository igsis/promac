<?php
	/* 
	> Campos obrigatórios
		+ eventos
		+ pedidos de contratação
	> Ocorrências obrigatórias
		+ eventos
		+ cinema
	> Comparação de datas
		+ não permitir datas
		+ deadlines
	*/
	function verificaCampos($idEvento)
	{
		$con = bancoMysqli(); //abre o banco
		$sql = "SELECT * 
			FROM igsis_opcoes 
			WHERE opcao = 'campos' 
			AND valor =  '1'"; //vai até o banco e pega os campos obrigatórios
		$query = mysqli_query($con,$sql); // executa a query
		$num = mysqli_num_rows($query); // recebe o número de campos a se verificar;
		$total = 0;
		$z['campo'] = "";
		if($num > 0)
		{
			// começa a verificação
			while($x = mysqli_fetch_array($query))
			{
				// roda os campos
				$y = explode('.',$x['codigo']); // separa a tabela do campo
				$tabela = $y[0];
				$campo = $y[1];
				$campoEvento = $y[2];
				$nomeCampo = $y[3];
				if($tabela == "ig_evento")
				{
					// evento
					$sql_verifica = "SELECT * FROM $tabela WHERE $campoEvento = '$idEvento' LIMIT 0,1"; //gera a query e retorna 1 registro
					$query_verifica = mysqli_query($con,$sql_verifica);
					$campoRecuperado = mysqli_fetch_array($query_verifica);
					$i = 0;
					if(($campoRecuperado[$campo] == "") OR ($campoRecuperado[$campo] == NULL))//verifica se o campo está vazio ou é nulo	
					{
						$z[$tabela][$campo] = 0;
						$z['campos'] = $z['campo'].", + ".$nomeCampo."<br />";
						$total++;
					}
					else
					{
						$z[$tabela][$campo] = 1;
					}
				}
			} // fecha o while
		}
		$z['total'] = $total;
		return $z;
	}
	function verificaOcorrencias($idEvento)
	{
		$evento = recuperaDados("ig_evento",$idEvento,"idEvento");
		$con = bancoMysqli();
		$num = 0;
		if($evento['ig_tipo_evento_idTipoEvento'] != 1)
		{
			$sql = "SELECT * 
				FROM ig_ocorrencia 
				WHERE idEvento = '$idEvento' 
				AND publicado = '1'";
			$query = mysqli_query($con,$sql);
			$num = mysqli_num_rows($query);
		}
		else
		{
			$sql = "SELECT * 
				FROM ig_ocorrencia 
				WHERE idEvento = '$idEvento' 
				AND publicado = '1' 
				AND idTipoOcorrencia = '5'"; //sessoes de cinema
			$query = mysqli_query($con,$sql);
			$num = mysqli_num_rows($query);
		}
		return $num;
	}
	function prazoContratos($idEvento)
	{
		//deixar mais redondo.
		$data = retornaDatas($idEvento);
		$opcoes = recuperaDados("igsis_opcoes","dataContrato","opcao");
		$mensagem = "";
		if($opcoes['valor'] == 1)
		{	
			$y = explode('.',$opcoes['codigo']); // separa a tabela do campo
			$data_inicio = $data['dataInicio'];
			$data_final = somarDatas($data_inicio,$y[1]);
			$hoje = date("Y-m-d");
			if($data_final >= $hoje)
			{
				$prazo = substr($y[1], 1);
				$mensagem .= "<h5> Você está dentro do prazo de contratos.</h5>";
				$mensagem .= "Hoje é ".exibirDataBr($hoje).".";
				$mensagem .= "
					O seu evento se inicia em ".exibirDataBr($data['dataInicio'])." .<br />
					O prazo para contratos é de <strong>$prazo </strong>dias.<br />
					Você está <strong>dentro</strong> do prazo de contratos.";
				$fora = 0;
			}
			else
			{
				$prazo = substr($y[1], 1);
				$mensagem .= "<h5> Você está fora do prazo de contratos.</h5>";
				$mensagem .= "Hoje é ".exibirDataBr($hoje).".";
				$mensagem .= "
					O seu evento se inicia em ".exibirDataBr($data['dataInicio'])." .<br />
					O prazo para contratos é de <strong>$prazo </strong>dias.<br />
					Você está <strong>fora</strong> do prazo de contratos.";
				$fora = 1;
			}
		}
		$x['fora'] = $fora;
		$x['mensagem'] = $mensagem;
		return $x;
	}
	function prazoEmCartaz($idEvento)
	{
		//deixar mais redondo.
		$data = retornaDatas($idEvento);
		$opcoes = recuperaDados("igsis_opcoes","dataEmCartaz","opcao");
		if($opcoes['valor'] == 1)
		{	
			$data_final = $opcoes['codigo'];
			$hoje = date("Y-m-d");
			if($data_final >= $hoje)
			{
				echo "Hoje é ".exibirDataBr($hoje).".<br />
					O seu evento se inicia em ".exibirDataBr($data['dataInicio'])." .<br />
					O prazo para a revista Em Cartaz é ".exibirDataBr($data_final).".<br />
					Você está no prazo.";
			}
			else
			{
				echo "Hoje é ".exibirDataBr($hoje).".<br />
					O seu evento se inicia em ".exibirDataBr($data['dataInicio'])." .<br />
					O prazo para contratos é de $prazo dias.<br />
					O prazo para a revista Em Cartaz é ".exibirDataBr($data_final).".<br />
					Você está fora do prazo.";
			}
		}
	}
	function verificaPendencias($idEvento)
	{
		return '0';	
	}
	function autorizaBotao($idUsuario,$idInstituicao)
	{
		$x['botao'] = FALSE;
		$x['mensagem'] = "Envio desabilitado até 15/02/2016 para balanço do sistema. Qualquer urgência, enviar e-mail para sistema.igsis@gmail.com mencionando usuário de sistema.";
		$con = bancoMysqli();
		$sql = "SELECT idUsuario FROM igsis_lista_usuarios WHERE idUsuario = '$idUsuario'";
		$query = mysqli_query($con,$sql);
		$num = mysqli_num_rows($query);	
		if($num == 1)
		{
			$x['botao'] == TRUE;	
		}
		return $x;
	}
	function retornaDataInicio($idEvento)
	{
		//retorna o período
		$con = bancoMysqli();
		$sql_anterior = "SELECT * 
			FROM ig_ocorrencia 
			WHERE idEvento = '$idEvento' 
			AND publicado = '1' 
			ORDER BY dataInicio 
			ASC LIMIT 0,1"; //a data inicial mais antecedente
		$query_anterior = mysqli_query($con,$sql_anterior);
		$data = mysqli_fetch_array($query_anterior);
		$data_inicio = $data['dataInicio'];
		$sql_posterior01 = "SELECT * 
			FROM ig_ocorrencia 
			WHERE idEvento = '$idEvento' 
			AND publicado = '1' 
			ORDER BY dataFinal 
			DESC LIMIT 0,1"; //quando existe data final
		$sql_posterior02 = "SELECT * 
			FROM ig_ocorrencia 
			WHERE idEvento = '$idEvento' 
			AND publicado = '1' 
			ORDER BY dataInicio 
			DESC LIMIT 0,1"; //quando há muitas datas únicas
		$query_anterior01 = mysqli_query($con,$sql_posterior01);
		$data = mysqli_fetch_array($query_anterior01);
		$num = mysqli_num_rows($query_anterior01);
		if(($data['dataFinal'] != '0000-00-00') OR ($data['dataFinal'] != NULL))
		{
			//se existe uma data final e que é diferente de NULO
			$dataFinal01 = $data['dataFinal'];	
		}
		$query_anterior02 = mysqli_query($con,$sql_posterior02); //recupera a data única mais tarde
		$data = mysqli_fetch_array($query_anterior02);
		$dataFinal02 = $data['dataInicio'];
		if(isset($dataFinal01))
		{
			//se existe uma temporada, compara com a última data única
			if($dataFinal01 > $dataFinal02)
			{
				$dataFinal = $dataFinal01;
			}
			else
			{
				$dataFinal = $dataFinal02;
			}
		}
		else
		{
			$dataFinal = $dataFinal02;		
		}
		if($data_inicio == $dataFinal)
		{ 
			return $data_inicio;
		}
		else
		{
			return $data_inicio;
		}
	}
	function prazoContratosDias($idEvento)
	{
		//deixar mais redondo.
		$data = retornaDatas($idEvento);
		$evento = recuperaDados("ig_evento",$idEvento,"idEvento");
		//$opcoes = recuperaDados("igsis_opcoes","dataContrato","opcao");
		//$y = explode('.',$opcoes['codigo']); // separa a tabela do campo
		$data_inicio = $data['dataInicio'];
		$data_final = somarDatas($data_inicio,-45);
		$hoje = $evento['dataEnvio'];
		if($data_final >= $hoje)
		{
			$prazo = substr(-45, 1);
			return true;
		}
		else
		{
			$prazo = substr(-45, 1);
			return false;
		}
	}
	function prazoOrcamento($idEvento)
	{
		$data = retornaDatas($idEvento);
		$hoje = date('Y-m-d');
		$diferenca = diferencaDatas($hoje,$data['dataInicio']);
		return $diferenca;	
	}
	function verificaPedidosContratacao($idEvento)
	{
		// Valor - Forma de pagamento
		$total = 0;
		$z['campos'] = ",";
		$con = bancoMysqli();
		$sql = "SELECT idPedidoContratacao, 
			justificativa, 
			parecerArtistico, 
			parcelas, 
			formaPagamento, 
			valor 
			FROM igsis_pedido_contratacao 
			WHERE idEvento = '$idEvento' 
			AND publicado = '1'";
		$query = mysqli_query($con,$sql);
		$num = mysqli_num_rows($query);
		if($num == 0)
		{
			$z['total'] = $total;
		}
		else
		{
			$i = 0;
			while($pedido = mysqli_fetch_array($query))
			{
				//justificativa
				if($pedido['justificativa'] == "" OR $pedido['justificativa'] == NULL)
				{
					$z['campos'] .= "+ Justificativa<br />";
					$total++;
				}
				//parecer
				if($pedido['parecerArtistico'] == "" OR $pedido['parecerArtistico'] == NULL)
				{
					$z['campos'] .= "+ Parecer Artístico<br />";	
					$total++;
				}  
				// valor
				if($pedido['parcelas'] == 0)
				{
					if($pedido['formaPagamento'] == "" OR $pedido['formaPagamento'] == NULL)
					{
						$z['campos'] .= "+ Forma de Pagamento<br />";	
						$total++;
					}  
				}
				else if($pedido['parcelas'] > 1)
				{
					if($pedido['valor'] == 0)
					{
						$z['campos'] .= "+ Valor<br />";	
						$total++;
					}
				}
			}
		}
		$z['n_pedidos'] = $num;
		$z['total'] = $total;
		return $z;
	}
	
	function verificaParecer ($id_ped)
	{
		$parecer = recuperaDados("igsis_parecer_artistico",$id_ped,"idPedidoContratacao");
		$topico1 = $parecer['topico1'];
		$topico2 = $parecer['topico2'];
		$topico3 = $parecer['topico3'];
		$topico4 = $parecer['topico4'];
		$cont1 = strlen($topico1);
		if((strlen($topico2)) < 500)
		{
			$msg2= 'Você não atingiu o mínimo de caracteres para o 2º tópico.';
 
		}
		else
		{
			$msg2 = "2º tópico - OK";
		}	
		
		if((strlen($topico3)) < 700)
		{
			$msg3= 'Você não atingiu o mínimo de caracteres para o 3º tópico.';
 
		}
		else
		{
			$msg3 = "3º tópico - OK";
		}	
		$cont4 = strlen($topico4);
		
		$mensagem = $msg2.'<br/>'.$msg3;
		return $mensagem;
		
	}
?>