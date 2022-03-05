# Recursos usados

- Codeigniter 3
- Bootstrap 3.4.1
- TinyMce 5.9.1

# Instalação

1. No arquivo **"application/config/config.php"**, definir a **base_url**
2. No **phpmyadmin**, executar os comandos sql, existentes no arquivo **tables.sql**
3. No arquivo **"application/config/database.php"**, informar as credenciais de acesso ao banco de dados.
4. No **phpmyadmin**, importar os arquivos **.sql**, que estão na pasta **"bancos"**.
6. Para acessar o painel administrativo, digitar a url: **http://base-url/painel**, e informar o login **admin** e a senha **123456**

**Obs:** Essa aplicação usa dois bancos de dados, um para o back-end e outro para o front-end, as credenciais para conexão com ambos os bancos devem ser informadas, no arquivo **application/config/database.php**.