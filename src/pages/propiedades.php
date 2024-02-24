<!DOCTYPE html>
<html lang="en">

  <head>
    <?php  include __DIR__."/components/head.php" ?>
  </head>

  <body>
    <?php include __DIR__."/components/header2.php" ?>
    <main class="bg-sky-50">
      <section class="proyectos max-w-screen-xl mx-auto p-5 sm:p-10 md:p-16">
        <h2 class="py-6 text-2xl font-bold tracking-tight text-gray-700">Lista de propiedades</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">
          <?php 
          for($i = 0; $i < 9; $i++){
          include __DIR__."/components/card.php"; 
          }
          ?>
        </div>
      </section>
    </main>
    <?php include __DIR__."/components/footer.php" ?>
    <?php include __DIR__."/components/scripts.php" ?>
  </body>
</html>
