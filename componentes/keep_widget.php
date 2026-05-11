<?php

function renderKeepWidgetHead(): void
{
    ?>
    <style>
    .keep-section{
      margin-top: 24px;
      position: relative;
      z-index: 3;
    }
    .keep-section__header{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:12px;
      margin-bottom:16px;
      color:#fff;
    }
    .keep-section__title{
      margin:0;
      font-size:24px;
      font-weight:900;
    }
    .keep-section__subtitle{
      margin:0;
      color:rgba(255,255,255,.82);
      font-weight:700;
    }
    .keep-grid{
      display:grid;
      grid-template-columns: repeat(4, minmax(0, 1fr));
      gap:16px;
    }
    .keep-note{
      border-radius:12px;
      padding:18px;
      box-shadow:0 12px 24px rgba(15,23,42,.12);
      border:1px solid rgba(15,23,42,.08);
      transition:transform .15s ease, box-shadow .15s ease;
      min-height:190px;
      display:flex;
      flex-direction:column;
    }
    .keep-note:hover{
      transform:translateY(-2px);
      box-shadow:0 18px 28px rgba(15,23,42,.16);
    }
    .keep-note__header{
      display:flex;
      align-items:flex-start;
      justify-content:space-between;
      gap:10px;
      margin-bottom:10px;
    }
    .keep-note__title{
      margin:0 0 8px;
      font-size:18px;
      font-weight:900;
      color:#0f172a;
    }
    .keep-note__badge{
      display:inline-flex;
      align-items:center;
      gap:6px;
      padding:5px 10px;
      border-radius:999px;
      background:#0f172a;
      color:#fff;
      font-size:11px;
      font-weight:900;
    }
    .keep-note__content{
      margin:0 0 14px;
      color:#334155;
      line-height:1.5;
      flex:1;
    }
    .keep-note__meta{
      color:#475569;
      font-size:12px;
      font-weight:700;
      margin-bottom:6px;
    }
    .keep-note__actions{
      display:flex;
      flex-wrap:wrap;
      gap:8px;
      margin-top:12px;
    }
    .keep-note__action{
      border:none;
      border-radius:999px;
      background:rgba(255,255,255,.8);
      color:#0f172a;
      font-weight:800;
      padding:8px 12px;
      cursor:pointer;
    }
    .keep-note__action--danger{
      background:#fee2e2;
      color:#b91c1c;
    }
    .keep-empty{
      grid-column:1 / -1;
      padding:20px;
      border-radius:14px;
      background:rgba(255,255,255,.8);
      color:#0f172a;
      font-weight:800;
    }
    .keep-modal-backdrop{
      position:fixed;
      inset:0;
      background:rgba(15,23,42,.42);
      z-index:150;
      opacity:0;
      pointer-events:none;
      transition:opacity .18s ease;
    }
    .keep-modal-backdrop.is-open{
      opacity:1;
      pointer-events:auto;
    }
    .keep-modal{
      position:fixed;
      inset:0;
      display:grid;
      place-items:center;
      z-index:160;
      opacity:0;
      pointer-events:none;
      transition:opacity .18s ease;
      padding:20px;
    }
    .keep-modal.is-open{
      opacity:1;
      pointer-events:auto;
    }
    .keep-modal__dialog{
      width:min(640px, 100%);
      background:#fff;
      border-radius:18px;
      box-shadow:0 24px 44px rgba(15,23,42,.22);
      overflow:hidden;
    }
    .keep-modal__header{
      display:flex;
      align-items:center;
      justify-content:space-between;
      padding:20px 22px;
      border-bottom:1px solid #e5e7eb;
    }
    .keep-modal__title{
      margin:0;
      font-size:22px;
      font-weight:900;
      color:#0f172a;
    }
    .keep-modal__close{
      border:none;
      background:transparent;
      color:#64748b;
      font-size:24px;
      cursor:pointer;
    }
    .keep-modal__body{
      padding:22px;
      display:flex;
      flex-direction:column;
      gap:16px;
    }
    .keep-field label{
      display:block;
      margin-bottom:8px;
      color:#0f172a;
      font-weight:800;
    }
    .keep-field input[type="text"],
    .keep-field input[type="datetime-local"],
    .keep-field textarea{
      width:100%;
      border:1px solid #d5dbe5;
      border-radius:12px;
      padding:12px 14px;
      font-size:14px;
      font-family:inherit;
    }
    .keep-field textarea{
      min-height:140px;
      resize:vertical;
    }
    .keep-colors{
      display:flex;
      flex-wrap:wrap;
      gap:10px;
    }
    .keep-color-option{
      width:34px;
      height:34px;
      border-radius:999px;
      border:2px solid transparent;
      cursor:pointer;
      box-shadow:inset 0 0 0 1px rgba(15,23,42,.1);
    }
    .keep-color-option.is-selected{
      border-color:#0f172a;
      transform:scale(1.08);
    }
    .keep-checkbox{
      display:flex;
      align-items:center;
      gap:8px;
      font-weight:800;
      color:#0f172a;
    }
    .keep-modal__footer{
      display:flex;
      justify-content:flex-end;
      gap:10px;
      padding:0 22px 22px;
    }
    .keep-btn{
      border:none;
      border-radius:12px;
      padding:12px 16px;
      font-weight:800;
      cursor:pointer;
    }
    .keep-btn--ghost{
      background:#e2e8f0;
      color:#0f172a;
    }
    .keep-btn--primary{
      background:#2563eb;
      color:#fff;
    }
    @media (max-width: 1200px){
      .keep-grid{ grid-template-columns: repeat(3, minmax(0, 1fr)); }
    }
    @media (max-width: 900px){
      .keep-grid{ grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 620px){
      .keep-grid{ grid-template-columns: 1fr; }
      .keep-section__header{ flex-direction:column; align-items:flex-start; }
    }
    </style>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <?php
}

function renderKeepWidget($modo = 'light'): void
{
    $texto = $modo === 'dark'
        ? ['title' => 'Notas rapidas', 'subtitle' => 'Tus recordatorios estilo Keep']
        : ['title' => 'Notas rapidas', 'subtitle' => 'Crea, fija y ordena tus ideas'];
    ?>
    <section class="keep-section">
      <div class="keep-section__header">
        <div>
          <h2 class="keep-section__title"><?= htmlspecialchars($texto['title'], ENT_QUOTES, 'UTF-8') ?></h2>
          <p class="keep-section__subtitle"><?= htmlspecialchars($texto['subtitle'], ENT_QUOTES, 'UTF-8') ?></p>
        </div>
      </div>
      <div class="keep-grid" data-keep-grid>
        <div class="keep-empty">Todavia no hay notas. Usa el boton + para crear la primera.</div>
      </div>
    </section>

    <div class="keep-modal-backdrop" data-keep-backdrop></div>
    <div class="keep-modal" data-keep-modal>
      <div class="keep-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="keepModalTitle">
        <div class="keep-modal__header">
          <h3 class="keep-modal__title" id="keepModalTitle">Nueva nota</h3>
          <button class="keep-modal__close" type="button" aria-label="Cerrar" data-keep-close>×</button>
        </div>
        <div class="keep-modal__body">
          <input type="hidden" id="keepNotaId" value="" />
          <input type="hidden" id="keepColor" value="#fff8b8" />

          <div class="keep-field">
            <label for="keepTitulo">Titulo</label>
            <input type="text" id="keepTitulo" maxlength="150" placeholder="Ej: Llamar a Alejandro" />
          </div>

          <div class="keep-field">
            <label for="keepContenido">Contenido</label>
            <textarea id="keepContenido" placeholder="Escribe una nota rapida..."></textarea>
          </div>

          <div class="keep-field">
            <label>Color</label>
            <div class="keep-colors">
              <button class="keep-color-option is-selected" type="button" data-color="#fff8b8" style="background:#fff8b8;"></button>
              <button class="keep-color-option" type="button" data-color="#ffd7d7" style="background:#ffd7d7;"></button>
              <button class="keep-color-option" type="button" data-color="#d8f5d0" style="background:#d8f5d0;"></button>
              <button class="keep-color-option" type="button" data-color="#d7e8ff" style="background:#d7e8ff;"></button>
              <button class="keep-color-option" type="button" data-color="#f4ddff" style="background:#f4ddff;"></button>
              <button class="keep-color-option" type="button" data-color="#ffe9c7" style="background:#ffe9c7;"></button>
            </div>
          </div>

          <label class="keep-checkbox" for="keepFijada">
            <input type="checkbox" id="keepFijada" />
            <span>Fijar nota</span>
          </label>

          <div class="keep-field">
            <label for="keepRecordatorio">Fecha recordatorio</label>
            <input type="datetime-local" id="keepRecordatorio" />
          </div>
        </div>
        <div class="keep-modal__footer">
          <button class="keep-btn keep-btn--ghost" type="button" data-keep-close>Cancelar</button>
          <button class="keep-btn keep-btn--primary" type="button" id="keepGuardarBtn">Guardar nota</button>
        </div>
      </div>
    </div>

    <script src="js/keep.js"></script>
    <?php
}

function renderKeepModalOnly(): void
{
    ?>
    <div class="keep-modal-backdrop" data-keep-backdrop></div>
    <div class="keep-modal" data-keep-modal>
      <div class="keep-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="keepModalTitle">
        <div class="keep-modal__header">
          <h3 class="keep-modal__title" id="keepModalTitle">Nueva nota</h3>
          <button class="keep-modal__close" type="button" aria-label="Cerrar" data-keep-close>×</button>
        </div>
        <div class="keep-modal__body">
          <input type="hidden" id="keepNotaId" value="" />
          <input type="hidden" id="keepColor" value="#fff8b8" />

          <div class="keep-field">
            <label for="keepTitulo">Titulo</label>
            <input type="text" id="keepTitulo" maxlength="150" placeholder="Ej: Llamar a Alejandro" />
          </div>

          <div class="keep-field">
            <label for="keepContenido">Contenido</label>
            <textarea id="keepContenido" placeholder="Escribe una nota rapida..."></textarea>
          </div>

          <div class="keep-field">
            <label>Color</label>
            <div class="keep-colors">
              <button class="keep-color-option is-selected" type="button" data-color="#fff8b8" style="background:#fff8b8;"></button>
              <button class="keep-color-option" type="button" data-color="#ffd7d7" style="background:#ffd7d7;"></button>
              <button class="keep-color-option" type="button" data-color="#d8f5d0" style="background:#d8f5d0;"></button>
              <button class="keep-color-option" type="button" data-color="#d7e8ff" style="background:#d7e8ff;"></button>
              <button class="keep-color-option" type="button" data-color="#f4ddff" style="background:#f4ddff;"></button>
              <button class="keep-color-option" type="button" data-color="#ffe9c7" style="background:#ffe9c7;"></button>
            </div>
          </div>

          <label class="keep-checkbox" for="keepFijada">
            <input type="checkbox" id="keepFijada" />
            <span>Fijar nota</span>
          </label>

          <div class="keep-field">
            <label for="keepRecordatorio">Fecha recordatorio</label>
            <input type="datetime-local" id="keepRecordatorio" />
          </div>
        </div>
        <div class="keep-modal__footer">
          <button class="keep-btn keep-btn--ghost" type="button" data-keep-close>Cancelar</button>
          <button class="keep-btn keep-btn--primary" type="button" id="keepGuardarBtn">Guardar nota</button>
        </div>
      </div>
    </div>

    <script src="js/keep.js"></script>
    <?php
}
