import Sortable from 'sortablejs';

Livewire.hook('component.init', ({ component, cleanup }) => {

    if(component.name == 'shopping-list'){
      
      const el = document.getElementById('shoppingList');

      Sortable.create(el, {
      handle: ".handle",
      ghostClass: 'ghost',
      onEnd: function (evt) {
          const ids = [];
          const items = document.querySelectorAll("#shoppingList li");

          items.forEach((element) => ids.push(element.dataset.id));

          const form = document.getElementById('shoppingOrder');
          const field = document.getElementById('order');
          
          field.value = ids.join('+');

          fetch(form.action,{method:'post', body: new FormData(form)});
        }

      });
    }
})