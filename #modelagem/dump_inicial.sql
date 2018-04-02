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
(7, 2, 'CNPJ', 'cnpj', 1),
(8, 2, 'Cadastro de Contribuintes Imobiliários - CCM', 'ccm', 1),
(9, 2, 'Ato Constitutivo', 'ac', 1),
(10, 2, 'Ata de Eleição e Posse', 'aep', 1),
(11, 2, 'RG/RNE do representante legal', 'rg', 1),
(12, 2, 'CPF do representante legal', 'cpf', 1),
(13, 2, 'Comprovante de endereço atual da sede da pessoa jurídica (até últimos 3 meses)', 'ce', 1),
(14, 2, 'Comprovante de endereço de pelo menos 2 anos atrás da sede da pessoa jurídica', 'ce2', 1),
(15, 2, 'Declaração [modelo para download]', 'de', 1),
(16, 2, 'Portfólio comprovando atividades artísticas ou culturais (opcional)', 'pcaa', 1), /* opcional */
(17, 2, 'Certidão de Regularidade da Cooperativa perante a Organização das Cooperativas Brasileiras ou Organização das Cooperativas do Estado de São Paulo (exclusivo para Cooperativas)', 'certcoop', 1),
(18, 3, 'Carta de Intenção de Incentivo (caso houver)', 'cii', 1), /* opcional */
(19, 3, 'Carta de Anuência do(s) Local(is) [modelo para download]', 'cal', 1), /* opcional */
(20, 3, 'Carta de Anuência do(s) Principais(is) Participante(s) [modelo para download]', 'cal', 1), /* opcional */
(21, 3, 'CV dos principais participantes [no máximo 20 linhas de cada participante]', 'cvpp', 1), /* opcional */
(22, 3, 'Declaração de Responsabilidade por Direitos Autorais [modelo para download]', 'drda', 1), /* opcional */
(23, 3, 'Informações adicionais, de acordo com a especificidade do segmento artístico do projeto (exemplo: roteiro do espetáculo)', 'ia', 1), /* opcional */
(24, 4, 'RG/RNE','rg',1),
(25, 4, 'CPF','cpf',1),
(26, 4, 'Comprovante de endereço atual (até últimos 3 meses)','ce',1),
(27, 4, 'Carnê IPTU','ciptu',1),
(28, 4, 'Contrato de locação','clc',1),
(29, 5, 'CNPJ','cnpj',1),
(30, 5, 'Cadastro de Contribuintes Imobiliários - CCM','ccm',1),
(31, 5, 'Contrato Social','cs',1),
(32, 5, 'Comprovante de endereço atual (até últimos 3 meses)','ce',1),
(33, 5, 'RG/RNE do Representante Legal','rg',1),
(34, 5, 'CPF do Representante Legal','cpf',1),
(35, 5, 'Carnê IPTU','ciptu',1),
(36, 5, 'Contrato de locação','clc',1),
(37, 9, 'Parecer da Comissão', 'parecer', 1);


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
(8, 'Outros');


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
(4, 'Unidade'),
(5, 'Outros');

--
-- Extraindo dados da tabela `status`
--

INSERT INTO `status`(`idStatus`, `status`) VALUES
(1, 'Em elaboração'),
(2, 'Enviado'),
(3, 'Projeto em análise'),
(4, 'Complementação'),
(5, 'Aprovado'),
(6, 'Reprovado'),
(7, 'Comissão');

--
-- Extraindo dados da tabela `area_atuacao`
--

INSERT INTO `area_atuacao` (`idArea`, `areaAtuacao`, `tipo`) VALUES
(1, 'Artes plásticas, visuais e "design"', 1),
(2, 'Bibliotecas, arquivos, centros culturais e espaços culturais independentes', 1),
(3, 'Cinema e séries de televisão', 2),
(4, 'Circo', 1),
(5, 'Cultura popular e artesanato', 1),
(6, 'Dança', 2),
(7, 'Eventos carnavalescos e escolas de samba', 2),
(8, '"Hip-hop”', 1),
(9, 'Literatura', 1),
(10, 'Museu', 1),
(11, 'Música', 2),
(12, 'Ópera', 2),
(13, 'Patrimônio histórico e artístico', 2),
(14, 'Pesquisa e documentação', 1),
(15, 'Teatro', 2),
(16, 'Vídeo e fotografia', 1),
(17, 'Bolsas de estudo para cursos de caráter cultural ou artístico, ministrados em instituições nacionais ou internacionais sem fins lucrativos', 1),
(18, 'Programas de rádio e de televisão com finalidade cultural, social e de prestação de serviços à comunidade', 2),
(19, 'Restauração e conservação de bens protegidos por órgão oficial de preservação', 2),
(20, 'Cultura digital', 1),
(21, '"Design" de moda', 1),
(22, 'Plano anual de atividades', 2),
(23, 'Projetos especiais: primeiras obras, experimentações, pesquisas, publicações, cursos, viagens, resgate de modos tradicionais de produção, desenvolvimento de novas tecnologias para as artes e para a cultura e preservação da diversidade cultural', 1);


INSERT INTO `status_documento` (`idStatusDocumento`, `status`) VALUES
(1, 'Aprovado'),
(2, 'Complementação'),
(3, 'Reprovado');

INSERT INTO `frase_seguranca` (`id`, `frase_seguranca`) VALUES
(1, 'Qual a sua cor favorita?'),
(2, 'Qual o nome do seu primeiro animal?'),
(3, 'Qual o nome do seu primeiro professor?'),
(4, 'Qual o nome do seu melhor amigo de infância?');
