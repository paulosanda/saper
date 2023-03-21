# Agenda de telefones

Esta API não usa a autenticação, guarda contatos em uma tabela única de agenda.

Esta aplicação tem as seguintes rotas

<ul>
<li> POST em /api/agenda -> armazena nova entrada na agenda.
<li> DELETE em /api/agenda -> exclui contato e seus dados da agenda.
<li> GET em /api/agenda -> Lista todos contatos da agenda.
<li> PUT /api/agenda -> Altera os dados de um contato na agenda.
<li> GET /api/agenda/nomes -> Lista todos os nomes da agenda ordenados pelo nome de forma crescente.
</ul>
Após clonar o repositório siga os passos básicos, copiar o .env.example para .env e rode o composer install.
Para usar o sail, após sua instalação poderá caso deseje usar os scripts up e down para subir e parar o sail.
