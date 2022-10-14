<head>
    <link rel="stylesheet" href="./bootstrap-italia/css/bootstrap-italia.min.css" />
    <link rel="stylesheet" href="./style.css" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mysql + Ajax</title>
</head>
<body>
    <?php require('header.html')?>

    <div class="container my-4">
        <h2 class="text-center">ESERCIZIO PHP-AJAX</h2>
    
    <div id="tabella-container"></div>

    <div class="row mt-5">

        <div class="col">

            <h4 class="text-center">FORM INSERIMENTO RIGA</h4>
            <form>

                <label for="nome">Inserisci nome</label>
                <input type="text" id="nome" name="nome">

                <label for="cognome">Inserisci cognome</label>
                <input type="text" id="cognome" name="cognome">

                <label for="email">Inserisci email</label>
                <input type="text" id="email" name="email">

                <button id="nuova-riga" class="mt-3">Inserisci persona</button>

            </form>

        </div>

        <div class="col">

        <h4 class="text-center">FORM UPDATE EMAIL</h4>
        <h6 class="text-center">Inserisci la mail da sostituire e clicca su "modifica" accanto alla riga da modificare</h6>
            <form>

                <label for="newMail">Inserisci nuova mail</label>
                <input type="text" id="newEmail" name="mail">

            </form>
            
        </div>

    </div>
    

    </div>

    <?php require('footer.html')?>

<script>
    let persone;
    let bottoneInserisci = document.getElementById('nuova-riga');
    let tabellaContainer = document.querySelector("#tabella-container");
    bottoneInserisci.addEventListener('click', inserisciPersona);

    generaTabella();

    function generaTabella(){
        fetch('./php/select.php', {
        method: 'POST',
        headers:{
            'Content-type' : 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        persone = data;
        console.log('Dati ricevuti: ',data);
        let tabella = `
        <div class="row">
        <table class='text-center' id='tabella-db'>

<thead>
    <tr>
        <th>ID_PERSONA</th>
        <th>NOME</th>
        <th>COGNOME</th>
        <th>EMAIL</th>
    </tr>
</thead>

<tbody>
    ${generaRighe(data)}
</tbody>

</table>
</div>`;

tabellaContainer.insertAdjacentHTML('beforeend', tabella);
let bottoniModifica = document.querySelectorAll(".modifica-persona");
let bottoniElimina = document.querySelectorAll(".elimina-persona");

for(let i = 0; i < bottoniModifica.length;  i++){
    bottoniModifica[i].addEventListener('click', modificaPersona);
}

for(let i = 0; i < bottoniElimina.length;  i++){
    bottoniElimina[i].addEventListener('click', eliminaPersona);
}

    })
    .catch((error)=>{
        console.error('Errore: ', error);
    });
    }


    function generaRighe(persone){
        let righe = ' ';
        persone.forEach(persona => {
            let riga = `
            <tbody>
    <tr>
        <td>${persona.id_persona}</td>
        <td>${persona.nome}</td>
        <td>${persona.cognome}</td>
        <td>${persona.email}</td>
        <td>
            <button class="modifica-persona" data-val="${persona.id_persona}">Modifica</button>
            <button class="elimina-persona" data-val="${persona.id_persona}">Elimina</button>
        </td>
    </tr>
</tbody>`;

            righe += riga;
        })
        return righe;
    }


    function inserisciPersona(){
        const formData = new FormData;
        nome = document.getElementById('nome').value;
        cognome = document.getElementById('cognome').value;
        email = document.getElementById('email').value;
        formData.append('nome', nome);
        formData.append('cognome', cognome);
        formData.append('email', email);
        

        fetch('./php/insert.php', {
            method: 'POST',
            headers:{
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => { 
            console.log(data);
            aggiornaTabella();
        })
        .catch(error=>{
            console.log('Errore: ',error);
        });
    }

    

    function modificaPersona(evento){
        let id =  evento.target.getAttribute('data-val');
        let nuovaEmail = document.getElementById('newEmail').value;
        console.log('Modifico persona: ', id);
        const formData = new FormData;
        formData.append('id_persona', id);
        formData.append('email', nuovaEmail);

        fetch('./php/update.php', {
            method: 'POST',
            headers:{
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => { 
            console.log(data);
            aggiornaTabella();
        })
        .catch(error=>{
            console.log('Errore: ',error);
        });
    }

    function eliminaPersona(evento){
        let id =  evento.target.getAttribute('data-val');
        console.log('Elimino persona: ', id);
        const formData = new FormData;
        formData.append('id_persona', id);
        

        fetch('./php/delete.php', {
            method: 'POST',
            headers:{
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => { 
            console.log(data);
            aggiornaTabella();
        })
        .catch(error=>{
            console.log('Errore: ',error);
        });
    }

    function aggiornaTabella(){
        let tabella = document.getElementById('tabella-db');
        tabella.parentNode.removeChild(tabella);
        generaTabella();
    };

</script>

<script>
window.__PUBLIC_PATH__ = './bootstrap-italia/fonts';
</script>
<script src="./bootstrap-italia/js/bootstrap-italia.bundle.min.js"></script>
</body>
</html>