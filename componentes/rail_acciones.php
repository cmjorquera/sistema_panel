<?php

function obtenerUsuariosCalendario(): array
{
    static $usuarios = null;

    if ($usuarios !== null) {
        return $usuarios;
    }

    $usuarios = [];

    if (!class_exists('Conexion')) {
        $conexionPath = __DIR__ . '/../class/conexion.php';
        if (is_file($conexionPath)) {
            require_once $conexionPath;
        }
    }

    if (!class_exists('Conexion')) {
        return [['id' => 1, 'label' => 'Usuario 1']];
    }

    try {
        $db = new Conexion();
        $conn = $db->getConexion();

        foreach (['usuario', 'usuarios'] as $tabla) {
            $resultado = $conn->query("SELECT * FROM {$tabla} ORDER BY id ASC");
            if (!$resultado) {
                continue;
            }

            while ($fila = $resultado->fetch_assoc()) {
                $id = (int)($fila['id'] ?? 0);
                if ($id <= 0) {
                    continue;
                }

                $label = '';
                foreach (['nombre_completo', 'nombre', 'usuario', 'nombres', 'email', 'correo', 'login', 'user'] as $campo) {
                    if (!empty($fila[$campo])) {
                        $label = trim((string)$fila[$campo]);
                        break;
                    }
                }

                if ($label === '') {
                    $label = 'Usuario ' . $id;
                }

                $usuarios[] = [
                    'id' => $id,
                    'label' => $label,
                ];
            }

            $resultado->free();

            if (!empty($usuarios)) {
                break;
            }
        }

        $db->cerrar();
    } catch (Throwable $e) {
        $usuarios = [];
    }

    if (empty($usuarios)) {
        $usuarios[] = ['id' => 1, 'label' => 'Usuario 1'];
    }

    return $usuarios;
}

function renderRailAccionesStyles(): void
{
    ?>
    <style>
    .rail{
      position: fixed;
      right: 16px;
      top: 50%;
      transform: translateY(-50%);
      z-index: 90;
      display:flex;
      flex-direction:column;
      gap: 12px;
      align-items:center;
    }
    .rail__btn{
      width: 46px;
      height: 46px;
      border-radius: 999px;
      border:1px solid rgba(255,255,255,.35);
      box-shadow: 0 14px 30px rgba(0,0,0,.22);
      background: rgba(17,24,39,.45);
      color:#fff;
      cursor:pointer;
      transition:.15s ease;
      font-size:18px;
      display:grid;
      place-items:center;
      backdrop-filter: blur(8px);
    }
    .rail__btn:hover{ transform: translateY(-1px); }
    .rail__spacer{ height: 16px; }
    .rail__item{ position: relative; }
    .rail__badge{
      position: absolute;
      top: -4px;
      right: -4px;
      min-width: 20px;
      height: 20px;
      padding: 0 6px;
      border-radius: 999px;
      background: #ef4444;
      color: #fff;
      font-size: 11px;
      font-weight: 900;
      display: grid;
      place-items: center;
      box-shadow: 0 8px 18px rgba(0,0,0,.22);
      border: 2px solid rgba(255,255,255,.9);
    }
    .rail__btn--danger{ background: rgba(239,68,68,.75); border-color: rgba(239,68,68,.35); }
    .rail__btn--dark{ background: rgba(15,23,42,.65); border-color: rgba(255,255,255,.20); }
    .rail__btn--white{ background: rgba(255,255,255,.90); color:#111827; border-color: rgba(255,255,255,.55); }
    .rail__btn--red{ background: rgba(220,38,38,.75); }
    .rail__btn--blue{ background: rgba(59,130,246,.75); }
    .rail__btn--yellow{ background: rgba(245,179,56,.92); color:#111827; border-color: rgba(245,179,56,.55); font-weight:900; }
    .rail__btn--green{ background: rgba(34,197,94,.78); }
    .rail__btn--add{ background: rgba(37,99,235,.88); font-weight:900; }
    .contenedor-modal-backdrop{
      position: fixed;
      inset: 0;
      background: rgba(15,23,42,.44);
      z-index: 145;
      opacity: 0;
      pointer-events: none;
      transition: opacity .18s ease;
    }
    .contenedor-modal-backdrop.is-open{
      opacity: 1;
      pointer-events: auto;
    }
    .contenedor-modal{
      position: fixed;
      inset: 0;
      display: grid;
      place-items: center;
      padding: 20px;
      z-index: 150;
      opacity: 0;
      pointer-events: none;
      transition: opacity .18s ease;
    }
    .contenedor-modal.is-open{
      opacity: 1;
      pointer-events: auto;
    }
    .contenedor-modal__dialog{
      width: min(560px, 100%);
      border-radius: 24px;
      background: linear-gradient(180deg, rgba(255,255,255,.98), rgba(248,250,252,.98));
      border: 1px solid rgba(226,232,240,.95);
      box-shadow: 0 30px 70px rgba(15,23,42,.32);
      overflow: hidden;
    }
    .contenedor-modal__header{
      display:flex;
      align-items:flex-start;
      justify-content:space-between;
      gap:16px;
      padding:24px 24px 18px;
      border-bottom:1px solid rgba(226,232,240,.9);
    }
    .contenedor-modal__eyebrow{
      margin:0 0 6px;
      color:#b45309;
      font-size:12px;
      font-weight:900;
      letter-spacing:.08em;
      text-transform:uppercase;
    }
    .contenedor-modal__title{
      margin:0;
      font-size:24px;
      font-weight:900;
      color:#0f172a;
    }
    .contenedor-modal__subtitle{
      margin:6px 0 0;
      color:#64748b;
      line-height:1.45;
      font-weight:700;
    }
    .contenedor-modal__close{
      width:40px;
      height:40px;
      border:none;
      border-radius:999px;
      background:rgba(226,232,240,.75);
      color:#475569;
      cursor:pointer;
      font-size:24px;
    }
    .contenedor-modal__body{
      padding:22px 24px 24px;
      display:grid;
      gap:16px;
    }
    .contenedor-modal__grid{
      display:grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap:14px;
    }
    .contenedor-field{
      display:grid;
      gap:8px;
    }
    .contenedor-field--full{
      grid-column:1 / -1;
    }
    .contenedor-field label{
      color:#0f172a;
      font-size:13px;
      font-weight:900;
    }
    .contenedor-field input{
      width:100%;
      border:1px solid #d7dee8;
      border-radius:14px;
      padding:13px 14px;
      background:#fff;
      color:#0f172a;
      font-size:14px;
      font-family:inherit;
      outline:none;
      transition:border-color .15s ease, box-shadow .15s ease;
    }
    .contenedor-field input:focus{
      border-color:#f59e0b;
      box-shadow:0 0 0 4px rgba(245,158,11,.16);
    }
    .contenedor-field input[type="file"]{
      padding:10px 12px;
      background:#fff7ed;
      border-style:dashed;
    }
    .contenedor-modal__preview{
      display:grid;
      gap:10px;
    }
    .contenedor-modal__preview-frame{
      width:100%;
      min-height:160px;
      border-radius:18px;
      border:1px solid #e2e8f0;
      background:linear-gradient(135deg, #fff7ed, #fffbeb);
      display:grid;
      place-items:center;
      overflow:hidden;
    }
    .contenedor-modal__preview-frame img{
      width:100%;
      max-height:220px;
      object-fit:contain;
      display:none;
    }
    .contenedor-modal__preview-frame.is-ready img{
      display:block;
    }
    .contenedor-modal__preview-empty{
      color:#94a3b8;
      font-weight:800;
      text-align:center;
      padding:18px;
    }
    .contenedor-modal__preview-name{
      display:none;
      color:#0f172a;
      font-size:13px;
      font-weight:900;
      background:#fff7ed;
      border:1px solid #fed7aa;
      border-radius:12px;
      padding:10px 12px;
    }
    .contenedor-modal__preview-name.is-visible{
      display:block;
    }
    .contenedor-modal__hint{
      margin:0;
      color:#64748b;
      font-size:12px;
      font-weight:700;
    }
    .contenedor-modal__status{
      display:none;
      border-radius:14px;
      padding:12px 14px;
      font-weight:800;
      line-height:1.4;
    }
    .contenedor-modal__status.is-visible{
      display:block;
    }
    .contenedor-modal__status--error{
      background:#fef2f2;
      color:#b91c1c;
      border:1px solid #fecaca;
    }
    .contenedor-modal__status--success{
      background:#ecfdf5;
      color:#166534;
      border:1px solid #bbf7d0;
    }
    .contenedor-modal__footer{
      display:flex;
      justify-content:flex-end;
      gap:10px;
      padding:0 24px 24px;
    }
    .contenedor-btn{
      border:none;
      border-radius:14px;
      padding:12px 16px;
      font-weight:900;
      cursor:pointer;
      transition:transform .15s ease, opacity .15s ease;
    }
    .contenedor-btn:hover{
      transform:translateY(-1px);
    }
    .contenedor-btn:disabled{
      opacity:.7;
      cursor:wait;
      transform:none;
    }
    .contenedor-btn--ghost{
      background:#e2e8f0;
      color:#0f172a;
    }
    .contenedor-btn--primary{
      background:linear-gradient(135deg, #f59e0b, #f97316);
      color:#fff;
      box-shadow:0 12px 26px rgba(249,115,22,.25);
    }
    .calendar-modal-backdrop{
      position:fixed;
      inset:0;
      background:rgba(15,23,42,.48);
      z-index:165;
      opacity:0;
      pointer-events:none;
      transition:opacity .18s ease;
    }
    .calendar-modal-backdrop.is-open{
      opacity:1;
      pointer-events:auto;
    }
    .calendar-modal{
      position:fixed;
      inset:0;
      display:grid;
      place-items:center;
      padding:24px;
      z-index:170;
      opacity:0;
      pointer-events:none;
      transition:opacity .18s ease;
    }
    .calendar-modal.is-open{
      opacity:1;
      pointer-events:auto;
    }
    .calendar-modal__dialog{
      width:min(1180px, 100%);
      max-height:min(88vh, 920px);
      border-radius:28px;
      overflow:hidden;
      background:linear-gradient(180deg, rgba(255,255,255,.98), rgba(248,250,252,.98));
      border:1px solid rgba(226,232,240,.9);
      box-shadow:0 34px 80px rgba(15,23,42,.34);
      display:grid;
      grid-template-columns:minmax(0, 1.6fr) minmax(320px, .8fr);
    }
    .calendar-modal__main{
      padding:24px 24px 20px;
      display:flex;
      flex-direction:column;
      min-height:0;
    }
    .calendar-modal__header{
      display:flex;
      align-items:flex-start;
      justify-content:space-between;
      gap:16px;
      margin-bottom:18px;
    }
    .calendar-modal__eyebrow{
      margin:0 0 6px;
      color:#b91c1c;
      font-size:12px;
      font-weight:900;
      letter-spacing:.08em;
      text-transform:uppercase;
    }
    .calendar-modal__title{
      margin:0;
      color:#0f172a;
      font-size:28px;
      font-weight:900;
    }
    .calendar-modal__subtitle{
      margin:6px 0 0;
      color:#64748b;
      font-weight:700;
      line-height:1.45;
    }
    .calendar-modal__close{
      width:42px;
      height:42px;
      border:none;
      border-radius:999px;
      background:rgba(226,232,240,.75);
      color:#475569;
      font-size:24px;
      cursor:pointer;
      flex:0 0 auto;
    }
    .calendar-modal__calendar{
      flex:1;
      min-height:540px;
      border-radius:22px;
      border:1px solid #e2e8f0;
      background:#fff;
      padding:16px;
      box-shadow:inset 0 1px 0 rgba(255,255,255,.9);
    }
    .calendar-modal__side{
      border-left:1px solid rgba(226,232,240,.9);
      background:rgba(248,250,252,.92);
      padding:24px 22px;
      display:flex;
      flex-direction:column;
      gap:16px;
      overflow:auto;
    }
    .calendar-form{
      display:grid;
      gap:14px;
    }
    .calendar-form__card{
      border-radius:18px;
      background:#fff;
      border:1px solid #e2e8f0;
      padding:16px;
      box-shadow:0 12px 24px rgba(15,23,42,.06);
    }
    .calendar-form__card h4{
      margin:0 0 6px;
      color:#0f172a;
      font-size:16px;
      font-weight:900;
    }
    .calendar-form__card p{
      margin:0;
      color:#64748b;
      font-size:13px;
      line-height:1.45;
      font-weight:700;
    }
    .calendar-field{
      display:grid;
      gap:8px;
    }
    .calendar-field label{
      color:#0f172a;
      font-size:13px;
      font-weight:900;
    }
    .calendar-field input,
    .calendar-field textarea,
    .calendar-field select{
      width:100%;
      border:1px solid #d7dee8;
      border-radius:14px;
      padding:12px 14px;
      background:#fff;
      color:#0f172a;
      font-size:14px;
      font-family:inherit;
      outline:none;
    }
    .calendar-field textarea{
      min-height:96px;
      resize:vertical;
    }
    .calendar-field input:focus,
    .calendar-field textarea:focus,
    .calendar-field select:focus{
      border-color:#2563eb;
      box-shadow:0 0 0 4px rgba(37,99,235,.14);
    }
    .calendar-field--inline{
      grid-template-columns:repeat(2, minmax(0, 1fr));
      gap:12px;
    }
    .calendar-checkbox{
      display:flex;
      align-items:center;
      gap:10px;
      color:#0f172a;
      font-size:13px;
      font-weight:800;
    }
    .calendar-status{
      display:none;
      border-radius:14px;
      padding:12px 14px;
      font-weight:800;
      line-height:1.4;
    }
    .calendar-status.is-visible{
      display:block;
    }
    .calendar-status--error{
      background:#fef2f2;
      color:#b91c1c;
      border:1px solid #fecaca;
    }
    .calendar-status--success{
      background:#ecfdf5;
      color:#166534;
      border:1px solid #bbf7d0;
    }
    .calendar-actions{
      display:flex;
      gap:10px;
      justify-content:flex-end;
    }
    .calendar-btn{
      border:none;
      border-radius:14px;
      padding:12px 16px;
      font-weight:900;
      cursor:pointer;
    }
    .calendar-btn--ghost{
      background:#e2e8f0;
      color:#0f172a;
    }
    .calendar-btn--primary{
      background:linear-gradient(135deg, #2563eb, #1d4ed8);
      color:#fff;
      box-shadow:0 12px 26px rgba(37,99,235,.22);
    }
    .calendar-btn--danger{
      background:#fee2e2;
      color:#b91c1c;
    }
    .calendar-mini-list{
      display:grid;
      gap:10px;
    }
    .calendar-mini-item{
      border-radius:14px;
      background:#fff;
      border:1px solid #e2e8f0;
      padding:12px 14px;
    }
    .calendar-mini-item__title{
      margin:0 0 6px;
      color:#0f172a;
      font-size:14px;
      font-weight:900;
    }
    .calendar-mini-item__meta{
      margin:0;
      color:#64748b;
      font-size:12px;
      font-weight:700;
      line-height:1.4;
    }
    .fc .fc-toolbar-title{
      font-size:1.2rem;
      color:#0f172a;
      font-weight:900;
    }
    .fc .fc-button-primary{
      background:#1d4ed8;
      border-color:#1d4ed8;
    }
    .fc .fc-button-primary:not(:disabled):hover{
      background:#1e40af;
      border-color:#1e40af;
    }
    .fc .fc-daygrid-event{
      border:none;
      border-radius:8px;
      padding:2px 4px;
    }
    @media (max-width: 820px){
      .rail{ right: 10px; }
      .contenedor-modal__grid{ grid-template-columns: 1fr; }
      .calendar-modal{
        padding:12px;
      }
      .calendar-modal__dialog{
        grid-template-columns:1fr;
        max-height:92vh;
      }
      .calendar-modal__main{
        padding:18px 18px 14px;
      }
      .calendar-modal__calendar{
        min-height:420px;
        padding:10px;
      }
      .calendar-modal__side{
        border-left:none;
        border-top:1px solid rgba(226,232,240,.9);
        padding:18px;
      }
      .calendar-field--inline{
        grid-template-columns:1fr;
      }
    }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.20/index.global.min.js"></script>
    <?php
}

function renderRailAcciones(bool $habilitarKeep = true): void
{
    $usuariosCalendario = obtenerUsuariosCalendario();
    ?>
    <aside class="rail" aria-label="Acciones rapidas">
      <div class="rail__item" title="SIAE: nuevo documento cargado">
        <button class="rail__btn rail__btn--danger" type="button" aria-label="Notificacion de SIAE: nuevo documento cargado">📄</button>
        <span class="rail__badge" aria-hidden="true">1</span>
      </div>
      <button class="rail__btn rail__btn--dark" type="button" title="Subir archivo">☁️</button>
      <button class="rail__btn rail__btn--white" type="button" title="Notificaciones">🔔</button>
      <button class="rail__btn rail__btn--red" type="button" title="Calendario" aria-label="Abrir calendario" data-open-calendar>📅</button>
      <button class="rail__btn rail__btn--blue" type="button" title="Contactos" aria-label="Abrir contactos" data-open-contacts>👥</button>
      <button class="rail__btn rail__btn--yellow" type="button" title="Nuevo contenedor" aria-label="Crear contenedor" data-open-contenedor>＋</button>
      <?php if ($habilitarKeep): ?>
        <button class="rail__btn rail__btn--add" type="button" title="Nueva nota" aria-label="Crear nota rapida" data-open-keep>＋</button>
      <?php else: ?>
        <button class="rail__btn rail__btn--add" type="button" title="Agregar acceso" aria-label="Agregar acceso">＋</button>
      <?php endif; ?>
    </aside>

    <div class="contenedor-modal-backdrop" data-contenedor-backdrop></div>
    <div class="contenedor-modal" data-contenedor-modal>
      <div class="contenedor-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="contenedorModalTitle">
        <div class="contenedor-modal__header">
          <div>
            <p class="contenedor-modal__eyebrow">Nuevo acceso</p>
            <h3 class="contenedor-modal__title" id="contenedorModalTitle">Crear contenedor</h3>
            <p class="contenedor-modal__subtitle">Agrega un acceso directo elegante al launcher usando la estructura real de la tabla <strong>contenedor</strong>.</p>
          </div>
          <button class="contenedor-modal__close" type="button" aria-label="Cerrar" data-contenedor-close>×</button>
        </div>

        <form class="contenedor-modal__body" data-contenedor-form>
          <div class="contenedor-modal__grid">
            <div class="contenedor-field contenedor-field--full">
              <label for="contenedorNombre">Nombre</label>
              <input id="contenedorNombre" name="nombre" type="text" maxlength="150" placeholder="Ej: Gmail institucional" required />
            </div>

            <div class="contenedor-field contenedor-field--full">
              <label for="contenedorUrl">URL</label>
              <input id="contenedorUrl" name="url_" type="text" maxlength="255" placeholder="Ej: mail.google.com" required />
            </div>

            <div class="contenedor-field contenedor-field--full">
              <label for="contenedorImagenFile">Imagen</label>
              <input id="contenedorImagenFile" name="imagen_file" type="file" accept="image/*" />
              <p class="contenedor-modal__hint">Adjunta una imagen y se vera al instante. Si no adjuntas una, se usara la imagen por defecto.</p>
            </div>

            <div class="contenedor-field contenedor-field--full">
              <div class="contenedor-modal__preview">
                <div class="contenedor-modal__preview-frame" data-contenedor-preview-frame>
                  <img src="" alt="Vista previa del contenedor" data-contenedor-preview-image />
                  <div class="contenedor-modal__preview-empty" data-contenedor-preview-empty>La vista previa aparecera aqui.</div>
                </div>
                <div class="contenedor-modal__preview-name" data-contenedor-preview-name></div>
              </div>
            </div>
          </div>

          <div class="contenedor-modal__status" data-contenedor-status></div>
        </form>

        <div class="contenedor-modal__footer">
          <button class="contenedor-btn contenedor-btn--ghost" type="button" data-contenedor-close>Cancelar</button>
          <button class="contenedor-btn contenedor-btn--primary" type="button" data-contenedor-save>Guardar acceso</button>
        </div>
      </div>
    </div>

    <script src="js/contenedor_modal.js"></script>

    <div class="calendar-modal-backdrop" data-calendar-backdrop></div>
    <div class="calendar-modal" data-calendar-modal>
      <div class="calendar-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="calendarModalTitle">
        <section class="calendar-modal__main">
          <div class="calendar-modal__header">
            <div>
              <!-- <p class="calendar-modal__eyebrow">Agenda operativa</p> -->
              <h3 class="calendar-modal__title" id="calendarModalTitle">Calendario</h3>
              <!-- <p class="calendar-modal__subtitle">Haz clic en un día para precargar un evento. Los eventos se leen desde la base de datos y se refrescan automáticamente.</p> -->
            </div>
            <button class="calendar-modal__close" type="button" aria-label="Cerrar calendario" data-calendar-close>×</button>
          </div>

          <div class="calendar-modal__calendar" id="panelCalendar"></div>
        </section>

        <aside class="calendar-modal__side">
          <form class="calendar-form" data-calendar-form>
            <!-- <div class="calendar-form__card">
              <h4>Nuevo evento</h4>
              <p>Usa el formulario o pulsa una fecha en el calendario para rellenar inicio y fin.</p>
            </div> -->

            <input type="hidden" name="id" value="" />

            <div class="calendar-field">
              <label for="calendarUsuario">Usuario</label>
              <select id="calendarUsuario" name="id_usuario">
                <?php foreach ($usuariosCalendario as $usuario): ?>
                  <option value="<?= (int)$usuario['id'] ?>"><?= htmlspecialchars($usuario['label'], ENT_QUOTES, 'UTF-8') ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="calendar-field">
              <label for="calendarTitulo">Titulo</label>
              <input id="calendarTitulo" name="titulo" type="text" maxlength="180" placeholder="Ej: Reunion con direccion" required />
            </div>

            <div class="calendar-field">
              <label for="calendarDescripcion">Descripcion</label>
              <textarea id="calendarDescripcion" name="descripcion" placeholder="Detalle del evento..."></textarea>
            </div>

            <div class="calendar-field calendar-field--inline">
              <div class="calendar-field">
                <label for="calendarInicio">Inicio</label>
                <input id="calendarInicio" name="fecha_inicio" type="datetime-local" required />
              </div>
              <div class="calendar-field">
                <label for="calendarFin">Fin</label>
                <input id="calendarFin" name="fecha_fin" type="datetime-local" />
              </div>
            </div>

            <div class="calendar-field">
              <label for="calendarColor">Color</label>
              <select id="calendarColor" name="color">
                <option value="#2563eb">Azul</option>
                <option value="#16a34a">Verde</option>
                <option value="#dc2626">Rojo</option>
                <option value="#d97706">Naranjo</option>
                <option value="#7c3aed">Violeta</option>
              </select>
            </div>

            <label class="calendar-checkbox" for="calendarAllDay">
              <input id="calendarAllDay" name="todo_el_dia" type="checkbox" value="1" />
              <span>Todo el dia</span>
            </label>

            <div class="calendar-status" data-calendar-status></div>

            <div class="calendar-actions">
              <button class="calendar-btn calendar-btn--ghost" type="button" data-calendar-reset>Limpiar</button>
              <button class="calendar-btn calendar-btn--primary" type="submit" data-calendar-save>Guardar evento</button>
            </div>
          </form>

          <div class="calendar-form__card">
            <h4>Proximos eventos</h4>
            <div class="calendar-mini-list" data-calendar-upcoming>
              <div class="calendar-mini-item">
                <p class="calendar-mini-item__title">Sin eventos cargados</p>
                <p class="calendar-mini-item__meta">Cuando guardes eventos, apareceran aqui.</p>
              </div>
            </div>
          </div>
        </aside>
      </div>
    </div>

    <script src="js/calendario_panel.js"></script>
    <?php
}
