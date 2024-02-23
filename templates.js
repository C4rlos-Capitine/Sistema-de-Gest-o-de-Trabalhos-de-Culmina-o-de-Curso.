const template = document.createElement('template');

template = `
    <div class="menu">
    <div class="icon-div">
        <i id="menu-toggle" class="bi bi-list"></i>
    </div>
    <!--<div class="division"></div>-->
    <div>
        <h2>Sistema de Gestão de Trabalhos de Culminação de Curso </h2>
    </div>
    <div class="division"></div>
    <div>
        <p>Username: Agostinho Ngonga</p>
    </div>
    <div class="division"></div>
    <div>
        <i id="logout" class="bi bi-box-arrow-left"></i>
    </div>
    </div>
`;
document.body.appendChild(template.content);