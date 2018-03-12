--
-- Database: `promac`
--

use promac;


--
-- Extraindo dados da tabela `lista_documento`
--

INSERT INTO `lista_documento` (`idListaDocumento`, `idTipoUpload`, `documento`, `sigla`, `publicado`) VALUES
(1, 1, 'RG/RNE', 'rg', 1),
(2, 1, 'CPF', 'cpf', 1),
(3, 1, 'CCM', 'ccm', 1),
(4, 1, 'Comprovante de endereço', 'cde', 1),
(6, 1, 'Declaração', 'dec', 1);

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

INSERT INTO `pessoa_juridica` (`idPj`, `razaoSocial`, `cnpj`, `ccm`, `logradouro`, `bairro`, `cidade`, `estado`, `cep`, `numero`, `complemento`, `telefone`, `celular`, `email`, `cooperativa`, `idRepresentanteLegal`, `liberado`, `senha`, `idNivelAcesso`, `idFraseSeguranca`, `respostaFrase`) VALUES
(1, 'Razão Social', '00.000.000/0000-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'razaosocial@gmail.com', NULL, 0, NULL, 'e10adc3949ba59abbe56e057f20f883e', 1, NULL, NULL);

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
(9, 2, 'CCM', 'ccm', 1),
(10, 2, 'Ato Constitutivo', 'ac', 1),
(11, 2, 'Ata de Eleição e Posse', 'aep', 1),
(12, 2, 'RG/RNE', 'rg', 1),
(13, 2, 'CPF', 'cpf', 1),
(14, 2, 'Comprovante de endereço atual (até últimos 3 meses)', 'ce', 1),
(15, 2, 'Comprovante de endereço de pelo menos 2 anos atrás', 'ce2', 1),
(16, 2, 'Declaração [modelo para download]', 'de', 1),
(17, 2, 'Declaração exclusiva para Organização Social com Termo de Colaboração a SMC [modelo para download]', 'deost', 1);

--
-- Extraindo dados da tabela `area_atuacao`
--

INSERT INTO `area_atuacao` (`idArea`, `areaAtuacao`, `tipo`) VALUES
(1, 'Artes Plásticas, Visuais e Design', NULL),
(2, 'Bibliotecas, Arquivos, Centros Culturais e Espaços Culturais Independentes', 3),
(3, 'Cinema e Séries de Televisão', 2),
(4, 'Circo', 3),
(5, 'Cultura Popular e Artesanato', 3),
(6, 'Dança', 2),
(7, 'Eventos Carnavalescos e Escolas de Samba', 2),
(8, 'Hip-Hop', 3),
(9, 'Literatura', 3),
(10, 'Museu', 2),
(11, 'Música', 3),
(12, 'Ópera', 2),
(13, 'Patrimônio Histórico e Artístico', 2),
(14, 'Pesquisa e Documentação', 3),
(15, 'Teatro', 2),
(16, 'Vídeo e Fotografia', 3),
(17, 'Bolsas de estudo para cursos de caráter cultural ou artístico, ministrados em instituições nacionais ou internacionais sem fins lucrativos.', 3),
(18, 'Programas de rádio e de televisão com finalidade cultural, social e de prestação de serviços à comunidade.\r\n', 2),
(19, 'Restauração e conservação de bens protegidos por órgão oficial de preservação.', 2),
(20, 'Cultura Digital', 3),
(21, 'Design de Moda', 3);
COMMIT;


