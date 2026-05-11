<?php

function renderPanelContactosStyles(): void
{
    ?>
    <style>
    .contact-panel{
      position: fixed;
      top: 0;
      right: 0;
      width: min(430px, 100vw);
      height: 100vh;
      background: #eef1f5;
      border-left: 1px solid #d8dee8;
      box-shadow: -18px 0 40px rgba(15,23,42,.14);
      z-index: 140;
      transform: translateX(100%);
      transition: transform .2s ease;
      display: flex;
      flex-direction: column;
    }
    .contact-panel.is-open{ transform: translateX(0); }
    .contact-panel__header{
      display:flex;
      align-items:center;
      justify-content:space-between;
      padding:20px 22px;
      background:#fff;
      border-bottom:1px solid #d8dee8;
    }
    .contact-panel__title{
      display:flex;
      align-items:center;
      gap:12px;
      font-size:20px;
      font-weight:900;
      color:#0f172a;
    }
    .contact-panel__close{
      border:none;
      background:transparent;
      font-size:24px;
      color:#6b7280;
      cursor:pointer;
    }
    .contact-panel__body{
      padding:18px 18px 24px;
      overflow:auto;
      display:flex;
      flex-direction:column;
      gap:16px;
    }
    .contact-panel__search{
      width:100%;
      border:1px solid #d1d9e4;
      border-radius:8px;
      padding:14px 16px;
      font-size:14px;
      background:#fff;
    }
    .contact-card{
      background:#fff;
      border:1px solid #d7dde7;
      border-radius:10px;
      padding:18px;
      box-shadow:0 4px 14px rgba(15,23,42,.05);
    }
    .contact-card__row{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:12px;
    }
    .contact-card__name{
      font-size:18px;
      font-weight:900;
      color:#0f172a;
    }
    .contact-card__actions{
      display:flex;
      align-items:center;
      gap:8px;
    }
    .contact-action{
      width:40px;
      height:40px;
      border-radius:999px;
      border:1px solid #97a3b6;
      background:#fff;
      cursor:pointer;
      display:grid;
      place-items:center;
      font-size:18px;
    }
    .contact-action--mail{ color:#2563eb; border-color:#2563eb; }
    .contact-action--wa{ color:#16a34a; border-color:#16a34a; }
    .contact-action--chat{ color:#6b7280; }
    .contact-action--chat.is-active{
      background:#f1f5f9;
      box-shadow: inset 0 0 0 3px #9ca3af;
    }
    .contact-chat{
      display:none;
      margin-top:14px;
      padding:18px;
      border-radius:10px;
      background:#e9e4dd;
      min-height:320px;
    }
    .contact-chat.is-open{ display:block; }
    .chat-thread{
      display:flex;
      flex-direction:column;
      gap:10px;
      margin-bottom:16px;
    }
    .chat-bubble{
      max-width:78%;
      border-radius:8px;
      padding:10px 14px;
      background:#fff;
      color:#0f172a;
      box-shadow:0 4px 10px rgba(15,23,42,.08);
    }
    .chat-bubble--self{
      align-self:flex-end;
      background:#b7ccb8;
    }
    .chat-bubble__author{
      display:block;
      font-weight:900;
      font-size:12px;
      margin-bottom:4px;
    }
    .chat-bubble__day{
      color:#ef4444;
      font-weight:900;
    }
    .chat-bubble__date{
      color:#475569;
    }
    .chat-compose{
      display:flex;
      align-items:stretch;
      margin-top:auto;
    }
    .chat-compose__input{
      flex:1;
      border:1px solid #d1d9e4;
      border-right:none;
      border-radius:8px 0 0 8px;
      padding:14px 16px;
      font-size:14px;
      background:#fff;
    }
    .chat-compose__send{
      width:52px;
      border:none;
      border-radius:0 8px 8px 0;
      background:#1982ff;
      color:#fff;
      font-size:22px;
      cursor:pointer;
    }
    .contact-panel-backdrop{
      position: fixed;
      inset: 0;
      background: rgba(15,23,42,.18);
      z-index: 130;
      opacity: 0;
      pointer-events: none;
      transition: opacity .2s ease;
    }
    .contact-panel-backdrop.is-open{
      opacity: 1;
      pointer-events: auto;
    }
    </style>
    <?php
}

function renderPanelContactos(): void
{
    $trabajadores = [
        'Alejandro Rojas',
        'Alex Espinoza',
        'Alvaro Fuentes',
        'Antonio Valdes',
        'Beatriz Herrera',
        'Carola Prado',
        'Carola Barros',
        'Catalina Jaramillo',
    ];
    ?>
    <div class="contact-panel-backdrop" data-contact-backdrop></div>
    <aside class="contact-panel" data-contact-panel aria-label="Contactar trabajadores">
      <div class="contact-panel__header">
        <div class="contact-panel__title"><span>👥</span><span>Contactar trabajadores</span></div>
        <button class="contact-panel__close" type="button" aria-label="Cerrar panel de contactos" data-contact-close>×</button>
      </div>
      <div class="contact-panel__body">
        <input class="contact-panel__search" type="search" placeholder="Buscar trabajador..." />
        <?php foreach ($trabajadores as $nombre): ?>
          <?php $slug = strtolower(str_replace(' ', '-', $nombre)); ?>
          <section class="contact-card">
            <div class="contact-card__row">
              <div class="contact-card__name"><?= htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?></div>
              <div class="contact-card__actions">
                <button class="contact-action contact-action--mail" type="button" title="Enviar correo">✉️</button>
                <button class="contact-action contact-action--wa" type="button" title="Abrir WhatsApp">🟢</button>
                <button class="contact-action contact-action--chat" type="button" title="Ver mensajes" data-chat-toggle="<?= htmlspecialchars($slug, ENT_QUOTES, 'UTF-8') ?>">💬</button>
              </div>
            </div>
            <?php if ($nombre === 'Alejandro Rojas'): ?>
              <div class="contact-chat" data-chat-box="<?= htmlspecialchars($slug, ENT_QUOTES, 'UTF-8') ?>">
                <div class="chat-thread">
                  <div class="chat-bubble chat-bubble--self">
                    <span class="chat-bubble__author">Cristian Jorquera:</span>
                    <div>Hola, Alejandro</div>
                    <div><span class="chat-bubble__day">Jueves</span> <span class="chat-bubble__date">(11 junio-2025)</span></div>
                  </div>
                  <div class="chat-bubble chat-bubble--self">
                    <span class="chat-bubble__author">Cristian Jorquera:</span>
                    <div>Saludos. Ya revise el documento nuevo en SIAE y quedo cargado para firma.</div>
                    <div><span class="chat-bubble__day">Jueves</span> <span class="chat-bubble__date">(07 enero-2026)</span></div>
                  </div>
                  <div class="chat-bubble">
                    <span class="chat-bubble__author">Alejandro Rojas:</span>
                    <div>Hola. Perfecto, lo reviso hoy despues de almuerzo y te confirmo.</div>
                    <div><span class="chat-bubble__day">Jueves</span> <span class="chat-bubble__date">(07 enero-2026)</span></div>
                  </div>
                </div>
                <div class="chat-compose">
                  <input class="chat-compose__input" type="text" placeholder="Escribe un mensaje..." />
                  <button class="chat-compose__send" type="button" aria-label="Enviar mensaje">✈</button>
                </div>
              </div>
            <?php else: ?>
              <div class="contact-chat" data-chat-box="<?= htmlspecialchars($slug, ENT_QUOTES, 'UTF-8') ?>">
                <div class="chat-thread">
                  <div class="chat-bubble">
                    <span class="chat-bubble__author"><?= htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?>:</span>
                    <div>Quedo atento por si necesitas apoyo con algun documento.</div>
                    <div><span class="chat-bubble__day">Martes</span> <span class="chat-bubble__date">(02 febrero-2026)</span></div>
                  </div>
                </div>
                <div class="chat-compose">
                  <input class="chat-compose__input" type="text" placeholder="Escribe un mensaje..." />
                  <button class="chat-compose__send" type="button" aria-label="Enviar mensaje">✈</button>
                </div>
              </div>
            <?php endif; ?>
          </section>
        <?php endforeach; ?>
      </div>
    </aside>
    <script>
    (function () {
      const panel = document.querySelector('[data-contact-panel]');
      const backdrop = document.querySelector('[data-contact-backdrop]');
      if (!panel || !backdrop) {
        return;
      }

      const openButtons = document.querySelectorAll('[data-open-contacts]');
      const closeButton = panel.querySelector('[data-contact-close]');
      const chatButtons = panel.querySelectorAll('[data-chat-toggle]');
      const chatBoxes = panel.querySelectorAll('[data-chat-box]');

      function closeChats() {
        chatBoxes.forEach((box) => box.classList.remove('is-open'));
        chatButtons.forEach((button) => button.classList.remove('is-active'));
      }

      function openPanel() {
        panel.classList.add('is-open');
        backdrop.classList.add('is-open');
      }

      function closePanel() {
        panel.classList.remove('is-open');
        backdrop.classList.remove('is-open');
        closeChats();
      }

      openButtons.forEach((button) => {
        button.addEventListener('click', openPanel);
      });

      if (closeButton) {
        closeButton.addEventListener('click', closePanel);
      }

      backdrop.addEventListener('click', closePanel);

      chatButtons.forEach((button) => {
        button.addEventListener('click', function () {
          const chatId = button.getAttribute('data-chat-toggle');
          const chatBox = panel.querySelector('[data-chat-box="' + chatId + '"]');
          const isOpen = button.classList.contains('is-active');

          closeChats();

          if (!isOpen && chatBox) {
            button.classList.add('is-active');
            chatBox.classList.add('is-open');
          }
        });
      });
    }());
    </script>
    <?php
}
