<!DOCTYPE html>
<html lang="en">

<head>
  <title>Casabela</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width" />
  <link rel="apple-touch-icon" sizes="180x180" href="assets/icons/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="assets/icons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="assets/icons/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="mask-icon" href="assets/icons/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
  <!--
      Need a visual blank slate?
      Remove all code in `styles.css`!
      https://kitwind.io/products/kometa/components/navs
    -->
  <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body>

  <header class="relative h-auto">
    <div class="relative">
      <img src="assets/images/headerbackground1.jpg" class="absolute inset-0 object-cover w-full h-full" alt="" />
      <div class="relative bg-gray-900 bg-opacity-75">
        <div class="bg-white bg-opacity-35">
          <div class="px-4 py-8 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8">
            <div class="relative flex grid items-center grid-cols-2 lg:grid-cols-3">
              <ul class="flex items-center hidden space-x-8 lg:flex">
                <li><a href="/" aria-label="Our product" title="Our product"
                    class="font-medium tracking-wide text-gray-100 transition-colors duration-200 hover:text-blue-400">Inicio</a>
                </li>
                <li><a href="/" aria-label="Our product" title="Our product"
                    class="font-medium tracking-wide text-gray-100 transition-colors duration-200 hover:text-blue-400">Proyectos</a>
                </li>
                <li><a href="/" aria-label="Product pricing" title="Product pricing"
                    class="font-medium tracking-wide text-gray-100 transition-colors duration-200 hover:text-blue-400">Contacto</a>
                </li>
              </ul>
              <a href="/" aria-label="Company" title="Company" class="inline-flex items-center lg:mx-auto">
                <img src="assets/svg/logo.svg" class="w-16" title="Logo CasaBela" />
              </a>
              <ul class="flex items-center hidden ml-auto space-x-8 lg:flex">
                <li>
                  <a href="/"
                    class="inline-flex items-center justify-center h-12 px-6 font-medium tracking-wide text-white transition duration-200 rounded shadow-md bg-red-400 hover:bg-red-700 focus:shadow-outline focus:outline-none"
                    aria-label="Sign up" title="Sign up">
                    Reservar Cita
                  </a>
                </li>
              </ul>
              <!-- Mobile menu -->
              <div class="ml-auto lg:hidden">
                <button aria-label="Open Menu" title="Open Menu"
                  class="p-2 -mr-1 transition duration-200 rounded focus:outline-none focus:shadow-outline">
                  <svg class="w-5 text-gray-600" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M23,13H1c-0.6,0-1-0.4-1-1s0.4-1,1-1h22c0.6,0,1,0.4,1,1S23.6,13,23,13z">
                    </path>
                    <path fill="currentColor" d="M23,6H1C0.4,6,0,5.6,0,5s0.4-1,1-1h22c0.6,0,1,0.4,1,1S23.6,6,23,6z">
                    </path>
                    <path fill="currentColor" d="M23,20H1c-0.6,0-1-0.4-1-1s0.4-1,1-1h22c0.6,0,1,0.4,1,1S23.6,20,23,20z">
                    </path>
                  </svg>
                </button>
                <!-- Mobile menu dropdown 
          <div class="absolute top-0 left-0 w-full">
            <div class="p-5 bg-white border rounded shadow-sm">
              <div class="flex items-center justify-between mb-4">
                <div>
                  <a href="/" aria-label="Company" title="Company" class="inline-flex items-center">
                    <svg class="w-8 text-red-400" viewBox="0 0 24 24" stroke-linejoin="round" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10" stroke="currentColor" fill="none">
                      <rect x="3" y="1" width="7" height="12"></rect>
                      <rect x="3" y="17" width="7" height="6"></rect>
                      <rect x="14" y="1" width="7" height="6"></rect>
                      <rect x="14" y="11" width="7" height="12"></rect>
                    </svg>
                    <span class="ml-2 text-xl font-bold tracking-wide text-gray-800 uppercase">Company</span>
                  </a>
                </div>
                <div>
                  <button aria-label="Close Menu" title="Close Menu" class="p-2 -mt-2 -mr-2 transition duration-200 rounded hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                    <svg class="w-5 text-gray-600" viewBox="0 0 24 24">
                      <path
                        fill="currentColor"
                        d="M19.7,4.3c-0.4-0.4-1-0.4-1.4,0L12,10.6L5.7,4.3c-0.4-0.4-1-0.4-1.4,0s-0.4,1,0,1.4l6.3,6.3l-6.3,6.3 c-0.4,0.4-0.4,1,0,1.4C4.5,19.9,4.7,20,5,20s0.5-0.1,0.7-0.3l6.3-6.3l6.3,6.3c0.2,0.2,0.5,0.3,0.7,0.3s0.5-0.1,0.7-0.3 c0.4-0.4,0.4-1,0-1.4L13.4,12l6.3-6.3C20.1,5.3,20.1,4.7,19.7,4.3z"
                      ></path>
                    </svg>
                  </button>
                </div>
              </div>
              <nav>
                <ul class="space-y-4">
                  <li><a href="/" aria-label="Our product" title="Our product" class="font-medium tracking-wide text-gray-700 transition-colors duration-200 hover:text-red-400">Product</a></li>
                  <li><a href="/" aria-label="Our product" title="Our product" class="font-medium tracking-wide text-gray-700 transition-colors duration-200 hover:text-red-400">Features</a></li>
                  <li><a href="/" aria-label="Product pricing" title="Product pricing" class="font-medium tracking-wide text-gray-700 transition-colors duration-200 hover:text-red-400">Pricing</a></li>
                  <li><a href="/" aria-label="Sign in" title="Sign in" class="font-medium tracking-wide text-gray-700 transition-colors duration-200 hover:text-red-400">Sign in</a></li>
                  <li>
                    <a
                      href="/"
                      class="inline-flex items-center justify-center w-full h-12 px-6 font-medium tracking-wide text-white transition duration-200 rounded shadow-md bg-red-400 hover:bg-red-700 focus:shadow-outline focus:outline-none"
                      aria-label="Sign up"
                      title="Sign up"
                    >
                      Sign up
                    </a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
          -->
              </div>
            </div>
          </div>
        </div>
        <div class="px-4 py-8 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 lg:py-16 lg:pb-48">
          <div class="flex flex-col items-center justify-between xl:flex-row">
            <div class="w-full max-w-xl mb-12 xl:mb-0 xl:pr-16 xl:w-7/12">
              <h2
                class="max-w-lg mb-6 font-sans text-3xl font-bold tracking-tight text-white sm:text-4xl sm:leading-none">
                La casa de tus sueños<br class="hidden md:block" />
                la tenemos para ti.
                    <a class="block mt-3" aria-label="Chat on WhatsApp" href="https://wa.me/51943100275"><img alt="Chat on WhatsApp" src="assets/svg/WhatsAppButtonRedMedium.svg" />
                    </a>
              </h2>
              <p class="max-w-xl mb-4 text-base text-gray-400 md:text-lg">Nuestra amplia experiencia es nuestra mejor carta de presentacion</p>
            </div>
            <div class="w-full max-w-xl xl:px-8 xl:w-5/12">
              <div class="bg-white rounded shadow-2xl p-7 sm:p-10">
                <h3 class="mb-4 text-xl font-semibold sm:text-center sm:mb-6 sm:text-2xl">
                  Concerta una cita
                </h3>
                <form>
                  <div class="mb-1 sm:mb-2">
                    <label for="email" class="inline-block mb-1 font-medium">Nombre</label>
                    <input placeholder="Nombres y Apellidos" required="" type="text"
                      class="flex-grow w-full h-12 px-4 mb-2 transition duration-200 bg-white border border-gray-300 rounded shadow-sm appearance-none focus:border-red-400 focus:outline-none focus:shadow-outline"
                      id="nombre" name="nombre" />
                  </div>
                  <div class="mb-1 sm:mb-2">
                    <label for="email" class="inline-block mb-1 font-medium">E-mail</label>
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
  <main>
      <section class="proyectos max-w-screen-xl mx-auto p-5 sm:p-10 md:p-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">
          <?php 
          for($i = 0; $i < 3; $i++){
            include "components/card.php"; 
            }
            ?>
        </div>
      </section>
      <section>
      </section>
      <section>
      </section>
  </main>
</body>

</html>
