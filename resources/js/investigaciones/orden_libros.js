async function getMiembros() {
    let url = '../getMiembros';
    try {
        let res = await fetch(url);
        return await res.json();
    } catch (error) {
        console.log(error);
    }
}

async function renderMiembros(id) {
    let miembros = await getMiembros();

    const ul = document.querySelector('ul#'+id)
        ul.innerHTML = '';
        let html = '';
        miembros.forEach((miembro, i) => {
            const li = document.createElement('li')
            li.setAttribute('list-pos', i)
            li.innerHTML = `
            <div class='user'>
                <img src='${base_url}/resources/img/profiles/${miembro.profile_pic}' >
                <div class='info'>
                    <input type='text' name='usuarios[]' id='usuario_${miembro.usuario}' hidden value='${miembro.usuario}' />
                    <h2>${miembro.nombre}</h2>
                    <p>${miembro.especialidad}</p>
                </div>
            </div>
            <h1 class='icon'>&#10978</h1>
            `;
        ul.appendChild(li)
    });
    listentoEvents(miembros,id)
}

function listentoEvents(miembros,id) {
    const ul = document.querySelector('ul#'+id)
    let lists = ul.querySelectorAll('li'),
        current_pos, drop_pos
    for (let li of lists) {

        li.draggable = true;

        li.ondragstart = function() {
            current_pos = this.getAttribute('list-pos')
            ul.style.height = ul.clientHeight + 'px';
            setTimeout(() => {
                this.style.display = 'none'
            }, 0);
            ul.style.height = ul.clientHeight - this.clientHeight + 'px';
        }
        li.ondragenter = () => li.classList.add('active');
        li.ondragleave = () => li.classList.remove('active');
        li.ondragend = function() {
            this.style.display = 'flex'
            if (drop_pos === undefined) {
                console.log('enter');
                ul.style.height = ul.clientHeight + this.clientHeight + 'px';
            }
            for (let active_list of lists) {
                active_list.classList.remove('active');
            }
        }
        li.ondragover = (e) => e.preventDefault()
        li.ondrop = function(e) {
            e.preventDefault()
            ul.style.height = ul.clientHeight + this.clientHeight + 'px';
            drop_pos = this.getAttribute('list-pos')
            miembros.splice(drop_pos, 0, miembros.splice(current_pos, 1)[0])
            renderMiembrosAfter(miembros,id)
        }
    }

}

function renderMiembrosAfter(newMiembros,id) {
    const ul = document.querySelector('ul#'+id)
    ul.innerHTML = '';
    console.log(newMiembros);
    newMiembros.forEach((miembro, i) => {
        const li = document.createElement('li')
        li.setAttribute('list-pos', i)
        li.innerHTML = `
        <div class='user'>
            <img src='${base_url}/resources/img/profiles/${miembro.profile_pic}' >
            <div class='info'>
            <input type='text' name='usuarios[]' id='usuario_${miembro.usuario}' hidden value='${miembro.usuario}' />
                <h2>${miembro.nombre}</h2>
                <p>${miembro.especialidad}</p>
            </div>
        </div>
        <h1 class='icon'>&#10978</h1>
        `;
        ul.appendChild(li)
    });
    listentoEvents(newMiembros,id)
}

async function getMiembrosRegistrados(id) {
    let url = '../getMiembrosRegistrados/'+id+'/'+anio;
    try {
        let res = await fetch(url);
        return await res.json();
    } catch (error) {
        console.log(error);
    }
}

async function renderMiembrosRegistrados(id) {

    let miembros = await getMiembrosRegistrados(id);
    $('#submit_'+id).prop('disabled',true).prop('title','El orden de los autores ya ha sido registrado').text('Orden registrado')
    $('#form_'+id).attr('action','#');
    console.log();
    const ul = document.querySelector('ul#'+id)
        ul.innerHTML = '';
        let html = '';
        miembros.forEach((miembro, i) => {
            const li = document.createElement('li')
            li.setAttribute('list-pos', i)
            li.innerHTML = `
            <div class='user'>
                <img src='${base_url}/resources/img/profiles/${miembro.profile_pic}' >
                <div class='info'>
                    <input type='text' name='usuarios[]' id='usuario_${miembro.usuario}' hidden value='${miembro.usuario}' />
                    <h2>${miembro.nombre}</h2>
                    <p>${miembro.especialidad}</p>
                </div>
            </div>
            <h1 class='icon'>&#10978</h1>
            `;
        ul.appendChild(li)
    });
}

if(impreso == 1){
    renderMiembros('impreso')
}else{
    renderMiembrosRegistrados('impreso');
}

if(digital == 1){
    renderMiembros('digital')
}else{
    renderMiembrosRegistrados('digital');
}

$(document).ready(function(){
    let date = new Date().toISOString().slice(0, 10);
    date = date.split('-').join("")
    let path = window.location.pathname
    let split = path.split('/')
    let proyecto = split[3]
    let split_proyecto = proyecto.split('_')
    let red = split_proyecto[3]
    if(date > '20230410' && red == 'Relayn'){
        //Deshabilitar
        $("#form_impreso button[type='submit']").prop('disabled',true).prop('title','El tiempo para registrar el orden de los autores ha expirado. El orden de sus autores va a ser tomado en automático por el sistema. Agradecemos su comprensión.').text('Fecha límite alcanzada.')
        $("#form_digital button[type='submit']").prop('disabled',true).prop('title','El tiempo para registrar el orden de los autores ha expirado. El orden de sus autores va a ser tomado en automático por el sistema. Agradecemos su comprensión.').text('Fecha límite alcanzada.')
        return
    }

    if(date > '20230417' && (red=='Relep' || red=='Relen')){
        //Deshabilitar
        $("#form_impreso button[type='submit']").prop('disabled',true).prop('title','El tiempo para registrar el orden de los autores ha expirado. El orden de sus autores va a ser tomado en automático por el sistema. Agradecemos su comprensión.').text('Fecha límite alcanzada.')
        $("#form_digital button[type='submit']").prop('disabled',true).prop('title','El tiempo para registrar el orden de los autores ha expirado. El orden de sus autores va a ser tomado en automático por el sistema. Agradecemos su comprensión.').text('Fecha límite alcanzada.')
        return
    }

    if(date > '20231003' && red=='Releg'){
        //Deshabilitar
        $("#form_impreso button[type='submit']").prop('disabled',true).prop('title','El tiempo para registrar el orden de los autores ha expirado. El orden de sus autores va a ser tomado en automático por el sistema. Agradecemos su comprensión.').text('Fecha límite alcanzada.')
        $("#form_digital button[type='submit']").prop('disabled',true).prop('title','El tiempo para registrar el orden de los autores ha expirado. El orden de sus autores va a ser tomado en automático por el sistema. Agradecemos su comprensión.').text('Fecha límite alcanzada.')
        return
    }

    console.log(date);


})