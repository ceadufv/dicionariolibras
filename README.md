# Dicionário de LIBRAS
Dicionario de LIBRAS desenvolvido com recursos do Edital 03/2015 da CAPES/UAB

## Instalação
A seguir estao as instruções para instalação do dicionario de LIBRAS. O dicionário foi criado utilizando a ferramenta WordPress e este pacote contem a instalação do WordPress já populado com todo o conteúdo do dicionário de LIBRAS. 

### Etapas
1. Crie um banco de dados MySQL e registre o usuario que deseja utilizar para a aplicação
2. Baixe os arquivos deste repositórios para uma pasta no servidor onde eles ficarão hospedados. 
3. Acesse a pasta do projeto no servidor. Faça o download dos vídeos disponíveis no link: https://drive.google.com/file/d/1s_VgvP_tb2JpJhUuoa9WTD_iX39SCYlg/view?usp=sharing. Extraia os arquivos de vídeo dentro do diretório "wp-content/uploads"
4. Insira as credenciais de acesso ao banco no arquivo "wp-config.php", modificando as variaveis DB_NAME, DB_USER, DB_PASSWORD e DB_HOST.
5. No banco criado no MySQL, acesse a tabela “tlmg_options” no banco de dados e altere os registros de id 1 (‘siteurl’) e 2 (‘home’) para o endereço da máquina onde o sistema está hospedado
6. Pronto, o sistema esta instalado! Para acessar a área administrativa do site use as credencias a seguir:
  usuario: admin
  senha: 123456

### Programas necessarios
Apache, PHP e MySQL

## Licença
O código derivado do Wordpress está licenciado sob licença GPL version2. Os vídeos estão licenciados com licença Creative Commons Atribuição-NãoComercial-CompartilhaIgual 3.0 (https://creativecommons.org/licenses/by-nc-sa/3.0/deed.pt_BR)

## Desenvolvimento
- Cead - Universidade Federal de Viçosa - https://www.cead.ufv.br
- Agencia de Fomento: CAPES/UAB

### Equipe

**Coordenador UAB/UFV**
-  Prof. Frederico José Vieira Passos - PRE/UFV

**Coordenação do Projeto**
-  Profa. Ana Luisa Borba Gediel - DLA/UFV
-  Pedro de Almeida Sacramento - Cead/UFV
-  Prof. Victor Luiz Alves Mourão - DCS/UFV

**Coordenação Cead/UFV**
- Profa. Silvane Guimarães - Cead/UFV

**Coordenação de Desenvolvimento**
- Pedro de Almeida Sacramento - Cead/UFV

**Desenvolvimento**
- Alan Mariano - Programação - Cead/UFV; DPI/UFV
- Edson Ney Duarte Nogueira - Design de Interfaces - Cead/UFV
- Hevellin Ferreira Aguiar e Ferraz - Programação - Cead/UFV; DPI/UFV
- Lucas Pereira Marques - Programação - Cead/UFV; DPI/UFV
- Pedro de Almeida Sacramento - Programação - Cead/UFV

**Consultoria**
- Dâmaris Pires Arruda - DPI/UFV

**Pesquisa**
- Carolina Macedo Lopes - DHI/UFV
- Daiane Araújo Meireles - DPE/UFV
- Isabela Martins Miranda - DLA/UFV
- Ramon Silva Teixeira - DCS/UFV
- Sheila Silva de Farias Xisto - DED/UFV

**Realização**
- DPE/UFV; DLA/UFV; DCS/UFV; Cead/UFV
