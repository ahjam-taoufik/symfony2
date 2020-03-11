$('#add-image').click(function(){

    // on supprime ce champ et deplacer par le champ qui ce trouve au dessus pour resoudre le bug d'id qui ce double 
     // const index=$('#ad_images div.form-group').length;
    // on ajoute ce champ pour resoudre le bug d'id qui ce double 
       const index=+$('#widget-counter').val();//on ajout un plus parceque javascript fait la concatenation
      // console.log(index);

      //console.log(index);
      const tmpl=$('#ad_images').data('prototype').replace(/__name__/g,index);//le g pour repeter plusieurs fois
      //console.log(tmpl);
      $('#ad_images').append(tmpl);

      // on ajoute ce champ pour resoudre le bug d'id qui ce double 
      $('#widget-counter').val(index+1);            

      handleDeleteButtons();

   });

   function handleDeleteButtons(){
           $('button[data-action="delete"]').click(function(){
              const target =this.dataset.target;
              //console.log(target);
              $(target).remove();

                });
   }

        function updateCounter(){
            const count= +$('#ad_images div.form-group').length;
            $('#widget-counter').val(count);
        }

      updateCounter();
     // appel de cette fonction au chargement de la page
     handleDeleteButtons();