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
(7, 2, 'CNPJ', 'cnpj', 1),
(8, 2, 'CCM', 'ccm', 1),
(9, 2, 'Ato Constitutivo', 'ac', 1),
(10, 2, 'Ata de Eleição e Posse', 'aep', 1),
(11, 2, 'RG/RNE', 'rg', 1),
(12, 2, 'CPF', 'cpf', 1),
(13, 2, 'Comprovante de endereço atual (até últimos 3 meses)', 'ce', 1),
(14, 2, 'Comprovante de endereço de pelo menos 2 anos atrás', 'ce2', 1),
(15, 2, 'Declaração [modelo para download]', 'de', 1),
(16, 2, 'Declaração exclusiva para Organização Social com Termo de Colaboração a SMC [modelo para download]', 'deost', 1),
(17, 3, 'Carta de Intenção de Incentivo (Caso houver)', 'cii', 1),
(18, 3, 'Carta de Anuência do Local [modelo para download]', 'cal', 1),
(19, 3, 'CV dos principais participantes [no máximo 20 linhas de cada participante]', 'cvpp', 1),
(20, 3, 'Declaração de Responsabilidade por Direitos Autorais [modelo para download]', 'drda', 1),
(21, 3, 'Informações adicionais, de acordo com a especificidade do segmento artístico do projeto (exemplo: roteiro do espetáculo)', 'ia', 1);

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
