<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <style>
        .user img {
            width: 4rem;
            height: 4rem;
            border-radius: 50%;
        }

        ul {
            width: 45vw;
            background-color: #fff;
            border-radius: 1rem;
            list-style: none;
            overflow: hidden;
            transition: .3s ease;
        }

        li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: move;
            transition: .3s ease;
        }

        li:nth-child(even) {
            background-color: #eee8;

        }

        li:hover {
            background-color: #00f2;
            transform: scale(1.03);
        }

        li.active {
            background-color: #0f03;
            transform: scale(1.03);
            padding-bottom: .8rem;
        }

        .user {
            display: flex;
            align-items: center;
            padding: 1rem;
        }

        .info {
            margin-left: 1rem;
        }

        .info h2 {
            font-size: 1.2rem;
        }

        .icon {
            padding: 1rem;
            transform: rotate(180deg);
        }
    </style>
    <form action="./letsgo" method="post" id="form">
        <ul id="impreso">
        </ul>
        <hr>
        <ul id="digital">
        </ul>

        <button type="submit">GOGOGOOGOGOGO</button>
    </form>
    <output id="output"></output>
    <script>
        async function getMiembros() {
            let url = './getMiembros';
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
                        <img src='http://localhost/redeslaci/resources/img/profiles/${miembro.profile_pic}' >
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

        renderMiembros('impreso');
        renderMiembros('digital');

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
                    <img src='http://localhost/redeslaci/resources/img/profiles/${miembro.profile_pic}' >
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
    </script>

    <script>
        /*
        document.addEventListener("submit", (e) => {
            e.preventDefault()
            console.log('entra');
            const form = document.getElementById("form");
            const formData = new FormData(form);
            console.log(formData);
            const output = document.getElementById("output");
            for (const [key, value] of formData) {
                output.textContent += `${key}: ${value}\n`;
            }
        });
        */
    </script>
</body>

</html>