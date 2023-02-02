Para criar um novo projeto no Laravel, executar o comando:
- composer create-project laravel/laravel projeto-transportadora

Acessar a pasta que foi criada:
- cd projeto-transportadora/

Assim que criar todos os arquivos executar o comando para que seja possível acessar o projeto via browser o qual aparecerá o link: "http://127.0.01:8000":
- php artisan serve
-
Criar controller, no qual será tratado as informações.
- php artisan make:controller TransportadoraController

Criar o banco de Dados no seu local. Após pode criar a tabela via comando sql ou atráves do arquivo do Laravel:
- hp artisan make:migration create_transportdora_preco_table --table=shipping_cost

No arquivo criado, inserir os dados da tabela, conforme "Transportadora/database/migrations/", onde ficam os arquivos a serem tratados.
Executar o comando:
- php artisan migrate

Para o upload da planilha a fim de não dar erro ao carregar os dados dela, é feito o carregamento em um array e após a conclusão deste é inserido no banco de dados apenas um insert com todos os dados.

Foi usado um ajax na tela de html quando envia os dados para que atualize as informações sem recarregar a pagina.


