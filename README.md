# Restaurante do Brejo

Fundado em 2009 por Carlos Miguel e sua família, o Restaurante do Brejo emerge como um estabelecimento de destaque na cidade de Conceição do Mato Dentro, Minas Gerais, oferecendo uma experiência gastronômica que combina a tradição culinária mineira com um ambiente familiar e inclusivo. No entanto, como muitos negócios contemporâneos, o restaurante enfrenta desafios significativos na adaptação às demandas crescentes do mercado digital.

Neste contexto, a transição para uma presença online surge como uma necessidade. Apesar dos serviços de entrega solicitados via WhatsApp terem sido uma solução temporária, a dependência exclusiva desta plataforma é limitada para atender às crescentes expectativas dos clientes e às complexidades operacionais do restaurante.

Dessa forma, a necessidade de desenvolver um sistema para o Restaurante do Brejo é fundamentada pela urgência de atualizar sua presença online e expandir suas capacidades digitais. Esta atualização visa atender às expectativas modernas dos clientes por serviços gastronômicos mais acessíveis e convenientes, além de permitir uma gestão mais eficiente das operações internas do restaurante

## Alunos integrantes da equipe

* Beatriz de Oliveira Silveira
* Joaquim de Moura Thomaz Neto
* Maria Eduarda Chrispim Santana
* Matheus Pereira
* Vitor Fernandes de Souza
* Vitória Ye Miao

## Professores responsáveis

* Joana Gabriela Ribeiro de Souza
* Joyce Christina de Paiva Carvalho
* Soraia Lúcia da Silva

## Instruções de utilização

1. Pré-requisitos
Para executar o sistema, você precisará ter os seguintes componentes instalados:

* Java Development Kit (JDK) 11 ou superior
* Node.js e npm (Node Package Manager)
* MySQL (ou outro banco de dados de sua escolha)
* Maven para gerenciar as dependências do projeto backend
* Git para clonar o repositório

2. Clonar o Repositório
Primeiro, clone o repositório em sua máquina local:

git clone https://github.com/ICEI-PUC-Minas-PPLES-TI/plf-es-2024-1-ti4-0658100-restaurante-do-brejo.git
cd plf-es-2024-1-ti4-0658100-restaurante-do-brejo

3. Configurar o Backend
Navegue até o diretório backend:

cd backend

Instale as dependências do Maven:

mvn install

Configure o banco de dados MySQL:

* Crie um banco de dados chamado restaurante_do_brejo.

* Configure o usuário e a senha no arquivo application.properties localizado em src/main/resources:

spring.datasource.url=jdbc:mysql://localhost:3306/restaurante_do_brejo
spring.datasource.username=SEU_USUARIO
spring.datasource.password=SUA_SENHA
Execute o servidor Spring Boot:


mvn spring-boot:run

4. Configurar o Frontend
Navegue até o diretório frontend:

cd ../frontend

Instale as dependências do Node.js:

npm install

Execute o servidor de desenvolvimento:

npm start

O servidor será iniciado e o sistema estará disponível em http://localhost:3000.

5. Utilizando o Sistema
   
Abra um navegador web e acesse http://localhost:3000 para começar a utilizar o sistema.
Você também pode acessar o site pelo link: http://restaurantedobrejo.infinityfreeapp.com/
