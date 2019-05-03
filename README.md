# Dicionário de LIBRAS
Dicionario de LIBRAS desenvolvido com recursos do Edital 03/2015 da CAPES/UAB

## Instalação
A seguir estao as instruções para instalação do dicionario de LIBRAS. O dicionário foi criado utilizando a ferramenta WordPress e este pacote contem a instalação do WordPress já populado com todo o conteúdo do dicionário de LIBRAS. 

## Programas necessarios
Apache, PHP e MySQL

## Etapas
1. Crie um banco de dados MySQL e registre o usuario que deseja utilizar para a aplicação
2. Insira as credenciais de acesso ao banco no arquivo "wp-config.php", modificando as variaveis DB_NAME, DB_USER, DB_PASSWORD e DB_HOST.
3. No banco criado no MySQL, acesse a tabela “tlmg_options” no banco de dados e altere os registros de id 1 (‘siteurl’) e 2 (‘home’) para o endereço da máquina onde o sistema está hospedado
4. Pronto, o sistema esta instalado! Para acessar a área administrativa do site use as credencias a seguir:
  usuario: admin
  senha: 123456
