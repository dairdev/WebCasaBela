<header class="relative h-auto">
  <div class="relative">
    <img src="assets/images/headerbackground1.jpg" class="absolute inset-0 object-cover w-full h-full" data-aos="zoom-in" alt="" />
    <div class="relative bg-gray-900 bg-opacity-75">
    <?php include __DIR__."/navbar.php"  ?>
      <div class="px-4 py-8 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 lg:py-16 lg:pb-48">
        <div class="flex flex-col items-center justify-between xl:flex-row">
          <div class="w-full max-w-xl mb-12 xl:mb-0 xl:pr-16 xl:w-7/12" data-aos="fade-right" data-aos-delay="300">
            <h2
              class="max-w-lg mb-6 font-sans text-3xl font-bold tracking-tight text-white sm:text-4xl sm:leading-none">
              La casa de tus sueños<br class="hidden md:block" />
              la tenemos para ti.
              <a class="block mt-3" aria-label="Chat on WhatsApp" href="https://wa.me/51943100275"><img alt="Chat on WhatsApp" src="assets/svg/WhatsAppButtonRedMedium.svg" />
              </a>
            </h2>
            <p class="max-w-xl mb-4 text-base text-gray-400 md:text-lg">Nuestra amplia experiencia es nuestra mejor carta de presentacion</p>
          </div>
          <div class="w-full max-w-xl xl:px-8 xl:w-5/12" data-aos="fade-left" data-aos-delay="300">
            <div class="bg-white rounded shadow-2xl p-7 sm:p-10">
              <h3 class="mb-4 text-xl font-semibold sm:text-center sm:mb-6 sm:text-2xl">
                Concerta una cita
              </h3>
              <form>
                <div class="mb-1 sm:mb-2">
                  <label for="nombre" class="inline-block mb-1 font-medium">Nombre</label>
                  <input placeholder="Nombres y Apellidos" required="" type="text"
                    class="flex-grow w-full h-12 px-4 mb-2 transition duration-200 bg-white border border-gray-300 rounded shadow-sm appearance-none focus:border-red-400 focus:outline-none focus:shadow-outline"
                    id="nombre" name="nombre" />
                </div>
                <div class="mb-1 sm:mb-2">
                  <label for="email" class="inline-block mb-1 font-medium">Email</label>
                  <input placeholder="micorreo@correo.com" required="" type="text"
                    class="flex-grow w-full h-12 px-4 mb-2 transition duration-200 bg-white border border-gray-300 rounded shadow-sm appearance-none focus:border-red-400 focus:outline-none focus:shadow-outline"
                    id="email" name="email" />
                </div>
                <div class="mt-4 mb-2 sm:mb-4">
                  <button type="submit"
                    class="inline-flex items-center justify-center w-full h-12 px-6 font-medium tracking-wide text-white transition duration-200 rounded shadow-md bg-red-400 hover:bg-red-700 focus:shadow-outline focus:outline-none">
                    Enviar
                  </button>
                </div>
                <p class="text-xs text-gray-600 sm:text-sm">
                  Respetamos tu privacidad.
                </p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
