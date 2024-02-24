<!DOCTYPE html>
<html lang="en">

  <head>
    <?php  include_once __DIR__."/components/head.php" ?>
  </head>

  <body>
    <?php  include __DIR__."/components/header2.php" ?>
    <main class="bg-sky-50">
      <section class="proyectos max-w-screen-xl mx-auto p-5 sm:p-10 md:p-16">
        <div class="rounded overflow-hidden shadow-lg flex flex-col bg-white">
          <a href="#"></a>
          <div class="relative">
            <a href="#">
              <img class="w-full"
                src="https://images.pexels.com/photos/271624/pexels-photo-271624.jpeg?cs=srgb&dl=pexels-pixabay-271624.jpg&fm=jpg&w=640&h=427&_gl=1*1wznhqi*_ga*ODkzNzE3ODcuMTcwNzI3NTQ1Nw..*_ga_8JE65Q40S6*MTcwNzI3NTQ1Ni4xLjEuMTcwNzI3NTcyNS4wLjAuMA.."
                alt="Departamento">
              <div
                class="hover:bg-transparent transition duration-300 absolute bottom-0 top-0 right-0 left-0 bg-gray-900 opacity-25">
              </div>
            </a>
            <a href="#!">
              <div
                class="text-xs absolute top-0 right-0 bg-blue-600 px-4 py-2 text-white mt-3 mr-3 hover:bg-white hover:text-blue-600 transition duration-500 ease-in-out">
                Departamento
              </div>
            </a>
          </div>
          <div class="px-6 py-4 mb-auto">
            <a href="#"
              class="font-medium text-lg hover:text-blue-600 transition duration-500 ease-in-out inline-block mb-2">Hermoso Triplex</a>
            <?php
            $features = array(
            "location" => "Alguna direccion #123",
            "contact" => "949 386 070",
            "type" => "Triplex",
            "floors" =>3,
            "rooms" => 3,
            "baths" => 3,
            "area" => 64.85,
            "cars" => 1,
            "price" => 220000,
            "others" => array("wash", "terraza", "parrilla", "estudio"),
            "description" => "Hermoso TRIPLEX ubicado en Zona Tranquila y segura de La Molina ,cerca de  Parques , Centros Comerciales , Colegios , USMP . El triplex cuenta con acabados Modernos , Ambientes Amplios y Acogedores. "
            );
            ?>
            <div class="flex flex-row items-center mb-3 text-gray-600">
              <span class="mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pinned"><path d="M18 8c0 4.5-6 9-6 9s-6-4.5-6-9a6 6 0 0 1 12 0"/><circle cx="12" cy="8" r="2"/><path d="M8.835 14H5a1 1 0 0 0-.9.7l-2 6c-.1.1-.1.2-.1.3 0 .6.4 1 1 1h18c.6 0 1-.4 1-1 0-.1 0-.2-.1-.3l-2-6a1 1 0 0 0-.9-.7h-3.835"/></svg>
              </span>
              <span>
                <?php echo $features["location"] ?>
              </span>
            </div>
            <div class="flex flex-row items-center mb-3 text-gray-600">
              <span class="mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-phone"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
              </span>
              <span>
                <?php echo $features["contact"] ?>
              </span>
            </div>
            <div class="grid grid-cols-2 gap-6 mt-3">
              <div class="flex flex-row items-center text-gray-600">
                <span class="mr-3">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building-2"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/></svg>
                </span>
                <span><?php echo $features["type"] ?></span>
              </div>
              <div class="flex flex-row items-center text-gray-600">
                <span class="mr-3">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-home"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                </span>
                <span><?php echo $features["floors"] ?> pisos</span>
              </div>
              <div class="flex flex-row items-center text-gray-600">
                <span class="mr-3">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bed-double"><path d="M2 20v-8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v8"/><path d="M4 10V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v4"/><path d="M12 4v6"/><path d="M2 18h20"/></svg>
                </span>
                <span><?php echo $features["rooms"] ?> cuartos</span>
              </div>
              <div class="flex flex-row items-center text-gray-600">
                <span class="mr-3">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-car"><path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><path d="M9 17h6"/><circle cx="17" cy="17" r="2"/></svg>
                </span>
                <span><?php echo $features["cars"] ?> carros</span>
              </div>
              <div class="flex flex-row items-center text-gray-600">
                <span class="mr-3">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bath"><path d="M9 6 6.5 3.5a1.5 1.5 0 0 0-1-.5C4.683 3 4 3.683 4 4.5V17a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5"/><line x1="10" x2="8" y1="5" y2="7"/><line x1="2" x2="22" y1="12" y2="12"/><line x1="7" x2="7" y1="19" y2="21"/><line x1="17" x2="17" y1="19" y2="21"/></svg>
                </span>
                <span><?php echo $features["baths"] ?> baños</span>
              </div>
              <div class="flex flex-row items-center text-gray-600">
                <span class="mr-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ruler" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 4h14a1 1 0 0 1 1 1v5a1 1 0 0 1 -1 1h-7a1 1 0 0 0 -1 1v7a1 1 0 0 1 -1 1h-5a1 1 0 0 1 -1 -1v-14a1 1 0 0 1 1 -1" /><path d="M4 8l2 0" /><path d="M4 12l3 0" /><path d="M4 16l2 0" /><path d="M8 4l0 2" /><path d="M12 4l0 3" /><path d="M16 4l0 2" /></svg>
                </span>
                <span><?php echo $features["area"] ?> m<sup>2</sup></span>
              </div>
            </div>
          </div>
          <div class="px-6 py-3 flex flex-row items-center justify-between bg-gray-100">
            <a href="propiedad.php">
              <span href="#" class="py-1 text-xs font-regular text-gray-900 mr-1 flex flex-row items-center">
                <span class="ml-1">Ver propiedad</span>
              </span>
            </a>
          </div>
        </div>
      </section>
    </main>
    <?php include __DIR__."/components/footer.php" ?>
    <?php include_once __DIR__."/components/scripts.php" ?>
  </body>
</html>
