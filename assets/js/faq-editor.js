(function () {
  'use strict';
  function makeButton(label, cls, aria) {
    var button = document.createElement('button');
    button.type = 'button'; button.className = 'button ' + cls;
    button.textContent = label; button.setAttribute('aria-label', aria || label);
    return button;
  }
  function makeRow(item) {
    var row = document.createElement('div'); row.className = 'lw-faq-editor-row';
    var head = document.createElement('div'); head.className = 'lw-faq-editor-head';
    var title = document.createElement('strong'); title.className = 'lw-faq-editor-index';
    var actions = document.createElement('div'); actions.className = 'lw-faq-editor-actions';
    actions.appendChild(makeButton('↑', 'lw-faq-up', 'Move question up'));
    actions.appendChild(makeButton('↓', 'lw-faq-down', 'Move question down'));
    actions.appendChild(makeButton('Remove', 'lw-faq-remove', 'Remove question'));
    head.appendChild(title); head.appendChild(actions);
    var qLabel = document.createElement('label'); qLabel.textContent = 'Question';
    var q = document.createElement('input'); q.type = 'text'; q.className = 'lw-faq-question';
    q.maxLength = 400; q.value = item.question || ''; q.placeholder = 'e.g. Can I arrange a site visit?';
    qLabel.appendChild(q);
    var aLabel = document.createElement('label'); aLabel.textContent = 'Answer';
    var a = document.createElement('textarea'); a.className = 'lw-faq-answer';
    a.maxLength = 6000; a.rows = 3; a.value = item.answer || '';
    a.placeholder = 'Write a clear, helpful answer';
    aLabel.appendChild(a); row.appendChild(head); row.appendChild(qLabel); row.appendChild(aLabel);
    return row;
  }
  function setup(root) {
    if (root.dataset.ready === '1') return;
    var input = root.querySelector('.lw-faq-json');
    var list = root.querySelector('.lw-faq-editor-list');
    var add = root.querySelector('.lw-faq-add');
    if (!input || !list || !add) return;
    root.dataset.ready = '1';
    var initial = [];
    try { initial = JSON.parse(input.value); if (!Array.isArray(initial)) initial = []; }
    catch (err) { initial = []; }
    initial.forEach(function (item) { list.appendChild(makeRow(item)); });
    function relabel() {
      var rows = Array.prototype.slice.call(list.children);
      rows.forEach(function(row, index) {
        row.querySelector('.lw-faq-editor-index').textContent = 'FAQ ' + (index + 1);
        row.querySelector('.lw-faq-up').disabled = index === 0;
        row.querySelector('.lw-faq-down').disabled = index === rows.length - 1;
      });
    }
    function sync() {
      var values = Array.prototype.map.call(list.querySelectorAll('.lw-faq-editor-row'), function(row) {
        return {
          question: row.querySelector('.lw-faq-question').value,
          answer: row.querySelector('.lw-faq-answer').value
        };
      });
      input.value = JSON.stringify(values);
      // WordPress Customizer listens to the change event on linked input fields.
      input.dispatchEvent(new Event('change', { bubbles:true }));
      relabel();
    }
    var typingTimer;
    list.addEventListener('input', function(e) {
      if (e.target.matches('.lw-faq-question,.lw-faq-answer')) { clearTimeout(typingTimer); typingTimer=setTimeout(sync,550); }
    });
    list.addEventListener('change',function(e) {
      if (e.target.matches('.lw-faq-question,.lw-faq-answer')) { clearTimeout(typingTimer); sync(); }
    });
    list.addEventListener('click', function(e) {
      var button = e.target.closest('button'); if (!button) return;
      var row = button.closest('.lw-faq-editor-row'); if(!row) return;
      if(button.classList.contains('lw-faq-remove')) row.remove();
      else if(button.classList.contains('lw-faq-up') && row.previousElementSibling) list.insertBefore(row,row.previousElementSibling);
      else if(button.classList.contains('lw-faq-down') && row.nextElementSibling) list.insertBefore(row.nextElementSibling,row);
      sync();
    });
    add.addEventListener('click', function() {
      if(list.children.length >= 250) { window.alert('Up to 250 FAQs are supported.'); return; }
      var row=makeRow({question:'',answer:''}); list.appendChild(row);
      sync(); row.querySelector('.lw-faq-question').focus();
    });
    relabel();
  }
  function init() { document.querySelectorAll('.lw-faq-repeater').forEach(setup); }
  if(document.readyState==='loading') document.addEventListener('DOMContentLoaded',init);
  else init();
  // WP Customizer can render controls after the initial DOMContentLoaded event.
  if(window.wp && wp.customize && wp.customize.control) {
    wp.customize.control.bind('add', function() { setTimeout(init,0); });
  }
})();
