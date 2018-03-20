--
-- Database: `promac`
--

use promac;

-- --------------------------------------------------------

--
-- Extraindo dados da tabela `pessoa_fisica`
--

INSERT INTO `pessoa_fisica` (`idPf`, `nome`, `cpf`, `rg`, `logradouro`, `bairro`, `cidade`, `estado`, `cep`, `numero`, `complemento`, `telefone`, `celular`, `email`, `cooperado`, `liberado`, `senha`, `idNivelAcesso`, `idFraseSeguranca`, `respostaFrase`) VALUES
(1, 'Pessoa Física', '000.000.000-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pessoafisica@gmail.com', NULL, NULL, 'e10adc3949ba59abbe56e057f20f883e', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Extraindo dados da tabela `pessoa_juridica`
--

INSERT INTO `pessoa_juridica` (`idPj`, `razaoSocial`, `cnpj`, `logradouro`, `bairro`, `cidade`, `estado`, `cep`, `numero`, `complemento`, `telefone`, `celular`, `email`, `cooperativa`, `idRepresentanteLegal`, `liberado`, `senha`, `idNivelAcesso`, `idFraseSeguranca`, `respostaFrase`) VALUES
(1, 'Razão Social', '00.000.000/0000-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'razaosocial@gmail.com', NULL, 0, NULL, 'e10adc3949ba59abbe56e057f20f883e', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Extraindo dados da tabela `lista_documento`
--

INSERT INTO `lista_documento` (`idListaDocumento`, `idTipoUpload`, `documento`, `sigla`, `publicado`) VALUES
(1, 1, 'RG/RNE', 'rg', 1),
(2, 1, 'CPF', 'cpf', 1),
(3, 1, 'CCM', 'ccm', 1),
(4, 1, 'Comprovante de endereço atual (até últimos 3 meses)', 'ce', 1),
(5, 1, 'Comprovante de endereço de pelo menos 2 anos atrás', 'ce2', 1),
(6, 1, 'Declaração [modelo para download]', 'de', 1),
(8, 2, 'CNPJ', 'cnpj', 1),
(9, 2, 'Cadastro de Contribuintes Imobiliários - CCM', 'ccm', 1),
(10, 2, 'Ato Constitutivo', 'ac', 1),
(11, 2, 'Ata de Eleição e Posse', 'aep', 1),
(12, 2, 'RG/RNE', 'rg', 1),
(13, 2, 'CPF', 'cpf', 1),
(14, 2, 'Comprovante de endereço atual (até últimos 3 meses)', 'ce', 1),
(15, 2, 'Comprovante de endereço de pelo menos 2 anos atrás', 'ce2', 1),
(16, 2, 'Declaração [modelo para download]', 'de', 1),
(17, 2, 'Declaração exclusiva para Organização Social com Termo de Colaboração a SMC [modelo para download]', 'deost', 1),
(18, 2, 'PDF para subir portfólio', 'pdfsp', 1),
(19, 2, 'Comprovações de atuação', 'compa', 1),
(20, 3, 'Carta de Intenção de Incentivo (Caso houver)', 'cii', 1),
(21, 3, 'Carta de Anuência do Local [modelo para download]', 'cal', 1),
(22, 3, 'CV dos principais participantes [no máximo 20 linhas de cada participante]', 'cvpp', 1),
(23, 3, 'Declaração de Responsabilidade por Direitos Autorais [modelo para download]', 'drda', 1),
(24, 3, 'Informações adicionais, de acordo com a especificidade do segmento artístico do projeto (exemplo: roteiro do espetáculo)', 'ia', 1);
--
-- Extraindo dados da tabela `renuncia_fiscal`
--

INSERT INTO `renuncia_fiscal` (`idRenuncia`, `renunciaFiscal`) VALUES
(1, '100%'),
(2, '80%'),
(3, '50%'),
(4, '20%');

--
-- Extraindo dados da tabela `etapa`
--

INSERT INTO `etapa` (`idEtapa`, `etapa`) VALUES
(1, 'Pré-Produção'),
(2, 'Produção'),
(3, 'Assessoria de Imprensa, Divulgação e Mídia'),
(4, 'Custos Administrativos'),
(5, 'Impostos, taxas, tarifas bancárias, contribuições e seguros'),
(6, 'Elaboração e Agenciamento'),
(7, 'Outros Financiamentos');

--
-- Extraindo dados da tabela `zona`
--

INSERT INTO `zona` (`idZona`, `zona`) VALUES
(1, 'Norte'),
(2, 'Sul'),
(3, 'Centro'),
(4, 'Leste'),
(5, 'Oeste');

--
-- Extraindo dados da tabela `unidade_medida`
--

INSERT INTO `unidade_medida` (`idUnidadeMedida`, `unidadeMedida`) VALUES
(1, 'Cachê'),
(2, 'Diária'),
(3, 'Serviço'),
(4, 'Unidade');

--
-- Extraindo dados da tabela `status`
--

INSERT INTO `status`(`idStatus`, `status`) VALUES
(1, 'em elaboração'),
(2, 'enviado'),
(3, 'em análise'),
(4, 'diligência'),
(5, 'aprovado'),
(6, 'indeferido');

--
-- Extraindo dados da tabela `area_atuacao`
--

INSERT INTO `area_atuacao` (`idArea`, `areaAtuacao`, `tipo`) VALUES
(1, 'Artes Plásticas, Visuais e Design', 2),
(2, 'Bibliotecas, Arquivos, Centros Culturais e Espaços Culturais Independentes', 2),
(3, 'Cinema e Séries de Televisão', 1),
(4, 'Circo', 2),
(5, 'Cultura Popular e Artesanato', 2),
(6, 'Dança', 1),
(7, 'Eventos Carnavalescos e Escolas de Samba', 1),
(8, 'Hip-Hop', 2),
(9, 'Literatura', 2),
(10, 'Museu', 1),
(11, 'Música', 2),
(12, 'Ópera', 1),
(13, 'Patrimônio Histórico e Artístico', 1),
(14, 'Pesquisa e Documentação', 2),
(15, 'Teatro', 1),
(16, 'Vídeo e Fotografia', 2),
(17, 'Bolsas de estudo para cursos de caráter cultural ou artístico, ministrados em instituições nacionais ou internacionais sem fins lucrativos.', 2),
(18, 'Programas de rádio e de televisão com finalidade cultural, social e de prestação de serviços à comunidade.', 1),
(19, 'Restauração e conservação de bens protegidos por órgão oficial de preservação.', 1),
(20, 'Cultura Digital', 2),
(21, 'Design de Moda', 2);


INSERT INTO `statusdocumento` (`ID`, `Status`) VALUES
(0, 'Aprovado'),
(1, 'Complementação'),
(2, 'Reprovado');

