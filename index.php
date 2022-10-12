<head>
    <link rel="stylesheet" href="./bootstrap-italia/css/bootstrap-italia.min.css" />
    <link rel="stylesheet" href="./style.css" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mysql + Ajax</title>
</head>
<body>

    <div class="container">
    
    <button id="nuova-riga">Inserisci persona</button>
    <div id="tabella-container"></div>

    </div>

<script>
    let persone;
    let bottoneInserisci = document.querySelector('#nuova-riga');
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
        let tabella = `<table>

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

</table>`;

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
        formData.append('nome', 'Romeo');
        formData.append('cognome', 'Santos');
        formData.append('email', 'romeo.santos@gmail.com');
        

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

    function aggiornaTabella(){
        let tabella = document.querySelector('table');
        tabellaContainer.removeChild(tabella);
        generaTabella();
    };

    function modificaPersona(evento){
        let id =  evento.target.getAttribute('data-val');
        let nuovaEmail = 'emailmodificata@gmail.com';
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

</script>

<script>
window.__PUBLIC_PATH__ = './bootstrap-italia/fonts';
</script>
<script src="./bootstrap-italia/js/bootstrap-italia.bundle.min.js"></script>
</body>
</html>