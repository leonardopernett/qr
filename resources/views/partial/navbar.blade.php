
<style>
    .titulo{
        opacity: 0;
        transition: all .5s ease-in-out
    }
    .show{
        opacity: 1;
        transition: all .5s ease-in-out
    }
</style>

<div class="container fixed-top" id="titulo">
    <div class="row">
        <div class="col-md-8 mx-auto">
           <div class="d-bock text-center">
               <img src="../public/images/logo.png" alt="" width="300" class="img-fluid my-3">
           </div>
        </div>
    </div>
</div>



<script>

   const titulo =  document.getElementById('titulo')
   window.addEventListener('scroll',()=>{
       if(window.scrollY > 20){
            titulo.classList.add('titulo')
            titulo.classList.remove('show')
       }else{
        titulo.classList.remove('titulo')
        titulo.classList.add('show')
       }
   })

</script>
