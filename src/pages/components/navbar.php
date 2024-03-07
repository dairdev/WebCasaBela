<div class="bg-white bg-opacity-35">
  <div class="px-4 py-8 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8">
    <div class="relative flex grid items-center grid-cols-2 lg:grid-cols-3">
      <menu class="flex items-center hidden space-x-8 lg:flex">
        <li><a href="/src/pages/index.php" aria-label="Inicio" title="Inicio"
          class="font-medium tracking-wide text-gray-100 transition-colors duration-200 hover:text-blue-400">Inicio</a>
        </li>
        <li><a href="/src/pages/propiedades.php" aria-label="Lista de propiedades" title="Proyectos"
          class="font-medium tracking-wide text-gray-100 transition-colors duration-200 hover:text-blue-400">Proyectos</a>
        </li>
        <li><a href="/src/pages/contacto.php" aria-label="Contacto" title="Contacto"
          class="font-medium tracking-wide text-gray-100 transition-colors duration-200 hover:text-blue-400">Contacto</a>
        </li>
      </menu>
      <a href="/" aria-label="Logo" title="Logo" class="inline-flex items-center lg:mx-auto">
        <img src="assets/svg/logo.svg" class="w-16" title="Logo CasaBela" />
      </a>
      <menu class="flex items-center hidden ml-auto space-x-8 lg:flex">
        <li>
          <a href="/src/pages/contacto.php"
            class="inline-flex items-center justify-center h-12 px-6 font-medium tracking-wide text-white transition duration-200 rounded shadow-md bg-red-400 hover:bg-red-700 focus:shadow-outline focus:outline-none"
            aria-label="Sign up" title="Sign up">
            Reservar Cita
          </a>
        </li>
      </menu>
      <!-- Mobile menu -->
      <div class="lg:hidden flex justify-end">
      <label class="relative z-40 cursor-pointer px-3 py-6" for="mobile-menu">
        <input class="peer hidden" type="checkbox" id="mobile-menu" />
        <div
          class="relative z-50 block h-[1px] w-7 bg-black bg-transparent content-[''] before:absolute before:top-[-0.35rem] before:z-50 before:block before:h-full before:w-full before:bg-black before:transition-all before:duration-200 before:ease-out before:content-[''] after:absolute after:right-0 after:bottom-[-0.35rem] after:block after:h-full after:w-full after:bg-black after:transition-all after:duration-200 after:ease-out after:content-[''] peer-checked:bg-transparent before:peer-checked:top-0 before:peer-checked:w-full before:peer-checked:rotate-45 before:peer-checked:transform after:peer-checked:bottom-0 after:peer-checked:w-full after:peer-checked:-rotate-45 after:peer-checked:transform"
        >
        </div>
        <div
          class="fixed inset-0 z-40 hidden h-full w-full bg-black/50 backdrop-blur-sm peer-checked:block"
        >
          &nbsp;
        </div>
        <div
          class="fixed top-0 right-0 z-40 h-full w-full translate-x-full overflow-y-auto overscroll-y-none transition duration-500 peer-checked:translate-x-0"
        >
          <div class="float-right min-h-full w-[85%] bg-white px-6 pt-12 shadow-2xl">
              <menu>
                <li class="py-3"><a href="/src/pages/index.php" aria-label="Inicio" title="Inicio"
                  class="font-medium tracking-wide text-gray-800 transition-colors duration-200 hover:text-blue-400">Inicio</a>
                </li>
                <li class="py-3"><a href="/src/pages/propiedades.php" aria-label="Lista de propiedades" title="Proyectos"
                  class="font-medium tracking-wide text-gray-800 transition-colors duration-200 hover:text-blue-400">Proyectos</a>
                </li>
                <li class="py-3"><a href="/src/pages/contacto.php" aria-label="Contacto" title="Contacto"
                  class="font-medium tracking-wide text-gray-800 transition-colors duration-200 hover:text-blue-400">Contacto</a>
                </li>
              </menu>
          </div>
        </div>
      </label>
      </div>
    </div>
  </div>
</div>
